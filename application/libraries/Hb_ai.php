<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author hobrt.me
 * @file Hb_ai.php
 * @package hobrtEcom
 *
 * AI provider connection set up in admin > AI settings: Claude (Anthropic SDK)
 * or any OpenAI-compatible Chat Completions API (OpenAI, Gemini, DeepSeek,
 * Qwen, or a custom endpoint such as OpenRouter, Groq, Mistral or Ollama).
 * Used by the template editor assistant, and meant to be reused for other
 * admin helpers (product descriptions, settings...) through ask().
 *
 * Settings live in hb_meta: ai_provider (the active one) and, per provider,
 * ai_model_<p>, ai_base_<p> and ai_key_<p>. Keys are stored encrypted with the
 * per-install encryption key, and each provider only ever gets its own key.
 *
 * A conversation is a plain array, saved as JSON between requests:
 *   ['provider' => ..., 'model' => ..., 'messages' => [...]]
 * Its messages are in the provider's own format, so a conversation can not
 * move between providers.
 */

use Anthropic\Client as AnthropicClient;
use Anthropic\Core\Exceptions\APIConnectionException;
use Anthropic\Core\Exceptions\APIStatusException;

class Hb_ai
{
	/**
	 * type: 'anthropic' (SDK) or 'compatible' (OpenAI Chat Completions format).
	 * base: default endpoint, editable in the settings (e.g. another region).
	 */
	const PROVIDERS = array(
		'anthropic' => array('label' => 'Claude (Anthropic)', 'type' => 'anthropic', 'model' => 'claude-opus-5-5', 'base' => '', 'keys' => 'https://platform.claude.com/settings/keys'),
		'openai' => array('label' => 'OpenAI', 'type' => 'compatible', 'model' => 'gpt-5', 'image_model' => 'gpt-image-1', 'base' => 'https://api.openai.com/v1', 'keys' => 'https://platform.openai.com/api-keys'),
		'gemini' => array('label' => 'Google Gemini', 'type' => 'compatible', 'model' => 'gemini-2.5-flash', 'image_model' => 'gemini-2.5-flash-image', 'base' => 'https://generativelanguage.googleapis.com/v1beta/openai', 'keys' => 'https://aistudio.google.com/apikey'),
		'deepseek' => array('label' => 'DeepSeek', 'type' => 'compatible', 'model' => 'deepseek-chat', 'base' => 'https://api.deepseek.com/v1', 'keys' => 'https://platform.deepseek.com/api_keys'),
		'qwen' => array('label' => 'Qwen (Alibaba Cloud)', 'type' => 'compatible', 'model' => 'qwen-plus', 'base' => 'https://dashscope-intl.aliyuncs.com/compatible-mode/v1', 'keys' => 'https://modelstudio.console.alibabacloud.com/'),
		'custom' => array('label' => 'Other (OpenAI-compatible)', 'type' => 'compatible', 'model' => '', 'base' => '', 'keys' => ''),
	);

	const MAX_TOKENS = 16000;

	/** output cap for the compatible providers, several of which reject more */
	const COMPATIBLE_MAX_TOKENS = 8192;

	/** @var CI_Controller */
	protected $CI;

	public function __construct()
	{
		$this->CI = &get_instance();
		require_once APPPATH . 'vendor/autoload.php';
	}

	/*
	| -------------------------------------------------------------------
	| Settings
	| -------------------------------------------------------------------
	*/

	/**
	 * The active provider with its model/endpoint and a hint of its key (never
	 * the key itself), plus the same for every provider under 'all'.
	 */
	public function settings()
	{
		$active = $this->meta('ai_provider');
		if (!isset(self::PROVIDERS[$active]))
			$active = 'anthropic';

		$all = array();
		foreach (self::PROVIDERS as $p => $def) {
			$key = $this->api_key($p);
			$all[$p] = array(
				'model' => $this->meta('ai_model_' . $p) ?: ($p === $active ? $this->meta('ai_model') : '') ?: $def['model'],
				'base' => $this->meta('ai_base_' . $p) ?: $def['base'],
				'image_model' => isset($def['image_model']) ? ($this->meta('ai_image_model_' . $p) ?: $def['image_model']) : '',
				'has_key' => $key !== '',
				'key_hint' => $key !== '' ? '…' . substr($key, -4) : '',
			);
		}

		return array('provider' => $active) + $all[$active] + array('all' => $all);
	}

	/** The active provider has a key (and, for a custom one, an endpoint and a model) */
	public function is_configured()
	{
		$s = $this->settings();
		return $s['has_key'] && $s['model'] !== '' && (self::PROVIDERS[$s['provider']]['type'] === 'anthropic' || $s['base'] !== '');
	}

	/**
	 * @param string $active provider to use
	 * @param array  $each   per provider: ['model' => ..., 'base' => ..., 'key' => new key or '' to keep]
	 */
	public function save_settings($active, array $each)
	{
		if (!isset(self::PROVIDERS[$active]))
			throw new InvalidArgumentException('Unknown provider');

		$this->set_meta('ai_provider', $active);

		foreach (self::PROVIDERS as $p => $def) {
			$in = isset($each[$p]) && is_array($each[$p]) ? $each[$p] : array();

			if (isset($in['model'])) {
				$model = trim((string) $in['model']);
				$this->set_meta('ai_model_' . $p, preg_match('/^[A-Za-z0-9._:\/@+-]{1,120}$/', $model) ? $model : '');
			}

			if (isset($in['image_model']) && isset($def['image_model'])) {
				$model = trim((string) $in['image_model']);
				$this->set_meta('ai_image_model_' . $p, preg_match('/^[A-Za-z0-9._:\/@+-]{1,120}$/', $model) ? $model : '');
			}

			if (isset($in['base']) && $def['type'] === 'compatible')
				$this->set_meta('ai_base_' . $p, $this->clean_base($in['base']));

			$key = trim((string) ($in['key'] ?? ''));
			if ($key !== '') {
				$this->CI->load->library('encryption');
				$this->set_meta('ai_key_' . $p, $this->CI->encryption->encrypt($key));
			}
		}
	}

	public function forget_key($provider)
	{
		if (isset(self::PROVIDERS[$provider]))
			$this->set_meta('ai_key_' . $provider, '');
		if ($provider === $this->meta('ai_provider'))
			$this->set_meta('ai_key', '');      // key saved by the first version of this page
	}

	/** Checks the active provider's key, endpoint and model; throws RuntimeException with the reason */
	public function test()
	{
		$s = $this->settings();
		if (!$this->is_configured())
			throw new RuntimeException('Save an API key (and for "Other" an endpoint and a model) first');

		if ($s['provider'] === 'anthropic') {
			$this->guard(function () use ($s) {
				$this->anthropic()->models->retrieve($s['model']);
			});
		} elseif ($s['provider'] === 'openai') {
			$this->openai_request('openai', 'GET', 'models/' . rawurlencode($s['model']));
		} else {
			// not every compatible API lists models: send the smallest possible request
			$this->openai_request($s['provider'], 'POST', 'chat/completions', array(
				'model' => $s['model'],
				'messages' => array(array('role' => 'user', 'content' => 'ping')),
				'max_tokens' => 16,
			));
		}
	}

	/** http(s) URL without a trailing slash, or '' */
	protected function clean_base($url)
	{
		$url = rtrim(trim((string) $url), '/');
		$parts = parse_url($url);
		if ($url === '' || !$parts || !in_array($parts['scheme'] ?? '', array('http', 'https'), TRUE) || empty($parts['host']))
			return '';
		return $url;
	}

	/*
	| -------------------------------------------------------------------
	| Conversations
	| -------------------------------------------------------------------
	*/

	public function new_conversation()
	{
		$s = $this->settings();
		return array('provider' => $s['provider'], 'model' => $s['model'], 'messages' => array());
	}

	/**
	 * @param array|null $image ['mime' => 'image/jpeg', 'data' => base64] shown to the model with the text
	 */
	public function add_user(array &$conv, $text, ?array $image = NULL)
	{
		if ($image === NULL) {
			$conv['messages'][] = array('role' => 'user', 'content' => (string) $text);
		} elseif ($this->is_anthropic($conv)) {
			$conv['messages'][] = array('role' => 'user', 'content' => array(
				array('type' => 'image', 'source' => array('type' => 'base64', 'mediaType' => $image['mime'], 'data' => $image['data'])),
				array('type' => 'text', 'text' => (string) $text),
			));
		} else {
			$conv['messages'][] = array('role' => 'user', 'content' => array(
				array('type' => 'image_url', 'image_url' => array('url' => 'data:' . $image['mime'] . ';base64,' . $image['data'])),
				array('type' => 'text', 'text' => (string) $text),
			));
		}
	}

	/**
	 * One call to the model. Appends its answer to the conversation.
	 *
	 * @param array $tools list of ['name', 'description', 'schema' (JSON schema)]
	 * @return array ['text' => string, 'calls' => list of ['id', 'name', 'input'], 'stop' => string]
	 */
	public function step(array &$conv, $system, array $tools = array())
	{
		if (!$this->is_configured())
			throw new RuntimeException('The AI provider is not set up');

		return $this->is_anthropic($conv)
			? $this->anthropic_step($conv, $system, $tools)
			: $this->compatible_step($conv, $system, $tools);
	}

	/**
	 * @param array $results list of ['id', 'content' (string), 'error' (bool)]
	 */
	public function add_tool_results(array &$conv, array $results)
	{
		if (!$results)
			return;

		if ($this->is_anthropic($conv)) {
			$blocks = array();
			foreach ($results as $r)
				$blocks[] = array('type' => 'tool_result', 'toolUseID' => $r['id'], 'content' => (string) $r['content'], 'isError' => !empty($r['error']));
			$conv['messages'][] = array('role' => 'user', 'content' => $blocks);
		} else {
			foreach ($results as $r)
				$conv['messages'][] = array('role' => 'tool', 'tool_call_id' => $r['id'], 'content' => (string) $r['content']);
		}
	}

	/** Single question, text answer (no tools) - for admin helpers like product descriptions */
	public function ask($system, $prompt)
	{
		$conv = $this->new_conversation();
		$this->add_user($conv, $prompt);
		return $this->step($conv, $system)['text'];
	}

	/*
	| -------------------------------------------------------------------
	| Claude
	| -------------------------------------------------------------------
	*/

	protected function anthropic()
	{
		return new AnthropicClient(apiKey: $this->api_key('anthropic'), requestOptions: array('timeout' => 240.0, 'maxRetries' => 2));
	}

	protected function anthropic_step(array &$conv, $system, array $tools)
	{
		$defs = array();
		foreach ($tools as $t)
			$defs[] = array('name' => $t['name'], 'description' => $t['description'], 'inputSchema' => $t['schema']);

		// a chat reloaded from JSON turns empty tool inputs ({}) into [], which the API rejects
		foreach ($conv['messages'] as $i => $m) {
			if ($m['role'] === 'assistant' && is_array($m['content'])) {
				foreach ($m['content'] as $j => $block) {
					if (($block['type'] ?? '') === 'tool_use' && $block['input'] === array())
						$conv['messages'][$i]['content'][$j]['input'] = new stdClass();
				}
			}
		}

		$response = $this->guard(function () use ($conv, $system, $defs) {
			return $this->anthropic()->beta->messages->create(
				model: $conv['model'],
				maxTokens: self::MAX_TOKENS,
				system: $system,
				tools: $defs ?: NULL,
				messages: $conv['messages'],
				// the conversation grows by appending: cache everything up to the last turn
				cacheControl: array('type' => 'ephemeral'),
				// if the model declines for policy reasons, let the API retry on its default fallback model
				fallbacks: 'default',
				betas: array('server-side-fallback-2026-07-01'),
			);
		});

		$out = array('text' => '', 'calls' => array(), 'stop' => (string) $response->stopReason);

		foreach ($response->content as $block) {
			if ($block->type === 'text')
				$out['text'] .= $block->text;
			elseif ($block->type === 'tool_use')
				$out['calls'][] = array('id' => $block->id, 'name' => $block->name, 'input' => (array) $block->input);
		}

		// the full content (thinking blocks included) goes back unchanged on the next call
		$content = json_decode(json_encode($response->content), TRUE);
		if ($content)
			$conv['messages'][] = array('role' => 'assistant', 'content' => $content);

		if ($out['stop'] === 'refusal' && $out['text'] === '')
			$out['text'] = 'The model declined this request.';

		return $out;
	}

	/** Runs an SDK call and turns its errors into a RuntimeException with a readable message */
	protected function guard(callable $call)
	{
		try {
			return $call();
		} catch (APIStatusException $e) {
			$type = $e->type ? $e->type->value : 'error';
			// the exception text is a dump of the response; keep the API's own message
			$detail = preg_match('/"message":\s*"((?:[^"\\\\]|\\\\.)*)"/', $e->getMessage(), $m) ? stripcslashes($m[1]) : $e->getMessage();
			throw new RuntimeException('Claude API: ' . $type . ' - ' . $detail, 0, $e);
		} catch (APIConnectionException $e) {
			throw new RuntimeException('Could not reach the Claude API: ' . $e->getMessage(), 0, $e);
		}
	}

	protected function is_anthropic(array $conv)
	{
		return (self::PROVIDERS[$conv['provider']]['type'] ?? '') === 'anthropic';
	}

	/*
	| -------------------------------------------------------------------
	| OpenAI and compatible APIs (Chat Completions over HTTPS)
	| -------------------------------------------------------------------
	*/

	protected function compatible_step(array &$conv, $system, array $tools)
	{
		$p = $conv['provider'];
		$openai = $p === 'openai';

		$body = array(
			'model' => $conv['model'],
			'messages' => array_merge(array(array('role' => 'system', 'content' => $system)), $conv['messages']),
		);
		// OpenAI's reasoning models only take max_completion_tokens; the others use max_tokens
		if ($openai)
			$body['max_completion_tokens'] = self::MAX_TOKENS;
		else
			$body['max_tokens'] = self::COMPATIBLE_MAX_TOKENS;

		foreach ($tools as $t) {
			$fn = array('name' => $t['name'], 'description' => $t['description']);
			$schema = $t['schema'];
			if (!$openai) {
				// some compatible APIs (Gemini) reject additionalProperties and empty objects
				unset($schema['additionalProperties']);
				if (empty((array) ($schema['properties'] ?? array())))
					$schema = NULL;
			}
			if ($schema !== NULL)
				$fn['parameters'] = $schema;
			$body['tools'][] = array('type' => 'function', 'function' => $fn);
		}

		$data = $this->openai_request($p, 'POST', 'chat/completions', $body);
		$choice = $data['choices'][0] ?? array();
		$message = $choice['message'] ?? array('role' => 'assistant', 'content' => '');

		$out = array('text' => (string) ($message['content'] ?? ''), 'calls' => array(), 'stop' => (string) ($choice['finish_reason'] ?? ''));

		foreach ($message['tool_calls'] ?? array() as $i => $call) {
			$input = json_decode($call['function']['arguments'] ?? '', TRUE);
			$id = (string) ($call['id'] ?? '') ?: 'call_' . count($conv['messages']) . '_' . $i;
			$message['tool_calls'][$i]['id'] = $id;
			$out['calls'][] = array('id' => $id, 'name' => $call['function']['name'] ?? '', 'input' => is_array($input) ? $input : array());
		}

		$keep = array('role' => 'assistant', 'content' => $message['content'] ?? NULL);
		if (!empty($message['tool_calls']))
			$keep['tool_calls'] = $message['tool_calls'];
		// DeepSeek's thinking mode needs its reasoning back while it is calling tools
		if ($p === 'deepseek' && isset($message['reasoning_content']))
			$keep['reasoning_content'] = $message['reasoning_content'];
		$conv['messages'][] = $keep;

		if (!empty($message['refusal']) && $out['text'] === '')
			$out['text'] = (string) $message['refusal'];

		return $out;
	}

	protected function openai_request($provider, $method, $path, ?array $body = NULL)
	{
		$label = self::PROVIDERS[$provider]['label'] ?? $provider;
		$base = $this->settings()['all'][$provider]['base'] ?? '';
		if ($base === '')
			throw new RuntimeException($label . ': no API endpoint set');

		$http = new GuzzleHttp\Client(array('base_uri' => $base . '/', 'timeout' => 240, 'http_errors' => FALSE));

		try {
			$res = $http->request($method, $path, array_filter(array(
				'headers' => array('Authorization' => 'Bearer ' . $this->api_key($provider), 'Content-Type' => 'application/json'),
				'body' => $body === NULL ? NULL : json_encode($body, JSON_UNESCAPED_UNICODE),
			), fn ($v) => $v !== NULL));
		} catch (GuzzleHttp\Exception\GuzzleException $e) {
			throw new RuntimeException('Could not reach ' . $label . ': ' . $e->getMessage(), 0, $e);
		}

		$data = json_decode((string) $res->getBody(), TRUE);
		if ($res->getStatusCode() >= 400) {
			// {"error": {...}}, or a list of them (Gemini)
			$err = $data['error'] ?? ($data[0]['error'] ?? array());
			$msg = is_array($err) ? ($err['message'] ?? '') : (string) $err;
			throw new RuntimeException($label . ': ' . ($msg !== '' ? $msg : 'HTTP ' . $res->getStatusCode()));
		}

		return is_array($data) ? $data : array();
	}

	/*
	| -------------------------------------------------------------------
	| Images (Claude and most compatible APIs can read images but not make them)
	| -------------------------------------------------------------------
	*/

	/** The providers that can create images, in the order they are tried: the active one first, then Gemini and OpenAI with a saved key */
	public function image_providers()
	{
		$s = $this->settings();
		$out = array();
		foreach (array_unique(array($s['provider'], 'gemini', 'openai')) as $p) {
			if (($s['all'][$p]['image_model'] ?? '') !== '' && $s['all'][$p]['has_key'])
				$out[] = $p;
		}
		return $out;
	}

	/** The first provider used to create images; '' for none */
	public function image_provider()
	{
		return $this->image_providers()[0] ?? '';
	}

	/**
	 * Creates one image.
	 *
	 * @param string     $prompt
	 * @param array|null $ref ['mime', 'data' (base64)] a photo the new image must be based on
	 * @return array ['mime' => ..., 'bytes' => raw image]
	 */
	public function generate_image($prompt, ?array $ref = NULL)
	{
		$providers = $this->image_providers();
		if (!$providers)
			throw new RuntimeException('Creating images needs a Gemini or OpenAI API key in AI settings.');

		// when one provider refuses (no billing, quota...), the next one with a key is tried
		$first = NULL;
		foreach ($providers as $p) {
			try {
				return $p === 'gemini' ? $this->gemini_image($prompt, $ref) : $this->openai_image($prompt, $ref);
			} catch (RuntimeException $e) {
				$first = $first ?: $e;
			}
		}
		throw $first;
	}

	/** Gemini's own API (generateContent): its OpenAI-compatible endpoint can't take a reference photo */
	protected function gemini_image($prompt, ?array $ref)
	{
		$s = $this->settings()['all']['gemini'];
		// https://generativelanguage.googleapis.com/v1beta/openai -> .../v1beta
		$root = preg_match('#^(https://[^/]+/v1[a-z0-9]*)(/openai)?$#', $s['base'], $m) ? $m[1] : 'https://generativelanguage.googleapis.com/v1beta';

		$parts = array(array('text' => (string) $prompt));
		if ($ref)
			$parts[] = array('inline_data' => array('mime_type' => $ref['mime'], 'data' => $ref['data']));

		$data = $this->http_json('Google Gemini', $root . '/models/' . rawurlencode($s['image_model']) . ':generateContent',
			array('x-goog-api-key' => $this->api_key('gemini')),
			array('contents' => array(array('role' => 'user', 'parts' => $parts)), 'generationConfig' => array('responseModalities' => array('TEXT', 'IMAGE'))));

		$candidate = $data['candidates'][0] ?? array();
		foreach ($candidate['content']['parts'] ?? array() as $part) {
			$inline = $part['inlineData'] ?? ($part['inline_data'] ?? NULL);
			if ($inline && empty($part['thought']) && !empty($inline['data']))
				return array('mime' => $inline['mimeType'] ?? ($inline['mime_type'] ?? 'image/png'), 'bytes' => base64_decode($inline['data']));
		}

		$why = $candidate['finishReason'] ?? ($data['promptFeedback']['blockReason'] ?? '');
		throw new RuntimeException('Google Gemini returned no image' . ($why !== '' ? ' (' . $why . ')' : '') . '. Try another description, or check the image model in AI settings.');
	}

	/** OpenAI Images API: generations, or edits when there is a reference photo */
	protected function openai_image($prompt, ?array $ref)
	{
		$s = $this->settings()['all']['openai'];
		$url = rtrim($s['base'], '/') . ($ref ? '/images/edits' : '/images/generations');
		$auth = array('Authorization' => 'Bearer ' . $this->api_key('openai'));

		if ($ref) {
			$data = $this->http_json('OpenAI', $url, $auth, NULL, array(
				array('name' => 'model', 'contents' => $s['image_model']),
				array('name' => 'prompt', 'contents' => (string) $prompt),
				array('name' => 'size', 'contents' => '1024x1024'),
				array('name' => 'image', 'contents' => base64_decode($ref['data']), 'filename' => 'photo.' . ($ref['mime'] === 'image/png' ? 'png' : 'jpg'), 'headers' => array('Content-Type' => $ref['mime'])),
			));
		} else {
			$data = $this->http_json('OpenAI', $url, $auth, array('model' => $s['image_model'], 'prompt' => (string) $prompt, 'size' => '1024x1024', 'n' => 1));
		}

		$b64 = $data['data'][0]['b64_json'] ?? '';
		if ($b64 === '')
			throw new RuntimeException('OpenAI returned no image. Check the image model in AI settings.');

		return array('mime' => 'image/png', 'bytes' => base64_decode($b64));
	}

	/** POST JSON (or multipart) and decode the JSON answer; errors become RuntimeException */
	protected function http_json($label, $url, array $headers, ?array $json, ?array $multipart = NULL)
	{
		$http = new GuzzleHttp\Client(array('timeout' => 240, 'http_errors' => FALSE));
		$options = array('headers' => $headers);
		if ($multipart !== NULL)
			$options['multipart'] = $multipart;
		else
			$options['json'] = $json;

		try {
			$res = $http->request('POST', $url, $options);
		} catch (GuzzleHttp\Exception\GuzzleException $e) {
			throw new RuntimeException('Could not reach ' . $label . ': ' . $e->getMessage(), 0, $e);
		}

		$data = json_decode((string) $res->getBody(), TRUE);
		if ($res->getStatusCode() >= 400) {
			$err = $data['error'] ?? ($data[0]['error'] ?? array());
			$msg = is_array($err) ? ($err['message'] ?? '') : (string) $err;
			throw new RuntimeException($label . ': ' . ($msg !== '' ? $msg : 'HTTP ' . $res->getStatusCode()));
		}

		return is_array($data) ? $data : array();
	}

	/*
	| -------------------------------------------------------------------
	| Storage
	| -------------------------------------------------------------------
	*/

	protected function api_key($provider)
	{
		$stored = $this->meta('ai_key_' . $provider);
		// the first version of the settings page kept one key for the active provider
		if ($stored === '' && $provider === $this->meta('ai_provider'))
			$stored = $this->meta('ai_key');
		if ($stored === '')
			return '';

		$this->CI->load->library('encryption');
		$key = $this->CI->encryption->decrypt($stored);
		return is_string($key) ? $key : '';
	}

	protected function meta($k)
	{
		$row = $this->CI->db->select('v')->where('k', $k)->get('hb_meta')->row();
		return $row ? (string) $row->v : '';
	}

	protected function set_meta($k, $v)
	{
		$this->CI->db->replace('hb_meta', array('k' => $k, 'v' => (string) $v));
	}
}

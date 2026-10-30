<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author hobrt.me
 * @file Hb_ai_fill.php
 * @package hobrtEcom
 *
 * "Fill with AI" on the product and landing page forms: the admin describes
 * what they sell and/or uploads one photo, the model writes the selling text
 * through one tool call, and the values come back cleaned. Product images can
 * then be created from the photo (or from the text) one by one with image().
 * Nothing is saved to the product here: the page fills the form and the admin
 * reviews it before pressing Submit.
 *
 * Prices are only filled when the admin gives them (the model is told not to
 * invent them), and landing page customer reviews are never written by the
 * model: shoppers read them as real reviews.
 */
class Hb_ai_fill
{
	const FORMS = array('product', 'landing');

	/** tags kept in the generated descriptions; every attribute is removed */
	const HTML_TAGS = '<p><br><h2><h3><h4><strong><b><em><i><u><ul><ol><li><blockquote><hr><span><div><table><thead><tbody><tr><th><td>';

	/** extra tags of the landing page text (the lp-* blocks and their icons) */
	const LANDING_TAGS = '<section><small>';

	/** classes kept in the landing page text: the blocks of assets/landing/blocks.css and Font Awesome icons */
	const LANDING_CLASSES = array('lp-hero', 'lp-sub', 'lp-problem', 'lp-badges', 'lp-badge', 'lp-benefits', 'lp-benefit',
		'lp-steps', 'lp-guarantee', 'lp-highlight', 'lp-faq', 'lp-cta', 'fas', 'far', 'fab');

	/** the photo sent to the model is scaled down to this (pixels, longest side) */
	const PHOTO_SIZE = 1280;

	/** one style per created image */
	const IMAGE_STYLES = array(
		'on a clean pure white studio background, soft even lighting, centered, the whole product visible',
		'in a realistic lifestyle scene where it is naturally used, natural light, inviting mood',
		'close-up detail shot showing the materials and finish, shallow depth of field',
		'on a soft pastel colored background with subtle shadows, modern minimal style',
	);

	/** @var CI_Controller */
	protected $CI;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->library('hb_ai');
	}

	/**
	 * @param string $form    'product' or 'landing'
	 * @param string $brief   what the admin wrote
	 * @param array  $current the values already in the form (name => value)
	 * @param string $photo    file name of an uploaded photo in uploads/ ('' for none)
	 * @param string $feedback landing page: real customer messages to turn into reviews
	 * @param int    $images   landing page: how many photos the text gets ({{image1}}... placeholders)
	 * @return array ['fields' => cleaned values to put in the form, 'note' => message from the model, 'image_prompt' => how the product looks]
	 */
	public function fill($form, $brief, array $current, $photo = '', $feedback = '', $images = 0)
	{
		if (!in_array($form, self::FORMS, TRUE))
			throw new InvalidArgumentException('Unknown form');

		$brief = mb_substr(trim((string) $brief), 0, 3000);
		$current = $this->current_values($form, $current);
		$image = $photo !== '' ? $this->photo($photo) : NULL;
		$feedback = $form === 'landing' ? mb_substr(trim((string) $feedback), 0, 6000) : '';
		$images = $form === 'landing' ? max(0, min(5, (int) $images)) : 0;

		if ($brief === '' && !$image && !array_filter($current))
			throw new InvalidArgumentException('Describe what you sell or add a photo first.');

		$tool = array(
			'name' => 'fill_form',
			'description' => 'Fill the ' . ($form === 'product' ? 'product' : 'landing page') . ' form.',
			'schema' => $form === 'product' ? $this->product_schema() : $this->landing_schema(),
		);

		$prompt = "The merchant's notes:\n" . ($brief !== '' ? $brief : '(none)')
			. ($image ? "\n\nThe attached photo shows the product: use what you can see (type of product, colors, materials, details)." : '')
			. "\n\nCurrent form values (JSON):\n" . json_encode($current, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
			. $this->context($form, $current)
			. ($form === 'landing' ? "\n\nPhotos for the page: $images" . ($images ? ' (place {{image1}}' . ($images > 1 ? " to {{image$images}}" : '') . ' in the content)' : ' (use no image placeholder)') : '')
			. ($feedback !== '' ? "\n\nReal customer feedback, pasted by the merchant (make the reviews from this only):\n" . $feedback : '')
			. "\n\nCall fill_form once with all the fields.";

		$conv = $this->CI->hb_ai->new_conversation();
		$this->CI->hb_ai->add_user($conv, $prompt, $image);
		$r = $this->CI->hb_ai->step($conv, $this->system($form), array($tool));

		$input = NULL;
		foreach ($r['calls'] as $call) {
			if ($call['name'] === 'fill_form') {
				$input = json_decode(json_encode($call['input']), TRUE);
				break;
			}
		}

		// some compatible models answer with plain JSON instead of the tool call
		if ($input === NULL && preg_match('/\{.*\}/s', $r['text'], $m))
			$input = json_decode($m[0], TRUE);

		if (!is_array($input))
			throw new RuntimeException(trim($r['text']) !== '' ? mb_substr(trim($r['text']), 0, 500) : 'The AI did not return the form fields. Try again.');

		$fields = $form === 'product' ? $this->clean_product($input) : $this->clean_landing($input, $feedback !== '', $images);
		if (!$fields)
			throw new RuntimeException('The AI did not return any usable field. Add more details and try again.');

		return array(
			'fields' => $fields,
			'note' => mb_substr(trim((string) ($input['note'] ?? '')), 0, 400),
			'image_prompt' => $this->text($input['image_prompt'] ?? '', 800),
		);
	}

	/**
	 * Creates one product image and saves it in uploads/ like an uploaded one.
	 *
	 * @param int    $index  which style (0..3): white background, lifestyle, detail, pastel
	 * @param string $photo  uploaded photo to base it on ('' to create from the text)
	 * @param string $looks  how the product looks (image_prompt from fill())
	 * @param string $title  product title, for context
	 * @return string the saved file name
	 */
	public function image($index, $photo, $looks, $title)
	{
		$style = self::IMAGE_STYLES[((int) $index) % count(self::IMAGE_STYLES)];
		$ref = $photo !== '' ? $this->photo($photo) : NULL;
		$looks = $this->text($looks, 800);
		$title = $this->text($title, 200);

		if ($ref) {
			$prompt = "Create a professional e-commerce photo of the exact product shown in the reference photo, $style."
				. " Keep the product identical to the photo: same shape, proportions, colors, materials, logos and details."
				. " Do not add text, watermarks, prices or other products." . ($title !== '' ? " The product: $title." : '');
		} else {
			if ($looks === '' && $title === '')
				throw new InvalidArgumentException('Describe the product or add a photo first.');
			$prompt = "Create a professional e-commerce product photo, $style. The product: "
				. ($looks !== '' ? $looks : $title) . ". Photorealistic. Do not add text, watermarks or prices.";
		}

		try {
			$img = $this->CI->hb_ai->generate_image($prompt, $ref);
		} catch (RuntimeException $e) {
			// Google gives free API keys no image requests at all ("free_tier ... limit: 0")
			if (stripos($e->getMessage(), 'Google Gemini') === 0 && preg_match('/free.?tier|limit: 0|billing/i', $e->getMessage()))
				throw new RuntimeException(lang('admin_h342') ?: 'Your Gemini key is on the free tier, which cannot create images.', 0, $e);
			if (preg_match('/billing|quota|insufficient/i', $e->getMessage()))
				throw new RuntimeException((lang('admin_h343') ?: 'The image provider refused because of quota or billing:') . ' ' . $e->getMessage(), 0, $e);
			throw $e;
		}
		return $this->save_image($img['bytes']);
	}

	/*
	| -------------------------------------------------------------------
	| Prompts
	| -------------------------------------------------------------------
	*/

	protected function system($form)
	{
		$lang = setting('store_lng') === 'arabic' ? 'Arabic' : 'English';
		$currency = trim((string) setting('currency'));

		$common = "You are an expert e-commerce copywriter. You fill in forms in the admin panel of an online store called \"" . setting('title') . "\"."
			. "\nThe merchant gives you rough notes and/or a photo. Turn them into polished, persuasive selling copy: never copy the notes as they are."
			. "\nWrite in the language of the merchant's notes. If there are no notes, use the language of the current values, or $lang."
			. ($currency !== '' ? "\nPrices are in $currency; write them as plain numbers." : '')
			. "\nRules:"
			. "\n- Always write a title and the selling text, even from a few words or only a photo."
			. "\n- Sell the benefits: what the customer gains, how it feels to use it, which problem it solves. Speak to the customer (\"you\"). Short paragraphs, warm and confident tone."
			. "\n- Hard facts (sizes, materials, capacity, battery life, warranty, delivery times, certifications) come only from the notes, the current values or what the photo clearly shows. Don't invent them, and no fake claims like \"best in the world\" or \"doctors recommend\"."
			. "\n- Never invent prices, discounts or shipping costs: fill a price field only when the merchant gives that number, or it is already in the form or in the product data."
			. "\n- When the form already has text and the merchant asks for a specific change, change only that."
			. "\n- Long text fields are simple HTML: <p>, <h2>/<h3>, <ul>/<li>, <strong>. No styles, classes, links, images, emojis or scripts."
			. "\n- image_prompt: in English, describe precisely how the product looks (type, shape, colors, materials, details) so a photographer could recreate it. Describe only the product."
			. "\n- note: one short sentence to the merchant, in " . (setting('admin_lng') === 'arabic' ? 'Arabic' : 'English') . " (for example what is still missing).";

		if ($form === 'product')
			return $common
				. "\n\nThe form is a product page:"
				. "\n- title: a clear, attractive product name (max about 70 characters): product type + the main feature or style."
				. "\n- descr: the product page description: a catchy opening paragraph (2-3 sentences), then <h3> with a short heading and a list of 4-6 benefits, each starting with <strong>the feature</strong> then what it gives the customer, then a short closing paragraph that invites to order."
				. "\n- description: the SEO meta description, one sentence of at most 155 characters, plain text, with the product type."
				. "\n- variants: options the customer chooses from (size, color...) with their choices, only when the merchant lists them or the photo clearly shows several."
				. "\n- cat: the id of the best matching category from the list. The cat in the current values is only the form's first option, not a choice: always pick the category that fits the product, unless the merchant names one.";

		return $common
			. "\n\nThe form is a one-product sales landing page (cash on delivery), opened from ads on phones."
			. "\n- title: a short catchy offer title."
			. "\n- content: the whole page, built from these blocks in this order (skip a block when you have nothing true to put in it):"
			. "\n  <section class=\"lp-hero\"><h2>strong headline: the main benefit</h2><p class=\"lp-sub\">one-line promise</p>{{image1}}<p>{{btn}}</p></section>"
			. "\n  <div class=\"lp-badges\"><span class=\"lp-badge\"><i class=\"fas fa-truck\"></i> short fact</span> (3 or 4 badges: delivery, payment on delivery, offer...)</div>"
			. "\n  <section class=\"lp-problem\"><h3>the customer's problem or wish</h3><p>how this product answers it</p></section>"
			. "\n  <div class=\"lp-benefits\"><div class=\"lp-benefit\"><i class=\"fas fa-bolt\"></i><h4>benefit</h4><p>one or two sentences</p></div> (3 to 6 cards)</div>"
			. "\n  {{image2}} and further photos between the blocks"
			. "\n  <div class=\"lp-highlight\">the offer in one sentence, with the prices given</div>"
			. "\n  <section class=\"lp-steps\"><h3>how to order</h3><ol><li>step</li> (3 steps: fill the form, we call to confirm, pay on delivery)</ol></section>"
			. "\n  <div class=\"lp-guarantee\"><i class=\"fas fa-shield-alt\"></i><p>guarantee</p></div> only when the merchant gives a guarantee or a return policy"
			. "\n  <section class=\"lp-faq\"><h3>questions</h3><h4>question</h4><p>answer</p> (3 or 4, answers only from known facts)</section>"
			. "\n  <section class=\"lp-cta\"><h3>closing call to action</h3><p>{{btn}}</p></section>"
			. "\n  Icons: Font Awesome 5 solid (fas fa-truck, fa-money-bill-wave, fa-check-circle, fa-shield-alt, fa-bolt, fa-heart, fa-leaf, fa-gift, fa-star, fa-clock, fa-smile, fa-thumbs-up, fa-box-open, fa-phone...)."
			. "\n  Use only these classes, no style attributes. {{btn}} becomes the \"Order now\" button. Each {{imageN}} placeholder stands alone between blocks or inside lp-hero, never inside a sentence."
			. "\n  No fake urgency: no countdowns, no invented stock limits or deadlines."
			. "\n- reviews: ONLY from the real customer feedback the merchant pasted, one review per customer message. Keep what the customer said: you may fix spelling, shorten it and translate it into the page language, never add praise or details. name: the customer's name as given (first name and initial), or \"Customer\" in the page language; city only if given. Without pasted feedback, return no reviews."
			. "\n- price is the offer price for one, old_price the price before the offer, price2 the total price for 2 pieces, price3 the total price for 3 pieces (plus one free)."
			. "\n- header_color is the background of the header and buttons, btn_color the text on them (#rrggbb, readable together, fitting the product).";
	}

	/** Extra facts for the model: the categories, or the product of the landing page */
	protected function context($form, array $current)
	{
		if ($form === 'product') {
			$cats = array();
			foreach ($this->CI->m_p->s_a('cats', array(), FALSE) as $c)
				$cats[] = array('id' => (int) $c->id, 'title' => (string) $c->title);
			return "\n\nCategories (JSON):\n" . json_encode($cats, JSON_UNESCAPED_UNICODE);
		}

		$product = !empty($current['product_id']) ? $this->CI->m_p->findOneById('products', (int) $current['product_id']) : NULL;
		if (!$product)
			return '';

		return "\n\nThe product this page sells (JSON):\n" . json_encode(array(
			'title' => (string) $product->title,
			'price' => (string) $product->price,
			'discount_percent' => (string) $product->discount,
			'description' => mb_substr(trim(preg_replace('/\s+/u', ' ', strip_tags(str_replace('<', ' <', (string) $product->descr)))), 0, 3000),
			'options' => json_decode((string) $product->variants, TRUE) ?: array(),
		), JSON_UNESCAPED_UNICODE);
	}

	/** Only the fields the model may fill, as short strings */
	protected function current_values($form, array $current)
	{
		$keys = $form === 'product'
			? array('title', 'price', 'discount', 'shipping', 'descr', 'cat', 'description')
			: array('title', 'price', 'old_price', 'price2', 'price3', 'content', 'header_color', 'btn_color', 'product_id');

		$out = array();
		foreach ($keys as $k) {
			$v = is_scalar($current[$k] ?? NULL) ? trim((string) $current[$k]) : '';
			// an empty editor holds <p><br></p>
			if (in_array($k, array('descr', 'content'), TRUE) && trim(strip_tags($v)) === '')
				$v = '';
			$out[$k] = mb_substr($v, 0, 6000);
		}

		if ($form === 'product') {
			$out['variants'] = array();
			$tp = (array) ($current['tp'] ?? array());
			$info = (array) ($current['info'] ?? array());
			foreach ($tp as $i => $name) {
				if (is_scalar($name) && trim((string) $name) !== '')
					$out['variants'][] = array('name' => mb_substr(trim((string) $name), 0, 100), 'choices' => mb_substr(trim((string) ($info[$i] ?? '')), 0, 500));
			}
		}

		return $out;
	}

	protected function product_schema()
	{
		$text = array('type' => 'string');
		$number = array('type' => 'string', 'description' => 'Plain number, only when the merchant gave it');

		return array('type' => 'object', 'properties' => array(
			'title' => $text + array('description' => 'Attractive product name'),
			'price' => $number,
			'discount' => array('type' => 'integer', 'minimum' => 0, 'maximum' => 100, 'description' => 'Discount percent, only when the merchant gave it'),
			'shipping' => $number,
			'descr' => $text + array('description' => 'Persuasive product description (HTML)'),
			'cat' => array('type' => 'integer', 'description' => 'Category id from the list'),
			'variants' => array('type' => 'array', 'items' => array('type' => 'object', 'properties' => array(
				'name' => $text + array('description' => 'Option name, e.g. Size'),
				'choices' => array('type' => 'array', 'items' => $text),
			), 'required' => array('name', 'choices'))),
			'description' => $text + array('description' => 'SEO meta description, max 155 characters'),
			'image_prompt' => $text + array('description' => 'English description of how the product looks'),
			'note' => $text + array('description' => 'One short sentence to the merchant'),
		), 'required' => array('title', 'descr', 'description', 'image_prompt'));
	}

	protected function landing_schema()
	{
		$text = array('type' => 'string');
		$number = array('type' => 'string', 'description' => 'Plain number, only when the merchant gave it');
		$color = array('type' => 'string', 'description' => '#rrggbb');

		return array('type' => 'object', 'properties' => array(
			'title' => $text + array('description' => 'Catchy offer title'),
			'price' => $number,
			'old_price' => $number,
			'price2' => $number,
			'price3' => $number,
			'content' => $text + array('description' => 'The page (HTML blocks) with {{btn}} and {{imageN}} placeholders'),
			'reviews' => array('type' => 'array', 'description' => 'Only from the pasted customer feedback', 'items' => array('type' => 'object', 'properties' => array(
				'name' => $text,
				'city' => $text,
				'text' => $text + array('description' => 'What the customer said'),
			), 'required' => array('name', 'text'))),
			'header_color' => $color,
			'btn_color' => $color,
			'image_prompt' => $text + array('description' => 'English description of how the product looks'),
			'note' => $text + array('description' => 'One short sentence to the merchant'),
		), 'required' => array('title', 'content', 'image_prompt'));
	}

	/*
	| -------------------------------------------------------------------
	| Images
	| -------------------------------------------------------------------
	*/

	/**
	 * An uploaded photo (file name in uploads/), scaled down, as ['mime', 'data' (base64)]
	 */
	protected function photo($name)
	{
		$name = basename((string) $name);
		$path = FCPATH . 'uploads/' . $name;
		if (!preg_match('/^[a-zA-Z0-9_-]+\.(jpe?g|png|gif)$/i', $name) || !is_file($path))
			throw new InvalidArgumentException('The photo could not be found. Upload it again.');

		$im = @imagecreatefromstring((string) file_get_contents($path));
		if (!$im)
			throw new InvalidArgumentException('The photo could not be read. Use a JPG or PNG image.');

		// phone photos are often stored sideways with an EXIF "turn me" flag
		$turn = array(3 => 180, 6 => -90, 8 => 90);
		$exif = function_exists('exif_read_data') ? @exif_read_data($path) : FALSE;
		if (!empty($exif['Orientation']) && isset($turn[$exif['Orientation']]) && ($turned = imagerotate($im, $turn[$exif['Orientation']], 0)))
			$im = $turned;

		// scaled onto a white true-color canvas: works for palette and transparent images too
		$w = imagesx($im);
		$h = imagesy($im);
		$scale = min(1, self::PHOTO_SIZE / max($w, $h));
		$nw = max(1, (int) round($w * $scale));
		$nh = max(1, (int) round($h * $scale));
		$out = imagecreatetruecolor($nw, $nh);
		imagefill($out, 0, 0, imagecolorallocate($out, 255, 255, 255));
		imagecopyresampled($out, $im, 0, 0, 0, 0, $nw, $nh, $w, $h);

		ob_start();
		imagejpeg($out, NULL, 88);
		return array('mime' => 'image/jpeg', 'data' => base64_encode(ob_get_clean()));
	}

	/** Saves a created image as a JPG in uploads/ with the same sizes as an uploaded one */
	protected function save_image($bytes)
	{
		$im = @imagecreatefromstring((string) $bytes);
		if (!$im)
			throw new RuntimeException('The created image could not be read.');

		$name = bin2hex(random_bytes(16)) . '.jpg';
		$path = FCPATH . 'uploads/' . $name;

		// transparent PNG parts become white
		$jpg = imagecreatetruecolor(imagesx($im), imagesy($im));
		imagefill($jpg, 0, 0, imagecolorallocate($jpg, 255, 255, 255));
		imagecopy($jpg, $im, 0, 0, 0, 0, imagesx($im), imagesy($im));
		$ok = imagejpeg($jpg, $path, 90);

		if (!$ok)
			throw new RuntimeException('The image could not be saved: the uploads folder must be writable.');

		make_image_sizes($path);
		return $name;
	}

	/*
	| -------------------------------------------------------------------
	| Cleaning what the model returned
	| -------------------------------------------------------------------
	*/

	protected function clean_product(array $in)
	{
		$out = array();

		if (($v = $this->text($in['title'] ?? NULL, 200)) !== '')
			$out['title'] = $v;
		foreach (array('price', 'shipping') as $k) {
			if (($v = $this->number($in[$k] ?? NULL)) !== '')
				$out[$k] = $v;
		}
		if (isset($in['discount']) && is_numeric($in['discount']) && $in['discount'] >= 0 && $in['discount'] <= 100)
			$out['discount'] = (string) (int) $in['discount'];
		if (($v = $this->html($in['descr'] ?? NULL)) !== '')
			$out['descr'] = $v;
		if (($v = $this->text($in['description'] ?? NULL, 300)) !== '')
			$out['description'] = $v;

		if (isset($in['cat']) && is_numeric($in['cat'])) {
			foreach ($this->CI->m_p->s_a('cats', array(), FALSE) as $c) {
				if ((int) $c->id === (int) $in['cat'])
					$out['cat'] = (string) (int) $c->id;
			}
		}

		if (isset($in['variants']) && is_array($in['variants'])) {
			$variants = array();
			foreach (array_slice($in['variants'], 0, 10) as $v) {
				$name = $this->text($v['name'] ?? NULL, 100);
				$choices = is_array($v['choices'] ?? NULL) ? $v['choices'] : explode(',', (string) ($v['choices'] ?? ''));
				// a comma separates the choices in the store, so it can't be inside one
				$choices = array_values(array_filter(array_map(function ($c) {
					return is_scalar($c) ? $this->text(str_replace(',', ' ', (string) $c), 60) : '';
				}, array_slice($choices, 0, 30)), 'strlen'));
				if ($name !== '' && $choices)
					$variants[] = array('tp' => $name, 'info' => implode(', ', $choices));
			}
			if ($variants)
				$out['variants'] = $variants;
		}

		return $out;
	}

	protected function clean_landing(array $in, $has_feedback = FALSE, $images = 0)
	{
		$out = array();

		if (($v = $this->text($in['title'] ?? NULL, 200)) !== '')
			$out['title'] = $v;
		foreach (array('price', 'old_price', 'price2', 'price3') as $k) {
			if (($v = $this->number($in[$k] ?? NULL)) !== '')
				$out[$k] = $v;
		}
		if (($v = $this->landing_html($in['content'] ?? NULL, $images)) !== '')
			$out['content'] = $v;

		// reviews only come from feedback the merchant pasted
		if ($has_feedback && isset($in['reviews']) && is_array($in['reviews'])) {
			$reviews = array();
			foreach (array_slice($in['reviews'], 0, 30) as $r) {
				$review = array('name' => $this->text($r['name'] ?? '', 60), 'city' => $this->text($r['city'] ?? '', 60), 'text' => $this->text($r['text'] ?? '', 600));
				if ($review['text'] !== '')
					$reviews[] = $review;
			}
			if ($reviews)
				$out['reviews'] = $reviews;
		}
		foreach (array('header_color', 'btn_color') as $k) {
			if (isset($in[$k]) && is_string($in[$k]) && preg_match('/^#[0-9a-f]{6}$/i', trim($in[$k])))
				$out[$k] = strtolower(trim($in[$k]));
		}

		return $out;
	}

	/** One line of plain text */
	protected function text($v, $max)
	{
		if (!is_scalar($v))
			return '';
		return mb_substr(trim(preg_replace('/\s+/u', ' ', strip_tags((string) $v))), 0, $max);
	}

	/** "199", "199.90" ("199,90" and "199 MAD" are understood); '' when it isn't a price */
	protected function number($v)
	{
		if (!is_scalar($v))
			return '';
		$v = str_replace(array(',', ' '), array('.', ''), trim((string) $v));
		$v = preg_replace('/[^0-9.]/', '', $v);
		return preg_match('/^\d{1,9}(\.\d{1,2})?$/', $v) ? $v : '';
	}

	/**
	 * The landing page text: simple HTML plus the lp-* blocks; the only
	 * attribute kept is class, with known class names only.
	 */
	protected function landing_html($v, $images)
	{
		if (!is_string($v))
			return '';
		$v = preg_replace('#<(script|style|iframe|object|embed|template)\b[^>]*>.*?</\1\s*>#is', '', $v);
		$v = strip_tags($v, self::HTML_TAGS . self::LANDING_TAGS);
		$v = preg_replace_callback('#<([a-z][a-z0-9]*)\b([^>]*?)(/?)>#i', function ($m) {
			$keep = array();
			if (preg_match('#\bclass\s*=\s*(["\'])(.*?)\1#is', $m[2], $c)) {
				foreach (preg_split('/\s+/', trim($c[2])) as $name) {
					if (in_array($name, self::LANDING_CLASSES, TRUE) || preg_match('/^fa-[a-z0-9-]{1,40}$/', $name))
						$keep[] = $name;
				}
			}
			return '<' . $m[1] . ($keep ? ' class="' . implode(' ', array_unique($keep)) . '"' : '') . $m[3] . '>';
		}, $v);

		// only the photo placeholders that will be filled
		$v = preg_replace_callback('/\{\{\s*image(\d+)\s*\}\}/i', function ($m) use ($images) {
			return (int) $m[1] >= 1 && (int) $m[1] <= $images ? '{{image' . (int) $m[1] . '}}' : '';
		}, $v);

		return mb_substr(trim($v), 0, 40000);
	}

	/** Simple HTML: allowed tags only, without any attribute */
	protected function html($v)
	{
		if (!is_string($v))
			return '';
		$v = preg_replace('#<(script|style|iframe|object|embed|template)\b[^>]*>.*?</\1\s*>#is', '', $v);
		$v = strip_tags($v, self::HTML_TAGS);
		$v = preg_replace('#<([a-z][a-z0-9]*)\b[^>]*?(/?)>#i', '<$1$2>', $v);
		return mb_substr(trim($v), 0, 20000);
	}
}

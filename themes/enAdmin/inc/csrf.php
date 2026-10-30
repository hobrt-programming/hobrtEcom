<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
/* Adds the CSRF token to every POST sent from the admin panel:
   regular forms, jQuery $.ajax, Dropzone and any other XMLHttpRequest. */
(function () {
	var name = <?php echo json_encode($this->security->get_csrf_token_name()); ?>,
		hash = <?php echo json_encode($this->security->get_csrf_hash()); ?>;

	window.HB_CSRF = { name: name, hash: hash };

	function addToForm(form) {
		if (!form || (form.getAttribute('method') || '').toLowerCase() !== 'post') return;
		if (form.querySelector('input[name="' + name + '"]')) return;
		var input = document.createElement('input');
		input.type = 'hidden';
		input.name = name;
		input.value = hash;
		form.appendChild(input);
	}

	document.addEventListener('DOMContentLoaded', function () {
		var forms = document.querySelectorAll('form');
		for (var i = 0; i < forms.length; i++) addToForm(forms[i]);
	});

	// capture phase: runs before page handlers that build new FormData(this)
	document.addEventListener('submit', function (e) { addToForm(e.target); }, true);

	var open = XMLHttpRequest.prototype.open,
		setHeader = XMLHttpRequest.prototype.setRequestHeader,
		send = XMLHttpRequest.prototype.send;

	XMLHttpRequest.prototype.open = function (method) {
		this._hbMethod = String(method).toUpperCase();
		this._hbType = null;
		return open.apply(this, arguments);
	};

	XMLHttpRequest.prototype.setRequestHeader = function (header, value) {
		if (String(header).toLowerCase() === 'content-type') this._hbType = String(value).toLowerCase();
		return setHeader.apply(this, arguments);
	};

	XMLHttpRequest.prototype.send = function (body) {
		if (this._hbMethod === 'POST') {
			var pair = name + '=' + encodeURIComponent(hash);
			if (window.FormData && body instanceof FormData) {
				if (!body.has(name)) body.append(name, hash);
			} else if (body === undefined || body === null || body === '') {
				if (!this._hbType) setHeader.call(this, 'Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
				body = pair;
			} else if (typeof body === 'string' && (!this._hbType || this._hbType.indexOf('application/x-www-form-urlencoded') === 0)) {
				if (body.indexOf(name + '=') === -1) body += '&' + pair;
			}
		}
		return send.call(this, body);
	};
})();
</script>

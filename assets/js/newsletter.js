/*
 * Newsletter signup for the store themes: any <form data-newsletter> posts its
 * email to ajax/subscribe and shows the reply in its [data-newsletter-msg].
 */
(function () {
	"use strict";

	document.querySelectorAll("form[data-newsletter]").forEach(function (form) {
		var msg = form.parentNode.querySelector("[data-newsletter-msg]");

		form.addEventListener("submit", function (e) {
			e.preventDefault();

			var button = form.querySelector("[type=submit]");
			if (button) button.disabled = true;

			fetch(form.action, {
				method: "POST",
				headers: { "X-Requested-With": "XMLHttpRequest" },
				body: new FormData(form)
			})
				.then(function (r) { return r.json(); })
				.then(function (reply) {
					if (msg) {
						msg.textContent = reply.message;
						msg.style.color = reply.ok ? "#198754" : "#dc3545";
					}
					if (reply.ok) form.reset();
				})
				.catch(function () {
					if (msg) msg.textContent = form.getAttribute("data-error") || "Error";
				})
				.then(function () {
					if (button) button.disabled = false;
				});
		});
	});
})();

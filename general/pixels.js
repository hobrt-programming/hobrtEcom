function eventAddToCart(value = 0, items = [], currency = 'USD') {
	
	if(typeof fbq !== 'undefined')
		fbq('track', 'AddToCart');

	if(typeof ttq !== 'undefined')
		ttq.track('AddToCart');

	if(typeof snaptr !== 'undefined')
		snaptr('track', 'ADD_CART');

	
	if(typeof gtag !== 'undefined')
		gtag("event", "add_to_cart", {
			currency: currency,
			value: value,
			items: items
		});

}

function eventPurchais(value, currency, items = []) {
	
	if(typeof fbq !== 'undefined')
		fbq('track', 'Purchase', {currency: currency, value: value});

	if(typeof ttq !== 'undefined')
		ttq.track('PlaceAnOrder', {currency: currency, value: value});

	if(typeof snaptr !== 'undefined')
		snaptr('track', 'PURCHASE', {'currency': currency, 'price': value});

	if(typeof gtag !== 'undefined')
		gtag("event", "purchase", {
			currency: currency,
			value: value,
			transaction_id: Math.floor(Math.random() * 99999999 + 10000000),
			items: items
		});
}
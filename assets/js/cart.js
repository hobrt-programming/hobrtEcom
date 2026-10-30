/* popup texts in the store language, set by the theme footer (window.hbCartText) */
function cartText(key, fallback) {
	return (window.hbCartText && window.hbCartText[key]) || fallback;
}

function addToCart(to = 1) {
	
	var dataForm = $("#productInfo").serialize();

	$.ajax({
		url : base_url + "ajax/addToCart",
		type : 'post',
		data : dataForm,
		success : function(response){
			if(typeof fbq !== 'undefined')
				fbq('track', 'AddToCart');
			if(to == 1)
				window.location.href = base_url + "cart";
			else {
				Swal.fire({
					title: cartText('added', 'Added to cart'),
					text: cartText('addedText', 'The product has been added to your cart.'),
					icon: 'success',
					showCancelButton: true,
					confirmButtonColor: '#f05036',
					cancelButtonColor: '#6c757d',
					confirmButtonText: cartText('checkout', 'Checkout now'),
					cancelButtonText: cartText('continue', 'Continue shopping')
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = base_url + "cart";
					}
				})
			}

		}		
	});

}

function deleteFromCart(id, ele) {

	var el = $(ele);

	$.ajax({
		url : base_url + "/ajax/deleteFromCart",
		type : 'post',
		data : {
			id : id,
		},
		success : function(response){
			Swal.fire({
				title: cartText('removed', 'Removed from cart'),
				text: cartText('removedText', 'The product has been removed from your cart.'),
				icon: 'success'
			});

			el.parent().remove()
		}		
	});	

}

$(function() {
	"use strict";



	if ($('#imageGallery').length && $.fn.lightSlider) $('#imageGallery').lightSlider({
		gallery:true,
		item:1,
		loop:true,
		thumbItem:9,
		slideMargin:0,
		enableDrag: false,
		currentPagerPosition:'left',
		onSliderLoad: function(el) {
			el.lightGallery({
				selector: '#imageGallery .lslide',
				rotate: false,
				fullScreen: false,
				download: false,
				share: false,
				actualSize: false,
				thumbnail: false
			});
		}   
	});

	$('.addQty').click(function() {

		var qty = $(this).prev();

		var oldQty = parseInt(qty.val());

		qty.val(oldQty + 1);

	})

	$('.subQty').click(function() {

		var qty = $(this).next();

		var oldQty = parseInt(qty.val());

		if(oldQty > 1)
			qty.val(oldQty - 1);

	})

})
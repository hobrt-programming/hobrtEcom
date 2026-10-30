$(document).ready(function (){
	/*$('.carousel').carousel({
	  interval: 2000
	})*/

 // FIXED NAVBAR
	$(window).on('scroll', function(){
		var scrollBody = $('html, body').scrollTop();

		if( scrollBody > 100 ){
			$('.navbar').css({position: 'fixed', padding: '16px'});
			$('.navbar').addClass('navbar-fixed-top');
		}else{
			$('.navbar').css({position: 'relative', padding: '25px'});
			$('.navbar').removeClass('navbar-fixed-top');
		}

	});

		// Page PRODUCT.html -> form -> qte ( الكمية )

	$('span#plus-qte').on('click', function(){

		var qte = parseInt( $('#qte').val() ) + 1;
		$('#qte').val( qte );
	});

	$('span#minus-qte').on('click', function(){
		var qte = parseInt( $('#qte').val() );

		if(qte > 0 ){
			var qte = parseInt( $('#qte').val() ) - 1;
			$('#qte').val( qte );
		}

	})

	$(document).on('click', '.orderClick', function() {

		var name = $("input[name='fullname']").val();
		var city = $("input[name='city']").val();
		var phone = $("input[name='phone']").val();
		var qty = $("input[name='qty']").val();

		var sub = true;

		if(name == "") {
			sub = false;
			$("input[name='fullname']").css("border-color", "red");
		}
		if(city == "") {
			sub = false;
			$("input[name='city']").css("border-color", "red");
		}
		if(phone == "") {
			sub = false;
			$("input[name='phone']").css("border-color", "red");
		}

		if(qty <= 0) {
			sub = false;
			$("input[name='qty']").css("border-color", "red");
		}

		if(sub) {

			var dataForm = $("#formData").serialize();

			$.ajax({
				url : base_url + "ajax/addToCart",
				type : 'post',
				data : dataForm,
				success : function(response){
					if(typeof fbq !== 'undefined')
						fbq('track', 'AddToCart');
					$("#orderNow").submit();
				}		
			});


		}


	})

});

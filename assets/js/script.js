// Strict Mode
var timer;

// Window Load Event
$(window).on("load", function() {

    return false;
});

// Document Ready event
$(document).on("ready", function() {

	$(".lx-hero-item").each(function(){
		$(this).css({"background":"url("+$(this).attr("data-bg")+") no-repeat","background-size":"cover","height":($(this).width()*0.7)+"px"});
	});

	if($(".lx-total-costs strong").length){
		var price = 0;
		$(".lx-cart-products-list .lx-price-total strong").each(function(){
			price += parseFloat($(this).text());
		})
		price += parseFloat($(".lx-shipping-costs b").text());
		$(".lx-total-costs strong").text(price.toFixed(0) + "DH");
		$("input[name='totalprice']").val(price.toFixed(0));	
	}	
	
	return false;
});

$(".lx-mobile-menu a").on("click",function(){
	if($(".lx-main-menu").css("left") !== "0px"){
		$(".lx-main-menu").css("left","0px");
	}
	else{
		$(".lx-main-menu").css("left","-102%");
	}
});

$(".lx-product-qty .lx-plus").on("click",function(){
	if($(this).prev("input").val() < parseInt($(this).prev("input").attr("data-max"))){
		$(this).prev("input").val(parseInt($(this).prev("input").val()) + 1);
	}
	if($("#qty").length){
		var cartcookie = "ID:" + $("#idproduct").val() + ";" + $("#qty").val();
		if($(".lx-sizes").length){
			cartcookie += ";Taille:" + $(".lx-sizes a.active").text();
		}
		if($(".lx-colors").length){
			cartcookie += ";Couleur:" + $(".lx-colors a.active").text();
		}
		$("#cartcookie").val(cartcookie);		
	}
	else{
		$(this).parent().parent().parent().find(".lx-price-total strong").text(($(this).attr("data-price") * $(this).prev("input").val()).toFixed(0) +  "DH");
		var price = 0;
		$(".lx-price-total strong").each(function(){
			price += parseFloat($(this).text());
		})
		price += parseFloat($(".lx-shipping-costs b").text());
		$(".lx-total-costs strong").text(price.toFixed(0) + "DH");
		$("input[name='totalprice']").val(price.toFixed(0));
	}
});

$(".lx-product-qty .lx-minus").on("click",function(){
	if($(this).next("input").val() > 1){
		$(this).next("input").val(parseInt($(this).next("input").val()) - 1);
	}
	if($("#qty").length){
		var cartcookie = "ID:" + $("#idproduct").val() + ";" + $("#qty").val();
		if($(".lx-sizes").length){
			cartcookie += ";Taille:" + $(".lx-sizes a.active").text();
		}
		if($(".lx-colors").length){
			cartcookie += ";Couleur:" + $(".lx-colors a.active").text();
		}
		$("#cartcookie").val(cartcookie);
	}
	else{
		$(this).parent().parent().parent().find(".lx-price-total strong").text(($(this).attr("data-price") * $(this).next("input").val()).toFixed(0) +  "DH");
		var price = 0;
		$(".lx-cart-products-list .lx-price-total strong").each(function(){
			price += parseFloat($(this).text());
		})
		price += parseFloat($(".lx-shipping-costs b").text());
		$(".lx-total-costs strong").text(price.toFixed(0) + "DH");
		$("input[name='totalprice']").val(price.toFixed(0));
	}
});

$(".lx-sizes a").on("click",function(){
	$(".lx-sizes a").removeClass("active");
	$(this).addClass("active");
	var cartcookie = "ID:" + $("#idproduct").val() + ";" + $("#qty").val();
	if($(".lx-sizes").length){
		cartcookie += ";Taille:" + $(".lx-sizes a.active").text();
	}
	if($(".lx-colors").length){
		cartcookie += ";Couleur:" + $(".lx-colors a.active").text();
	}
	$("#cartcookie").val(cartcookie);
});

$(".lx-colors a").on("click",function(){
	$(".lx-colors a").removeClass("active");
	$(this).addClass("active");
	var cartcookie = "ID:" + $("#idproduct").val() + ";" + $("#qty").val();
	if($(".lx-sizes").length){
		cartcookie += ";Taille:" + $(".lx-sizes a.active").text();
	}
	if($(".lx-colors").length){
		cartcookie += ";Couleur:" + $(".lx-colors a.active").text();
	}
	$("#cartcookie").val(cartcookie);
});

$(".lx-product-images ul li img").on("click",function(){
	$(".lx-product-main-img img").attr("data-nb",$(this).parent().index());
	$(".lx-product-main-img img").attr("src",$(this).attr("src").replace(/_m/,""));
});

$(".lx-purchase-btns-floating a").on("click",function(){
	$(".lx-add-to-cart").html('<i class="fas fa-circle-notch fa-spin"></i> المرجو الانتظار');

	var id = $(this).data("id");
	var q = $("#qty").val();

	$.ajax({
		url : base_url + "ajax/addToCart",
		type : 'post',
		data : {
			id : id,
			q : q
		},
		success : function(response){
			if(fbq != undefined)
				fbq('track', 'AddToCart');
			window.location.href = base_url + "cart";
		}		
	});		
});

$(".lx-add-to-cart").on("click",function(){
	$(".lx-add-to-cart").html('<i class="fas fa-circle-notch fa-spin"></i> المرجو الانتظار');

	var id = $(this).data("id");
	var q = $("#qty").val();

	$.ajax({
		url : base_url + "ajax/addToCart",
		type : 'post',
		data : {
			id : id,
			q : q
		},
		success : function(response){
			if(fbq != undefined)
				fbq('track', 'AddToCart');
			window.location.href = base_url + "cart";
		}		
	});		
});
$(".lx-applycoupon").on("click",function(){

	var coupon = $("#coupon").val();

	$(this).remove();

	$.ajax({
		url : base_url + "ajax/validCoupon",
		type : 'post',
		data : {
			coupon : coupon
		},
		success : function(response){
			if(response == 0)
			{
				alert("ended");
			}else {

				var tp = parseInt($(".totalprice").text().replace("DH", ""));

				var ship = parseInt($(".ship").text().replace("DH", ""));


				var disc = (tp - ship) * parseInt(response) / 100;

				$(".couponUse").html("الكوبون <b>- "+ disc +" DH</b>");

				$("#value").val(tp - disc);

				var ship = parseInt($(".ship").text());

				var totalprice = tp - disc;

				$(".lx-total-costs strong").html(totalprice + " DH");

			}
		}		
	});		
});


// Scroll Effect
$(document).scroll(function() {
	if($(".lx-purchase-btns-floating").length){
		if($(this).scrollTop() > ($(".lx-purchase-btns").offset().top + 60)){

			$(".lx-purchase-btns-floating").fadeIn();
		}
		else{
			$(".lx-purchase-btns-floating").fadeOut();
		}				
	}	
	
    return false;
});

$(".lx-continue-shopping").on("click",function(){
	$(".lx-order").css("display","none");
});

$(".lx-delete-cookie").on("click",function(){
	var el = $(this);
	var id = $(this).data("id");
	$.ajax({
		url : base_url + "/ajax/deleteFromCart",
		type : 'post',
		data : {
			id : id,
		},
		success : function(response){
			el.parent().parent().remove();
			var price = 0;
			$(".lx-cart-products-list .lx-price-total strong").each(function(){
				price += parseFloat($(this).text());
			})
			price += parseFloat($(".lx-shipping-costs b").text());
			$(".lx-total-costs strong").text(price.toFixed(0) + "DH");
			$("input[name='totalprice']").val(price.toFixed(0));
			$(".lx-floating-response").remove();
			window.clearTimeout(timer);
			$("body").append('<div class="lx-floating-response"><p class="lx-succes"><i class="material-icons">error_outline</i> تمت الإزالة من السلة<i class="material-icons">close</i></p></div>');
			$(".lx-floating-response").fadeIn();
			timer = window.setTimeout(function(){
				$(".lx-floating-response").fadeOut();
			},5000);
		}		
	});	
});

$("body").delegate(".lx-floating-response","click",function(){
	$(".lx-floating-response").fadeOut();
});

$(".lx-cart-next-step a").on("click",function(){
	var save = "yes";
	$(".lx-cart-info-address input").removeAttr("style");
	$(".lx-cart-info-address select").removeAttr("style");
	if($("input[name='fullname']").val() === ""){
		$("input[name='fullname']").css("border-color","red");
		save = "no";
	}
	var patt = /^0[0-9]{1}[0-9]{8}$/;
	if(!patt.test($("input[name='phone']").val())){
		$("input[name='phone']").css("border-color","red");
		save = "no";
	}
	if($("select[name='city']").val() === ""){
		$("select[name='city']").css("border-color","red");
		save = "no";
	}
	if($(".items").length == 0){
		save = "noproduct";
	}
	if(save === "yes"){
		if(fbq != undefined)
			fbq('track', 'Purchase', {currency: 'MAD', value: $("#value").val()});
		$("#sendcart").submit();
	}
	else if(save === "noproduct"){
		$(".lx-floating-response").remove();
		window.clearTimeout(timer);
		$("body").append('<div class="lx-floating-response"><p class="lx-error"><i class="material-icons">check</i> السلة فارغة<i class="material-icons">close</i></p></div>');
		$(".lx-floating-response").fadeIn();
		timer = window.setTimeout(function(){
			$(".lx-floating-response").fadeOut();
		},5000);		
	}
	else{
		$(".lx-floating-response").remove();
		window.clearTimeout(timer);
		$("body").append('<div class="lx-floating-response"><p class="lx-error"><i class="material-icons">error_outline</i> المرجو ملأ الاستمارة بالكامل<i class="material-icons">close</i></p></div>');
		$(".lx-floating-response").fadeIn();
		timer = window.setTimeout(function(){
			$(".lx-floating-response").fadeOut();
		},5000);		
	}
});

$('.popup').on("click",function() {
	var NWin = window.open($(this).attr('href'), '', 'scrollbars=1,height=300,width=600');
	if (window.focus){
		NWin.focus();
	}
	return false;
});


$(".lx-cart-info-address select[name='city']").on("change",function(){
	if($(".lx-shipping-costs b").text() !== "0DH"){
		if($(this).val() === "Casablanca"){
			$(".lx-shipping-costs b").text("25DH");
		}
		else{
			$(".lx-shipping-costs b").text("45DH");
		}		
	}
	var price = 0;
	$(".lx-cart-products-list .lx-price-total strong").each(function(){
		price += parseFloat($(this).text());
	})
	price += parseFloat($(".lx-shipping-costs b").text());
	$(".lx-total-costs strong").text(price.toFixed(0) + "DH");
	$("input[name='totalprice']").val(price.toFixed(0));
});

$(".lx-contact-us > a").on("click",function(){
	if($(".lx-contact-us-content").css("display") !== "block"){
		$(".lx-contact-us-content").css("display","block");
		$(this).find("i").attr("class","fa fa-times");
	}
	else{
		$(".lx-contact-us-content").css("display","none");
		$(this).find("i").attr("class","fa fa-phone");
	}
});

$(".lx-float-numbers").on("keypress",function(event){
	return ((event.charCode >= 44 && event.charCode <= 57) && event.charCode !== 47 && event.charCode !== 45) || event.charCode === 0;
});
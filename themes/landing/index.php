<?php

$btn = '<button class="btn-move"> <i class="fas fa-shopping-cart"></i> أطلب الان</button>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$p->title;?></title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


	<base href="<?php echo base_url(); ?>">
	<link rel="stylesheet" href="assets/landing/blocks.css">

	<?php if (isset($code_header)) : ?>

		<?php foreach ($code_header as $code) : ?>

			<?php echo $code->content; ?>

		<?php endforeach; ?>

	<?php endif; ?>

	<?php $pixels = $p->pixel;
		if(!empty($pixels)) { ?>

		<script>
			!function(f,b,e,v,n,t,s)
			{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};
			if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
			n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t,s)}(window, document,'script',
			'https://connect.facebook.net/en_US/fbevents.js');

			<?php
			
			$pixels = trim($pixels);
			
			$pixels = explode("/", $pixels);

			foreach ($pixels as $pixel) { ?>

				fbq('init', '<?=trim($pixel);?>');

			<?php } ?>

			fbq('track', 'PageView');
		</script>

	<?php } ?>

	<style>

body {
		overflow-x: hidden;
		--lp-main: <?php echo html_escape($p->header_color ?: '#4e73df'); ?>;
		--lp-on: <?php echo html_escape($p->btn_color ?: '#ffffff'); ?>;
	}

	body, html, * {
		padding: 0;
		margin: 0;
		font-family: 'Cairo', sans-serif;
		box-sizing: border-box;
	}

	.container {
		max-width: 1112px;
		margin: auto;
		text-align: center;
		padding:0 15px;
		overflow-x: hidden;
	}

	.section1 {
		background: #aaee55;
		height: 60px;
		line-height: 60px;
		margin-bottom: 15px;
		text-align: center;
	}

	.section1 h2 {
		font-size: 1rem;
	}

	img {
		max-width: 100%;
		border-radius: 5px;
	}

	.btn-move {
		animation-name: moves;
		background: #aaee55;
		padding: 2px 30px;
		border-radius: 10px;
		font-size: 32px;
		text-decoration: none;
		color: #000;
		box-shadow: 0px 6px 3px -1px #444;
		animation-duration: 200ms;
		animation-iteration-count: infinite;
		animation-direction: alternate-reverse;
		width: calc(100% - 20px);
		border: 0;
		margin: 15px 0;
	}

	.btn-move i {
		float: left;
		line-height: 64px;
	}

	@keyframes moves {
		0%   {margin-right: 20px;}
		100% {margin-right: -20px}
	}

	.list-options1 {
		list-style: none;
		background: #eeffdd;
		border: 2px solid orange;
		margin: 15px 0;
		border-radius: 5px;
	}


	.list-options1 li:before {
		content: '✓';
		font-size: 25px;
	}
	.flex1 {
		display: flex;
		justify-content: space-around;
	}

	.flex1 img {
		width: 25%;
		border: 4px solid #71c6e6;
		border-radius: 5px;
	}
	.progress {
		width: 100%;
		margin: auto;
		height: 30px;
		background: #ffbcbc;
		border-radius: 10px;
	}
	.progress .p98 {
		background: #aaee55;
		height: 30px;
		width: 98%;
		border-radius: 10px;
	}	

	.form {
		max-width: 1100px;
		margin: 10px auto;
		padding: 16px;
		border: #cf0628 2px dashed;
		border-radius: 10px;
	}

	.form input, .form button, .form select {
		width: 100%;
		height: 50px;
		padding:0 22px;
		color: #7a7a7a;
		background-color: #fff;
		border: 1px solid #988a88;
		border-radius: 5px;
		margin-bottom: 4%;
	}

	.form button {
		background: #cf0628;
		color: white;
		font-size: 20px;
	}

		.whatsapp {
			width: 100%;
		    height: 40px;
		    margin-top: 20px;
		    text-align: center;
		    display: block;
		    line-height: 40px;
		    font-weight: bold;
		    color: white;
		    background: #44c453;
		    text-decoration: none;
		}

		.whatsapp i {
			font-size: 16px;
		}

	.flex2 {
		display: flex;
		margin-bottom: 10px;
	}

	.flex2 p i {
		color: orange;
	}

	.flex2 img {
		border-radius: 50%;
	}

	.flex2 div {
		padding-right: 10px;
		text-align: right;
		line-height: 20px;
	}

	.btn-order {
		background: #33b99d;
		border-radius: 5px;
		padding: 10px 20px;
		color: white;
		text-decoration: none;
		width: 100%;
		display: block;
	}

	.item {
		background: #fff;
		margin:0 20px;
		padding: 10px;
		border: 5px solid #ccc;
	}

	.frtl {
		text-align: right;
	}

	.section1, .btn-move, .form button, .timer .circle, header {
		background: <?php echo $p->header_color; ?>;
		color: <?php echo $p->btn_color; ?>;
	}
	
	span.oldprice {
    color: #aaa;
    text-decoration: line-through;
}

	.timer {
		    display: flex;
		    justify-content: center;
		    margin: 15px 0;
		}
		.timer .circle {
		    height: 60px;
		    width: 60px;
		    border-radius: 50%;
		    font-size: 30px;
		    margin: 0 5px;
		}

		header {
			padding: 10px;
			text-align: center;
		}
		.head {
			padding: 10px;
			text-align: center;
			box-shadow: 1px 4px 10px 0px #ccc;
			margin-bottom: 30px;
		}

		#alert-not-all-filled {
			position: fixed;
			bottom: 0;
			width: 100vw;
			text-align: center;
			background: #ff0000;
			z-index: 99; display: none;
			height: 50px;
			color: #fff;
			font-weight: bold;
			line-height: 50px;
		}


		.reviews {
    text-align: center;
    padding: 20px;
}

.card-list {
    direction: ltr;
}

.card {
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-bottom: 1px solid #ddd;
}

.card-content {
    padding: 20px;
}

.card-content h3 {
    margin-bottom: 10px;
    font-size: 1.2em;
}

.stars {
    color: #ffd700;
    margin-bottom: 10px;
}

.stars i {
    font-size: 1.2em;
}

.small {
    font-size: 0.8em;
    color: #777;
}

.review-avatar {
	width: 90px;
	height: 90px;
	margin: 10px auto;
	border-radius: 50%;
	background: var(--lp-main);
	color: var(--lp-on);
	font-size: 2.4rem;
	font-weight: 900;
	display: flex;
	align-items: center;
	justify-content: center;
}

.card-content p {
    margin-top: 10px;
    font-size: 1em;
    line-height: 1.5;
    color: #333;
}


	</style>

</head>
<body dir="rtl">

	<header>
		<p><?php echo $p->title; ?></p>
	</header>

	<div class="head">
		<a href="<?= base_url("/") ?>"><img src="<?= store_logo() ?>" style="height:55px" alt="logo.png" class="logo"></a>
	</div>

	<div class="container">
		<section>
			<div><?php echo preg_replace_callback("|{{btn}}|", fn() => $btn, $p->content); ?></div>
		</section>



		<?php $reviews = json_decode((string) $p->reviews) ?: array(); ?>
		<?php if ($reviews): ?>
		<section class="reviews">
    <h1>شهادات نعتز بها</h1>
    <div class="card-list">
        <?php foreach ($reviews as $review) { ?>
			<div style="padding: 10px;">
            <div class="card">
                <div class="card-image">
					<?php if (!empty($review->image)): ?>
                    <img src="uploads/<?php echo html_escape(add_thumb($review->image, "")); ?>" alt="">
					<?php else: ?>
					<div class="review-avatar"><?php echo html_escape(mb_substr(trim((string) $review->name), 0, 1)); ?></div>
					<?php endif; ?>
                </div>
                <div class="card-content">
                    <h3><?php echo html_escape($review->name) ?></h3>
                    <p class="stars">
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
                    </p>
                    <small><?php echo html_escape($review->city ?? '') ?></small>
                    <p><?php echo html_escape($review->text); ?></p>
                </div>
            </div>
			</div>
        <?php } ?>
    </div>
</section>
		<?php endif; ?>

		<section class="form" id="menudiv">

			<?php
			// the landing page is written in Arabic: always the Arabic currency name (settings)
			$cur = html_escape(currency_label(TRUE));
			$one = floor($p->price * (100 - $p->discount) / 100);
			?>
			<h2>اطلب الان ب <?php echo $one; ?> <?= $cur ?> فقط !</h2>

			<div class="timer">
								
				<div>
					
					<div class="circle">41</div>
					ثواني

				</div>
				<div>
					
					<div class="circle">41</div>
					دقائق

				</div>
				<div>
					
					<div class="circle">41</div>
					ساعات

				</div>
				<div>
					
					<div class="circle">41</div>
					ايام

				</div>


			</div>

			<form method="post" action="<?php echo base_url("l/order") ?>" id="formOrder">

				<select name="qty" id="select_element" required>

					<option value="1" data-price="<?php echo $one; ?>">واحدة (<?php echo $one; ?> <?= $cur ?>)</option>
					<?php if($p->price2 > 0) : ?><option value="2" data-price="<?php echo $p->price2; ?>">2 فقط ب (<?php echo $p->price2; ?> <?= $cur ?>)</option> <?php endif; ?>
					<?php if($p->price3 > 0) : ?><option value="3" data-price="<?php echo $p->price3; ?>">3 فقط ب (<?php echo $p->price3; ?> <?= $cur ?>) + واحدة مجانا</option> <?php endif; ?>

				</select>
				
				<input type="text" placeholder="الإسم الكامل" name="fullname" required>

				<input type="text" placeholder="المدينة" name="city" required>

				<input type="text" placeholder="رقم الهاتف" name="phone" required>

				<input type="hidden" name="id" value="<?php echo $p->id; ?>">

				<input type="hidden" name="order" value="yes">

				<button type="button" onclick="ordernow();" name="order">إضغط هنا لتأكيد طلبك</button>
				
			</form>

		</section>

		<div class="sticky">

		</div>

	</div>


<div id="alert-not-all-filled" style="">
	<div>
		<p class="text-white">الرجاء ادخال جميع البيانات المطلوبة </p>
	</div>
</div>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" ></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

	<script>


		function ordernow() {

			var total = $('#select_element option:selected').data('price');
			
			var save = "yes";
			
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

			
            
            if(save == "yes"){
                
                if(typeof fbq !== 'undefined')
				    fbq('track', 'Purchase', {currency: <?= json_encode((string) setting('currency')) ?>, value: total});
                
			    $("#formOrder").submit();
			    
            }
			else {
				$('#alert-not-all-filled').slideDown();
				setInterval(function () {$('#alert-not-all-filled').slideUp();}, 5000);
			}
			    
		    return false;

		}

		$(".btn-move").click(function() {

			document.querySelector('#menudiv').scrollIntoView({
				behavior: 'smooth' 
			});

		});


		$('.card-list').slick({
			dots: true,
			infinite: true,
			speed: 300,
			slidesToShow: 3,
			slidesToScroll: 1,
			responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
    ]
});


		function pad(r) {
			return ("000" + r).slice(-2);
		}
		function progress(r, i, o) {
			r > 0 &&
			setTimeout(function () {
				progress(r - 1, i, o);
			}, 1e3);
			var e = Math.floor(r / 3600),
			s = r % 3600;
			console.log();
			var t = Math.floor(s / 60);
			sec = Math.floor(s % 60);
			var c = '<div><div class="circle">' + pad(sec) + '</div>ثواني</div><div><div class="circle">' + pad(t) + '</div>دقائق</div><div><div class="circle">' + pad(e) + '</div>ساعات</div><div><div class="circle">00</div>ايام</div>';
			$(".timer").html(c);
		}
		$(".btn-a").click(function () {
			$(".order").slideDown(1e3);
		}),
		(Number.prototype.pad = function (r) {
			for (var i = String(this); i.length < (r || 2); ) i = "0" + i;
				return "<b>" + i + "</b>";
		}),
		progress(3e3 * Math.random() + 600, 3600, $("#progressBar"));
		
</script>

</body>
</html>
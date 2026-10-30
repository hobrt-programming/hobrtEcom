<?php foreach($info as $p) : ?>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<base href="<?php echo base_url(); ?>">

	<script>
		var base_url = "<?php echo base_url(); ?>";
	</script>

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300&display=swap" rel="stylesheet">
	<style>
		@import url(//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css);
		@import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
	</style>

	<style>
	
	

.cf:before,
.cf:after {
    content: " ";
    display: table;
}
.cf:after {
    clear: both;
}

* {
	box-sizing: border-box;
}

html {
	font-size: 16px;
	background-color: #fffffe;
}
body {
	padding: 0 20px;
	min-width: 300px;
	background-color: #fffffe;
	color: #1a1a1a;
	text-align: center;
	word-wrap: break-word;
	-webkit-font-smoothing: antialiased
}
a:link,
a:visited {
	color: #00c2a8;
}
a:hover,
a:active {
	color: #03a994;
}

.site-header {
	margin: 0 auto;
	padding: 80px 0 0;
	max-width: 820px;
}
.site-header__title {
	margin: 0;
	font-size: 2.5rem;
	font-weight: 700;
	line-height: 1.1;
	text-transform: uppercase;
	-webkit-hyphens: auto;
	-moz-hyphens: auto;
	-ms-hyphens: auto;
	hyphens: auto;
}

.main-content {
	margin: 0 auto;
	max-width: 820px;
}
.main-content__checkmark {
	font-size: 4.0625rem;
	line-height: 1;
	color: #24b663;
}
.main-content__body {
	margin: 20px 0 0;
	font-size: 1rem;
	line-height: 1.4;
}


.site-footer {
	margin: 0 auto;
	padding: 80px 0 25px;
	padding: 0;
	max-width: 820px;
}
.site-footer__fineprint {
	font-size: 0.9375rem;
	line-height: 1.3;
	font-weight: 300;
}


@media only screen and (min-width: 40em) {
	.site-header {
		padding-top: 150px;
	}
	.site-header__title {
		font-size: 6.25rem;
	}
	.main-content__checkmark {
		font-size: 9.75rem;
	}
	.main-content__body {
		font-size: 1.25rem;
	}
	.site-footer {
		padding: 145px 0 25px;
	}
	.site-footer__fineprint {
		font-size: 1.125rem;
	}
}
	    
	    body {
	        font-family: 'Cairo', sans-serif;
	    }


	    .flex1 {
	    	display: flex;
	    	max-width: 100%;
	    	flex-wrap: wrap;
	    	justify-content: space-between;
	    }

	    .flex1 .item {
	    	width: 25%;
	    	padding: 10px;
	    }

	    img {
	    	max-width: 100%;
	    }

	    .all {
	    	max-width: 1200px;
	    	text-align: center;
	    	margin: auto;
	    	padding: 10px;
	    }

	    .price_pd span {
	    	text-decoration: line-through;
	    	color: #b1b1b1;
	    }

	    .btn {
		    border-radius: 5px;
		    padding: 6px 16px;
		    border: 0;
		    font-size: 22px;
		    text-decoration: none;
		    margin: 20px;
		    color: #fff;
		    position: relative;
		    display: inline-block;
		    background-color: #55acee;
    		box-shadow: 0px 5px 0px 0px #3c93d5;
		}

        .subs_form {
          display: flex;
          flex-wrap: wrap
        }
        
        .subs_form > input {
            flex: 1 1 10ch;
            margin: .5rem
          }
        
        .subs_form > input[type="email"] {
              flex: 3 1 30ch;
            }
        
        .subs_form input {
          border: none;
          background: hsl(0, 0%, 93%);
          border-radius: .25rem;
          padding: .75rem 1rem
        }
        
        .subs_form input[type="submit"] {
            background: hotpink;
            color: white;
            box-shadow: 0 .75rem .5rem -.5rem hsl(0, 50%, 80%);
        }

	    
	</style>
	
	<?php if (isset($code_header)) : ?>

	<?php foreach ($code_header as $code) : ?>

		<?php echo $code->content; ?>

	<?php endforeach; ?>

	<?php endif; ?>
	
	
	
	
</head>
<body dir="rtl">
	<header class="site-header" id="header">
		<h1 class="site-header__title" data-lead-id="site-header-title">تم الطلب بنجاح</h1>
	</header>

	<div class="main-content">
		<i class="fa fa-check main-content__checkmark" id="checkmark"></i>
		<p class="main-content__body" data-lead-id="main-content-body" dir="rtl">شكرا على طلبك فريق العمل سيتواصل معك في اقرب وقت</p>
	</div>


</body>
</html>

<?php endforeach; ?>
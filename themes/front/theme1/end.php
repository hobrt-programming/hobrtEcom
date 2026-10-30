<?php include_once 'header.php'; ?>


</header>
	<style>
	
	

.cf:before,
.cf:after {
    content: " ";
    display: table;
}
.cf:after {
    clear: both;
}


.site-header {
	margin: 0 auto;
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
	padding: 0;
	max-width: 820px;
}
.site-footer__fineprint {
	font-size: 0.9375rem;
	line-height: 1.3;
	font-weight: 300;
}

.center {
	padding: 30px 0px;
}


@media only screen and (min-width: 40em) {
	.site-header__title {
		font-size: 6.25rem;
	}
	.main-content__checkmark {
		font-size: 9.75rem;
	}
	.main-content__body {
		font-size: 1.25rem;
	}
	.site-footer__fineprint {
		font-size: 1.125rem;
	}
}
	    
	</style>
<div class="center">
	<header class="site-header" id="header">
		<h1 class="site-header__title" data-lead-id="site-header-title"><?= lang("lang_h95") ?></h1>
	</header>

	<div class="main-content">
		<i class="fa fa-check main-content__checkmark" id="checkmark"></i>
		<p class="main-content__body" data-lead-id="main-content-body" dir="rtl"><?= lang("lang_h94") ?><br /><?= lang("lang_h93") ?> </p>
	</div>

</div>



<?php include_once 'footer.php'; ?>
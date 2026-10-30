/*--------------------------------------------------
Project:        Markito
Version:        1.0
Author:        Markito
-----------------------------------------------------

    JS INDEX
    ================================================
    * preloader js
    * One Page Scroll
    * slick Menu js 
    * slick Nav
    * Isotope
    * Counter
    * bottom to top
    ================================================*/

(function ($) {
  "use strict";
  var $main_window = $(window);
  /*====================================
      preloader js
    ======================================*/
  $main_window.on('load', function () {
    $('#preloader').fadeOut('slow');
  });

  /*====================================
                One Page Scroll
    ======================================*/

  // Select all »a« elements with a parent class »links« and add a function that is executed on click
  $('.navbar-nav .nav-item a').on('click', function (e) {
    // Define variable of the clicked »a« element (»this«) and get its href value.
    var href = $(this).attr('href');
    // Run a scroll animation to the position of the element which has the same id like the href value.
    $('html, body').animate({
      scrollTop: $(href).offset().top
    }, '300');
    // Prevent the browser from showing the attribute name of the clicked link in the address bar
    e.preventDefault();
  });

  /*====================================
              slick slider
  ======================================*/
  var isRtl = $('body').attr('dir') === 'rtl';


  $('.home-slider').slick({
    rtl: isRtl,
    dots: false,
    infinite: true,
    speed: 500,
    fade: true,
    arrows: true,
    cssEase: 'linear',
    responsive: [{

      breakpoint: 786,
      settings: {
        arrows: false,
        dots: false,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
      },
      breakpoint: 600,
      settings: {
        arrows: false,
        dots: false,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
      },
    }]
  });

  $('.autoplay').slick({
    rtl: isRtl,
    slidesToShow: 1,
    arrows: false,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    dots: true,
  });
/*====================================
              slick slider
  =====================================*/
  $('.product-slider').slick({
    rtl: isRtl,
  slidesToShow: 4,
  arrow:true,
  slidesToScroll: 1,
  infinite: true,
  autoplay: false,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
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

$('.one-time').slick({
    rtl: isRtl,
  dots: true,
  infinite: true,
  arrow:false,
  speed: 300,
  autoplay:false,
  autoplaySpeed: 1400,
  slidesToShow: 1,
  adaptiveHeight: true
});



// client-Slider

$('.client-Slider').slick({
    rtl: isRtl,
  infinite: true,
  slidesToShow: 5,
  arrow: false,
  dots: true,
  autoplay: false,
  autoplaySpeed: 1400,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 450,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 375,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }

  ]
});
    
  /*====================================
      sticky menu js
    ======================================*/
  var windows = $(window);
  var sticky = $('.header-fixed');
  windows.on('scroll', function () {
    var scroll = windows.scrollTop();
    if (scroll < 50) {
      sticky.removeClass('stick');
    } else {
      sticky.addClass('stick');
    }
  });
  /*====================================
      slick nav
  ======================================*/
  var logo_path = $('.mobile-menu').data('logo');
  $('.navbar-nav').slicknav({
    appendTo: '.mobile-menu'
  });
  $('.mobile-menu-button').click(function(){
    $('.navbar-nav').slicknav('toggle');
  })
  

  /*------------ Wow-js -------------*/

  new WOW().init();

  /*====================================
            bottom to top
        ======================================*/

  var btn = $('#btn-to-top');
  $(window).on('scroll', function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });
  btn.on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({
      scrollTop: 0
    }, '300');
  });


/*$(document).ready(function () {
  var count = 0;
  $("a.add-to-cart").click(function (event) {
    count++;
    $("a.add-to-cart").addClass("size");
    setTimeout(function () {
      $("a.add-to-cart").addClass("hover");
    }, 200);
    setTimeout(function () {
      $("a.cart > span").addClass("counter");
      $("a.cart > span.counter").text(count);
    }, 400);
    setTimeout(function () {
      $("a.add-to-cart").removeClass("hover");
      $("a.add-to-cart").removeClass("size");
    }, 600);
    event.preventDefault();
  });
});*/

document.addEventListener("touchstart", function(){}, true);

})(jQuery);


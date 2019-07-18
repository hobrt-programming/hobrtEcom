// Variables
"use strict";

var nbpics;
var currentpic;
var popup = $(".lx-popup").not(".legal");
var popupImg = $(".lx-popup-image img");

// espand popup click event
$(".lx-product-main-img").click(function() {
    // set nbpics to 0
    nbpics = 0;
    // get the number of pictures
    for (var i = 0; i < $(".lx-product-images ul li").length; i++) {
        // increment the number of pictures
        nbpics += 1;
    }
    // get current picture number
    currentpic = $(this).find("img").attr("data-nb");
    // transmit information to the popup
    popupImg.attr("src", $(this).find("img").attr("src"));
    popup.css({
        "display": "block"
    });
    return false;
});

// popup left arrow click event
$(".lx-popup-inside a .lx-angle-left").click(function() {
    // test if the curent picture is equal to 1 or not
    if (currentpic == 0) {
        currentpic = (nbpics - 1);
    } else {
        currentpic = parseInt(currentpic,10) - 1;
    }
    // transmit information to the popup
    popupImg.attr("src", $(".lx-product-images ul li:eq(" + currentpic + ") img").attr("src").replace(/_m/,""));
    return false;
});

// popup right arrow click event
$(".lx-popup-inside a .lx-angle-right").click(function() {
    // test if the current picture is equal to the number pictures or not
    if (currentpic == (nbpics - 1)) {
        currentpic = 0;
    } else {
        currentpic = parseInt(currentpic,10) + 1;
    }
    // transmit information to the popup
    popupImg.attr("src", $(".lx-product-images ul li:eq(" + currentpic + ") img").attr("src").replace(/_m/,""));
    return false;
});

// popup remove click event
$(".lx-popup-inside a .lx-remove").click(function() {
    // hide popup
    popup.css({
        "display": "none"
    });
    return false;
});

// Hide the popup when esc key is clicked
$(document).on("keyup", function(e) {
    if (e.keyCode === 27) {
        // hide popup
        popup.css({
            "display": "none"
        });
    }
    if (e.keyCode === 37) {
        $(".lx-popup-inside a .lx-angle-left").trigger("click");
    }	
	if (e.keyCode === 39) {
        $(".lx-popup-inside a .lx-angle-right").trigger("click");
    }	
    return false;
});

$("body").on("mouseup",function (e){
	var bloc = $(".lx-popup-inside *");
	if (!bloc.is(e.target)){
        popup.css({
            "display": "none"
        });
	}
});

// search-plus click event
$(".lx-portfolio-item").click(function(event) {
    // stop hide popup event
    event.stopPropagation();
    return false;
});

// arrows click event
$(".lx-popup-content,.lx-popup-inside a .lx-angle-left,.lx-popup-inside a .lx-angle-right", ".lx-popup").click(function(event) {
    // stop hide popup event
    event.stopPropagation();
    return false;
});
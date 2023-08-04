jQuery(function($) {

	"use strict";

	function sk_generate_slider_unique_ID() {
		return Math.round(new Date().getTime() + (Math.random() * 100));
	}

	$('.gbt_18_sk_slider').each(function() {

		var data_id = sk_generate_slider_unique_ID();
		$(this).addClass( 'swiper-' + data_id );

		var autoplay = $(this).attr('data-autoplay');
		if ($.isNumeric(autoplay)) {
			autoplay = autoplay * 1000;
		} else {
			autoplay = 10000;
		}

		var mySwiper = new Swiper( '.swiper-' + data_id, {

			// Optional parameters
		    direction: 'horizontal',
		    loop: true,
		    grabCursor: true,
			preventClicks: true,
			preventClicksPropagation: true,
			autoplay: {
			    delay: autoplay,
		  	},
			speed: 600,
			effect: 'slide',
			parallax: true,
		    // Pagination
		    pagination: {
			    el: '.swiper-' + data_id + ' .gbt_18_sk_slider_pagination',
			    type: 'bullets',
			    clickable: true
			},
		    // Navigation
		    navigation: {
			    nextEl: '.swiper-' + data_id + ' .swiper-button-next',
			    prevEl: '.swiper-' + data_id + ' .swiper-button-prev',
			},
		});

	});
});

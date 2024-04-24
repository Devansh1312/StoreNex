$(document).ready(function() {
	"use strict";

	var window_width = $(window).width(),
		window_height = window.innerHeight,
		header_height = $(".default-header").height(),
		header_height_static = $(".site-header.static").outerHeight(),
		fitscreen = window_height - header_height;

	$(".fullscreen").css("height", window_height);
	$(".fitscreen").css("height", fitscreen);

	//------- Active Nice Select --------//
	$('select').niceSelect();

	$('.navbar-nav li.dropdown').hover(
		function() {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
		},
		function() {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
		}
	);

	$('.img-pop-up').magnificPopup({
		type: 'image',
		gallery: {
			enabled: true
		}
	});

	// Search Toggle
	$("#search_input_box").hide();
	$("#search").on("click", function() {
		$("#search_input_box").slideToggle();
		$("#search_input").focus();
	});
	$("#close_search").on("click", function() {
		$('#search_input_box').slideUp(500);
	});

	/*==========================
	    JavaScript for sticky header
	============================*/
	$(".sticky-header").sticky();

	/*=================================
	    Javascript for banner area carousel
	==================================*/
	$(".active-banner-slider").owlCarousel({
		items: 1,
		autoplay: false,
		autoplayTimeout: 5000,
		loop: true,
		nav: true,
		navText: ["<img src='frontend/img/banner/prev.png'>", "<img src='frontend/img/banner/next.png'>"],
		dots: false
	});

	/*=================================
	    Javascript for product area carousel
	==================================*/
	$(".active-product-area").owlCarousel({
		items: 1,
		autoplay: false,
		autoplayTimeout: 5000,
		loop: true,
		nav: true,
		navText: ["<img src='frontend/img/product/prev.png'>", "<img src='frontend/img/product/next.png'>"],
		dots: false
	});

	/*=================================
	    Javascript for single product area carousel
	==================================*/
	$(".s_Product_carousel").owlCarousel({
		items: 1,
		autoplay: false,
		autoplayTimeout: 5000,
		loop: true,
		nav: false,
		dots: true
	});

	/*=================================
	    Javascript for exclusive area carousel
	==================================*/
	$(".active-exclusive-product-slider").owlCarousel({
		items: 1,
		autoplay: false,
		autoplayTimeout: 5000,
		loop: true,
		nav: true,
		navText: ["<img src='frontend/img/product/prev.png'>", "<img src='frontend/img/product/next.png'>"],
		dots: false
	});

	//--------- Accordion Icon Change ---------//
	$('.collapse').on('shown.bs.collapse', function() {
		$(this).parent().find(".lnr-arrow-right").removeClass("lnr-arrow-right").addClass("lnr-arrow-left");
	}).on('hidden.bs.collapse', function() {
		$(this).parent().find(".lnr-arrow-left").removeClass("lnr-arrow-left").addClass("lnr-arrow-right");
	});

	// Select all links with hashes
	$('.main-menubar a[href*="#"]')
		// Remove links that don't actually link to anything
		.not('[href="#"]')
		.not('[href="#0"]')
		.click(function(event) {
			// On-page links
			if (
				location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
				location.hostname == this.hostname
			) {
				// Figure out element to scroll to
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
				// Does a scroll target exist?
				if (target.length) {
					// Only prevent default if animation is actually gonna happen
					event.preventDefault();
					$('html, body').animate({
						scrollTop: target.offset().top - 70
					}, 1000, function() {
						// Callback after animation
						// Must change focus!
						var $target = $(target);
						$target.focus();
						if ($target.is(":focus")) { // Checking if the target was focused
							return false;
						} else {
							$target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
							$target.focus(); // Set focus again
						};
					});
				}
			}
		});

	// -------   Mail Send ajax
	$(document).ready(function() {
		var form = $('#booking'); // contact form
		var submit = $('.submit-btn'); // submit button
		var alert = $('.alert-msg'); // alert div for show alert message

		// form submit event
		form.on('submit', function(e) {
			e.preventDefault(); // prevent default form submit

			$.ajax({
				url: 'booking.php', // form action url
				type: 'POST', // form submit method get/post
				dataType: 'html', // request type html/json/xml
				data: form.serialize(), // serialize form data
				beforeSend: function() {
					alert.fadeOut();
					submit.html('Sending....'); // change submit button text
				},
				success: function(data) {
					alert.html(data).fadeIn(); // fade in response data
					form.trigger('reset'); // reset form
					submit.attr("style", "display: none !important");; // reset submit button text
				},
				error: function(e) {
					console.log(e)
				}
			});
		});
	});

	$(document).ready(function() {
		$('#mc_embed_signup').find('form').ajaxChimp();
	});

	if (document.getElementById("js-countdown")) {

		var countdown = new Date("October 17, 2018");

		function getRemainingTime(endtime) {
			var milliseconds = Date.parse(endtime) - Date.parse(new Date());
			var seconds = Math.floor(milliseconds / 1000 % 60);
			var minutes = Math.floor(milliseconds / 1000 / 60 % 60);
			var hours = Math.floor(milliseconds / (1000 * 60 * 60) % 24);
			var days = Math.floor(milliseconds / (1000 * 60 * 60 * 24));

			return {
				'total': milliseconds,
				'seconds': seconds,
				'minutes': minutes,
				'hours': hours,
				'days': days
			};
		}

		function initClock(id, endtime) {
			var counter = document.getElementById(id);
			var daysItem = counter.querySelector('.js-countdown-days');
			var hoursItem = counter.querySelector('.js-countdown-hours');
			var minutesItem = counter.querySelector('.js-countdown-minutes');
			var secondsItem = counter.querySelector('.js-countdown-seconds');

			function updateClock() {
				var time = getRemainingTime(endtime);

				daysItem.innerHTML = time.days;
				hoursItem.innerHTML = ('0' + time.hours).slice(-2);
				minutesItem.innerHTML = ('0' + time.minutes).slice(-2);
				secondsItem.innerHTML = ('0' + time.seconds).slice(-2);

				if (time.total <= 0) {
					clearInterval(timeinterval);
				}
			}

			updateClock();
			var timeinterval = setInterval(updateClock, 1000);
		}

		initClock('js-countdown', countdown);
	}

	$('.quick-view-carousel-details').owlCarousel({
		loop: true,
		dots: true,
		items: 1,
	});


	// -- sorting --//

	

	//----- Active No ui slider --------//
	$(function() {
		// Initial Setup
		var initialMinPrice = 0;
		var initialMaxPrice = 40000;
	
		// Check for URL Parameters for min_price and max_price
		var urlParams = new URLSearchParams(window.location.search);
		var minPriceParam = parseInt(urlParams.get('min_price'), 10);
		var maxPriceParam = parseInt(urlParams.get('max_price'), 10);
	
		// Update initial values if parameters are found
		if (!isNaN(minPriceParam) && !isNaN(maxPriceParam)) {
			initialMinPrice = minPriceParam;
			initialMaxPrice = maxPriceParam;
		}
	
		if (document.getElementById("price-range")) {
			var nonLinearSlider = document.getElementById('price-range');
	
			noUiSlider.create(nonLinearSlider, {
				connect: true,
				behaviour: 'tap',
				start: [initialMinPrice, initialMaxPrice],
				range: {
					'min': [0],
					'max': [500000]
				}
			});
	
			var nodes = [
				document.getElementById('lower-value'),
				document.getElementById('upper-value')
			];
	
			nonLinearSlider.noUiSlider.on('update', function(values, handle) {
				nodes[handle].innerHTML = Math.round(values[handle]);
			});
	
			$('#apply-filter').click(function() {
				var minPrice = parseInt($('#lower-value').text());
				var maxPrice = parseInt($('#upper-value').text());
				var baseUrl = window.location.href;
				var newUrl = updateQueryStringParameter(baseUrl, 'min_price', minPrice);
				newUrl = updateQueryStringParameter(newUrl, 'max_price', maxPrice);
				window.location.href = newUrl;
			});

			// Clear Filter
			$('#clear-filter').click(function() {
				// Get the base URL from the current window location
				var baseUrl = window.location.href;

				// Remove any existing min_price and max_price parameters from the URL
				var newUrl = removeQueryStringParameter(baseUrl, 'min_price');
				newUrl = removeQueryStringParameter(newUrl, 'max_price');

				// Redirect to the new URL without the filter parameters
				window.location.href = newUrl;

				// Reset the price slider to its initial range
				resetPriceSlider();
			});

			// Function to add or update URL parameters
			function updateQueryStringParameter(uri, key, value) {
				var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
				var separator = uri.indexOf('?') !== -1 ? "&" : "?";
				if (uri.match(re)) {
					return uri.replace(re, '$1' + key + "=" + value + '$2');
				} else {
					return uri + separator + key + "=" + value;
				}
			}

			// Function to remove URL parameters
			function removeQueryStringParameter(uri, key) {
				// Remove the parameter and any trailing '&'
				return uri.replace(new RegExp("([?&])" + key + "=[^&]*(&|$)", "i"), '$1').replace(/&$/, '');
			}


			// Function to update the price slider start option
			function updatePriceSlider(range) {
				var nonLinearSlider = document.getElementById('price-range');
				nonLinearSlider.noUiSlider.updateOptions({
					start: range
				});
			}

			// Function to reset the price slider to its initial range
			// function resetPriceSlider() {
			//     updatePriceSlider([500, 4000]); // Set the initial range here
			// }
		}
	});
});
// import * as Headroom from "headroom.js";
// import * as $ from "jquery";
import * as Tablesaw from "tablesaw";
import * as ScrollReveal from "scrollreveal";
// import * as Flickity from "flickity";

Tablesaw.init();

export function diviMarkupCleaner(){
	function wrap(cta, container, wrapper) {
		var el = cta.querySelector(container);
		var link = cta.querySelector(wrapper).cloneNode(false);
		el.parentNode.insertBefore(link, el);
		link.appendChild(el);
	}
	function unlinker(cta, link_class) {
		var el = cta.querySelector(link_class);
		el.outerHTML = el.innerHTML;
	}
	function appender(el, elText, elClass) {
		var newNode = document.createElement('div');
		newNode.innerHTML = elText;
		newNode.classList.add(elClass);
		el.appendChild(newNode);
	}

	//Fix cta markup
	var ctas = document.querySelectorAll('.mfb_cta');
	[].forEach.call(ctas, function(cta) {
		var link = cta.querySelector('.et_pb_promo_button');
		var wrapper_link = link.cloneNode(false);
		wrapper_link.className = '';
		cta.parentNode.insertBefore(wrapper_link, cta);
		wrapper_link.appendChild(cta);
		link.outerHTML = link.innerHTML;
	});

	//Fix icon with text
	// var iconsWithText = document.querySelectorAll('.module--icon-with-text');
	// [].forEach.call(iconsWithText, function(iconWithText) {
	// 	wrap(iconWithText, '.et_pb_blurb_content', '.et_pb_main_blurb_image a');
	// 	unlinker(iconWithText, '.et_pb_main_blurb_image a');
	// 	unlinker(iconWithText, '.et_pb_module_header a');
	// });

	//Add quote learn more markup
	var quotes = document.querySelectorAll('.et_pb_row--featured-quote .et_pb_image');
	[].forEach.call(quotes, function(quote) {
		appender(quote, 'Learn More', 'learn-more');
	});

	//Move caption inside video overlay
	var captionedVideos = document.querySelectorAll('.section--video-with-caption');
	[].forEach.call(captionedVideos, function(captionedVideo) {
		captionedVideo.querySelector('.et_pb_video_overlay').appendChild(captionedVideo.querySelector('.et_pb_text'));
	});

	let heroTitle = document.querySelector('.hero--internal h1') as HTMLElement;
	if (heroTitle) {
		var newNode = document.createElement('h2');
		newNode.innerText = heroTitle.innerText;
		var parentNode = heroTitle.parentNode;
		parentNode.insertBefore(newNode, heroTitle);
		parentNode.removeChild(heroTitle);
	}
}

export function parallax() {

	var parallaxQuote = document.querySelectorAll('.et_pb_row--featured-quote');
	var parallaxCTA = document.querySelectorAll('.mfb_cta--imagebg');
	var parallaxIconWithImage = document.querySelectorAll('.module--icon-with-text');
  let sr = ScrollReveal();

	// if any exist
	if (parallaxQuote) {

		// run scrollreveal function
		sr.reveal('.et_pb_row--featured-quote', {
			reset: false,
			// scale: 1,
			scale: 0,
			mobile: false,
			distance: '100px',
			viewFactor: 0.2,
			duration: 1000,
			opacity: 0.3,
			easing: 'cubic-bezier(0.6, 0.2, 0.1, 1)'
		});
	}

	// if (parallaxCTA) {

	// 	// run scrollreveal function
	// 	sr.reveal('.mfb_cta--imagebg', {
	// 		reset: false,
	// 		// scale: 1,
	// 		scale: 0,
	// 		mobile: false,
	// 		distance: '100px',
	// 		viewFactor: 0.2,
	// 		duration: 1000,
	// 		opacity: 0.3,
	// 		easing: 'cubic-bezier(0.6, 0.2, 0.1, 1)'
	// 	});
	// }
	if (parallaxIconWithImage) {

		// run scrollreveal function
		sr.reveal('.module--icon-with-text', {
			reset: false,
			// scale: 1,
			scale: 0,
			mobile: false,
			distance: '100px',
			viewFactor: 0.2,
			duration: 1000,
			opacity: 0.3,
			easing: 'cubic-bezier(0.6, 0.2, 0.1, 1)'
		});
	}

}

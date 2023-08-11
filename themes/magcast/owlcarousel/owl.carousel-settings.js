/* Featured Slider */
jQuery('.featured-slider .owl-carousel').owlCarousel({
	loop: true,
	margin: 20,
	nav: true,
	dots: false,
	responsive: {
		0:		{ items: 1 },
		667:	{ items: 2 },
		1024:	{ items: 3 }
	}
})

/* Primary Widget 2 Column Large Image */
jQuery('#main .widget_2_column_large_image .owl-carousel').owlCarousel({
	loop: true,
	margin: 30,
	nav: true,
	navText: ['<span class="slide-prev">', '<span class="slide-next">'],
	dots: false,
	responsive: {
		0:		{ items: 1, margin: 15 },
		737: 	{ items: 2, margin: 15 },
		768:  { items: 2, margin: 30 }
	}
})

/* Sidebar Widget 2 Column Large Image */
jQuery('#secondary .widget_2_column_large_image .owl-carousel').owlCarousel({
	loop: true,
	margin: 30,
	nav: true,
	navText: ['<span class="slide-prev">', '<span class="slide-next">'],
	dots: false,
	responsive: {
		0:			{ items: 1, margin: 15 },
		737: 		{ items: 2, margin: 15 },
		768: 		{ items: 2, margin: 30 },
		1024:		{ items: 1 }
	}
})

/* Footer Widget 2 Column Large Image */
jQuery('#colophon .widget_2_column_large_image .owl-carousel').owlCarousel({
	loop: true,
	margin: 30,
	nav: true,
	navText: ['<span class="slide-prev">', '<span class="slide-next">'],
	dots: false,
	responsive: {
		0:		{ items:1 }
	}
})
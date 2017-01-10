Justimmo_Realty_Page = (function($) {

	var self = this;

	function init() 
	{
		initPhotoGallery();
		initFancybox();
		initMap();
	}

	function initPhotoGallery() 
	{
		$('#lightSlider').lightSlider({
			gallery: true,
			item: 1,
			loop: true,
			slideMargin: 0,
			thumbItem: 9
		});
	}

	function initFancybox() {
		$('.fancybox').fancybox();
	}

	function initMap()
	{
		if (typeof RealtyData !== 'undefined') 
		{
			var map = new google.maps.Map(document.getElementsByClassName('jiwp-map')[0], {
				zoom: 11,
				scrollwheel: false,
				center: RealtyData.position
			});

			// var marker = new google.maps.Marker({
			// 	map: map,
			// 	position: RealtyData.position,
			// 	title: RealtyData.title,
			// });

			var circle = new google.maps.Circle({
				strokeColor: '#0000FF',
				strokeOpacity: 0.8,
				strokeWeight: 1,
				fillColor: '#0000FF',
				fillOpacity: 0.35,
				map: map,
				center: RealtyData.position,
				radius: 600
			});
		}
	}

	return {
		init: init
	}

})(jQuery);

jQuery(document).ready(function($) {

	Justimmo_Realty_Page.init();

});
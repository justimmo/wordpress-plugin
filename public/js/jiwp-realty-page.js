Justimmo_Realty_Page = (function($) {

	var self = this;

	function init() 
	{
		initPhotoGallery();
		initMap();
	}

	function initPhotoGallery() 
	{
		$('.featherlight-gallery').featherlightGallery({
		    openSpeed: 300
		});
	}

	function initMap()
	{
		if (RealtyData) 
		{
			var map = new google.maps.Map(document.getElementsByClassName('jiwp-map')[0], {
				zoom: 10,
				scrollwheel: false,
				center: RealtyData.position
			});

			var marker = new google.maps.Marker({
				map: map,
				position: RealtyData.position,
				title: RealtyData.title,
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
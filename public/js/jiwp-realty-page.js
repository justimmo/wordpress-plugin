Justimmo_Realty_Page = (function($) {

	var self = this;

	function init() 
	{
		initPhotoGallery();
	}

	function initPhotoGallery() 
	{
		$('.featherlight-gallery').featherlightGallery({
		    openSpeed: 300
		});
	}

	return {
		init: init
	}

})(jQuery);

jQuery(document).ready(function($) {

	Justimmo_Realty_Page.init();

});
Justimmo_Search_Form_Widget = (function($) {

	var self = this;

	function init() 
	{
		eventHandlers();
	}

	function eventHandlers() 
	{
		$('body').on( 'change', '.js-get-states', getStates );
		$('body').on( 'change', '.js-get-cities', getCities );
	}

	function getStates(e)
	{
		$.ajax({
			url: Justimmo_Ajax.ajax_url,
			type: 'POST',
			data: {
				action 		: 'ajax_get_states',
				security	: Justimmo_Ajax.ajax_nonce,
				country 	: e.target.value
			},
			beforeSend: setLoadingMessage.bind( this, '.ji-states-container' ),
			success: showStates,
			error: ajaxError
		});
	}

	function getCities(e)
	{
		$.ajax({
			url: Justimmo_Ajax.ajax_url,
			type: 'POST',
			data: {
				action 			: 'ajax_get_cities',
				security		: Justimmo_Ajax.ajax_nonce,
				country 		: $('.js-get-states').prop('value'),
				state			: $('.js-get-cities').prop('value')
			},
			beforeSend: setLoadingMessage.bind( this, '.ji-cities-container' ),
			success: showCities,
			error: ajaxError
		});	
	}

	function showStates(data) 
	{
		$('.ji-states-container')
			.empty()
			.append( data );
	}

	function showCities(data)
	{
		$('.ji-cities-container')
			.empty()
			.append( data );
	}

	function setLoadingMessage(elem) 
	{
		$(elem)
			.empty()
			.append( 'loading...' );
	}

	function ajaxError(jqXHR, textStatus, errorThrown) 
	{
		console.log( textStatus, errorThrown );
	}

	return {
		init: init
	};

})(jQuery);

jQuery(document).ready(function($) {

	Justimmo_Search_Form_Widget.init();

});
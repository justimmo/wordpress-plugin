<?php

/**
 * Justimmo search form widget.
 *
 * @link       somasocial.com
 * @since      1.0.0
 *
 * @package    Jiwp
 * @subpackage Jiwp/includes
 */

class Justimmo_Search_Form_Widget extends WP_Widget {

	function __construct() {

		// Instantiate the parent object
		parent::__construct( false, 'Justimmo Search Form' );

	}

	function widget( $args, $instance ) {
		
		try 
		{
			$realty_types 	= Jiwp_Public::get_realty_types();
			$countries  	= Jiwp_Public::get_countries();
			$states 		= array();
			$cities 		= array();

			if ( !empty( $_GET[ 'filter' ] ) && $_GET[ 'filter' ][ 'country' ] ) 
			{
				$states = Jiwp_Public::get_states( $_GET[ 'filter' ][ 'country' ] );
				$cities = Jiwp_Public::get_cities( $_GET[ 'filter' ][ 'country' ] );
			}
		} 
		catch ( Exception $e ) 
		{
			Jiwp_Public::jiwp_error_log( $e );
		}

		// Widget output		
		include( 'partials/search-form/_search-form.php' );

	}

	function update( $new_instance, $old_instance ) {

		// Save widget options

	}

	function form( $instance ) {

		// Output admin widget options form

	}
}
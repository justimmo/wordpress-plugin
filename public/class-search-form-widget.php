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

		$plugin_name = 'jiwp';
		
		try 
		{
			$realty_types 	= Jiwp_Public::$ji_basic_query->all( false )->findRealtyTypes();
			$countries  	= Jiwp_Public::$ji_basic_query->all( false )->findCountries();
			$states 		= array();
			$cities 		= array();

			if ( $_GET[ 'filter' ][ 'country' ] ) 
			{
				$states = Jiwp_Public::get_states( $_GET[ 'filter' ][ 'country' ] );
				$cities = Jiwp_Public::get_cities( $_GET[ 'filter' ][ 'country' ] );
			}
		} 
		catch (Exception $e) 
		{
			Jiwp_Public::jiwp_error_log( $e );
		}

		// Widget output		
		include( 'partials/_search-form.php' );

	}

	function update( $new_instance, $old_instance ) {

		// Save widget options

	}

	function form( $instance ) {

		// Output admin widget options form

	}
}
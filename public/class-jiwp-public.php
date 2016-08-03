<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       somasocial.com
 * @since      1.0.0
 *
 * @package    Jiwp
 * @subpackage Jiwp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Jiwp
 * @subpackage Jiwp/public
 * @author     Mihalache Razvan - Ionut <razvan@somasocial.com>
 */

use Justimmo\Api\JustimmoApi;
use Psr\Log\NullLogger;
use Justimmo\Cache\NullCache;
use Justimmo\Model\RealtyQuery;
use Justimmo\Model\Wrapper\V1\RealtyWrapper;
use Justimmo\Model\Mapper\V1\RealtyMapper;
use Justimmo\Model\Query\BasicDataQuery;
use Justimmo\Model\Wrapper\V1\BasicDataWrapper;
use Justimmo\Model\Mapper\V1\BasicDataMapper;

class Jiwp_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Justimmo realty query object
	 * 
	 * @since  1.0.0
	 * @var object
	 */
	private $ji_realty_query = null;

	/**
	 * Justimmo basic query object
	 *
	 * @since 1.0.0
	 * @var object
	 */
	public static $ji_basic_query = null;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name 	= $plugin_name;
		$this->version  	= $version;

		$this->init_query_objects( 
			get_option( 'ji_api_username' ), 
			get_option( 'ji_api_password' )
		);

		$this->init_shortcodes();

		// Set php money formatting
		setlocale( LC_MONETARY, 'de_DE' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jiwp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jiwp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		if ( get_query_var( 'ji_page', false ) == 'realty' ) 
		{
			wp_enqueue_style( 
				'featherlight',
				plugin_dir_url( __FILE__ ) . 'js/featherlight/featherlight.min.css'
			);

			wp_enqueue_style( 
				'featherlight-gallery',
				plugin_dir_url( __FILE__ ) . 'js/featherlight/featherlight.gallery.min.css'
			);
		}

		wp_enqueue_style( 
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/jiwp-public.css',
			array(),
			$this->version,
			'all'
		);

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jiwp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jiwp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_deregister_script( 'jquery' );
		wp_register_script(
			'jquery',
			plugin_dir_url( __FILE__ ) . 'js/jquery/jquery-1.7.0.min.js',
			'1.7.0'
		);
		
		if ( get_query_var( 'ji_page', false ) == 'realty' ) 
		{
			wp_enqueue_script( 
				'featherlight',
				plugin_dir_url( __FILE__ ) . 'js/featherlight/featherlight.min.js',
				array( 'jquery' )
			);

			wp_enqueue_script( 
				'featherlight-gallery',
				plugin_dir_url( __FILE__ ) . 'js/featherlight/featherlight.gallery.min.js',
				array( 'jquery' )
			);

			wp_enqueue_script( 
				'jiwp-realty-page',
				plugin_dir_url( __FILE__ ) . 'js/jiwp-realty-page.js',
				array( 'featherlight-gallery' )
			);
		}

		wp_enqueue_script( 
			$this->plugin_name, 
			plugin_dir_url( __FILE__ ) . 'js/jiwp-search-form-widget.js',
			array( 'jquery' ), 
			$this->version, 
			false 
		);

		wp_localize_script( 
			$this->plugin_name, 
			'Justimmo_Ajax',
            array( 
            	'ajax_url' 		=> admin_url( 'admin-ajax.php' ), 
            	'ajax_nonce' 	=> wp_create_nonce( 'justimmo_ajax' )
            ) 
		);
	}

	/**
	 * Instantiates and sets Justimmo query objects if username and password are set.
	 * Sets admin notice otherwise.
	 *
	 * @since  1.0.0
	 * @param  string $username 	Justimmo API username
	 * @param  string $password 	Justimmo API password
	 */
	private function init_query_objects( $username, $password ) {

		if ( !empty( $username ) && !empty( $password ) ) 
		{
			$this->ji_realty_query = $this->get_justimmo_realty_query( 
				$username,
				$password 
			);

			self::$ji_basic_query = $this->get_justimmo_basic_query( 
				$username,
				$password
			);
		}
		else 
		{
			add_action( 'admin_notices', array( $this, 'api_credentials_notification' ) );
		}

	}

	/**
	 * Shows admin notice that prompts user to complete their
	 * Justimmo API credentials
	 *
	 * @since 1.0.0
	 */
	public function api_credentials_notification() {

		$class 				= 'notice notice-error';
		$message 			= __( 'Please set your Justimmo API username and password in the', 'jiwp' );
		$admin_link_text 	= __('Justimmo settings panel');

		printf( '<div class="%1$s"><p>%2$s <a href=' . get_admin_url( null, 'admin.php?page=jiwp' ) . '>%3$s</a></p></div>', $class, $message, $admin_link_text );

	}

	/**
	 * Creates and returns a Justimmo RealtyQuery instance.
	 * Also sets the `culture` parameter to wordpress locale.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	private function get_justimmo_realty_query( $username, $password ) {

		$api = new JustimmoApi(
			$username,
			$password,
			new NullLogger(),
			new NullCache()
		);

		$mapper 	= new RealtyMapper();
		$wrapper 	= new RealtyWrapper( $mapper );
		$query  	= new RealtyQuery( $api, $wrapper, $mapper );

		$query->set( 'culture', substr( get_locale(), 0, 2 ) );

		return $query;

	}

	/**
	 * Creates and returns a Justimmo BasicQuery instance
	 * Also sets the `culture` parameter to wordpress locale.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	private function get_justimmo_basic_query( $username, $password ) {

		$api = new JustimmoApi(
			$username,
			$password,
			new NullLogger(),
			new NullCache()
		);

		$query = new BasicDataQuery( $api, new BasicDataWrapper(), new BasicDataMapper() );

		$query->set( 'culture', substr( get_locale(), 0, 2 ) );

		return $query;
	}

	/**
	 * Register frontend rewrite rules
	 *
	 * @since 1.0.0
	 */
	public function init_rewrite_rules() {

		// realty detail rule
		add_rewrite_rule( 'realties/(\d+)', 'index.php?ji_page=realty&ji_realty_id=$matches[1]', 'top' );

		// search results rule
		add_rewrite_rule( 'realties/search', 'index.php?ji_page=search', 'top' );

		if ( get_transient( 'rewrite_rules_check' ) ) 
		{
			delete_transient( 'rewrite_rules_check' );
			flush_rewrite_rules();
		}

	}

	/**
	 * Register frontend rewrite tags
	 * 
	 * @since 1.0.0
	 */
	public function init_rewrite_tags() {

		// add page tag (used for template switching)
		add_rewrite_tag( '%ji_page%', '([^&]+)' );

		// realty id tag
		add_rewrite_tag( '%ji_realty_id%', '([^&]+)' );

	}

	/**
	 * Register frontend endpoint templates
	 *
	 * @since 1.0.0
	 * @param string $template default template 
	 */
	public function init_templates( $template ) {

		$screen = get_query_var( 'ji_page', false );

		switch ( $screen )
		{
			case 'realty':
				
				$this->realty_page();

				return;

			case 'search':
				
				$this->search_results_page();

				return;
			
			default:
				
				break;
		}

        //Fall back to original template
        return $template;

	}

	/**
	 * Displays single property template
	 * 
	 * @since 1.0.0
	 */
	private function realty_page() {

		$realty_id = get_query_var( 'ji_realty_id', false );

        $new_template = self::get_template( 'realty-template.php' );

        try 
        {
        	$realty = $this->get_realty( $realty_id );

        	if ( $new_template ) 
	        {
	        	include( $new_template );
	        }
        } 
        catch ( Exception $e ) 
        {
        	self::jiwp_error_log( $e );
        }

	}

	/**
	 * Displays search results template
	 * 
	 * @since 1.0.0.
	 */
	private function search_results_page() {

		$filter_params = $_GET[ 'filter' ];

		try 
		{
			$this->set_realty_query_filters( $filter_params );

			$page = get_query_var( 'page', 1 );

			$pager_url = $this->build_pager_url( $_GET );

			$realties = $this->get_realties( $page, get_option('posts_per_page') );

			$new_template = self::get_template( 'search-results-template.php' );

	        if ( $new_template ) 
	        {
	        	include( $new_template );
	        }			
		}
		catch ( Exception $e ) 
		{
			self::jiwp_error_log( $e );
		}        

	}

	/**
	 * Register shortcodes
	 * 
	 * @since 1.0.0
	 */
	public function init_shortcodes() {

		// Enable shortcodes in widgets
		add_filter('widget_text', 'do_shortcode');

		add_shortcode( 'ji_property_list', array( $this, 'property_list_shortcode_output' ) );
		add_shortcode( 'ji_search_form', array( $this, 'search_form_shortcode_output' ) );

	}

	/**
	 * Property list shortcode handler
	 *
	 * @since 1.0.0
	 */
	public function property_list_shortcode_output( $atts ) {

		$atts = shortcode_atts( 
			array(
				'max_per_page' 			=> 5,
				'rent'  				=> null,
				'buy'	 				=> null,
				'type' 					=> null,
				'price_min' 			=> null,
				'price_max' 			=> null,
				'rooms_min' 			=> null,
				'rooms_max' 			=> null,
				'surface_min' 			=> null,
				'surface_max' 			=> null,
				'garden' 				=> null,
				'garage' 				=> null,
				'balcony_terrace' 		=> null,
				'price_order' 			=> null,
				'date_order'			=> null,
				'surface_order' 		=> null
			), 
			$atts, 
			'ji_property_list' 
		);

		try 
		{
			$this->set_realty_query_filters( $atts );

			$this->set_realty_query_ordering( $atts );

			$page = get_query_var( 'page', 1 );

			$pager_url = $this->build_pager_url();

			$realties = $this->get_realties( $page, $atts[ 'max_per_page' ] );

			ob_start();
			include( 'partials/_realty-list.php' );
			return ob_get_clean();
		} 
		catch ( Exception $e ) 
		{
			self::jiwp_error_log( $e );
		}		

	}

	/**
	 * Search form shortcode handler
	 *
	 * @since 1.0.0
	 */
	public function search_form_shortcode_output() {

		$plugin_name = $this->plugin_name;

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

			ob_start();
			include( 'partials/_search-form.php' );
			return ob_get_clean();
		} 
		catch ( Exception $e ) 
		{
			self::jiwp_error_log( $e );
		}

	}

	/**
	 * Locates template in theme folder first and then in plugin folder. 
	 * 
	 * @since 1.0.0
	 * @param  string $template_file template file
	 * @return string           	template path
	 */
	public static function get_template( $template_file ) {

		// Check theme directory first
        $new_template = locate_template( array( 'jiwp-templates/' . $template_file ) );

        if ( $new_template != '' ) 
        {
            return $new_template;
        }

        // Check plugin directory next
        $new_template = plugin_dir_path( __FILE__ ) . 'partials/' . $template_file;

        if ( file_exists( $new_template ) ) 
        {
            return $new_template;
        }

		return false;

	}

	/**
	 * Initialize widgets
	 * 
	 * @since 1.0.0
	 */
	public function init_widgets() {

		register_widget( 'Justimmo_Search_Form_Widget' );

	}

	/**
	 * Retrieves the list of states for a certain country.
	 *
	 * @since 1.0.0
	 * @return partial containing state list
	 */
	public function ajax_get_states() {

		check_ajax_referer( 'justimmo_ajax', 'security' );

		$plugin_name = $this->plugin_name;

		$states = array();

		if ( !empty( $_POST['country'] ) ) 
		{
			$states	= self::get_states( $_POST['country'] );
		}

		include( 'partials/_search-form__states.php' );

		wp_die();

	}

	/**
	 * Currently retrieves the list of zipcodes for a certain country,
	 * but should be changed in the future to retrieve actual cities.
	 *
	 * @since 1.0.0
	 * @return partial containing zipcodes list
	 */
	public function ajax_get_cities() {

		check_ajax_referer( 'justimmo_ajax', 'security' );

		$plugin_name = $this->plugin_name;

		$cities = array();

		if ( !empty( $_POST['country'] ) )
		{
			$cities = self::get_cities( $_POST['country'] );
		}

		include( 'partials/_search-form__cities.php' );

		wp_die();

	}

	/**
	 * Retrieves single realty from Justimmo API.
	 *
	 * @since  1.0.0
	 * @param  integer $realty_id 	Realty id
	 * @return object            	Realty object
	 */
	private function get_realty( $realty_id ) {

		if ( $this->ji_realty_query == null ) 
		{
			return null;
		}
		
		// This method does not pass `culture` param to `JustimmoApi` class 
		// and neither does the `/objekt/detail` endpoint retrieve translated data. 
		return $this->ji_realty_query->findPk( $realty_id );

	}

	/**
	 * Retrieves realties from Justimmo API.
	 *
	 * @since  1.0.0
	 * @param  integer $page 	Current page
	 * @return object       	Pager object containing realties array
	 */
	private function get_realties( $page, $max_per_page ) {

		if ( $this->ji_realty_query == null ) 
		{
			return array();
		}

		return $this->ji_realty_query->paginate( $page, $max_per_page );

	}

	/**
	 * Returns states based on country id.
	 * 
	 * @since  1.0.0
	 * @param  integer $selected_country_id Id of the selected country
	 * @return array                        Array of state arrays
	 */
	public static function get_states( $selected_country_id ) {

		$states = array();

		try 
		{
			$states = self::$ji_basic_query
							->all( false )
							->filterByCountry( $selected_country_id )
							->findFederalStates();	
		}
		catch ( Exception $e ) 
		{
			self::jiwp_error_log( $e->getMessage() );
		}

		return $states;

	}

	/**
	 * Currently returns zipcodes based on country id,
	 * but should be changed in the future to get actual cities. 
	 *
	 * @since 1.0.0
	 * @param  integer $selected_country_id Id of the selected country. 
	 * @return array                      	Array of zipcode arrays
	 */
	public static function get_cities( $selected_country_id ) {

		$cities = array();

		try 
		{
			$cities = self::$ji_basic_query
							->all( false )
							->filterByCountry( $selected_country_id )
							->findZipCodes();
		}
		catch ( Exception $e ) 
		{
			self::jiwp_error_log( $e->getMessage() );
		}

		return $cities;

	}

	/**
	 * Returns url string to be used in pagination.
	 *
	 * @since  1.0.0
	 * @param  array  $query_params query string parameters
	 * @return string               url to be used by pagination partial
	 */
	private function build_pager_url( $query_params = array() ) {

		$url = get_permalink();

		if ( !empty( $query_params ) )
		{
			$url .= '?' . http_build_query( $query_params ) . '&';
		}
		else 
		{
			$url .= '?';
		}

		return $url;

	}

	/**
	 * Sets Realty Query filters
	 *
	 * @since 1.0.0
	 * @param array $filter_params Array containing the search form filter options.
	 */
	private function set_realty_query_filters( $filter_params = array() ) {

		// realty number

		if ( !empty( $filter_params[ 'objektnummer' ] )  ) 
		{
			$this->ji_realty_query->filter( 'objektnummer', $filter_params[ 'objektnummer' ] );
		}

		// rent

		if ( !empty( $filter_params[ 'rent' ] )  ) 
		{
			$this->ji_realty_query->filter( 'miete', 1 );
		}

		// buy

		if ( !empty( $filter_params[ 'buy' ] )  ) 
		{
			$this->ji_realty_query->filter( 'kauf', 1 );
		}

		// realty type

		if ( !empty( $filter_params[ 'type' ] ) ) 
		{
			// find realty type `id` from `key` value
			$property_types = self::$ji_basic_query->all( false )->findRealtyTypes();
			
			foreach ($property_types as $property_type_id => $property_type) 
			{
				if ( $filter_params[ 'type' ] == $property_type[ 'key' ] ) 
				{
					$this->ji_realty_query->filterByRealtyTypeId( $property_type_id );
					break;
				}
			}
		}

		// price

		if ( !empty( $filter_params[ 'price_min' ] ) ) 
		{
			$this->ji_realty_query->filterByPrice( array( 'min' => $filter_params[ 'price_min' ] ) );
		}

		if ( !empty( $filter_params[ 'price_max' ] ) ) 
		{
			$this->ji_realty_query->filterByPrice( array( 'max' => $filter_params[ 'price_max' ] ) );
		}

		// rooms

		if ( !empty( $filter_params[ 'rooms_min' ] ) ) 
		{
			$this->ji_realty_query->filterByRooms( array( 'min' => $filter_params[ 'rooms_min' ] ) );
		}

		if ( !empty( $filter_params[ 'rooms_max' ] ) ) 
		{
			$this->ji_realty_query->filterByRooms( array( 'max' => $filter_params[ 'rooms_max' ] ) );
		}

		// surface

		if ( !empty( $filter_params[ 'surface_min' ] ) ) 
		{
			$this->ji_realty_query->filterByLivingArea( array( 'min' => $filter_params[ 'surface_min' ] ) );
		}

		if ( !empty( $filter_params[ 'surface_max' ] ) ) 
		{
			$this->ji_realty_query->filterByLivingArea( array( 'max' => $filter_params[ 'surface_max' ] ) );
		}

		// country

		if ( !empty( $filter_params[ 'country' ] ) ) 
		{
			$this->ji_realty_query->filter( 'land_id', $filter_params[ 'country' ] );
		}

		// federal states

		if ( !empty( $filter_params[ 'states' ] ) ) 
		{
			$this->ji_realty_query->filter( 'bundesland_id', $filter_params[ 'states' ] );
		}

		// zip codes

		if ( !empty( $filter_params[ 'zip_codes' ] ) ) 
		{
			$this->ji_realty_query->filter( 'plz', $filter_params[ 'zip_codes' ] );
		}

		// garden
		
		if ( !empty( $filter_params[ 'garden' ] )  ) 
		{
			$this->ji_realty_query->filter( 'garden', 1 );
		}

		// garage
		
		if ( !empty( $filter_params[ 'garage' ] )  ) 
		{
			$this->ji_realty_query->filter( 'garage', 1 );
		}

		// balcony
		
		if ( !empty( $filter_params[ 'balcony_terrace' ] )  ) 
		{
			$this->ji_realty_query->filter( 'balkon', 1 );
		}

	}

	/**
	 * Set Realty Query ordering
	 *
	 * @since 1.0.0
	 * @param string $order_by  Type of ordering
	 * @param string $direction Direction of ordering ('asc' or 'desc')
	 */
	private function set_realty_query_ordering( $order_params ) {

		if ( !empty( $order_params['price_order'] ) ) 
		{
			$this->ji_realty_query->orderByPrice( $order_params['price_order'] );
		}


		if ( !empty( $order_params['date_order'] ) ) 
		{
			$this->ji_realty_query->orderByCreatedAt( $order_params['date_order'] );
		}


		if ( !empty( $order_params['surface_order'] ) ) 
		{
			$this->ji_realty_query->orderBySurfaceArea( $order_params['surface_order'] );
		}

	}

	/**
	 * Helper function that logs errors in a file located in plugin's 'public' folder.
	 *
	 * @since  1.0.0
	 * @param  object $error error object.
	 */
	private static function jiwp_error_log( $error ) {

		file_put_contents( 
			plugin_dir_path( __FILE__ ) . 'error_log', json_encode( $error->getMessage() ) . "\n\n", 
			FILE_APPEND
		);

	}

}

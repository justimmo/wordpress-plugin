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
use Justimmo\Api\JustimmoApiInterface;
use Psr\Log\NullLogger;
use Justimmo\Cache\NullCache;

use Justimmo\Model\Project;

use Justimmo\Model\RealtyQuery;
use Justimmo\Model\Wrapper\V1\RealtyWrapper;
use Justimmo\Model\Mapper\V1\RealtyMapper;

use Justimmo\Model\Query\BasicDataQuery;
use Justimmo\Model\Wrapper\V1\BasicDataWrapper;
use Justimmo\Model\Mapper\V1\BasicDataMapper;

use Justimmo\Model\ProjectQuery;
use Justimmo\Model\Wrapper\V1\ProjectWrapper;
use Justimmo\Model\Mapper\V1\ProjectMapper;

use Justimmo\Request\RealtyInquiryRequest;
use Justimmo\Model\Mapper\V1\RealtyInquiryMapper;

class Jiwp_Public
{
    const PROJECT_INFO_TEMPLATES_MAPPING = array(
        'address'           => '/project/_project-info__address.php',
        'contact'           => '/project/_project-info__contact.php',
        'description'       => '/project/_project-info__description.php',
        'other-info'        => '/project/_project-info__other-info.php',
        'photo-gallery'     => '/project/_project-info__photo-gallery.php',
        'realties'          => '/project/_project-info__realties.php',
    );

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
     * Justimmo API client.
     *
     * @var JustimmoApiInterface
     */
    private $api;

    /**
     * Justimmo realty query object
     *
     * @since  1.0.0
     * @var RealtyQuery
     */
    private $ji_realty_query = null;

    /**
     * Justimmo project query object
     *
     * @since  1.0.0
     * @var ProjectQuery
     */
    private $ji_project_query = null;

    /**
     * Justimmo basic query object
     *
     * @since 1.0.0
     * @var BasicDataQuery
     */
    public static $ji_basic_query = null;

    /**
     * Stores project in variable for use when multiple
     * instances of [ji_project_info] are used in the same page.
     *
     * @var Project
     */
    private $cached_project;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name  = $plugin_name;
        $this->version      = $version;

        $this->init_query_objects( 
            get_option( 'ji_api_username' ), 
            get_option( 'ji_api_password' )
        );

        $this->init_shortcodes();

        // Set php money formatting
        setlocale( LC_MONETARY, get_locale() );

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
        
        if ( get_query_var( 'ji_page', false ) == 'realty' || get_query_var( 'ji_page', false ) == 'project' ) {

            wp_enqueue_style(
                'lightslider',
                plugin_dir_url(__FILE__) . 'js/lightslider/css/lightslider.min.css',
                array(),
                $this->version,
                'all'
            );

            wp_enqueue_style(
                'fancybox',
                plugin_dir_url(__FILE__) . 'js/fancybox/jquery.fancybox.css',
                array(),
                '2.0',
                'all'
            );

        }

        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'css/jiwp-public.css',
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
    public function enqueue_scripts()
    {
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
        
        wp_deregister_script('jquery');
        wp_register_script(
            'jquery',
            plugin_dir_url(__FILE__) . 'js/jquery/jquery-1.7.0.min.js',
            '1.7.0'
        );
        
        if (get_query_var('ji_page', false) == 'realty' || get_query_var('ji_page', false) == 'project') {
            wp_enqueue_script(
                'lightslider',
                plugin_dir_url(__FILE__) . 'js/lightslider/js/lightslider.min.js',
                array( 'jquery' ),
                $this->version,
                true
            );

            wp_enqueue_script(
                'fancybox',
                plugin_dir_url(__FILE__) . 'js/fancybox/jquery.fancybox.pack.js',
                array( 'jquery' ),
                '2.0',
                true
            );

            wp_enqueue_script(
                'jiwp-realty-page',
                plugin_dir_url(__FILE__) . 'js/jiwp-realty-page.js',
                array( 'lightslider' ),
	            $this->version,
	            true
            );

            wp_enqueue_script(
                $this->plugin_name,
                plugin_dir_url(__FILE__) . 'js/jiwp-inquiry-form.js',
                array( 'jquery' ),
                $this->version,
                true
            );

            wp_enqueue_script(
                'jiwp-google-map',
                'https://maps.googleapis.com/maps/api/js?key=' . get_option('jiwp_google_api_key', ''),
                array( 'jquery' ),
                $this->version,
                true
            );
        }

        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'js/jiwp-search-form-widget.js',
            array( 'jquery' ),
            $this->version,
            true
        );

        wp_localize_script(
            $this->plugin_name,
            'Justimmo_Ajax',
            array(
                'ajax_url'      => admin_url('admin-ajax.php'),
                'ajax_nonce'    => wp_create_nonce('justimmo_ajax')
            )
        );
    }

    /**
     * Instantiates and sets Justimmo query objects if username and password are set.
     * Sets admin notice otherwise.
     *
     * @since  1.0.0
     * @param  string $username     Justimmo API username
     * @param  string $password     Justimmo API password
     */
    private function init_query_objects( $username, $password ) {

        if ( !empty( $username ) && !empty( $password ) ) 
        {
            $this->api = new JustimmoApi(
                $username,
                $password,
                new NullLogger(),
                new NullCache()
            );

            $this->api->setCurlOptions([
                CURLOPT_TIMEOUT_MS => 60000
            ]);

            $this->ji_realty_query = $this->get_justimmo_realty_query($this->api);
            $this->ji_project_query = $this->get_justimmo_project_query($this->api);
            self::$ji_basic_query = $this->get_justimmo_basic_query($this->api);
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

        $class              = 'notice notice-error';
        $message            = __( 'Please set your Justimmo API username and password in the', 'jiwp' );
        $admin_link_text    = __('Justimmo settings panel');

        printf( '<div class="%1$s"><p>%2$s <a href=' . get_admin_url( null, 'admin.php?page=jiwp' ) . '>%3$s</a></p></div>', $class, $message, $admin_link_text );

    }

    /**
     * Creates and returns a Justimmo RealtyQuery instance.
     * Also sets the `culture` parameter to wordpress locale.
     *
     * @since  1.0.0
     * @param JustimmoApiInterface $api Justimmo Api instance
     * @return object
     */
    private function get_justimmo_realty_query( JustimmoApiInterface $api ) {

        $mapper     = new RealtyMapper();
        $wrapper    = new RealtyWrapper( $mapper );
        $query      = new RealtyQuery( $api, $wrapper, $mapper );

        $query->setCulture( $this->get_language_code() );

        return $query;

    }

    /**
     * Creates and returns a Justimmo ProjectQuery instance.
     * Also sets the `culture` parameter to wordpress locale.
     *
     * @since  1.0.0
     * @param JustimmoApiInterface $api Justimmo Api instance
     * @return ProjectQuery
     */
    private function get_justimmo_project_query( JustimmoApiInterface $api ) {

        $mapper     = new ProjectMapper();
        $wrapper    = new ProjectWrapper( $mapper );
        $query      = new ProjectQuery( $api, $wrapper, $mapper );

        $query->setCulture( $this->get_language_code() );

        return $query;

    }

    /**
     * Creates and returns a Justimmo BasicDataQuery instance
     * Also sets the `culture` parameter to wordpress locale.
     *
     * @since  1.0.0
     * @param JustimmoApiInterface $api Justimmo Api instance
     * @return BasicDataQuery
     */
    private function get_justimmo_basic_query( JustimmoApiInterface $api ) {

        $query = new BasicDataQuery( $api, new BasicDataWrapper(), new BasicDataMapper() );

        $query->set( 'culture', $this->get_language_code() );

        return $query;

    }

    /**
     * Register frontend rewrite rules
     *
     * @since 1.0.0
     */
    public function init_rewrite_rules()
    {
        // realty detail rule
        add_rewrite_rule(
            __('properties', 'jiwp') . '/(.+)-(\d+)/?$',
            'index.php?ji_page=realty&ji_realty_id=$matches[2]',
            'top'
        );

        // realty expose rule
        add_rewrite_rule(
            'realty-expose/(\d+)/?$',
            'index.php?ji_page=realty-expose&ji_realty_id=$matches[1]',
            'top'
        );

        // project detail rule
        add_rewrite_rule(
            __('projects', 'jiwp') . '/(.+)-(\d+)/?$',
            'index.php?ji_page=project&ji_project_id=$matches[2]',
            'top'
        );

        // realty search results rule
        add_rewrite_rule(
            __('properties', 'jiwp') . '/' . __('search', 'jiwp') . '/?',
            'index.php?ji_page=realty-search',
            'top'
        );


        if (get_transient('rewrite_rules_check')
            || get_option('jiwp_language_locale') != $this->get_language_code()) {
            delete_transient('rewrite_rules_check');
            update_option('jiwp_language_locale', $this->get_language_code());
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

        // project id tag
        add_rewrite_tag( '%ji_project_id%', '([^&]+)' );

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

            case 'realty-expose':

                $this->realty_expose();
                exit;

                return;

            case 'project':
                
                $this->project_page();

                return;

            case 'realty-search':
                
                $this->realty_search_results_page();

                return;
            
            default:
                
                break;
        }

        //Fall back to original template
        return $template;

    }

    /**
     * Displays single realty template
     * 
     * @since 1.0.0
     */
    private function realty_page() {

        $realty_id = get_query_var( 'ji_realty_id', false );

        $new_template = self::get_template( 'realty/realty-template.php' );

        try 
        {
            $realty = $this->get_realty( $realty_id );

            $countries = self::get_countries();
            $cities = self::get_cities();

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

    private function realty_expose() {

        $id = get_query_var('ji_realty_id');
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="expose-' . $id . '-' . time() . '.pdf"');
        echo $this->api->callExpose($id, 'Default');
        exit;

    }

    /**
     * Displays single project template
     * 
     * @since 1.0.0
     */
    private function project_page() {

        $project_id = get_query_var( 'ji_project_id', false );

        $new_template = self::get_template( 'project/project-template.php' );

        try 
        {
            $project = $this->get_project( $project_id );

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
     * Displays realty search results template
     * 
     * @since 1.0.0.
     */
    private function realty_search_results_page() {

        $filter_params = $_GET[ 'filter' ];

        try 
        {
            $this->set_realty_query_filters( $filter_params );

            $page = get_query_var( 'page', 1 );

            $pager_url = $this->build_pager_url( $_GET );

            $pager = $this->get_realties( $page, get_option('posts_per_page') );

            $new_template = self::get_template( 'search-form/search-results-template.php' );

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
    public function init_shortcodes()
    {
        // Enable shortcodes in widgets
        add_filter('widget_text', 'do_shortcode');

        add_shortcode('ji_search_form', array($this, 'search_form_shortcode_output'));
        add_shortcode('ji_realty_list', array($this, 'realty_list_shortcode_output'));
        add_shortcode('ji_project_list', array($this, 'project_list_shortcode_output'));
        add_shortcode('ji_project_info', array($this, 'project_info_shortcode_output'));
    }

    /**
     * Property list shortcode handler
     *
     * @since 1.0.0
     */
    public function realty_list_shortcode_output($atts)
    {
        $atts = shortcode_atts(
            array(
                'max_per_page'          => 5,
                'rent'                  => null,
                'buy'                   => null,
                'type'                  => null,
                'category'              => null,
                'price_min'             => null,
                'price_max'             => null,
                'rooms_min'             => null,
                'rooms_max'             => null,
                'surface_min'           => null,
                'surface_max'           => null,
                'garden'                => null,
                'garage'                => null,
                'balcony_terrace'       => null,
                'price_order'           => null,
                'date_order'            => null,
                'surface_order'         => null,
                'exclude_country_id'    => null,
                'occupancy'             => null,
                'format'                => 'list',
                'zip'                   => null,
            ),
            $atts,
            'ji_realty_list'
        );

        try {
            $this->set_realty_query_filters($atts);

            $this->set_realty_query_ordering($atts);

            $page = get_query_var('page', 1);

            $pager_url = $this->build_pager_url();

            $pager = $this->get_realties($page, $atts[ 'max_per_page' ]);

            $realty_list_class = $atts['format'] == 'grid' ? 'ji-realty-list--grid' : '';

            ob_start();
            include('partials/realty/_realty-list.php');
            return ob_get_clean();
        } catch (Exception $e) {
            self::jiwp_error_log($e);
        }
    }

    /**
     * Search form shortcode handler
     *
     * @since 1.0.0
     */
    public function search_form_shortcode_output( $atts ) {

        try 
        {
            $realty_types   = self::get_realty_types();
            $countries      = self::get_countries();
            $states         = array();
            $cities         = array();

            if ( !empty( $_GET[ 'filter' ] ) ) {
                $filter = $_GET[ 'filter' ];
            }

            if ( !empty( $_GET[ 'filter' ] ) && $_GET[ 'filter' ][ 'country' ] ) 
            {
                $states = self::get_states( $_GET[ 'filter' ][ 'country' ] );
                $cities = self::get_cities( $_GET[ 'filter' ][ 'country' ] );
            }            

            ob_start();
            include( 'partials/search-form/_search-form.php' );
            return ob_get_clean();
        } 
        catch ( Exception $e ) 
        {
            self::jiwp_error_log( $e );
        }

    }

    /**
     * Project list shortcode handler
     *
     * @since 1.0.0
     */
    public function project_list_shortcode_output( $atts ) {

        $atts = shortcode_atts(
            array(
                'max_per_page' => 5,
            ),
            $atts,
            'ji_project_list'
        );

        try
        {
            $this->set_project_query_filters( $atts );

            $this->set_project_query_ordering( $atts );

            $page = get_query_var( 'page', 1 );

            $pager_url = $this->build_pager_url();

            $pager = $this->get_projects( $page, $atts[ 'max_per_page' ] );

            ob_start();
            include( 'partials/project/_project-list.php' );
            return ob_get_clean();
        }
        catch ( Exception $e )
        {
            self::jiwp_error_log( $e );
        }

    }

    /**
     * Project info shortcode handler
     *
     * @since 1.0.0
     */
    public function project_info_shortcode_output( $atts ) {

        $atts = shortcode_atts(
            array(
                'id' => null,
                'info' => false,
            ),
            $atts,
            'ji_project_info'
        );

        if ( empty( $atts['id'] ) ) 
        {
            return;
        }

        try
        {
            if ( !empty( $this->cached_project ) ) 
            {
                $project = $this->cached_project;
            }
            else 
            {
                $project = $this->get_project( $atts['id'] );
            }

            if ( array_key_exists( $atts['info'], self::PROJECT_INFO_TEMPLATES_MAPPING ) )
            {
                ob_start();
                include( self::get_template( self::PROJECT_INFO_TEMPLATES_MAPPING[ $atts['info'] ] ) );
                return ob_get_clean();
            }
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
     * @return string               template path
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
     * Builds realty detail url
     * with the following format
     * <postcode>-<city>-<realty name>-<realty number>-<realty id>
     *
     * @param  \Realty $realty      realty object
     * @return string               realty url
     */
    public static function get_realty_url($realty)
    {
        $linkParts = [
            sanitize_title($realty->getZipCode()),
            sanitize_title($realty->getPlace()),
            sanitize_title($realty->getTitle()),
            $realty->getPropertyNumber(),
            $realty->getId(),
        ];

        return get_bloginfo('url') . '/' . __('properties', 'jiwp') . '/' . implode('-', $linkParts) . '/';
    }

    /**
     * Builds realty expose detail url.
     *
     * @param  \Realty $realty      realty object
     * @return string               realty url
     */
    public static function get_realty_expose_url($realty)
    {
        return get_bloginfo('url') . '/realty-expose/' . $realty->getId();
    }

    /**
     * Builds project detail url
     * with the following format
     * <postcode>-<city>-<project name>-<project id>
     *
     * @param  \Project $project      project object
     * @return string                 project url
     */
    public static function get_project_url($project)
    {
        $linkParts = [
            sanitize_title($project->getZipCode()),
            sanitize_title($project->getPlace()),
            sanitize_title($project->getTitle()),
            $project->getId(),
        ];

        return get_bloginfo('url') . '/' . __('projects', 'jiwp') . '/' . implode('-', $linkParts) . '/';
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

        $states = array();

        if ( !empty( $_POST['country'] ) ) 
        {
            $states = self::get_states( $_POST['country'] );
        }

        include( 'partials/search-form/_search-form__states.php' );

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

        $cities = array();

        if ( !empty( $_POST['country'] ) )
        {
            $cities = self::get_cities( $_POST['country'] );
        }

        include( 'partials/search-form/_search-form__cities.php' );

        wp_die();

    }

    public function ajax_send_inquiry()
    {
        check_ajax_referer('justimmo_ajax', 'security');
        parse_str($_POST['formData']);

        try {
            $api = new JustimmoApi(
                get_option('ji_api_username'),
                get_option('ji_api_password'),
                new NullLogger(),
                new NullCache()
            );

            $inquiryRequest = new RealtyInquiryRequest($api, new RealtyInquiryMapper());
            
            if (!empty($realty_id)) {
                $inquiryRequest->setRealtyId($realty_id);
            }

            if (!empty($contact_salutation)) {
                $inquiryRequest->setSalutationId($contact_salutation);
            }

            if (!empty($contact_title)) {
                $inquiryRequest->setTitle($contact_title);
            }

            if (!empty($contact_first_name)) {
                $inquiryRequest->setFirstName($contact_first_name);
            }

            if (!empty($contact_last_name)) {
                $inquiryRequest->setLastName($contact_last_name);
            }

            if (!empty($contact_email)) {
                $inquiryRequest->setEmail($contact_email);
            }

            if (!empty($contact_phone)) {
                $inquiryRequest->setPhone($contact_phone);
            }

            if (!empty($contact_street)) {
                $inquiryRequest->setStreet($contact_street);
            }

            if (!empty($contact_zipcode)) {
                $inquiryRequest->setZipCode($contact_zipcode);
            }

            if (!empty($contact_city)) {
                $inquiryRequest->setCity($contact_city);
            }

            if (!empty($contact_country)) {
                $inquiryRequest->setCountry($contact_country);
            }

            if (!empty($contact_message)) {
                $inquiryRequest->setMessage($contact_message);
            }
            
            $inquiryRequest->send();

            echo json_encode([
                'message' => __('Inquiry Sent!', 'jiwp'),
            ]);
        } catch (Exception $e) {
            self::jiwp_error_log($e);
            echo json_encode([
                'error' => $e->getMessage(),
            ]);
        }

        wp_die();
    }

    /**
     * Retrieves single realty from Justimmo API.
     *
     * @since  1.0.0
     * @param  integer $realty_id   Realty id
     * @return \Realty              Realty object
     */
    private function get_realty( $realty_id ) {

        if ( $this->ji_realty_query == null ) 
        {
            return null;
        }
        
        return $this->ji_realty_query->findPk( $realty_id );

    }

    /**
     * Retrieves realties from Justimmo API.
     *
     * @since  1.0.0
     * @param  integer $page    Current page
     * @return \ListPager       Pager object containing realties array
     */
    private function get_realties( $page, $max_per_page ) {

        if ( $this->ji_realty_query == null ) 
        {
            return array();
        }

        return $this->ji_realty_query->paginate( $page, $max_per_page );

    }

    /**
     * Retrieves single project from Justimmo API.
     *
     * @since  1.0.0
     * @param  integer $project_id  Project id
     * @return \Project             Project object
     */
    private function get_project( $project_id ) {

        if ( $this->ji_project_query == null ) 
        {
            return null;
        }

        return $this->ji_project_query->findPk( $project_id );

    }

    /**
     * Retrieves projects from Justimmo API.
     *
     * @since  1.0.0
     * @param  integer $page    Current page
     * @return \ListPager       Pager object containing projects array
     */
    private function get_projects( $page, $max_per_page ) {

        if ( $this->ji_project_query == null ) 
        {
            return array();
        }

        return $this->ji_project_query->paginate( $page, $max_per_page );

    }

    /**
     * Returns states based on country id.
     * 
     * @since  1.0.0
     * @param  integer $selected_country_id Id of the selected country
     * @return array                        Array of state arrays
     */
    public static function get_states( $selected_country_id = null ) {

        if ( self::$ji_basic_query == null ) 
        {
            return array();
        }

        $states = array();
        
        $states = self::$ji_basic_query
            ->all( false )
            ->filterByCountry( $selected_country_id )
            ->findFederalStates();

        return $states;

    }

    /**
     * Currently returns zipcodes based on country id,
     * but should be changed in the future to get actual cities. 
     *
     * @since 1.0.0
     * @param  integer $selected_country_id Id of the selected country. 
     * @return array                        Array of zipcode arrays
     */
    public static function get_cities( $selected_country_id = null ) {

        if ( self::$ji_basic_query == null ) 
        {
            return array();
        }

        $cities = array();
        
        $cities = self::$ji_basic_query
            ->all( false )
            ->filterByCountry( $selected_country_id )
            ->findZipCodes();       

        return $cities;

    }

    /**
     * Retrieves realty types from Justimmo API.
     *
     * @since  1.0.0
     * @return array    Array containing realty types
     */
    public static function get_realty_types() {

        if ( self::$ji_basic_query == null ) 
        {
            return array();
        }

        return self::$ji_basic_query->all( false )->findRealtyTypes();

    }

    /**
     * Retrieves countries from Justimmo API
     *
     * @since 1.0.0
     * @return array    Array containing countries
     */
    public static function get_countries() {

        if ( self::$ji_basic_query == null ) 
        {
            return array();
        }

        return self::$ji_basic_query->all( false )->findCountries();

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

        if ( $this->ji_realty_query == null ) 
        {
            return;
        }

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
            $types = explode(',', $filter_params[ 'type' ]);
            $this->ji_realty_query->filterByRealtyTypeId( $types );
        }

        // realty category

        if ( !empty( $filter_params[ 'category' ] ) ) 
        {
            $tags = explode(',', $filter_params[ 'category' ]);
            $this->ji_realty_query->filterByTag( $tags );
        }

        // realty zipcode

        if ( !empty( $filter_params[ 'zip' ] ) ) 
        {
            $zipcodes = explode(',', $filter_params[ 'zip' ]);
            $this->ji_realty_query->filterByZipCode( $zipcodes );
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

        // exclude country
        if ( !empty( $filter_params[ 'exclude_country_id' ] ) ) 
        {
            $this->ji_realty_query->filter( 'not_land_id', $filter_params[ 'exclude_country_id' ] );
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

        // occupancy
        
        if ( !empty( $filter_params[ 'occupancy' ] )  ) 
        {
            $this->ji_realty_query->filter( 'nutzungsart', $filter_params[ 'occupancy' ] );
        }
        
    }

    /**
     * Set Realty Query ordering
     *
     * @since 1.0.0
     * @param array $order_params  array containing ordering params
     */
    private function set_realty_query_ordering( $order_params ) {

        if ( $this->ji_realty_query == null )
        {
            return;
        }

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
     * Sets Project Query filters
     *
     * @since 1.0.0
     * @param array $filter_params Array containing the search form filter options.
     */
    private function set_project_query_filters( $filter_params = array() ) {
    }

    /**
     * Set Project Query ordering
     *
     * @since 1.0.0
     * @param array $order_params  array containing ordering params
     */
    private function set_project_query_ordering( $order_params ) {
    }

    /**
     * Helper function that logs errors in a file located in plugin's 'public' folder.
     *
     * @since  1.0.0
     * @param  object $error error object.
     */
    public static function jiwp_error_log( $error ) {

        file_put_contents( 
            plugin_dir_path( __FILE__ ) . 'error_log', json_encode( $error->getMessage() ) . "\n\n", 
            FILE_APPEND
        );

    }

    /**
     * Retrieve subtring of language locale.
     * @return string language code
     */
    private function get_language_code()
    {
        return substr(get_locale(), 0, 2);
    }

    public function page_title_setup($title, $sep) {

        $screen = get_query_var( 'ji_page', false );

        if ( $screen == 'realty' )
        {
            $realty_id = get_query_var( 'ji_realty_id', false );

            try
            {
                $realty = $this->get_realty( $realty_id );

                if (!empty($realty->getTitle())) {
                    $title = $realty->getTitle();
                }
                else
                {
                    $title = $realty->getRealtyTypeName()
                        . ' '
                        . __('in', 'jiwp')
                        . ' '
                        . $realty->getCountry()
                        . ' / '
                        . $realty->getFederalState();
                }
            }
            catch ( Exception $e )
            {
                self::jiwp_error_log( $e );
            }
        }

        if ( $screen == 'project' )
        {
            $project_id = get_query_var( 'ji_project_id', false );

            try
            {
                $project = $this->get_project( $project_id );

                if (!empty($project->getTitle())) {
                    $title = $project->getTitle();
                }
            }
            catch ( Exception $e )
            {
                self::jiwp_error_log( $e );
            }
        }

        return $title;

    }
}

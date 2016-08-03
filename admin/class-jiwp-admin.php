<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       somasocial.com
 * @since      1.0.0
 *
 * @package    Jiwp
 * @subpackage Jiwp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Jiwp
 * @subpackage Jiwp/admin
 * @author     Mihalache Razvan - Ionut <razvan@somasocial.com>
 */
class Jiwp_Admin {

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
	 * Pages array
	 * @var array
	 */
	private $pages;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->pages = array();

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( 
			'featherlight',
			plugin_dir_url( __DIR__ ) . 'public/js/featherlight/featherlight.min.css'
		);

		wp_enqueue_style( 
			'featherlight-gallery',
			plugin_dir_url( __DIR__ ) . 'public/js/featherlight/featherlight.gallery.min.css'
		);

		wp_enqueue_style( 
			$this->plugin_name, 
			plugin_dir_url( __FILE__ ) . 'css/jiwp-admin.css', 
			array(), 
			$this->version, 
			'all' 
		);

	}

	/**
	 * Register the JavaScript for the admin area.
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
		
		wp_enqueue_script( 
			'featherlight',
			plugin_dir_url( __DIR__ ) . 'public/js/featherlight/featherlight.min.js',
			array( 'jquery' )
		);

		wp_enqueue_script( 
			'featherlight-gallery',
			plugin_dir_url( __DIR__ ) . 'public/js/featherlight/featherlight.gallery.min.js',
			array( 'jquery' )
		);

		wp_enqueue_script( 
			$this->plugin_name, 
			plugin_dir_url( __FILE__ ) . 'js/jiwp-admin.js', 
			array( 'jquery' ), 
			$this->version, 
			false 
		);

	}

	/**
	 * Initialize admin menu
	 * 
	 * @since 1.0.0
	 */
	public function init_admin_menu() {

		$this->pages['admin'] = add_menu_page( 
			'Justimmo Settings', 
			'Justimmo', 
			'manage_options', 
			$this->plugin_name, 
			array( $this, 'admin_page' ), 
			'dashicons-filter'
		);

		$this->pages['shortcodes'] = add_submenu_page( 
			$this->plugin_name, 
			'Shortcodes',
			'Shortcodes',
			'manage_options',
			$this->plugin_name . '-shortcodes',
			array( $this, 'admin_page' )
		);

		$this->pages['theming'] = add_submenu_page( 
			$this->plugin_name, 
			'Theming',
			'Theming',
			'manage_options',
			$this->plugin_name . '-theming',
			array( $this, 'admin_page' )
		);

	}

	/**
	 * Outputs specific admin page by screen id
	 *
	 * @since 1.0.0
	 */
	public function admin_page() {

		$current_screen = get_current_screen();
		$child_template = '';

		switch ( $current_screen->id ) 
		{
			case $this->pages['shortcodes']:
			
				$child_template = 'shortcodes-template.php';

				break;

			case $this->pages['theming']:
			
				$child_template = 'theming-template.php';

				break;
			
			default:

				$api_credentials = $this->get_api_credentials();
				$child_template = 'api-settings-template.php';
				
				break;
		}

		include( plugin_dir_path( __FILE__ ) . 'partials/admin-template.php' );

	}

	/**
	 * Handle Justimmo API credentials form POST.
	 * Saves api credentials in wordpress `wp_options` table
	 *
	 * @since 1.0.0
	 */
	public function api_credentials_post() {

		update_option( 'ji_api_username', $_REQUEST['api_credentials']['api_username'] );
		update_option( 'ji_api_password', $_REQUEST['api_credentials']['api_password'] );

		wp_redirect( admin_url() . 'admin.php?page=jiwp', 200 );

	}

	/**
	 * Get api credentials array.
	 *
	 * @since  1.0.0
	 * @return array having with the following keys `api_username`, `api_password`
	 */
	private function get_api_credentials() {

		return array( 
			'api_username' => get_option( 'ji_api_username'), 
			'api_password' => get_option( 'ji_api_password' ) 
		);

	}

}

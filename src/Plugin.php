<?php

namespace Justimmo\Wordpress;

use Justimmo\Exception\NotFoundException;
use Justimmo\Wordpress\Translation\I18N;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 */
class Plugin
{
    /**
     * The unique identifier of this plugin.
     */
    const NAME = 'jiwp';

    //Please increase version on every .css or .js update
    const VERSION = '1.0.1';

    /**
     * Define the core functionality of the plugin.
     *
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     */
    public function __construct()
    {
        $this->setLocale();
        $this->defineAdminHooks();
        $this->definePublicHooks();
        $this->defineShortCodes();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Jiwp_i18n class in order to set the domain and to register the hook
     * with WordPress.
     */
    private function setLocale()
    {
        add_action('plugins_loaded', array(new I18N(), 'loadPluginTextdomain'));
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     */
    private function defineAdminHooks()
    {
        $admin = new Admin();

        add_action('admin_enqueue_scripts', array($admin, 'enqueueStyles'));
        add_action('admin_enqueue_scripts', array($admin, 'enqueueScripts'));

        add_action('admin_menu', array($admin, 'initAdminMenu'));
        add_action('admin_post_api_credentials_post', array($admin, 'apiCredentialsPost'));
        add_action('admin_post_google_api_key_post', array($admin, 'googleApiKeyPost'));
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * use closures to emulate lazy loading where neccessary
     */
    private function definePublicHooks()
    {
        $templating       = new Templating();
        $routing          = new Routing();

        add_action('wp_enqueue_scripts', array($templating, 'enqueueStyles'));
        add_action('wp_enqueue_scripts', array($templating, 'enqueueScripts'));

        add_action('init', array($routing, 'initRewriteRules'));
        add_action('init', array($routing, 'initRewriteTags'));
        add_action('template_include', array($routing, 'connectActions'));

        add_action('widgets_init', function () {
            register_widget('Justimmo\\Wordpress\\Widget\\SearchForm');
        });

        $loadStates = $this->createLazyLoadCallback('Justimmo\\Wordpress\\Controller\\WidgetController', 'ajaxGetStates');
        add_action('wp_ajax_ajax_get_states', $loadStates);
        add_action('wp_ajax_nopriv_ajax_get_states', $loadStates);

        $loadCities = $this->createLazyLoadCallback('Justimmo\\Wordpress\\Controller\\WidgetController', 'ajaxGetCities');
        add_action('wp_ajax_ajax_get_cities', $loadCities);
        add_action('wp_ajax_nopriv_ajax_get_cities', $loadCities);

        $sendInquiry = $this->createLazyLoadCallback('Justimmo\\Wordpress\\Controller\\WidgetController', 'ajaxSendInquiry');
        add_action('wp_ajax_ajax_send_inquiry', $sendInquiry);
        add_action('wp_ajax_nopriv_ajax_send_inquiry', $sendInquiry);
    }

    /**
     * adds shortcodes
     */
    private function defineShortCodes()
    {
        add_filter('widget_text', 'do_shortcode');

        add_shortcode('ji_realty_list', $this->createLazyLoadCallback('Justimmo\\Wordpress\\Controller\\RealtyController', 'getShortcodeList'));
        add_shortcode('ji_search_form', $this->createLazyLoadCallback('Justimmo\\Wordpress\\Controller\\RealtyController', 'getShortcodeSearchForm'));
        add_shortcode('ji_number_search_form', $this->createLazyLoadCallback('Justimmo\\Wordpress\\Controller\\RealtyController', 'getShortcodeNumberForm'));

        add_shortcode('ji_project_list', $this->createLazyLoadCallback('Justimmo\\Wordpress\\Controller\\ProjectController', 'getShortcodeList'));
        add_shortcode('ji_project_info', $this->createLazyLoadCallback('Justimmo\\Wordpress\\Controller\\ProjectController', 'getShortcodeInfo'));
    }


    /**
     * Creates a closure callback wrapping an instance creation for lazy loading
     *
     * @param string $class
     * @param string $method
     *
     * @return \Closure
     */
    private function createLazyLoadCallback($class, $method)
    {
        return function () use ($class, $method) {
            try {
                $instance = new $class();

                return call_user_func_array(array($instance, $method), func_get_args());
            } catch (\Exception $e) {
                if (WP_DEBUG === true) {
                    throw $e;
                }
            }
        };
    }
}

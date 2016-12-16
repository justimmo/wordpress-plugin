<?php

namespace Justimmo\Wordpress;

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
    const VERSION = '1.0.4';

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin
     *
     * @var Loader
     */
    protected $loader;

    /**
     * Define the core functionality of the plugin.
     *
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     */
    public function __construct()
    {
        $this->loader = new Loader();

        $this->setLocale();
        $this->defineAdminHooks();
        $this->definePublicHooks();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Jiwp_i18n class in order to set the domain and to register the hook
     * with WordPress.
     */
    private function setLocale()
    {
        $this->loader->addAction('plugins_loaded', new I18N(), 'loadPluginTextdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function defineAdminHooks()
    {
        $admin = new Admin();

        $this->loader->addAction('admin_enqueue_scripts', $admin, 'enqueueStyles');
        $this->loader->addAction('admin_enqueue_scripts', $admin, 'enqueueScripts');

        $this->loader->addAction('admin_menu', $admin, 'initAdminMenu');
        $this->loader->addAction('admin_post_api_credentials_post', $admin, 'apiCredentialsPost');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     */
    private function definePublicHooks()
    {
        $frontend = new Frontend();

        $this->loader->addAction('wp_enqueue_scripts', $frontend, 'enqueueStyles');
        $this->loader->addAction('wp_enqueue_scripts', $frontend, 'enqueueScripts');

        $this->loader->addAction('init', $frontend, 'initRewriteRules');
        $this->loader->addAction('init', $frontend, 'initRewriteTags');
        $this->loader->addAction('template_include', $frontend, 'initTemplates');
        $this->loader->addAction('widgets_init', $frontend, 'initWidgets');
        $this->loader->addAction('wp_ajax_ajax_get_states', $frontend, 'ajaxGetStates');
        $this->loader->addAction('wp_ajax_nopriv_ajax_get_states', $frontend, 'ajaxGetStates');
        $this->loader->addAction('wp_ajax_ajax_get_cities', $frontend, 'ajaxGetCities');
        $this->loader->addAction('wp_ajax_nopriv_ajax_get_cities', $frontend, 'ajaxGetCities');
        $this->loader->addAction('wp_ajax_ajax_send_inquiry', $frontend, 'ajaxSendInquiry');
        $this->loader->addAction('wp_ajax_nopriv_ajax_send_inquiry', $frontend, 'ajaxSendInquiry');

        $this->loader->addFilter('wp_title', $frontend, 'pageTitleSetup', 999, 2);
        $this->loader->addFilter('aioseop_title', $frontend, 'pageTitleSetup', 10);
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     */
    public function run()
    {
        $this->loader->run();
    }
}

<?php

namespace Justimmo\Wordpress;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
class Admin
{
    /**
     * Pages array
     * @var array
     */
    private $pages = array();

    /**
     * Register the stylesheets for the admin area.
     *
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Jiwp_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */
    public function enqueueStyles()
    {
        wp_enqueue_style(
            'featherlight',
            JI_WP_PLUGIN_RESOURCES_URL . 'js/featherlight/featherlight.min.css'
        );

        wp_enqueue_style(
            'featherlight-gallery',
            JI_WP_PLUGIN_RESOURCES_URL . 'js/featherlight/featherlight.gallery.min.css'
        );

        wp_enqueue_style(
            Plugin::NAME,
            JI_WP_PLUGIN_RESOURCES_URL . 'css/jiwp-admin.css',
            array(),
            Plugin::VERSION,
            'all'
        );

    }

    /**
     * Register the JavaScript for the admin area.
     *
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
    public function enqueueScripts()
    {
        wp_enqueue_script(
            'featherlight',
            JI_WP_PLUGIN_RESOURCES_URL . 'js/featherlight/featherlight.min.js',
            array('jquery')
        );

        wp_enqueue_script(
            'featherlight-gallery',
            JI_WP_PLUGIN_RESOURCES_URL . 'js/featherlight/featherlight.gallery.min.js',
            array('jquery')
        );

        wp_enqueue_script(
            Plugin::NAME,
            JI_WP_PLUGIN_RESOURCES_URL . 'js/jiwp-admin.js',
            array('jquery'),
            Plugin::VERSION,
            false
        );
    }

    /**
     * Initialize admin menu
     */
    public function initAdminMenu()
    {
        $this->pages['admin'] = add_menu_page(
            'JUSTIMMO Settings',
            'JUSTIMMO',
            'manage_options',
            Plugin::NAME,
            array($this, 'adminPage'),
            'dashicons-filter'
        );

        $this->pages['shortcodes'] = add_submenu_page(
            Plugin::NAME,
            'Shortcodes',
            'Shortcodes',
            'manage_options',
            Plugin::NAME . '-shortcodes',
            array($this, 'adminPage')
        );

        $this->pages['theming'] = add_submenu_page(
            Plugin::NAME,
            'Theming',
            'Theming',
            'manage_options',
            Plugin::NAME . '-theming',
            array($this, 'adminPage')
        );
    }

    /**
     * Outputs specific admin page by screen id
     */
    public function adminPage()
    {
        $current_screen = get_current_screen();
        $child_template = '';

        switch ($current_screen->id) {
            case $this->pages['shortcodes']:

                $child_template = 'shortcodes-template.php';

                break;

            case $this->pages['theming']:

                $child_template = 'theming-template.php';

                break;

            default:

                $api_credentials = $this->getApiCredentials();
                $child_template  = 'api-settings-template.php';

                break;
        }


        include(JI_WP_PLUGIN_TEMPLATES_PATH . 'admin/admin-template.php');
    }

    /**
     * Handle Justimmo API credentials form POST.
     * Saves api credentials in wordpress `wp_options` table
     */
    public function apiCredentialsPost()
    {

        update_option('ji_api_username', $_REQUEST['api_credentials']['api_username']);
        update_option('ji_api_password', $_REQUEST['api_credentials']['api_password']);

        header('Location: ' . admin_url() . 'admin.php?page=jiwp');
    }

    /**
     * Get api credentials array.
     *
     * @return array having with the following keys `api_username`, `api_password`
     */
    private function getApiCredentials()
    {
        return array(
            'api_username' => get_option('ji_api_username'),
            'api_password' => get_option('ji_api_password'),
        );
    }

}

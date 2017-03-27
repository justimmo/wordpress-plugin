<?php

namespace Justimmo\Wordpress;

class Templating
{
    /**
     * Locates template in theme folder first and then in plugin folder.
     *
     * @param  string $templateFile template file
     *
     * @return string               template path
     */
    public static function getPath($templateFile)
    {
        // Check theme directory first
        $newTemplate = locate_template(array('jiwp-templates/' . $templateFile));

        if ($newTemplate != '') {
            return $newTemplate;
        }

        // Check plugin directory next
        $newTemplate = JI_WP_PLUGIN_TEMPLATES_PATH . 'frontend/' . $templateFile;

        if (file_exists($newTemplate)) {
            return $newTemplate;
        }

        return false;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     */
    public function enqueueStyles()
    {
        if (get_query_var('ji_page', false) == 'realty' || get_query_var('ji_page', false) == 'project') {
            wp_enqueue_style(
                'lightslider',
                JI_WP_PLUGIN_RESOURCES_URL . 'js/lightslider/css/lightslider.min.css',
                array(),
                Plugin::VERSION,
                'all'
            );

            wp_enqueue_style(
                'fancybox',
                JI_WP_PLUGIN_RESOURCES_URL . 'js/fancybox/jquery.fancybox.css',
                array(),
                '2.0',
                'all'
            );
        }

        wp_enqueue_style(
            Plugin::NAME,
            JI_WP_PLUGIN_RESOURCES_URL . 'css/jiwp-public.css',
            array(),
            Plugin::VERSION,
            'all'
        );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     */
    public function enqueueScripts()
    {
        if (!wp_script_is('jquery')) {
            wp_register_script(
                'jquery',
                JI_WP_PLUGIN_RESOURCES_URL . 'js/jquery/jquery-1.7.0.min.js',
                '1.7.0'
            );
        }

        if (get_query_var('ji_page', false) == 'realty' || get_query_var('ji_page', false) == 'project') {
            wp_enqueue_script(
                'lightslider',
                JI_WP_PLUGIN_RESOURCES_URL . 'js/lightslider/js/lightslider.min.js',
                array('jquery'),
                Plugin::VERSION,
                true
            );

            wp_enqueue_script(
                'fancybox',
                JI_WP_PLUGIN_RESOURCES_URL . 'js/fancybox/jquery.fancybox.pack.js',
                array('jquery'),
                '2.0',
                true
            );

            wp_enqueue_script(
                'jiwp-realty-page',
                JI_WP_PLUGIN_RESOURCES_URL . 'js/jiwp-realty-page.js',
                array('lightslider'),
                Plugin::VERSION,
                true
            );

            wp_enqueue_script(
                Plugin::NAME,
                JI_WP_PLUGIN_RESOURCES_URL . 'js/jiwp-inquiry-form.js',
                array('jquery'),
                Plugin::VERSION,
                true
            );

            wp_enqueue_script(
                'jiwp-google-map',
                'https://maps.googleapis.com/maps/api/js?key=' . get_option('jiwp_google_api_key', ''),
                array('jquery'),
                Plugin::VERSION,
                true
            );
        }

        wp_enqueue_script(
            Plugin::NAME,
            JI_WP_PLUGIN_RESOURCES_URL . 'js/jiwp-search-form-widget.js',
            array('jquery'),
            Plugin::VERSION,
            true
        );

        wp_localize_script(
            Plugin::NAME,
            'Justimmo_Ajax',
            array(
                'ajax_url'   => admin_url('admin-ajax.php'),
                'ajax_nonce' => wp_create_nonce('justimmo_ajax'),
            )
        );
    }
}

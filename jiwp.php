<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @wordpress-plugin
 * Plugin Name:       JUSTIMMO WP Plugin
 * Plugin URI:        https://github.com/justimmo/wordpress-plugin
 * Description:       Wordpress plugin which brokers can use to access the JUSTIMMO API and list their properties and more.
 * Version:           1.0.0
 * Author:            JUSTIMMO
 * Author URI:        www.justimmo.at
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jiwp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.

if ( ! defined( 'WPINC' ) ) {
	die;
}

define('JI_WP_PLUGIN_ROOT_PATH', plugin_dir_path(__FILE__));
define('JI_WP_PLUGIN_RESOURCES_URL', plugin_dir_url(__FILE__) . 'resources/');
define('JI_WP_PLUGIN_TEMPLATES_PATH', JI_WP_PLUGIN_ROOT_PATH . 'resources' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR );

register_activation_hook( __FILE__, function() {
    Justimmo\Wordpress\Installer::activate();
});
register_deactivation_hook( __FILE__, function () {
    Justimmo\Wordpress\Installer::deactivate();
});

$jiWpPlugin = new Justimmo\Wordpress\Plugin();

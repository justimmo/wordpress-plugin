<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              somasocial.com
 * @since             1.0.0
 * @package           Jiwp
 *
 * @wordpress-plugin
 * Plugin Name:       Justimmo WP Plugin
 * Plugin URI:        http://www.justimmo.at/
 * Description:       Wordpress plugin which brokers can use to access the Justimmo API and list their properties and more.
 * Version:           1.0.0
 * Author:            Mihalache Razvan - Ionut
 * Author URI:        somasocial.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jiwp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-jiwp-activator.php
 */
function activate_jiwp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jiwp-activator.php';
	Jiwp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-jiwp-deactivator.php
 */
function deactivate_jiwp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jiwp-deactivator.php';
	Jiwp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_jiwp' );
register_deactivation_hook( __FILE__, 'deactivate_jiwp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-jiwp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_jiwp() {

	$plugin = new Jiwp();
	$plugin->run();

}

run_jiwp();
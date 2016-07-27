<?php

/**
 * Fired during plugin activation
 *
 * @link       somasocial.com
 * @since      1.0.0
 *
 * @package    Jiwp
 * @subpackage Jiwp/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Jiwp
 * @subpackage Jiwp/includes
 * @author     Mihalache Razvan - Ionut <razvan@somasocial.com>
 */
class Jiwp_Activator {

	/**
	 * Set transient value to be checked when the plugin is activated.
	 * Used for adding rewrite rules and flushing permalinks only once. 
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		set_transient( 'rewrite_rules_check', true, 60 );
		
	}

}

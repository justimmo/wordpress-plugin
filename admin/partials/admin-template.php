<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       somasocial.com
 * @since      1.0.0
 *
 * @package    Jiwp
 * @subpackage Jiwp/admin/partials
 */
?>

<section class="wrap">
	<header>
		<h1><?php _e( 'JUSTIMMO Settings', 'jiwp' ); ?></h1>
	</header>

	<h2 class="nav-tab-wrapper">
		<a href="?page=jiwp" class="nav-tab <?php echo 'toplevel_page_jiwp' == $current_screen->id ? 'nav-tab-active' : '' ?>">
			<?php _e( 'API Settings', 'jiwp' ); ?>
		</a>
		<a href="?page=jiwp-shortcodes" class="nav-tab <?php echo 'justimmo_page_jiwp-shortcodes' == $current_screen->id ? 'nav-tab-active' : '' ?>">
			<?php _e( 'Shortcodes', 'jiwp' ); ?>
		</a>
		<a href="?page=jiwp-theming" class="nav-tab <?php echo 'justimmo_page_jiwp-theming' == $current_screen->id ? 'nav-tab-active' : '' ?>">
			<?php _e( 'Theming', 'jiwp' ); ?>
		</a>
	</h2>
	
	<section class="wrap"><?php include( $child_template ); ?></section>

</section>

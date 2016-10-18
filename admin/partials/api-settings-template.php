<h3><?php _e( 'Please enter your JUSTIMMO API credentials:', 'jiwp' ); ?></h3>

<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="POST">
	<input type="hidden" name="action" value="api_credentials_post"/>
	<p>
		<label for="api_username">
			<strong><?php _e( 'Username', 'jiwp' ); ?>:</strong>
		</label>
		<input 
			type 	= "text" 
			id 		= "api_username" 
			class 	= "all-options" 
			name 	= "api_credentials[api_username]"
			value 	= "<?php echo $api_credentials['api_username']; ?>" />
	</p>
	<p>
		<label for="api_password">
			<strong><?php _e( 'Password', 'jiwp' ); ?>:</strong>
		</label>
		<input 
			type 	= "password" 
			id  	= "api_password" 
			class 	= "all-options" 
			name 	= "api_credentials[api_password]"
			value	= "<?php echo $api_credentials['api_password']; ?>" />
	</p>
	<p>
		<input class="button-primary" type="submit" value="<?php esc_attr_e( 'Save', 'jiwp' ); ?>" />
	</p>
</form>

<section class="wrap">
	<header>
		<h3><?php echo _e('How to obtain your JUSTIMMO API credentials:', 'jiwp' ); ?></h3>
	</header>

	<ol>
		<li>
			<?php _e( 'Log into the JUSTIMMO platform using your account.', 'jiwp' ); ?>
			<a class="featherlight-gallery" href="#" data-featherlight="<?php echo plugin_dir_url( __DIR__ ) ?>/img/api-credentials-steps/step1.png"><?php _e( 'show image', 'jiwp' ); ?></a>
		</li>
		<li>
			<?php _e( 'From the main menu go to "more" > "Exports".', 'jiwp' ); ?>
			<a class="featherlight-gallery" href="#" data-featherlight="<?php echo plugin_dir_url( __DIR__ ) ?>/img/api-credentials-steps/step2.png"><?php _e( 'show image', 'jiwp' ); ?></a>
		</li>
		<li>
			<?php _e( 'Switch to the "Custom Exports" tab.', 'jiwp' ); ?>
			<a class="featherlight-gallery" href="#" data-featherlight="<?php echo plugin_dir_url( __DIR__ ) ?>/img/api-credentials-steps/step3.png"><?php _e( 'show image', 'jiwp' ); ?></a>
		</li>
		<li>
			<?php _e( 'Click the "Create JUSTIMMO API" button.', 'jiwp' ); ?>
			<a class="featherlight-gallery" href="#" data-featherlight="<?php echo plugin_dir_url( __DIR__ ) ?>/img/api-credentials-steps/step3.png"><?php _e( 'show image', 'jiwp' ); ?></a>
		</li>
		<li>
			<?php _e( 'Complete the form with your desired options. Click the "Save" button.', 'jiwp' ); ?>
			<a class="featherlight-gallery" href="#" data-featherlight="<?php echo plugin_dir_url( __DIR__ ) ?>/img/api-credentials-steps/step4.png"><?php _e( 'show image', 'jiwp' ); ?></a>
		</li>
		<li>
			<?php _e( 'You should now have a username and password in your export settings form.', 'jiwp' ); ?>
			<a class="featherlight-gallery" href="#" data-featherlight="<?php echo plugin_dir_url( __DIR__ ) ?>/img/api-credentials-steps/step4.png"><?php _e( 'show image', 'jiwp' ); ?></a>
		</li>
		<li>
			<?php _e( 'You should use these credentials to complete the above form.', 'jiwp' ); ?>
		</li>
	</ol>
</section>
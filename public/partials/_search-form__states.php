<div class="ji-states-container">

	<?php if ( !empty( $states ) ): ?>

		<ul class="ji-state-list">
			
			<?php foreach ( $states as $state_id => $state ): ?>
				
				<li class="ji-state">

					<input 
						type 	= "checkbox" 
						id 		= "state_<?php echo $state_id; ?>"
						class 	= "ji-input ji-input--checkbox js-get-cities"
						value 	= <?php echo $state_id; ?>
						name 	= "filter[states][]"
						<?php echo isset( $_GET[ 'filter' ][ 'states' ] ) && in_array( $state_id , $_GET[ 'filter' ][ 'states' ]) ? 'checked="checked"' : ''; ?> />

					<label class="ji-label" for="state_<?php echo $state_id ?>"><?php echo $state['name']; ?></label>
				
				</li>

			<?php endforeach; ?>

		</ul>

	<?php else: ?>

		<?php if ( empty( $_POST[ 'country' ] ) ): ?>

			<span class="ji-search-form__no-data-msg">
				<?php _e( 'Please select a country first', $plugin_name ); ?>
			</span>

		<?php else: ?>
			
			<span class="ji-search-form__no-data-msg">
				<?php _e( 'No states found for selected country', $plugin_name ); ?>
			</span>

		<?php endif; ?>

	<?php endif; ?>

</div>
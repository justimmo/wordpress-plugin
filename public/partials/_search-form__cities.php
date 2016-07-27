<?php 

// Although this template is named '_search-form__cities.php',
// it actually lists zip codes. In the near future it should be changed to list actual cities.

?>

<div class="ji-cities-container">

	<?php if ( !empty( $cities ) ): ?>

		<ul class="ji-city-list">
			
			<?php foreach ( $cities as $city_id => $city ): ?>
				
				<li class="ji-city">

					<input 
						type 	= "checkbox" 
						id 		= "city_<?php echo $city_id; ?>"
						class 	= "ji-input ji-input--checkbox"
						value 	= <?php echo $city['zipCode']; ?>
						name 	= "filter[zip_codes][]"
						<?php echo isset( $_GET[ 'filter' ][ 'zip_codes' ] ) && in_array( $city['zipCode'], $_GET[ 'filter' ][ 'zip_codes' ]) ? 'checked="checked"' : ''; ?> />

					<label class="ji-label" for="city_<?php echo $city_id ?>">
						<?php echo $city['zipCode'] . ' (' . $city['place'] . ')' ; ?>
					</label>
				
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
				<?php _e( 'No zip codes found for selected country', $plugin_name ); ?>
			</span>

		<?php endif; ?>

	<?php endif; ?>

</div>
<form action="<?php bloginfo( 'url' ); ?>/<?php _e('properties', 'jiwp'); ?>/search" class="ji-search-form">

    <h3><?php _e( 'Realty Number:', 'jiwp' ); ?></h3>
    
    <input 
    	type 	= "number" 
    	id 		= "" 
    	class 	= "ji-input ji-input--number" 
    	size 	= "10" 
    	value 	= "<?php echo isset($filter[ 'objektnummer' ]) ? $filter[ 'objektnummer' ] : '' ?>" 
    	name 	= "filter[objektnummer]" />

    <input type="submit" class="ji-input ji-input--submit" value="<?php _e( 'Search', 'jiwp' ); ?>" />

</form>

<form action="<?php bloginfo( 'url' ); ?>/<?php _e('properties', 'jiwp'); ?>/search" class="ji-search-form">

	<h3><?php _e( 'Advanced Realty Search', 'jiwp' ); ?></h3>

	<p class="ji-search-form__row">
		
		<input 
			type 	= "checkbox"
			id 		= "filter_rent"
			class 	= "ji-input ji-input--checkbox"
			name 	= "filter[rent]"
			<?php echo isset( $filter[ 'rent' ] ) ? 'checked="checked"' : ''; ?> />

		<label class="ji-label" for="filter_rent"><?php _e( 'Rent', 'jiwp' ); ?></label>

		<input 
			type 	= "checkbox"
			id 		= "filter_buy"
			class 	= "ji-input ji-input--checkbox"
			name 	= "filter[buy]"
			<?php echo isset( $filter[ 'buy' ] ) ? 'checked="checked"' : ''; ?> />

		<label class="ji-label" for="filter_buy"><?php _e( 'Buy', 'jiwp' ); ?></label>

	</p>

	<p class="ji-search-form__row">

		<label class="ji-label" for="filter_property_type"><?php _e( 'Realty Type:', 'jiwp' ); ?></label>

        <select id="filter_property_type" class="ji-input ji-input--select" name="filter[type]">

            <option value=""></option>

            <?php foreach ( $realty_types as $realty_type_id => $realty_type ): ?>

                <option value="<?php echo $realty_type[ 'key' ] ?>" 
                	<?php echo isset( $filter[ 'type' ] ) && ( $realty_type[ 'key' ] == $filter[ 'type' ] ) ? 'selected=selected' : '' ?>>

                	<?php echo $realty_type['name']; ?>

                </option>

            <?php endforeach; ?>

        </select>

	</p>

	<p class="ji-search-form__row">

		<label class="ji-label" for="filter_price"><?php _e( 'Price:', 'jiwp' ); ?></label>

		<br/>
        
        <input 
        	type 	= "number" 
        	id 		= "filter_price_from" 
        	class 	= "ji-input ji-input--number" 
        	value 	= "<?php echo isset($filter[ 'price_min' ]) ? $filter[ 'price_min' ] : '' ?>"
        	name 	= "filter[price_min]" />

        <?php _e( 'to', 'jiwp' ); ?>

        <input 
        	type 	= "number"
        	id 		= "filter_price_to" 
        	class 	= "ji-input ji-input--number" 
        	value 	= "<?php echo isset($filter[ 'price_max' ]) ? $filter[ 'price_max' ] : '' ?>"
        	name 	= "filter[price_max]" />

        &euro;

	</p>

	<p class="ji-search-form__row">

		<label class="ji-label" for="filter_rooms"><?php _e( 'Rooms:', 'jiwp' ); ?></label>

		<br/>
        
        <input 
        	type 	= "number" 
        	id 		= "filter_rooms_from" 
        	class 	= "ji-input ji-input--number" 
        	value 	= "<?php echo isset($filter[ 'rooms_min' ]) ? $filter[ 'rooms_min' ] : '' ?>"
        	name 	= "filter[rooms_min]" />

        <?php _e( 'to', 'jiwp' ); ?>

        <input 
        	type 	= "number" 
        	id 		= "filter_rooms_to" 
        	class 	= "ji-input ji-input--number" 
        	value 	= "<?php echo isset($filter[ 'rooms_max' ]) ? $filter[ 'rooms_max' ] : '' ?>"
        	name 	= "filter[rooms_max]" />

	</p>

	<p class="ji-search-form__row">

		<label class="ji-label" for="filter_surface"><?php _e( 'Surface:', 'jiwp' ); ?></label>

		<br/>
        
        <input
        	type 	= "number" 
        	id 		= "filter_surface_from"
        	class 	= "ji-input ji-input--number" 
        	value 	= "<?php echo isset($filter[ 'surface_min' ]) ? $filter[ 'surface_min' ] : '' ?>"
        	name 	= "filter[surface_min]" />

        <?php _e( 'to', 'jiwp' ); ?>

        <input
        	type 	= "number" 
        	id 		= "filter_surface_to"
        	class 	= "ji-input ji-input--number" 
        	value 	= "<?php echo isset($filter[ 'surface_max' ]) ? $filter[ 'surface_max' ] : '' ?>"
        	name 	= "filter[surface_max]" />

        m&sup2;

	</p>

	<p class="ji-search-form__row">

		<label class="ji-label"><?php _e( 'Country:', 'jiwp' ) ?></label>

		<select class="ji-input ji-input--select js-get-states" name="filter[country]">

			<option value=""></option>

			<?php foreach ($countries as $country_id => $country): ?>

				<option value="<?php echo $country_id; ?>"
					<?php echo isset($filter[ 'country' ]) && $filter[ 'country' ] == $country_id ? 'selected=selected' : '' ?>>

					<?php echo $country['name']; ?>

				</option>

			<?php endforeach; ?>

		</select>

	</p>

	<p class="ji-search-form__row">

		<label class="ji-label"><?php _e( 'State:', 'jiwp' ) ?></label>
		
		<?php include( '_search-form__states.php' ); ?>

	</p>

    <p class="ji-search-form__row">

        <label class="ji-label"><?php _e( 'Zip Codes:', 'jiwp' ) ?></label>
        
        <?php include( '_search-form__cities.php' ); ?>

    </p>

	<p class="ji-search-form__row">

        <input 
        	type 	= "checkbox" 
        	id 		= "filter_garden"
        	class 	= "ji-input ji-input--checkbox"
        	name 	= "filter[garten]"
        	<?php echo isset( $filter[ 'garden' ] ) ? 'checked="checked"' : ''; ?> />

        <label class="ji-label" for="filter_garden"><?php _e( 'Garden', 'jiwp' ); ?></label>
        
        <br>
        
        <input 
        	type 	= "checkbox" 
        	id  	= "filters_garage"
        	class 	= "ji-input ji-input--checkbox"
        	name  	= "filter[garage]"
        	<?php echo isset( $filter[ 'garage' ] ) ? 'checked="checked"' : ''; ?> />

        <label class="ji-label" for="filters_garage"><?php _e( 'Garage', 'jiwp' ); ?></label>
        
        <br>
        
        <input 
        	type 	= "checkbox" 
        	id  	= "filters_balcony"
        	class 	= "ji-input ji-input--checkbox"
        	name  	= "filter[balcony_terrace]"
        	<?php echo isset( $filter[ 'balcony_terrace' ] ) ? 'checked="checked"' : ''; ?> />

        <label class="ji-label" for="filters_balcony"><?php _e( 'Balcony/Terrace', 'jiwp' ); ?></label>

	</p>

	<p class="ji-search-form__row">
		<input type="submit" class="ji-input ji-input--submit" value="<?php _e( 'Search', 'jiwp' ); ?>" />
	</p>

	<p class="ji-search-form__row">
		<a href="/<?php _e('properties', 'jiwp'); ?>/search"><?php _e( 'Reset Filter', 'jiwp' ); ?></a>
	</p>
	
</form>
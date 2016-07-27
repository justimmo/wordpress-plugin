<h3><?php _e( 'The following shortcodes are made available by the Justimmo API Plugin:', 'jiwp' ); ?></h3>

<ol class="ji-shortcode-list">
	<li class="ji-shortcode-list__item">
		<label class="ji-label">
			<?php _e( 'The property listing shortcode:', 'jiwp' ); ?>
		</label>

		<code>[ji_property_list]</code>

		<p><?php _e( 'Paste this shortcode in any page, post or sidebar Text widget to output a list of your available realties.', 'jiwp' ); ?></p>

		<p><?php _e( 'It has the following options which you can pass as parameters:', 'jiwp' ); ?></p>

		<ul class="ji-shortcode-options">

			<li class="ji-shortcode-option">
				<code>max_per_page</code>: <?php _e( 'Limits the number of realties displayed per page.', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list max_per_page=5]</code> <?php _e( 'shows 5 realties per page.', 'jiwp'); ?>
			</li>

			<li class="ji-shortcode-option">
				<code>rent</code>: <?php _e( 'Lists only realties up for rent.', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list rent="1"]</code>
			</li>

			<li class="ji-shortcode-option">
				<code>buy</code>: <?php _e( 'Lists only realties up for purchase.', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list buy="1"]</code>
			</li>

			<li class="ji-shortcode-option">
				<code>type</code>: <?php _e( 'Lists only realties of certain type. Available values: "wohnung" (Apartment), "haus" (House), "buero_praxen" (Bureau).', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list type="wohnung"]</code> <?php _e( 'shows only apartments.', 'jiwp' ); ?>
			</li>

			<li class="ji-shortcode-option">
				<code>price_min</code>: <?php _e( 'Sets a minimum price (in euro).', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list price_min="100"]</code> <?php _e( 'show realties with a minimum price of 100 euro.', 'jiwp' ); ?>
			</li>

			<li class="ji-shortcode-option">
				<code>price_max</code>: <?php _e( 'Sets a maximum price (in euro).', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list price_max="100"]</code> <?php _e( 'show realties with a maximum price of 100 euro.', 'jiwp' ); ?>
			</li>

			<li class="ji-shortcode-option">
				<code>rooms_min</code>: <?php _e( 'Sets a minimum number of rooms.', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list rooms_min="3"]</code> <?php _e( 'shows realties with a minimum of 3 rooms.', 'jiwp' ); ?>
			</li>

			<li class="ji-shortcode-option">
				<code>rooms_max</code>: <?php _e( 'Sets a maximum number of rooms.', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list rooms_max="3"]</code> <?php _e( 'shows realties with a maximum of 3 rooms.', 'jiwp' ); ?>
			</li>

			<li class="ji-shortcode-option">
				<code>surface_min</code>: <?php _e( 'Sets a minimum surface area (m&sup2;).', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list surface_min="100"]</code> <?php _e( 'shows realties with a minimum surface area of 100 m&sup2;', 'jiwp' ); ?>
			</li>

			<li class="ji-shortcode-option">
				<code>surface_max</code>: <?php _e( 'Sets a maximum surface area (m&sup2;).', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list surface_max=""]</code> <?php _e( 'shows realties with a maximum surface area of 100 m&sup2;', 'jiwp' ); ?>
			</li>

			<li class="ji-shortcode-option">
				<code>garden</code>: <?php _e( 'Lists only realties that have a garden.', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list garden="1"]</code>
			</li>

			<li class="ji-shortcode-option">
				<code>garage</code>: <?php _e( 'Lists only realties that have a garage.', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list garage="1"]</code>
			</li>

			<li class="ji-shortcode-option">
				<code>balcony_terrace</code>: <?php _e( 'Lists only realties that have a balcony/terrace.', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list balcony_terrace="1"]</code>
			</li>

			<li class="ji-shortcode-option">
				<code>price_order</code>: <?php _e( 'Orders realties by price. Available values: "asc" (ascending), "desc" (descending).', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list price_order="desc"]</code> <?php _e( 'shows realties in descending price order.', 'jiwp' ); ?>
			</li>

			<li class="ji-shortcode-option">
				<code>date_order</code>: <?php _e( 'Orders realties by entry date. Available values: "asc" (ascending), "desc" (descending).', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list date_order="desc"]</code> <?php _e( 'shows realties in descending date order.', 'jiwp' ); ?>
			</li>

			<li class="ji-shortcode-option">
				<code>surface_order</code>: <?php _e( 'Orders realties by surface. Available values: "asc" (ascending), "desc" (descending).', 'jiwp' ); ?>
				<?php _e( 'Example:', 'jiwp' ); ?>
				<code>[ji_property_list surface_order="desc"]</code> <?php _e( 'shows realties in descending surface order.', 'jiwp' ); ?>
			</li>

		</ul>

		<p><?php _e( '(Note: you cannot combine multiple ordering attributes. Only the last one will be used)', 'jiwp' ); ?></p>
	</li>

	<li class="ji-shortcode-list__item">
		<label class="ji-label">
			<?php _e( 'The search form shortcode:', 'jiwp' ); ?>
		</label>

		<code>[ji_search_form]</code>

		<p><?php _e( 'Paste this shortcode in any page, post or sidebar Text widget to output a realty search form. This can also be achieved by using the "Justimmo Search Form" widget.', 'jiwp' ); ?></p>
	</li>
</ol>
<h3><?php _e( 'The following shortcodes are made available by the JUSTIMMO API Plugin:', 'jiwp' ); ?></h3>

<ul class="ji-shortcode-list">
	<li class="ji-shortcode-list__item">
		<details>
			<summary>
				<label class="ji-label">
					<?php _e( 'The realty listing shortcode:', 'jiwp' ); ?>
				</label>
				<code>[ji_realty_list]</code>
			</summary>

			<p><?php _e( 'Paste this shortcode in any page, post or sidebar Text widget to output a list of your available realties.', 'jiwp' ); ?></p>

			<p><?php _e( 'It has the following options which you can pass as parameters:', 'jiwp' ); ?></p>

			<ul class="ji-shortcode-options">
				<li class="ji-shortcode-option">
					<code>max_per_page</code>: <?php _e( 'Limits the number of realties displayed per page.', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list max_per_page=5]</code> <?php _e( 'shows 5 realties per page.', 'jiwp'); ?>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>rent</code>: <?php _e( 'Lists only realties up for rent.', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list rent="1"]</code>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>buy</code>: <?php _e( 'Lists only realties up for purchase.', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list buy="1"]</code>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>type</code>: <?php _e( 'Lists only realties of certain type. Available values: "wohnung" (Apartment), "haus" (House), "buero_praxen" (Bureau).', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list type="wohnung"]</code> <?php _e( 'shows only apartments.', 'jiwp' ); ?>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>format</code>: <?php _e( 'Formats realty list in grid format.', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list format="grid"]</code> <?php _e( 'shows realties in grid format.', 'jiwp' ); ?>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>price_min</code>: <?php _e( 'Sets a minimum price (in euro).', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list price_min="100"]</code> <?php _e( 'show realties with a minimum price of 100 euro.', 'jiwp' ); ?>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>price_max</code>: <?php _e( 'Sets a maximum price (in euro).', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list price_max="100"]</code> <?php _e( 'show realties with a maximum price of 100 euro.', 'jiwp' ); ?>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>rooms_min</code>: <?php _e( 'Sets a minimum number of rooms.', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list rooms_min="3"]</code> <?php _e( 'shows realties with a minimum of 3 rooms.', 'jiwp' ); ?>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>rooms_max</code>: <?php _e( 'Sets a maximum number of rooms.', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list rooms_max="3"]</code> <?php _e( 'shows realties with a maximum of 3 rooms.', 'jiwp' ); ?>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>surface_min</code>: <?php _e( 'Sets a minimum surface area (m&sup2;).', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list surface_min="100"]</code> <?php _e( 'shows realties with a minimum surface area of 100 m&sup2;', 'jiwp' ); ?>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>surface_max</code>: <?php _e( 'Sets a maximum surface area (m&sup2;).', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list surface_max=""]</code> <?php _e( 'shows realties with a maximum surface area of 100 m&sup2;', 'jiwp' ); ?>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>garden</code>: <?php _e( 'Lists only realties that have a garden.', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list garden="1"]</code>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>garage</code>: <?php _e( 'Lists only realties that have a garage.', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list garage="1"]</code>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>balcony_terrace</code>: <?php _e( 'Lists only realties that have a balcony/terrace.', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list balcony_terrace="1"]</code>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>price_order</code>: <?php _e( 'Orders realties by price. Available values: "asc" (ascending), "desc" (descending).', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list price_order="desc"]</code> <?php _e( 'shows realties in descending price order.', 'jiwp' ); ?>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>date_order</code>: <?php _e( 'Orders realties by entry date. Available values: "asc" (ascending), "desc" (descending).', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list date_order="desc"]</code> <?php _e( 'shows realties in descending date order.', 'jiwp' ); ?>
					</p>
				</li>

				<li class="ji-shortcode-option">
					<code>surface_order</code>: <?php _e( 'Orders realties by surface. Available values: "asc" (ascending), "desc" (descending).', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_realty_list surface_order="desc"]</code> <?php _e( 'shows realties in descending surface order.', 'jiwp' ); ?>
					</p>
				</li>
			</ul>

			<p><?php _e( '(Note: you cannot combine multiple ordering attributes. Only the last one will be used)', 'jiwp' ); ?></p>
		</details>
	</li>

	<li class="ji-shortcode-list__item">
		<details>
			<summary>
				<label class="ji-label">
					<?php _e( 'The search form shortcode:', 'jiwp' ); ?>
				</label>
				<code>[ji_search_form]</code>
			</summary>

			<p><?php _e( 'Paste this shortcode in any page, post or sidebar Text widget to output a realty search form. This can also be achieved by using the "JUSTIMMO Search Form" widget.', 'jiwp' ); ?></p>
		</details>
	</li>

	<li class="ji-shortcode-list__item">
		<details>
			<summary>
				<label class="ji-label">
					<?php _e( 'The project listing shortcode:', 'jiwp' ); ?>
				</label>
				<code>[ji_project_list]</code>
			</summary>

			<p><?php _e( 'Paste this shortcode in any page, post or sidebar Text widget to output a list of your available projects.', 'jiwp' ); ?></p>

			<p><?php _e( 'It has the following options which you can pass as parameters:', 'jiwp' ); ?></p>

			<ul class="ji-shortcode-options">
				<li class="ji-shortcode-option">
					<code>max_per_page</code>: <?php _e( 'Limits the number of projects displayed per page.', 'jiwp' ); ?>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_project_list max_per_page=5]</code> <?php _e( 'shows 5 projects per page.', 'jiwp'); ?>
					</p>
				</li>
			</ul>
		</details>
	</li>

	<li class="ji-shortcode-list__item">
		<details>
			<summary>
				<label class="ji-label">
					<?php _e( 'The project information shortcode:', 'jiwp' ); ?>
				</label>
				<code>[ji_project_info]</code>
			</summary>

			<p><?php _e( 'Paste this shortcode in any page, post or sidebar Text widget to output various project information.', 'jiwp' ); ?></p>

			<p><?php _e( 'It has the following options which you can pass as parameters:', 'jiwp' ); ?></p>

			<ul class="ji-shortcode-options">
				<li class="ji-shortcode-option">
					<code>id</code>: <?php _e( 'The project JUSTIMMO ID (mandatory).', 'jiwp' ); ?>
					<a class="featherlight-gallery" href="#" data-featherlight="<?php echo plugin_dir_url( __DIR__ ) ?>/img/justimmo-project-id.png"><?php _e( 'show image', 'jiwp' ); ?></a>
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_project_info id="5"]</code> <?php _e( 'shows information belonging to the project with the JUSTIMMO ID of 5.', 'jiwp'); ?>
					</p>
				</li>
				<li class="ji-shortcode-option">
					<code>info</code>: <?php _e( 'The project information to be shown (mandatory).', 'jiwp' ); ?>
					
					<p>
						<?php _e( 'Example:', 'jiwp' ); ?>
						<code>[ji_project_info id="5" info="address"]</code> <?php _e( 'shows project address information belonging to the project with the JUSTIMMO ID of 5.', 'jiwp'); ?>
					</p>
					
					<p>
						<?php _e( 'Here is a list of all the values available for the "info" option:' ,'jiwp' ); ?>
						<ul class="ji-shortcode-options">
							<li class="ji-shortcode-option"><code>contact</code></li>
							<li class="ji-shortcode-option"><code>description</code></li>
							<li class="ji-shortcode-option"><code>other-info</code></li>
							<li class="ji-shortcode-option"><code>photo-gallery</code></li>
							<li class="ji-shortcode-option"><code>realties</code></li>
						</ul>
					</p>
				</li>
			</ul>
		</details>
	</li>
</ul>
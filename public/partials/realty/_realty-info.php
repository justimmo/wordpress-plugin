<ul class="ji-info-list">

	<li class="ji-info">

		<label class="ji-info__label">
			<?php _e( 'Realty Type:', 'jiwp' ); ?>
		</label>
		
		<span class="ji-info__value">
			<?php echo $realty->getRealtyTypeName(); ?>
		</span>

	</li>

	<li class="ji-info">

		<label class="ji-info__label">
			<?php _e( 'For:', 'jiwp' ); ?>
		</label>
		
		<span class="ji-info__value">
			<?php

				$marketingType = $realty->getMarketingType();

				if ( $marketingType['KAUF'] == true )
				{
					_e( 'Purchase', 'jiwp' );
				}
				else 
				{
					_e( 'Rent', 'jiwp' );
				}

			?>
		</span>

	</li>

	<li class="ji-info">

		<label class="ji-info__label">
			<?php _e( 'Price:', 'jiwp' ); ?>
		</label>
		
		<span class="ji-info__value">
			<?php

				$currency = $realty->getCurrency();

				if ( empty( $currency ) ) 
				{
					$currency = 'EUR';
				}

				if ( $marketingType['KAUF'] == true ) 
				{
					echo money_format( "%!i $currency", $realty->getPurchasePrice() );
				}
				else 
				{
					echo money_format( "%!i $currency", $realty->getTotalRent() );
				}

			?>
		</span>

	</li>

	<?php if ( $surface_area = $realty->getSurfaceArea() ): ?>

		<li class="ji-info">

			<label class="ji-info__label">
				<?php _e( 'Surface Area:', 'jiwp' ); ?>
			</label>
			
			<span class="ji-info__value">
				<?php echo $surface_area . ' m&sup2;'; ?>
			</span>

		</li>

	<?php endif; ?>

	<?php if ( $room_count = $realty->getRoomCount() ): ?>

		<li class="ji-info">

			<label class="ji-info__label">
				<?php _e( 'Rooms:', 'jiwp' ); ?>
			</label>
			
			<span class="ji-info__value">
				<?php echo $room_count; ?>
			</span>

		</li>

	<?php endif; ?>

</ul>
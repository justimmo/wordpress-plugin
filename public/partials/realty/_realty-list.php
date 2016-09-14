<section class="ji-realties-container">

	<?php if ( count($pager) ): ?>

		<ul class="ji-realty-list">

			<?php foreach ( $pager as $realty ): ?>

				<?php include( Jiwp_Public::get_template( 'realty/_realty-list__item.php' ) ); ?>

			<?php endforeach; ?>

		</ul>

		<?php include( Jiwp_Public::get_template( '_pagination.php' ) ); ?>

	<?php else: ?>

		<h3 class="ji-no-realties"><?php _e( 'No realties found', 'jiwp' ); ?></h3>

	<?php endif; ?>

</section>
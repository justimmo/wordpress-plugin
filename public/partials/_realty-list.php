<section class="ji-realties-container">

	<?php $pager_count = $pager->getNbResults(); ?>

	<?php if ( !empty( $pager ) && !empty( $pager_count ) ): ?>

	<ul class="ji-realty-list">

		<?php foreach ( $pager as $realty ): ?>

		<li class="ji-realty-list__item">

			<article class="ji-realty ji-realty--list-item">

				<header class="ji-realty__header">

					<?php $photos_array = $realty->getPictures(); ?>

					<img src="<?php echo $photos_array[0]->getUrl('medium'); ?>" class="ji-realty__featured-img" alt=''/>

					<h1 class="ji-realty__title">

						<a href="<?php echo get_bloginfo('url') . '/realties/' . $realty->getId() ?>">
							<?php echo $realty->getTitle(); ?>
						</a>

					</h1>

					<?php include( Jiwp_Public::get_template( '_realty-info.php' ) ); ?>

				</header>

			</article>

		</li>

		<?php endforeach; ?>

	</ul>

	<?php include( Jiwp_Public::get_template( '_pagination.php' ) ); ?>

	<?php else: ?>

	<h3 class="ji-no-realties"><?php _e( 'No realties found', 'jiwp' ); ?></h3>

	<?php endif; ?>

</section>
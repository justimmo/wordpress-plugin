<?php get_header(); ?>

<?php if ( !empty( $realty ) ): ?>

	<article class="ji-realty content-area">

		<header class="ji-realty__header">

			<h1 class="ji-realty__title"><?php echo $realty->getTitle(); ?></h1>

		</header>

		<?php include( Jiwp_Public::get_template( 'realty/_realty-extended-info.php' ) ); ?>

		<section class="ji-info-section ji-info-section--photos">

			<?php $photos_array = $realty->getPictures(); ?>

			<?php if ( !empty( $photos_array ) ): ?>
				
				<h3 class="ji-info-section__title"><?php _e( 'Photo Gallery', 'jiwp' ); ?></h3>

				<ul class="ji-photos-list">

					<?php foreach ( $photos_array as $photo ): ?>

						<li class="ji-photos-list__item">

							<a href="<?php echo $photo->getUrl('big2') ?>" class="featherlight-gallery">
								<img src="<?php echo $photo->getUrl('medium') ?>" class="ji-photo" alt=""/>
							</a>

						</li>

					<?php endforeach; ?>

				</ul>

			<?php endif; ?>

		</section>

	</article>

<?php else: ?>

	<p><?php _e( 'No realty found.', 'jiwp' ); ?></p>

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
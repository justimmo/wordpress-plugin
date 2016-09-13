<?php get_header(); ?>

<?php if ( !empty( $project ) ): ?>

    <article class="ji-project content-area">

        <header class="ji-project__header">

            <h1 class="ji-project__title"><?php echo $project->getTitle(); ?></h1>

        </header>

        <?php include( Jiwp_Public::get_template( '_project-extended-info.php' ) ); ?>

        <section class="ji-info-section ji-info-section--photos">

            <h3 class="ji-info-section__title"><?php _e( 'Photo Gallery', 'jiwp' ); ?></h3>

            <?php $photos_array = $project->getPictures(); ?>

            <?php if ( !empty( $photos_array ) ): ?>

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

    <p><?php _e( 'No project found.', 'jiwp' ); ?></p>

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
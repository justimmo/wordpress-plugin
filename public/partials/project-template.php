<?php get_header(); ?>

<?php if ( !empty( $project ) ): ?>

    <article class="ji-project content-area">

        <header class="ji-project__header">

            <h1 class="ji-project__title"><?php echo $project->getTitle(); ?></h1>

        </header>

        <?php include( Jiwp_Public::get_template( '_project-extended-info.php' ) ); ?>

        <?php $realties_array = $project->getRealties(); ?>

        <?php if ( count($realties_array) ): ?>
        
            <section class="ji-realty-list ji-realty-list--project">

                <h1 class="ji-realty-list__title"><?php echo _e( 'Project Realties:', 'jiwp' ); ?></h1>

                <ul class="ji-realty-list">

                    <?php foreach ( $realties_array as $realty ): ?>

                        <?php include( Jiwp_Public::get_template( '_realty-list__item.php' ) ); ?>

                    <?php endforeach; ?>

                </ul>

            </section>

        <?php endif; ?>

        <?php $photos_array = $project->getPictures(); ?>

        <?php if ( !empty( $photos_array ) ): ?>

            <section class="ji-info-section ji-info-section--photos">

                <h3 class="ji-info-section__title"><?php _e( 'Photo Gallery', 'jiwp' ); ?></h3>

                <ul class="ji-photos-list">

                    <?php foreach ( $photos_array as $photo ): ?>

                        <?php

                            try {
                                $img_src = $photos_array[0]->getUrl('medium');
                            } catch (Exception $e) {
                                $img_src = $photos_array[0]->getUrl();
                            }

                            try {
                                $img_href = $photos_array[0]->getUrl('big2');
                            } catch (Exception $e) {
                                $img_href = $photos_array[0]->getUrl();
                            }

                        ?>

                        <li class="ji-photos-list__item">

                            <a href="<?php echo $img_href; ?>" class="featherlight-gallery">
                                <img src="<?php echo $img_src; ?>" class="ji-photo" alt=""/>
                            </a>

                        </li>

                    <?php endforeach; ?>

                </ul>

            </section>

        <?php endif; ?>

    </article>

<?php else: ?>

    <p><?php _e( 'No project found.', 'jiwp' ); ?></p>

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
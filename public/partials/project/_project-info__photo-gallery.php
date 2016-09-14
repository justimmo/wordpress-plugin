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
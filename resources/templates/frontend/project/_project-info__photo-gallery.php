<?php $photos_array = $project->getPictures(); ?>
<?php if ( !empty( $photos_array ) ): ?>
    <section class="ji-info-section ji-info-section--photos">
        <h3 class="ji-info-section__title"><?php _e( 'Photo Gallery', 'jiwp' ); ?></h3>
        <ul class="ji-photos-list" id="lightSlider">
            <?php foreach ( $photos_array as $photo ): ?>

                <?php

                try {
                    $img_src = $photo->getUrl('medium');
                } catch (Exception $e) {
                    $img_src = $photo->getUrl();
                }

                try {
                    $img_href = $photo->getUrl('big2');
                } catch (Exception $e) {
                    $img_href = $photo->getUrl();
                }

                ?>

                <li class="ji-photos-list__item" data-thumb="<?php echo $img_src; ?>">

                    <a href="<?php echo $img_href; ?>" class="fancybox" rel="gallery">
                        <img src="<?php echo $img_src; ?>" class="ji-photo" alt=""/>
                    </a>

                </li>

            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>

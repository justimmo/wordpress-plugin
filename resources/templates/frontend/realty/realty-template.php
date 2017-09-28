<?php get_header(); ?>

<?php if (!empty($realty)) : ?>
    <article class="ji-realty">
        <header class="ji-realty__header">
            <h1 class="ji-realty__title">
                <?php $realty_title = $realty->getTitle(); ?>
                <?php if (!empty($realty_title)) : ?>
                    <?php echo $realty->getTitle(); ?>
                <?php else : ?>
                    <?php

                    echo $realty->getRealtyTypeName()
                        . ' '
                        . __('in', 'jiwp')
                        . ' '
                        . $realty->getCountry()
                        . ' / '
                        . $realty->getFederalState();

                    ?>
                <?php endif; ?>
            </h1>

            <a href="<?php echo Justimmo\Wordpress\Routing::getRealtyExposeUrl($realty); ?>"
               class="ji-realty__expose-link"><?php _e('Expose', 'jiwp'); ?></a>
        </header>

        <section class="ji-info-section ji-info-section--photos">
            <?php $photos_array = $realty->getPictures(); ?>
            <?php if (!empty($photos_array)) : ?>
                <ul class="ji-photos-list" id="lightSlider">
                    <?php /** @var \Justimmo\Model\Attachment $photo */ ?>
                    <?php foreach ($photos_array as $photo) : ?>

                        <?php
                        try {
                            $imageBigUrl = $photo->getUrl('big2');
                            $imageMediumUrl = $photo->getUrl('medium');
                        } catch (\Exception $e) {
                            $imageBigUrl = null;
                            $imageMediumUrl = null;
                        }
                        ?>

                        <?php if ($imageBigUrl && $imageMediumUrl) : ?>

                            <li class="ji-photos-list__item" data-thumb="<?php echo $imageBigUrl ?>">
                                <a href="<?php echo $imageBigUrl ?>" class="fancybox" rel="gallery">
                                    <img src="<?php echo $imageMediumUrl ?>" class="ji-photo" alt=""/>
                                </a>

                            </li>

                        <?php endif; ?>

                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <!-- Description Text -->
        <?php $description = $realty->getDescription(); ?>
        <?php if (!empty($description)) : ?>
            <section class="ji-info-section">
                <h3 class="ji-info-section__title"><?php _e('Description', 'jiwp'); ?></h3>
                <?php echo $description; ?>
            </section>
        <?php endif; ?>

        <!-- Other Information Text -->
        <?php $other_information = $realty->getOtherInformation(); ?>
        <?php if (!empty($other_information)) : ?>
            <section class="ji-info-section">
                <h3 class="ji-info-section__title"><?php _e('Other Information', 'jiwp'); ?></h3>
                <?php echo $other_information; ?>
            </section>
        <?php endif; ?>

        <!-- Documents -->
        <?php $attachments = $realty->getDocuments(); ?>
        <?php if (!empty($attachments)) : ?>
            <section class="ji-info-section">
                <ul class="ji-info-list ji-info-list--extended">
                    <?php /** @var \Justimmo\Model\Attachment $attachment */ ?>
                    <?php foreach ($attachments as $attachment) : ?>
                        <li class="ji-info-list__item">
                            <a href="<?php echo $attachment->getUrl(); ?>">
                                <?php echo $attachment->getTitle(); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <!-- Map -->
        <?php $lat = $realty->getLatitudePrecise(); ?>
        <?php $lng = $realty->getLongitudePrecise(); ?>
        <?php if ($lat && $lng && get_option(JIWP_GOOGLE_API_KEY_OPTION, '')) : ?>
            <section class="ji-info-section">
                <h3 class="ji-info-section__title"><?php _e('Location', 'jiwp'); ?></h3>

                <div class="jiwp-map"></div>
                <script>
                    var RealtyData = {
                        position: {
                            lat: <?php echo $lat; ?>,
                            lng: <?php echo $lng; ?>
                        },
                        title: <?php echo wp_json_encode($realty->getTitle()); ?>
                    };
                </script>
            </section>
        <?php endif; ?>
    </article>

    <?php echo do_shortcode('[ji_similar_realties realty_id="' . $realty->getId() . '" max_nb="1" format="grid"]'); ?>
<?php else : ?>
    <p><?php _e('No realty found.', 'jiwp'); ?></p>
<?php endif; ?>

<?php include(Justimmo\Wordpress\Templating::getPath('realty/realty-template__sidebar.php')); ?>

<?php get_footer(); ?>
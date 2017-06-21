<?php get_header(); ?>

<?php if (!empty($realty)) : ?>

    <article class="ji-realty">

        <header class="ji-realty__header">

            <h1 class="ji-realty__title">
                <?php $realty_title = $realty->getTitle(); ?>
                <?php if (!empty($realty_title)) : ?>
                    <?php echo $realty->getTitle(); ?>
                <?php else : ?>
                    <?php echo $realty->getRealtyTypeName() . ' ' . __('in', 'jiwp') . ' ' . $realty->getCountry() . ' / ' . $realty->getFederalState(); ?>
                <?php endif; ?>
            </h1>

            <a href="<?php echo Justimmo\Wordpress\Routing::getRealtyExposeUrl($realty); ?>" class="ji-realty__expose-link"><?php _e('Expose', 'jiwp'); ?></a>

        </header>

        <section class="ji-info-section ji-info-section--photos">

            <?php $photos_array = $realty->getPictures(); ?>

            <?php if (!empty($photos_array)) : ?>

                <ul class="ji-photos-list" id="lightSlider">

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

        <?php include(Justimmo\Wordpress\Templating::getPath('realty/_realty-extended-info.php')); ?>

        <?php include(Justimmo\Wordpress\Templating::getPath('inquiry-form/_inquiry-form.php')); ?>
    </article>

<?php else : ?>

    <p><?php _e('No realty found.', 'jiwp'); ?></p>

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
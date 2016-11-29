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

            <a href="<?php echo Jiwp_Public::get_realty_expose_url($realty); ?>" class="ji-realty__expose-link"><?php _e('Expose', 'jiwp'); ?></a>

        </header>

        <section class="ji-info-section ji-info-section--photos">

            <?php $photos_array = $realty->getPictures(); ?>

            <?php if (!empty($photos_array)) : ?>

                <ul class="ji-photos-list" id="lightSlider">

                    <?php foreach ($photos_array as $photo) : ?>

                        <li class="ji-photos-list__item" data-thumb="<?php echo $photo->getUrl('big2') ?>">

                            <a href="<?php echo $photo->getUrl('big2') ?>" class="fancybox" rel="gallery">
                                <img src="<?php echo $photo->getUrl('medium') ?>" class="ji-photo" alt=""/>
                            </a>

                        </li>

                    <?php endforeach; ?>

                </ul>

            <?php endif; ?>

        </section>

        <?php include(Jiwp_Public::get_template('realty/_realty-extended-info.php')); ?>

        <?php include(Jiwp_Public::get_template('inquiry-form/_inquiry-form.php')); ?>
    </article>

<?php else : ?>

    <p><?php _e('No realty found.', 'jiwp'); ?></p>

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
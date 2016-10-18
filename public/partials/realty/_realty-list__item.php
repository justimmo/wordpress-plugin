<li class="ji-realty-list__item">

    <article class="ji-realty ji-realty--list-item">

        <header class="ji-realty__header">

            <?php $photos_array = $realty->getPictures(); ?>

            <?php if (count($photos_array)) : ?>

                <?php

                try {
                    $img_src = $photos_array[0]->getUrl('medium');
                } catch (Exception $e) {
                    $img_src = $photos_array[0]->getUrl();
                }

                ?>

                <a href="<?php echo Jiwp_Public::get_realty_url($realty); ?>">
                    <img src="<?php echo $img_src; ?>" class="ji-realty__featured-img" alt=''/>
                </a>

            <?php endif; ?>

            <h1 class="ji-realty__title">

                <a href="<?php echo Jiwp_Public::get_realty_url($realty); ?>">
                    <?php echo $realty->getTitle(); ?>
                </a>

            </h1>

            <?php include(Jiwp_Public::get_template('realty/_realty-info.php')); ?>

        </header>

    </article>

</li>
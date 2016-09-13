<li class="ji-realty-list__item">

    <article class="ji-realty ji-realty--list-item">

        <header class="ji-realty__header">

            <?php $photos_array = $realty->getPictures(); ?>

            <?php if ( count($photos_array) ): ?>

                <?php

                    try {
                        $img_src = $photos_array[0]->getUrl('medium');
                    } catch (Exception $e) {
                        $img_src = $photos_array[0]->getUrl();
                    }

                ?>

                <img src="<?php echo $img_src; ?>" class="ji-realty__featured-img" alt=''/>

            <?php endif; ?>

            <h1 class="ji-realty__title">

                <a href="<?php echo get_bloginfo('url') . '/realties/' . $realty->getId() ?>">
                    <?php echo $realty->getTitle(); ?>
                </a>

            </h1>

            <?php include( Jiwp_Public::get_template( '_realty-info.php' ) ); ?>

        </header>

    </article>

</li>
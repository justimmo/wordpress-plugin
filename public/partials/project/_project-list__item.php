<li class="ji-project-list__item">

    <article class="ji-project ji-project--list-item">

        <header class="ji-project__header">

            <h1 class="ji-project__title">

                <a href="<?php echo Jiwp_Public::get_project_url($project); ?>">
                    <?php echo $project->getTitle(); ?>
                </a>

            </h1>

            <?php $photos_array = $project->getPictures(); ?>

            <?php if ( count($photos_array) ): ?>

                <?php

                    try {
                        $img_src = $photos_array[0]->getUrl('medium');
                    } catch (Exception $e) {
                        $img_src = $photos_array[0]->getUrl();
                    }

                ?>
                
                <a href="<?php echo Jiwp_Public::get_project_url($project); ?>">
                    <img src="<?php echo $img_src; ?>" class="ji-project__featured-img" alt=''/>
                </a>

            <?php endif; ?>

            <?php include( Jiwp_Public::get_template( 'project/_project-info.php' ) ); ?>

        </header>

    </article>

</li>
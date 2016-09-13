<section class="ji-projects-container">

    <?php if ( count( $pager ) ): ?>

        <ul class="ji-project-list">

            <?php foreach ( $pager as $project ): ?>

                <li class="ji-project-list__item">

                    <article class="ji-project ji-project--list-item">

                        <header class="ji-project__header">

                            <h1 class="ji-project__title">

                                <a href="<?php echo get_bloginfo('url') . '/projects/' . $project->getId() ?>">
                                    <?php echo $project->getTitle(); ?>
                                </a>

                            </h1>

                            <?php include( Jiwp_Public::get_template( '_project-info.php' ) ); ?>

                        </header>

                    </article>

                </li>

            <?php endforeach; ?>

        </ul>

        <?php include( Jiwp_Public::get_template( '_pagination.php' ) ); ?>

    <?php else: ?>

        <h3 class="ji-no-projects"><?php _e( 'No projects found', 'jiwp' ); ?></h3>

    <?php endif; ?>

</section>
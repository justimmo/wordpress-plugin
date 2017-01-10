<section class="ji-projects-container">

    <?php if ( count( $pager ) ): ?>

        <ul class="ji-project-list">

            <?php foreach ( $pager as $project ): ?>

                <?php include( Justimmo\Wordpress\Templating::getPath( 'project/_project-list__item.php' ) ); ?>

            <?php endforeach; ?>

        </ul>

        <?php include( Justimmo\Wordpress\Templating::getPath( '_pagination.php' ) ); ?>

    <?php else: ?>

        <h3 class="ji-no-projects"><?php _e( 'No projects found', 'jiwp' ); ?></h3>

    <?php endif; ?>

</section>
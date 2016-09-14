<section class="ji-projects-container">

    <?php if ( count( $pager ) ): ?>

        <ul class="ji-project-list">

            <?php foreach ( $pager as $project ): ?>

                <?php include( Jiwp_Public::get_template( 'project/_project-list__item.php' ) ); ?>

            <?php endforeach; ?>

        </ul>

        <?php include( Jiwp_Public::get_template( '_pagination.php' ) ); ?>

    <?php else: ?>

        <h3 class="ji-no-projects"><?php _e( 'No projects found', 'jiwp' ); ?></h3>

    <?php endif; ?>

</section>
<?php get_header(); ?>

<?php if ( !empty( $project ) ): ?>

    <article class="ji-project">
        <header class="ji-project__header">
            <h1 class="ji-project__title"><?php echo $project->getTitle(); ?></h1>
        </header>

        <?php include( Jiwp_Public::get_template( 'project/_project-info__address.php' ) ); ?>

        <?php include( Jiwp_Public::get_template( 'project/_project-info__contact.php' ) ); ?>

        <?php include( Jiwp_Public::get_template( 'project/_project-info__description.php' ) ); ?>

        <?php include( Jiwp_Public::get_template( 'project/_project-info__other-info.php' ) ); ?>

        <?php include( Jiwp_Public::get_template( 'project/_project-info__realties.php' ) ); ?>

        <?php include( Jiwp_Public::get_template( 'project/_project-info__photo-gallery.php' ) ); ?>
    </article>

<?php else: ?>

    <p><?php _e( 'No project found.', 'jiwp' ); ?></p>

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
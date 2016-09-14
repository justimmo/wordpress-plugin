<?php $realties_array = $project->getRealties(); ?>

<?php if ( count($realties_array) ): ?>

    <section class="ji-realty-list ji-realty-list--project">

        <h1 class="ji-realty-list__title"><?php echo _e( 'Project Realties:', 'jiwp' ); ?></h1>

        <ul class="ji-realty-list">

            <?php foreach ( $realties_array as $realty ): ?>

                <?php include( Jiwp_Public::get_template( 'realty/_realty-list__item.php' ) ); ?>

            <?php endforeach; ?>

        </ul>

    </section>

<?php endif; ?>
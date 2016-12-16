<section class="ji-realties-container">

    <?php if (count($pager)) : ?>

        <ul class="ji-realty-list <?php echo $realty_list_class ?>">

            <?php foreach ($pager as $realty) : ?>

                <?php include(Justimmo\Wordpress\Frontend::getTemplate('realty/_realty-list__item.php')); ?>

            <?php endforeach; ?>

        </ul>

        <?php include(Justimmo\Wordpress\Frontend::getTemplate('_pagination.php')); ?>

    <?php else : ?>

        <h3 class="ji-no-realties"><?php _e('No realties found', 'jiwp'); ?></h3>

    <?php endif; ?>

</section>
<?php if (!empty($pager) && count($pager)) : ?>
    <h4><?php _e('Similar Realties', 'jiwp'); ?></h4>
    <?php include(Justimmo\Wordpress\Templating::getPath('realty/realty-list.php')); ?>
<?php endif;

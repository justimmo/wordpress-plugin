<?php
use Justimmo\Wordpress\Controller\BaseController;
?>

<?php get_header(); ?>

<section class="search-results content-area">

    <ul class="search-results__ordering-options">
        <li class="search-results__ordering-option">
            <?php _e('Price Order', 'jiwp'); ?>
            <a
                class="<?php echo ($_GET['filter']['price_order'] == 'asc') ? 'active' : ''; ?>"
                href="<?php echo BaseController::getAscendingPriceOrderQueryString(); ?>"
                title="<?php _e('low to high', 'jiwp'); ?>">&#9650;</a>
            <a
                class="<?php echo ($_GET['filter']['price_order'] == 'desc') ? 'active' : ''; ?>"
                href="<?php echo BaseController::getDescendingPriceOrderQueryString(); ?>"
                title="<?php _e('high to low', 'jiwp'); ?>">&#9660;</a>
        </li>
        <li class="search-results__ordering-option">
            <?php _e('Date Order', 'jiwp'); ?>
            <a
                class="<?php echo ($_GET['filter']['created_at_order'] == 'asc') ? 'active' : ''; ?>"
                href="<?php echo BaseController::getAscendingDateOrderQueryString(); ?>"
                title="<?php _e('oldest first', 'jiwp'); ?>">&#9650;</a>
            <a
                class="<?php echo ($_GET['filter']['created_at_order'] == 'desc') ? 'active' : ''; ?>"
                href="<?php echo BaseController::getDescendingDateOrderQueryString(); ?>"
                title="<?php _e('newest first', 'jiwp'); ?>">&#9660;</a>
        </li>
    </ul>

    <?php include(Justimmo\Wordpress\Templating::getPath('realty/realty-list.php')); ?>

</section>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
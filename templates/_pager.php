<?php if (ceil($ji_obj_list->getTotalCount() / $ji_obj_list->getMaxPerPage()) > 1): ?>
    <div class="bg_pager01">
        <?php if($ji_obj_list->getPage() > 1): ?>
        <a href="<?php echo $ji_api_wp_plugin->getIndexUrl(); ?>&ji_page=1">&laquo;</a>
        <a href="<?php echo $ji_api_wp_plugin->getIndexUrl(); ?>&ji_page=<?php echo $ji_obj_list->getPage() - 1; ?>">&lsaquo;</a>
        <?php endif; ?>
        <!-- --> &nbsp;
    </div>
    <div class="bg_pager02">
        <span><?php echo $ji_obj_list->getPage(); ?></span><!-- --> &nbsp;
    </div>
    <div class="bg_pager03">
        <?php if(ceil($ji_obj_list->getTotalCount() / $ji_obj_list->getMaxPerPage()) > $ji_obj_list->getPage()): ?>
        <a href="<?php echo $ji_api_wp_plugin->getIndexUrl(); ?>&ji_page=<?php echo $ji_obj_list->getPage() + 1; ?>">&rsaquo;</a>
        <a href="<?php echo $ji_api_wp_plugin->getIndexUrl(); ?>&ji_page=<?php echo ceil($ji_obj_list->getTotalCount() / $ji_obj_list->getMaxPerPage()); ?>">&raquo;</a>
        <?php endif; ?>
        <!-- --> &nbsp;
    </div>
    <div class="bg_clear"></div>
<?php endif; ?>


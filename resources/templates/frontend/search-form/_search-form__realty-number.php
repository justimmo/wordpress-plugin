<form
    action="<?php bloginfo('url'); ?>/<?php _e('properties', 'jiwp'); ?>/<?php _e('search', 'jiwp'); ?>"
    class="ji-search-form">

    <h3><?php _e('Realty Number:', 'jiwp'); ?></h3>

    <input
        type    = "number" 
        id      = "" 
        class   = "ji-input ji-input--number" 
        size    = "10" 
        value   = "<?php echo isset($filter[ 'objektnummer' ]) ? $filter[ 'objektnummer' ] : '' ?>" 
        name    = "filter[objektnummer]" />

    <input type="submit" class="ji-input ji-input--submit" value="<?php _e('Search', 'jiwp'); ?>" />

</form>
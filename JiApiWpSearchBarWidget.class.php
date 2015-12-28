<?php
/**
 * Created by JetBrains PhpStorm.
 * User: harry
 * Date: 20.12.12
 * Time: 20:18
 * To change this template use File | Settings | File Templates.
 */
class JiApiWpSearchBarWidget extends WP_Widget
{
    public function __construct()
    {
        $widget_ops = array('classname'   => 'JiApiWpSearchBarWidget',
                            'description' => 'Widget für die JUSTIMMO Suchbox'
        );
        $this->WP_Widget('JiApiWpSearchBarWidget', 'JUSTIMMO Suchbox', $widget_ops);
    }

    function form($instance)
    {
        $instance = wp_parse_args((array)$instance, array('title' => ''));
        $title = $instance['title'];
        global $ji_api_wp_plugin;
        include(JI_API_WP_PLUGIN_DIR . '/admin/widget_options.php');
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        return $instance;
    }

    function widget($args, $instance)
    {
        extract($args, EXTR_SKIP);

        echo $before_widget;
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        global $ji_api_wp_plugin;
        $ji_obj_list = $ji_api_wp_plugin->getObjektList();

        $objektarten = $ji_api_wp_plugin->getObjektarten();
        $regions = $ji_api_wp_plugin->getFilteredRegions(isset($ji_obj_list->filter['bundesland_id']) ? $ji_obj_list->filter['bundesland_id'] : null);

        include JI_API_WP_PLUGIN_DIR . '/widget/ji_searchbox_widget.php';

        echo $after_widget;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("JiApiWpSearchBarWidget");'));

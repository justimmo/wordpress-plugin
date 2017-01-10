<?php

namespace Justimmo\Wordpress\Translation;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 */
class I18N
{
    /**
     * Load the plugin text domain for translation.
     */
    public function loadPluginTextdomain()
    {
        load_plugin_textdomain(
            'jiwp',
            false,
            dirname(dirname(dirname(plugin_basename(__FILE__)))) . '/languages/'
        );
    }
}

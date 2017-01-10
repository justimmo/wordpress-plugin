<?php

namespace Justimmo\Wordpress;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 */
class Installer
{
    /**
     * Set transient value to be checked when the plugin is activated.
     * Used for adding rewrite rules and flushing permalinks only once.
     */
    public static function activate()
    {
        set_transient('rewrite_rules_check', true, 60);
    }

    public static function deactivate()
    {

    }
}

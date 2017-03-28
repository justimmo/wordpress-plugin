# JUSTIMMO Wordpress plugin

[![Latest Stable Version](https://poser.pugx.org/justimmo/justimmo-wordpress-plugin/version.png)](https://packagist.org/packages/justimmo/justimmo-wordpress-plugin)

The JUSTIMMO Wordpress plugin allows brokers to list their properties stored in the JUSTIMMO software on their own Wordpress website.

## Installation

#### Composer (recommended for advanced users)
Most flexible. Lets you update PHP-SDK and Wordpress plugin independently
```bash
composer require justimmo/justimmo-wordpress-plugin "^1.0"
```

#### Standalone zipfile
You can download the current version of the Wordpress plugin with a packaged SDK from https://github.com/justimmo/wordpress-plugin/releases.

Please use the link **"justimmo-wordpress-plugin-x.x.x.zip"** and not the "Source code" links.

The SDK version is the newest version at the time the Wordpress plugin version was released. You won't be able to update the SDK independently from the Wordpress plugin.
Upload the plugin via the plugin installation feature in the Wordpress admin panel or extract it manually into your wp-content/plugins folder.

## Configuration

* Activate the plugin through the 'Plugins' menu in Wordpress
* Search through the plugin's settings menus for more information on the various shortcodes and widgets and how to use them

## Upgrading

#### Composer
If you've chosen composer as your installation method you can upload the plugin and SDK independently.
This means, even if there is no new plugin version you can update the SDK independently to get the newest features and bugfixes you may use in your own templates.
```bash
composer update --with-dependencies justimmo/justimmo-wordpress-plugin
```

#### Standalone zipfile
Download the newest version from https://github.com/justimmo/wordpress-plugin/releases and extract it to your wp-content/plugins folder. Overwrite old files.
An easy independent upgrade of the SDK is not possible with this method, but you can check out our code changes and apply them manually (advanced users): https://github.com/justimmo/php-sdk  
Please note, that we can not give any support for the manual update of the SDK.

<?php

/**
 * Plugin name: Thamm IT WordPress Shortcodes
 * Plugin URI: https://github.com/thammit/ti-wp-shortcodes
 * Author: Peter Pfeufer (Thamm IT)
 * Author URI: https://www.thamm-it.de
 * Version: 1.0.0
 * Description: A collection of assorted shortcodes for WordPress
 */

/*
 * Copyright (C) 2019 p.pfeufer
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace WordPress\ThammIT\Plugins\TiWpShortcodes;

/**
 * Are we in WordPress?
 */
if(!\class_exists('\WP')) {
    \header('Status: 403 Forbidden');
    \header('HTTP/1.1 403 Forbidden');
    exit();
}

// Include the autoloader so we can dynamically include the rest of the classes.
require_once(\trailingslashit(\dirname(__FILE__)) . 'inc/autoloader.php');

class TiWpShortcodes {
    /**
     * Let's do some setup here ...
     */
    public function init() {
        new Libs\Shortcodes(true);

        $this->initShortcodes();

        if(!\is_admin()) {
            /**
             * Adding some CSS
             */
            \add_action('wp_enqueue_scripts', [$this, 'enqueueCss']);
        }
    }

    private function initShortcodes() {
        $shortcodeLibs = new \FilesystemIterator(\PLUGINDIR . '/' . \dirname(\plugin_basename(__FILE__)) . '/Libs/Shortcodes');

        foreach($shortcodeLibs as $shortcodeLib) {
            if($shortcodeLib->getExtension() === 'php') {
                $shortcodeClass = 'WordPress\\ThammIT\\Plugins\\TiWpShortcodes\\Libs\\Shortcodes\\' . str_replace('.php', '', $shortcodeLib->getFilename());

                new $shortcodeClass;
            }
        }
    }

    /**
     * Enqueue the needed CSS
     */
    public function enqueueCss() {
        $pluginStyle = (\WP_DEBUG === true) ? '/' . \PLUGINDIR . '/' . \dirname(\plugin_basename(__FILE__)) . '/Assets/Css/ti-wp-shortcodes.css' : '/' . \PLUGINDIR . '/' . \dirname(\plugin_basename(__FILE__)) . '/css/ti-wp-shortcodes.min.css';
        \wp_enqueue_style('font-awesome', '/' . \PLUGINDIR . '/' . \dirname(\plugin_basename(__FILE__)) . '/Assets/Libraries/font-awesome/4.6.3/css/font-awesome.min.css');
        \wp_enqueue_style('ti-button-shortcode', $pluginStyle, false);
    }
}

/**
 * Start the show ....
 */
function initializePlugin() {
    $plugin = new \WordPress\ThammIT\Plugins\TiWpShortcodes\TiWpShortcodes;

    /**
     * Initialize the plugin
     */
    $plugin->init();
}

// Start the show
initializePlugin();

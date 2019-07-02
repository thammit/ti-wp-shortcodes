<?php

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

namespace WordPress\ThammIT\Plugins\TiWpShortcodes\Libs\Shortcodes;

class Button extends \WordPress\ThammIT\Plugins\TiWpShortcodes\Libs\Shortcodes implements \WordPress\ThammIT\Plugins\TiWpShortcodes\Libs\Interfaces\ShortcodeInterface {
    /**
     * Constructor
     */
    public function __construct($addFilter = false) {
        parent::__construct($addFilter);

        $this->registerShortcodes($this->getShortcodeArray());
    }

    public function getShortcodeArray() {
        $shortcodes = [
            'ti_button'
        ];

        return $shortcodes;
    }

    /**
     * Rendering the [ti_button] shortcode
     * [ti_button align="" type=""]Link/Text here[/ti_button]
     *  Options:
     *      align   => left/center/right (default: center)
     *      type    => Buttontype (readmore for a Read More Button for example)
     *
     * This is basically just a designed text box.
     *
     * @param array $atts
     * @param string $content
     */
    public function shortcodeTiButton(array $atts, string $content = null) {
        $args = \shortcode_atts(
            [
                'align' => '',
                'type' => '',
                'link' => '',
                'target' => ''
            ],
            $atts,
            'button'
        );

        $type = (empty($args['type'])) ? 'primary' : (string) $args['type'];
        $link = (string) $args['link'];
        $target = (empty($args['target'])) ? 'target="_self"' : 'target="_' . \str_replace('_', '', (string) $args['target']) . '"';
        $align = (empty($args['align'])) ? 'center' : (string) $args['align'];

        /**
         * If there is no content, stop right here
         */
        if(empty($content)) {
            return false;
        }

        $classes = 'ti-button';
        $classes .= ' ti-button-' . $type;
        $classes .= ' ti-button-align-' . $align;


        $html = '';
        $html .= '<button class="' . $classes . '">';

        if(!empty($link)) {
            /**
             * Linktarget
             */
            if(!empty($target)) {
                $target = 'target="_' . \str_replace('_', '', $target) . '"';
            }

            $html .= '<a href="' . $link . '" ' . $target . '>';
        }

        $html .= '<span class="ti-button-content">' . $content . '</span>';

        if(!empty($link)) {
            $html .= '</a>';
        }

        $html .= '</button>';

        return $html;
    }
}

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
                'type' => ''
            ],
            $atts,
            'button'
        );

        $align = (string) $args['align'];
        $type = (string) $args['type'];

        /**
         * If there is no content, stop right here
         */
        if(empty($content)) {
            return false;
        }

        $classes = 'ti-button';

        /**
         * If no align, simply center the button.
         */
        if(empty($align)) {
            $align = 'center';
        }

        $classes .= ' ti-button-align-' . $align;

        if(!empty($type)) {
            $classes .= ' ' . $type;
        }

        $var_sHTML = '';
        $var_sHTML .= '<span class="' . $classes . '">';
        $var_sHTML .= $content;
        $var_sHTML .= '</span>';

        return $var_sHTML;
    }
}

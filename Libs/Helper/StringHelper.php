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

namespace WordPress\ThammIT\Plugins\TiWpShortcodes\Libs\Helper;

/**
 * Helper Class for manipulating and/or checking strings
 */
class StringHelper extends \WordPress\ThammIT\Plugins\TiWpShortcodes\Libs\Singletons\AbstractSingleton {
    /**
     * Make a string camelCase
     *
     * @param string $string
     * @param bool $ucFirst
     * @param array $noStrip
     * @return string
     */
    public function camelCase(string $string, bool $ucFirst = false, array $noStrip = array()) {
        // First we make sure all is lower case
        $string = \strtolower($string);

        // non-alpha and non-numeric characters become spaces
        $string = \preg_replace('/[^a-z0-9' . \implode('', $noStrip) . ']+/i', ' ', $string);
        $string = \trim($string);

        // uppercase the first character of each word
        $string = \ucwords($string);
        $string = \str_replace(' ', '', $string);

        if($ucFirst === false) {
            $string = \lcfirst($string);
        }

        return $string;
    }
}

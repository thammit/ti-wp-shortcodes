<?php

/*
 * Copyright (C) 2017 ppfeufer
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

\spl_autoload_register('\WordPress\ThammIT\Plugins\TiWpShortcodes\autoload');

function autoload($className) {
    // If the specified $className does not include our namespace, duck out.
    if(\strpos($className, 'WordPress\ThammIT\Plugins\TiWpShortcodes') === false) {
        return;
    }

    // Split the class name into an array to read the namespace and class.
    $fileParts = \explode('\\', $className);

    // Do a reverse loop through $fileParts to build the path to the file.
    $namespace = '';
    for($i = \count($fileParts) - 1; $i > 0; $i--) {
        // Read the current component of the file part.
        $current = \str_ireplace('_', '-', $fileParts[$i]);

        $namespace = '/' . $current . $namespace;

        // If we're at the first entry, then we're at the filename.
        if(\count($fileParts) - 1 === $i) {
            $namespace = '';
            $fileName = $current . '.php';

            /* If 'interface' is contained in the parts of the file name, then
             * define the $file_name differently so that it's properly loaded.
             * Otherwise, just set the $file_name equal to that of the class
             * filename structure.
             */
            if(\strpos(\strtolower($fileParts[\count($fileParts) - 1]), 'interface')) {
                // Grab the name of the interface from its qualified name.
                $interfaceNameParts = \explode('_', $fileParts[\count($fileParts) - 1]);
                $interfaceName = $interfaceNameParts[0];

                $fileName = $interfaceName . '.php';
            }
        }

        // Now build a path to the file using mapping to the file location.
        $filepath = \trailingslashit(\dirname(\dirname(__FILE__)) . $namespace);
        $filepath .= $fileName;

        // If the file exists in the specified path, then include it.
        if(\file_exists($filepath)) {
            include_once($filepath);
        }
    }
}

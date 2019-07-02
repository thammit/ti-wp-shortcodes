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

class Download extends \WordPress\ThammIT\Plugins\TiWpShortcodes\Libs\Shortcodes implements \WordPress\ThammIT\Plugins\TiWpShortcodes\Libs\Interfaces\ShortcodeInterface {

    /**
     * Constructor
     */
    public function __construct($addFilter = false) {
        parent::__construct($addFilter);

        $this->registerShortcodes($this->getShortcodeArray());
    }

    public function getShortcodeArray() {
        $shortcodes = [
            'ti_download'
        ];

        return $shortcodes;
    }

    /**
     * Rendering the [download] shortcode
     * [ti_download url="" type="" title="" target="" align=""]
     *  Options:
     *      type    => The button type (primary, secondary, link | Default: primary)
     *      link    => The download link
     *      title   => The link description (Optional. Default: Download)
     *      target  => The link target (similar to <a> attribute target / default: _self)
     *      align   => left/center/right (default: center)
     *
     * Without giving a link and only a title, this is nothing more than just a text box.
     *
     * @param array $atts
     * @param string $content
     */
    public function shortcodeTiDownload(array $atts, string $content = null) {
        $args = \shortcode_atts(
            [
                'type' => 'primary',
                'link' => '',
                'title' => 'Download',
                'target' => '_self',
                'align' => 'center',
            ],
            $atts,
            'download'
        );

        $type = (empty($args['type'])) ? 'primary' : (string) $args['type'];
        $link = (string) $args['link'];
        $title = (empty($args['title'])) ? 'Download' : (string) $args['title'];
        $target = (empty($args['target'])) ? 'target="_self"' : 'target="_' . \str_replace('_', '', (string) $args['target']) . '"';
        $align = (empty($args['align'])) ? 'center' : (string) $args['align'];

        $downloadTypes = [
            'pdf',
            'archive',
            'doc',
            'image',
            'audio',
            'video',
            'link'
        ];

        /**
         * Autodetecting filetype of the given download.
         * Only runs if no type is given in shortcode.
         *
         * @since 1.0
         */
        $fileType = \strrchr($link, ".");
        $mimeType = null;
        $iconClass = null;

        switch($fileType) {
            case '.ez':
                $mimeType = 'andrew-inset';
                break;

            case '.hqx':
                $mimeType = 'mac-binhex40';
                break;

            case '.cpt':
                $mimeType = 'mac-compactpro';
                break;

            case '.doc':
                $mimeType = 'ms-word document';
                $iconClass = 'fa fa-file-text-o';
                break;

            case '.bin':
            case '.dms':
            case '.lha':
            case '.lzh':
            case '.exe':
            case '.class':
            case '.so':
            case '.dll':
                $mimeType = 'octet-stream';
                break;

            case '.oda':
                $mimeType = 'oda';
                break;

            case '.pdf':
                $mimeType = 'pdf';
                $iconClass = 'fa fa-file-pdf-o';
                break;

            case '.ai':
            case '.eps':
            case '.ps':
                $mimeType = 'postscript';
                break;

            case '.smi':
            case '.smil':
                $mimeType = 'smil';
                break;

            case '.xls':
                $mimeType = 'ms-excel';
                break;

            case '.ppt':
                $mimeType = 'ms-powerpoint';
                break;

            case '.wbxml':
                $mimeType = 'wap-wbxml';
                break;

            case '.wmlc':
                $mimeType = 'wap-wmlc';
                break;

            case '.wmlsc':
                $mimeType = 'wap-wmlscriptc';
                break;

            case '.bcpio':
                $mimeType = 'bcpio';
                break;

            case '.vcd':
                $mimeType = 'cdlink';
                break;

            case '.pgn':
                $mimeType = 'chess-pgn';
                break;

            case '.cpio':
                $mimeType = 'cpio';
                break;

            case '.csh':
                $mimeType = 'csh';
                break;

            case '.dcr':
            case '.dir':
            case '.dxr':
                $mimeType = 'director';
                break;

            case '.dvi':
                $mimeType = 'dvi';
                break;

            case '.spl':
                $mimeType = 'futuresplash';
                break;

            case '.hdf':
                $mimeType = 'hdf';
                break;

            case '.js':
                $mimeType = 'text javascript';
                break;

            case '.skp':
            case '.skd':
            case '.skt':
            case '.skm':
                $mimeType = 'koan';
                break;

            case '.latex':
                $mimeType = 'latex';
                break;

            case '.nc':
            case '.cdf':
                $mimeType = 'application x-netcdf';
                break;

            case '.sh':
                $mimeType = 'sh';
                break;

            case '.shar':
                $mimeType = 'shar';
                break;

            case '.swf':
                $mimeType = 'shockwave-flash';
                break;

            case '.sit':
                $mimeType = 'stuffit';
                break;

            case '.sv4cpio':
                $mimeType = 'sv4cpio';
                break;

            case '.sv4crc':
                $mimeType = 'sv4crc';
                break;

            case '.tcl':
                $mimeType = 'tcl';
                break;

            case '.tex':
                $mimeType = 'tex';
                break;

            case '.texinfo':
            case '.texi':
                $mimeType = 'texinfo';
                break;

            case '.t':
            case '.tr':
            case '.roff':
                $mimeType = 'troff';
                break;

            case '.man':
                $mimeType = 'troff-man';
                break;
            case '.me':
                $mimeType = 'troff-me';
                break;

            case '.ms':
                $mimeType = 'troff-ms';
                break;

            case '.ustar':
                $mimeType = 'ustar';
                break;

            case '.src':
                $mimeType = 'wais-source';
                break;

            case '.xhtml':
            case '.xht':
                $mimeType = 'xhtml-xml';
                break;

            case '.7z':
                $mimeType = 'archive sevenzip';
                $iconClass = 'fa-file-archive-o';
                break;

            case '.zip':
                $mimeType = 'archive zip';
                $iconClass = 'fa-file-archive-o';
                break;

            case '.arj':
                $mimeType = 'archive arj';
                $iconClass = 'fa-file-archive-o';
                break;

            case '.rar':
                $mimeType = 'archive rar';
                $iconClass = 'fa-file-archive-o';
                break;

            case '.ace':
                $mimeType = 'archive ace';
                $iconClass = 'fa-file-archive-o';
                break;

            case '.tar':
                $mimeType = 'archive tar';
                $iconClass = 'fa-file-archive-o';
                break;

            case '.gtar':
                $mimeType = 'archive gtar';
                $iconClass = 'fa-file-archive-o';
                break;

            case '.gz':
                $mimeType = 'archive gzip';
                $iconClass = 'fa-file-archive-o';
                break;

            case '.bzip':
            case '.bzip2':
                $mimeType = 'archive bzip';
                $iconClass = 'fa-file-archive-o';
                break;

            case '.iso':
                $mimeType = 'archive iso-image';
                $iconClass = 'fa-file-archive-o';
                break;

            case '.au':
            case '.snd':
                $mimeType = 'audio basic';
                $iconClass = 'fa fa-file-audio-o';
                break;

            case '.mid':
            case '.midi':
            case '.kar':
                $mimeType = 'audio midi';
                $iconClass = 'fa fa-file-audio-o';
                break;

            case '.mpga':
            case '.mp2':
            case '.mp3':
                $mimeType = 'audio mpeg';
                $iconClass = 'fa fa-file-audio-o';
                break;

            case '.aif':
            case '.aiff':
            case '.aifc':
                $mimeType = 'audio aiff';
                $iconClass = 'fa fa-file-audio-o';
                break;

            case '.m3u':
                $mimeType = 'audio mpegurl';
                $iconClass = 'fa fa-file-audio-o';
                break;

            case '.ram':
            case '.rm':
            case '.ra':
                $mimeType = 'audio realaudio';
                $iconClass = 'fa fa-file-audio-o';
                break;

            case '.rpm':
                $mimeType = 'audio ealaudio-plugin';
                $iconClass = 'fa fa-file-audio-o';
                break;

            case '.wav':
                $mimeType = 'audio wav';
                $iconClass = 'fa fa-file-audio-o';
                break;

            case '.pdb':
                $mimeType = 'chemical pdb';
                break;

            case '.xyz':
                $mimeType = 'chemical xyz';
                break;

            case '.bmp':
                $mimeType = 'image bmp';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.gif':
                $mimeType = 'image gif';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.ief':
                $mimeType = 'image ief';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.jpeg':
            case '.jpg':
            case '.jpe':
                $mimeType = 'image jpeg';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.png':
                $mimeType = 'image png';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.tiff':
            case '.tif':
                $mimeType = 'image tiff';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.djvu':
            case '.djv':
                $mimeType = 'image vnd-djvu';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.wbmp':
                $mimeType = 'image wap-wbmp';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.ras':
                $mimeType = 'image cmu-raster';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.pnm':
                $mimeType = 'image portable-anymap';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.pbm':
                $mimeType = 'image portable-bitmap';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.pgm':
                $mimeType = 'image portable-graymap';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.ppm':
                $mimeType = 'image portable-pixmap';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.rgb':
                $mimeType = 'image rgb';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.xbm':
                $mimeType = 'image xbitmap';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.xpm':
                $mimeType = 'image xpixmap';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.xwd':
                $mimeType = 'image xwindowdump';
                $iconClass = 'fa fa-file-image-o';
                break;

            case '.igs':
            case '.iges':
                $mimeType = 'model iges';
                break;

            case '.msh':
            case '.mesh':
            case '.silo':
                $mimeType = 'model mesh';
                break;

            case '.wrl':
            case '.vrml':
                $mimeType = 'model vrml';
                break;

            case '.css':
                $mimeType = 'text css';
                break;

            case '.html':
                $mimeType = 'text html';
                break;

            case '.htm':
                $mimeType = 'text html';
                break;

            case '.asc':
            case '.txt':
                $mimeType = 'text plain';
                break;

            case '.rtx':
                $mimeType = 'text richtext';
                break;

            case '.rtf':
                $mimeType = 'text rtf';
                break;

            case '.sgml':
                $mimeType = 'text sgml';
                break;

            case '.sgm':
                $mimeType = 'text sgml';
                break;

            case '.tsv':
                $mimeType = 'text tab-separated-values';
                break;

            case '.wml':
                $mimeType = 'text vnd-wap-wml';
                break;

            case '.wmls':
                $mimeType = 'text vnd-wap-wmlscript';
                break;

            case '.etx':
                $mimeType = 'text setext';
                break;

            case '.xml':
                $mimeType = 'text xml';
                break;

            case '.xsl':
                $mimeType = 'text xml';
                break;

            case '.mpeg':
            case '.mpg':
            case '.mpe':
                $mimeType = 'video mpeg';
                $iconClass = 'fa-file-video-o';
                break;

            case '.qt':
            case '.mov':
                $mimeType = 'video quicktime';
                $iconClass = 'fa-file-video-o';
                break;

            case '.mxu':
                $mimeType = 'video vnd-mpegurl';
                $iconClass = 'fa-file-video-o';
                break;

            case '.avi':
                $mimeType = 'video msvideo';
                $iconClass = 'fa-file-video-o';
                break;

            case '.movie':
                $mimeType = 'video sgi-movie';
                $iconClass = 'fa-file-video-o';
                break;

            case '.asf':
            case '.asx':
                $mimeType = 'video ms-asf';
                $iconClass = 'fa-file-video-o';
                break;

            case '.wm':
            case '.wmv':
                $mimeType = 'video ms-wmv';
                $iconClass = 'fa-file-video-o';
                break;

            case '.wvx':
                $mimeType = 'video ms-wvx';
                $iconClass = 'fa-file-video-o';
                break;

            case '.ice':
                $mimeType = 'conference cooltalk';
                break;
        }

        /**
         * Get the button type into CSS classes
         */
        $isDownload = false;

        if(\strstr($mimeType, ' ')) {
            $types = \explode(' ', $mimeType);
        }

        $linkClass = '';
        if(!\is_null($mimeType) && \in_array($mimeType, $downloadTypes, true) || isset($types['0'])) {
            $linkClass = 'class="ti-item-link download-type-' . \sanitize_title($mimeType) . '"';
            $isDownload = true;
        } else {
            $linkClass = 'class="ti-item-link"';
        }

        /**
         * The HTML
         */
        $html = '';

        if($isDownload == true) {
            $html .= '<button class="ti-button ti-button-' . $type . ' button-download ti-button-align-' . $align . '">';
        } else {
            $html .= '<button class="ti-button ti-button-align-' . $align . '">';
        }

        if(!empty($link)) {
            $html .= '<a ' . $linkClass . ' href="' . $link . '" ' . $target . '>';
        }

        $html .= '<span class="ti-button-content">';

        if($isDownload == true && !empty($iconClass)) {
            $html .= '<span class="download-icon ' . $iconClass . '"></span>';
        }

        $html .= '<span class="button-title">' . $title . '</span>';

        $html .= '</span>';

        if(!empty($link)) {
            $html .= '</a>';
        }

        $html .= '</button>';

        return $html;
    }
}

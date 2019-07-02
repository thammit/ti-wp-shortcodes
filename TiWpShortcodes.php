<?php

/**
 * Plugin name: Thamm IT WordPress Shortcodes
 * Plugin URI: https://github.com/thammit/ti-wp-shortcodes
 * Author: Peter Pfeufer (Thamm IT)
 * Author URI: http://www.thamm-it.de
 * Version: 1.0.0
 * Description: A collection of assorted shortcodes for WordPress
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

class TiWpShortcodes {
    /**
     * Let's do some setup here ...
     */
    public function init() {
        if(!\is_admin()) {
            /**
             * Adding some CSS
             */
            \add_action('wp_enqueue_scripts', [$this, 'enqueueCss']);

            /**
             * Adding [button] shortcode to WordPress
             * [button align=""]Link/Text here[/button]
             */
            \add_shortcode('button', [$this, 'addButtonShortcode']);

            /**
             * Adding [download] shortcode to WordPress
             * [download url="" type="" title="" target="" align=""]
             */
            \add_shortcode('download', [$this, 'addDownloadShortcode']);
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

    /**
     * Rendering the [button] shortcode
     * [button align="" type=""]Link/Text here[/button]
     *  Options:
     *      align   => left/center/right (default: center)
     *      type    => Buttontype (readmore for a Read More Button for example)
     *
     * This is basically just a designed text box.
     *
     * @param array $atts
     * @param string $content
     */
    public function addButtonShortcode($atts, $content = null) {
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

    /**
     * Rendering the [download] shortcode
     * [download url="" type="" title="" target="" align=""]
     *  Options:
     *      url     => The downloads link
     *      type    => The file type
     *      title   => The link description
     *      target  => The link target (similar to <a> attribute target / default: _self)
     *      align   => left/center/right (default: center)
     *
     * Without giving a link and only a title, this is nothing more than just a text box.
     *
     * @param array $atts
     * @param string $content
     */
    function addDownloadShortcode($atts) {
        $args = \shortcode_atts(
            [
                'url' => '',
                'type' => '',
                'title' => '',
                'target' => '',
                'align' => '',
            ],
            $atts,
            'download'
        );

        $url = (string) $args['url'];
        $type = (string) $args['type'];
        $title = (string) $args['title'];
        $target = (string) $args['target'];
        $align = (string) $args['align'];

        /**
         * If there is no title, stop right here
         */
        if(empty($title)) {
            return false;
        }

        $array_Downloadtypes = [
            'pdf',
            'archive',
            'doc',
            'image',
            'audio',
            'video',
            'link'
        ];

        $iconClass = null;

        /**
         * If no align, simply center the button.
         */
        if(empty($align)) {
            $align = 'center';
        }

        /**
         * Linktarget
         */
        if(!empty($target)) {
            $target = 'target="_' . \str_replace('_', '', $target) . '"';
        } else {
            $target = '';
        }

        /**
         * Autodetecting filetype of the given download.
         * Only runs if no type is given in shortcode.
         *
         * @since 1.0
         */
        if(empty($type)) {
            $var_sFiletype = \strrchr($url, ".");

            switch($var_sFiletype) {
                case '.ez':
                    $type = 'andrew-inset';
                    break;

                case '.hqx':
                    $type = 'mac-binhex40';
                    break;

                case '.cpt':
                    $type = 'mac-compactpro';
                    break;

                case '.doc':
                    $type = 'ms-word document';
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
                    $type = 'octet-stream';
                    break;

                case '.oda':
                    $type = 'oda';
                    break;

                case '.pdf':
                    $type = 'pdf';
                    $iconClass = 'fa fa-file-pdf-o';
                    break;

                case '.ai':
                case '.eps':
                case '.ps':
                    $type = 'postscript';
                    break;

                case '.smi':
                case '.smil':
                    $type = 'smil';
                    break;

                case '.xls':
                    $type = 'ms-excel';
                    break;

                case '.ppt':
                    $type = 'ms-powerpoint';
                    break;

                case '.wbxml':
                    $type = 'wap-wbxml';
                    break;

                case '.wmlc':
                    $type = 'wap-wmlc';
                    break;

                case '.wmlsc':
                    $type = 'wap-wmlscriptc';
                    break;

                case '.bcpio':
                    $type = 'bcpio';
                    break;

                case '.vcd':
                    $type = 'cdlink';
                    break;

                case '.pgn':
                    $type = 'chess-pgn';
                    break;

                case '.cpio':
                    $type = 'cpio';
                    break;

                case '.csh':
                    $type = 'csh';
                    break;

                case '.dcr':
                case '.dir':
                case '.dxr':
                    $type = 'director';
                    break;

                case '.dvi':
                    $type = 'dvi';
                    break;

                case '.spl':
                    $type = 'futuresplash';
                    break;

                case '.hdf':
                    $type = 'hdf';
                    break;

                case '.js':
                    $type = 'text javascript';
                    break;

                case '.skp':
                case '.skd':
                case '.skt':
                case '.skm':
                    $type = 'koan';
                    break;

                case '.latex':
                    $type = 'latex';
                    break;

                case '.nc':
                case '.cdf':
                    $type = 'application x-netcdf';
                    break;

                case '.sh':
                    $type = 'sh';
                    break;

                case '.shar':
                    $type = 'shar';
                    break;

                case '.swf':
                    $type = 'shockwave-flash';
                    break;

                case '.sit':
                    $type = 'stuffit';
                    break;

                case '.sv4cpio':
                    $type = 'sv4cpio';
                    break;

                case '.sv4crc':
                    $type = 'sv4crc';
                    break;

                case '.tcl':
                    $type = 'tcl';
                    break;

                case '.tex':
                    $type = 'tex';
                    break;

                case '.texinfo':
                case '.texi':
                    $type = 'texinfo';
                    break;

                case '.t':
                case '.tr':
                case '.roff':
                    $type = 'troff';
                    break;

                case '.man':
                    $type = 'troff-man';
                    break;
                case '.me':
                    $type = 'troff-me';
                    break;

                case '.ms':
                    $type = 'troff-ms';
                    break;

                case '.ustar':
                    $type = 'ustar';
                    break;

                case '.src':
                    $type = 'wais-source';
                    break;

                case '.xhtml':
                case '.xht':
                    $type = 'xhtml-xml';
                    break;

                case '.7z':
                    $type = 'archive sevenzip';
                    $iconClass = 'fa-file-archive-o';
                    break;

                case '.zip':
                    $type = 'archive zip';
                    $iconClass = 'fa-file-archive-o';
                    break;

                case '.arj':
                    $type = 'archive arj';
                    $iconClass = 'fa-file-archive-o';
                    break;

                case '.rar':
                    $type = 'archive rar';
                    $iconClass = 'fa-file-archive-o';
                    break;

                case '.ace':
                    $type = 'archive ace';
                    $iconClass = 'fa-file-archive-o';
                    break;

                case '.tar':
                    $type = 'archive tar';
                    $iconClass = 'fa-file-archive-o';
                    break;

                case '.gtar':
                    $type = 'archive gtar';
                    $iconClass = 'fa-file-archive-o';
                    break;

                case '.gz':
                    $type = 'archive gzip';
                    $iconClass = 'fa-file-archive-o';
                    break;

                case '.bzip':
                case '.bzip2':
                    $type = 'archive bzip';
                    $iconClass = 'fa-file-archive-o';
                    break;

                case '.iso':
                    $type = 'archive iso-image';
                    $iconClass = 'fa-file-archive-o';
                    break;

                case '.au':
                case '.snd':
                    $type = 'audio basic';
                    $iconClass = 'fa fa-file-audio-o';
                    break;

                case '.mid':
                case '.midi':
                case '.kar':
                    $type = 'audio midi';
                    $iconClass = 'fa fa-file-audio-o';
                    break;

                case '.mpga':
                case '.mp2':
                case '.mp3':
                    $type = 'audio mpeg';
                    $iconClass = 'fa fa-file-audio-o';
                    break;

                case '.aif':
                case '.aiff':
                case '.aifc':
                    $type = 'audio aiff';
                    $iconClass = 'fa fa-file-audio-o';
                    break;

                case '.m3u':
                    $type = 'audio mpegurl';
                    $iconClass = 'fa fa-file-audio-o';
                    break;

                case '.ram':
                case '.rm':
                case '.ra':
                    $type = 'audio realaudio';
                    $iconClass = 'fa fa-file-audio-o';
                    break;

                case '.rpm':
                    $type = 'audio ealaudio-plugin';
                    $iconClass = 'fa fa-file-audio-o';
                    break;

                case '.wav':
                    $type = 'audio wav';
                    $iconClass = 'fa fa-file-audio-o';
                    break;

                case '.pdb':
                    $type = 'chemical pdb';
                    break;

                case '.xyz':
                    $type = 'chemical xyz';
                    break;

                case '.bmp':
                    $type = 'image bmp';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.gif':
                    $type = 'image gif';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.ief':
                    $type = 'image ief';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.jpeg':
                case '.jpg':
                case '.jpe':
                    $type = 'image jpeg';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.png':
                    $type = 'image png';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.tiff':
                case '.tif':
                    $type = 'image tiff';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.djvu':
                case '.djv':
                    $type = 'image vnd-djvu';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.wbmp':
                    $type = 'image wap-wbmp';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.ras':
                    $type = 'image cmu-raster';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.pnm':
                    $type = 'image portable-anymap';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.pbm':
                    $type = 'image portable-bitmap';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.pgm':
                    $type = 'image portable-graymap';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.ppm':
                    $type = 'image portable-pixmap';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.rgb':
                    $type = 'image rgb';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.xbm':
                    $type = 'image xbitmap';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.xpm':
                    $type = 'image xpixmap';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.xwd':
                    $type = 'image xwindowdump';
                    $iconClass = 'fa fa-file-image-o';
                    break;

                case '.igs':
                case '.iges':
                    $type = 'model iges';
                    break;

                case '.msh':
                case '.mesh':
                case '.silo':
                    $type = 'model mesh';
                    break;

                case '.wrl':
                case '.vrml':
                    $type = 'model vrml';
                    break;

                case '.css':
                    $type = 'text css';
                    break;

                case '.html':
                    $type = 'text html';
                    break;

                case '.htm':
                    $type = 'text html';
                    break;

                case '.asc':
                case '.txt':
                    $type = 'text plain';
                    break;

                case '.rtx':
                    $type = 'text richtext';
                    break;

                case '.rtf':
                    $type = 'text rtf';
                    break;

                case '.sgml':
                    $type = 'text sgml';
                    break;

                case '.sgm':
                    $type = 'text sgml';
                    break;

                case '.tsv':
                    $type = 'text tab-separated-values';
                    break;

                case '.wml':
                    $type = 'text vnd-wap-wml';
                    break;

                case '.wmls':
                    $type = 'text vnd-wap-wmlscript';
                    break;

                case '.etx':
                    $type = 'text setext';
                    break;

                case '.xml':
                    $type = 'text xml';
                    break;

                case '.xsl':
                    $type = 'text xml';
                    break;

                case '.mpeg':
                case '.mpg':
                case '.mpe':
                    $type = 'video mpeg';
                    $iconClass = 'fa-file-video-o';
                    break;

                case '.qt':
                case '.mov':
                    $type = 'video quicktime';
                    $iconClass = 'fa-file-video-o';
                    break;

                case '.mxu':
                    $type = 'video vnd-mpegurl';
                    $iconClass = 'fa-file-video-o';
                    break;

                case '.avi':
                    $type = 'video msvideo';
                    $iconClass = 'fa-file-video-o';
                    break;

                case '.movie':
                    $type = 'video sgi-movie';
                    $iconClass = 'fa-file-video-o';
                    break;

                case '.asf':
                case '.asx':
                    $type = 'video ms-asf';
                    $iconClass = 'fa-file-video-o';
                    break;

                case '.wm':
                case '.wmv':
                    $type = 'video ms-wmv';
                    $iconClass = 'fa-file-video-o';
                    break;

                case '.wvx':
                    $type = 'video ms-wvx';
                    $iconClass = 'fa-file-video-o';
                    break;

                case '.ice':
                    $type = 'conference cooltalk';
                    break;
            }
        }

        /**
         * Get the button type into CSS classes
         */
        $isDownload = false;

        if(\strstr($type, ' ')) {
            $types = \explode(' ', $type);
        }

        if($type && \in_array($type, $array_Downloadtypes, true) || isset($types['0'])) {
            $type = 'class="ti-item-link download-type-' . $type . '"';
            $isDownload = true;
        } else {
            $type = 'class="ti-item-link"';
        }

        /**
         * The HTML
         */
        $var_sHTML = '';

        if($isDownload == true) {
            $var_sHTML .= '<span class="ti-button button-download ti-button-align-' . $align . '">';
        } else {
            $var_sHTML .= '<span class="ti-button ti-button-align-' . $align . '">';
        }

        if(!empty($url)) {
            $var_sHTML .= '<a ' . $type . ' href="' . $url . '" ' . $target . '>';
        }

        if($isDownload == true && !empty($iconClass)) {
            $var_sHTML .= '<span class="download-icon ' . $iconClass . '"></span>';
        }

        $var_sHTML .= '<span class="button-title">' . $title . '</span>';

        if(!empty($url)) {
            $var_sHTML .= '</a>';
        }

        $var_sHTML .= '</span>';

        return $var_sHTML;
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

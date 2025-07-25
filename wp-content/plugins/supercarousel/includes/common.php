<?php

/*
  Created on : Mar 1, 2016, 9:46:27 PM
  Author     : Tara
  Email      : swain.tara@gmail.com
  Website    : http://www.taraprasad.com
 */

class SuperCarousel_Common {

    public static function spcr_is_session_started() {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }

    public static function get_extension($file = '') {
        $filearr = explode('.', $file);
        $filearr = array_reverse($filearr);
        return $filearr[0];
    }

    public static function generate_merged_js($path, $filesarr, $mergedfilepath) {
        $ext = self::get_extension($mergedfilepath);
        if (!in_array($ext, array('js'))) {
            return false;
        }
        if (file_exists($mergedfilepath)) {
            @unlink($mergedfilepath);
        }
        foreach ($filesarr as $file) {
            $filename = $file . '.js';
            if (SUPER_MINIFIED_RESOURCE) {
                $filename = $file . '.min.js';
            }
            file_put_contents($mergedfilepath, "/*{$file}*/\n" . file_get_contents($path . $filename) . "\n\n", FILE_APPEND);
        }
    }

    public static function generate_merged_css($path, $filesarr, $mergedfilepath) {
        $ext = self::get_extension($mergedfilepath);
        if (!in_array($ext, array('css'))) {
            return false;
        }
        if (file_exists($mergedfilepath)) {
            @unlink($mergedfilepath);
        }
        foreach ($filesarr as $file) {
            $filename = $file . '.css';
            if (SUPER_MINIFIED_RESOURCE) {
                $filename = $file . '.min.css';
            }
            file_put_contents($mergedfilepath, "/*{$file}*/\n" . file_get_contents($path . $filename) . "\n\n", FILE_APPEND);
        }
    }

    /*
     * Decodes string
     */

    public static function decode_string($encode, $options) {
        $escape = '\\\0..\37';
        $needle = array();
        $replace = array();

        if ($options & JSON_HEX_APOS) {
            $needle[] = "'";
            $replace[] = 'u0027';
        } else {
            $escape .= "'";
        }

        if ($options & JSON_HEX_QUOT) {
            $needle[] = '"';
            $replace[] = 'u0022';
        } else {
            $escape .= '"';
        }

        if ($options & JSON_HEX_AMP) {
            $needle[] = '&';
            $replace[] = 'u0026';
        }

        if ($options & JSON_HEX_TAG) {
            $needle[] = '<';
            $needle[] = '>';
            $replace[] = 'u003C';
            $replace[] = 'u003E';
        }

        //$encode = addcslashes( $encode , $escape );
        $encode = str_replace($replace, $needle, $encode);

        return $encode;
    }

    /*
     * @name name of the checkbox
     * @value value of the checkbox
     * @check if the checkbox is checked
     * return html output for the checkbox
     */

    public static function generate_super_checkbox($name, $value, $check) {
        $selected = '';
        if ($check == $value) {
            $selected = ' checked="checked"';
        }
        return '<input type="checkbox" name="' . $name . '" id="' . $name . '" value="' . $value . '"' . $selected . ' />';
    }

    /*
     * @name name of the input
     * @value value of the input
     * @param extra attributes of the input
     * return html output for the input
     */

    public static function generate_super_textbox($name, $value = '', $param = '') {
        return '<input type="text" name="' . $name . '" id="' . $name . '" value="' . $value . '" ' . $param . ' />';
    }

    public static function get_super_thumb($img) {
        $imgx = array_reverse(explode('.', $img));
        $imgx[1] = $imgx[1] . '-150x150';
        $imgx = array_reverse($imgx);
        return join('.', $imgx);
    }

    public static function is_supercarousel_edit() {
        $act = isset($_REQUEST['act']) ? esc_attr($_REQUEST['act']) : '';
        $id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;
        if ($act == 'edit' and $id > 0) {
            return true;
        }
        return false;
    }

    public static function is_supercarousel_add() {
        $act = isset($_REQUEST['act']) ? esc_attr($_REQUEST['act']) : '';
        $id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;
        if ($act == 'add' and $id == 0) {
            return true;
        }
        return false;
    }

    public static function is_supercarousel_listing() {
        $act = isset($_REQUEST['act']) ? esc_attr($_REQUEST['act']) : '';
        $id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;
        if ($act == '' and $id == 0) {
            return true;
        }
        return false;
    }

    public static function super_get_post($key = '') {
        if (isset($_POST[$key])) {
            return addslashes(stripslashes($_POST[$key]));
        }
        return '';
    }

    public static function super_get_get($key = '') {
        if (isset($_GET[$key])) {
            return addslashes($_GET[$key]);
        }
        return '';
    }

    public static function super_clean_array($data = array()) {
        foreach ($data as $key => $val) {
            $data[$key] = addslashes($val);
        }
        return $data;
    }

    public static function super_serialize($obj) {
        return base64_encode(gzcompress(serialize($obj)));
    }

    public static function super_unserialize($txt) {
        return unserialize(gzuncompress(base64_decode($txt)));
    }

    public static function get_array_value(&$supertemplate, $key = '', $value = '') {
        $default_type = 'string';
        if (is_numeric($value)) {
            return (isset($supertemplate[$key]) and is_numeric($supertemplate[$key])) ? $supertemplate[$key] : $value;
        } else if (is_array($value) or is_object($value)) {
            return (isset($supertemplate[$key]) and ( is_array($supertemplate[$key]) or is_object($supertemplate[$key]))) ? $supertemplate[$key] : $value;
        }
        return isset($supertemplate[$key]) ? stripslashes($supertemplate[$key]) : $value;
    }

    public static function get_easing_list() {
        return array('swing', 'linear', 'easeInQuad', 'easeOutQuad', 'easeInOutQuad', 'easeInCubic', 'easeOutCubic', 'easeInOutCubic', 'easeInQuart', 'easeOutQuart', 'easeInOutQuart', 'easeInQuint', 'easeOutQuint', 'easeInOutQuint', 'easeInSine', 'easeOutSine', 'easeInOutSine', 'easeInExpo', 'easeOutExpo', 'easeInOutExpo', 'easeInCirc', 'easeOutCirc', 'easeInOutCirc', 'easeInElastic', 'easeOutElastic', 'easeInOutElastic', 'easeInBack', 'easeOutBack', 'easeInOutBack', 'easeInBounce', 'easeOutBounce', 'easeInOutBounce');
    }

    public static function plugin_get_version() {
        $plugin_data = get_plugin_data(SUPER_CAROUSEL_FILE);
        $plugin_version = $plugin_data['Version'];
        return $plugin_version;
    }

    public static function array_css_string($arr = array()) {
        $returnarr = array();
        $css3prop = array('transform', 'transition');
        foreach ($arr as $key => $val) {
            if ($val == '') {
                continue;
            }
            $returnarr[] = "{$key}: {$val}";
            if (in_array($key, $css3prop)) {
                $returnarr[] = "-wekbit-{$key}: {$val}";
                $returnarr[] = "-moz-{$key}: {$val}";
                $returnarr[] = "-ms-{$key}: {$val}";
                $returnarr[] = "-o-{$key}: {$val}";
            }
        }
        if (!count($returnarr)) {
            return '{}';
        }
        return ' {' . join(';', $returnarr) . ';}';
    }

    public static function get_mult_arr($arr) {
        $temp = array();
        foreach ($arr as $key => $val) {
            $asarr = array();
            foreach ($val as $i => $value) {
                if (!isset($temp[$i])) {
                    $temp[$i] = array();
                }
                $temp[$i][$key] = $value;
            }
        }
        return $temp;
    }

    public static function get_super_content_categories($id = 0, $separator = ', ') {
        $id = (int) $id;
        if ($id > 0) {
            $supercontent_category = get_the_terms($id, 'supercontentcat');
            $returnarr = array();
            if (is_array($supercontent_category)) {
                foreach ($supercontent_category as $row) {
                    $returnarr[] = $row->name;
                }
            }
            return join($separator, $returnarr);
        }
        return '';
    }

    public static function get_super_content_categories_arr($id = 0) {
        $id = (int) $id;
        if ($id > 0) {
            $supercontent_category = get_the_terms($id, 'supercontentcat');
            $returnarr = array();
            foreach ($supercontent_category as $row) {
                $returnarr[] = $row->name;
            }
            return $returnarr;
        }
        return '';
    }

    public static function get_post_taxonomies($id = 0) {
        $id = (int) $id;
        $returnarr = array();
        if ($id > 0) {
            $taxonomies = get_taxonomies('', 'names');
            $terms = wp_get_post_terms($id, $taxonomies);
            foreach ($terms as $row) {
                $termhtml = '<a class="supercarousel_custom_taxonomy" href="' . get_term_link($row->term_id) . '" title="' . $row->name . '">' . $row->name . '</a>';
                $returnarr[] = $termhtml;
            }
            return join(', ', $returnarr);
        }
        return '';
    }

    public static function get_post_categories($id = 0) {
        $id = (int) $id;
        $returnarr = array();
        if ($id > 0) {
            $terms = wp_get_post_terms($id, 'category');
            foreach ($terms as $row) {
                $termhtml = '<a class="supercarousel_custom_taxonomy" href="' . get_term_link($row->term_id) . '" title="' . $row->name . '">' . $row->name . '</a>';
                $returnarr[] = $termhtml;
            }
            return join(', ', $returnarr);
        }
        return '';
    }

    public static function get_post_tags($id = 0) {
        $id = (int) $id;
        $returnarr = array();
        if ($id > 0) {
            $terms = wp_get_post_terms($id, 'post_tag');
            foreach ($terms as $row) {
                $termhtml = '<a class="supercarousel_custom_taxonomy" href="' . get_term_link($row->term_id) . '" title="' . $row->name . '">' . $row->name . '</a>';
                $returnarr[] = $termhtml;
            }
            return join(', ', $returnarr);
        }
        return '';
    }

}

function supershow($val) {
    if (is_array($val) or is_object($val)) {
        echo "<pre>";
        print_r($val);
        echo "</pre>";
    } else {
        echo $val;
    }
}

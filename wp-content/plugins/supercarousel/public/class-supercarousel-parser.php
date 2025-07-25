<?php

class SuperCarousel_Parser {

    public $data = [], $keymaps = [];

    public function __construct($data = []) {
        $this->data = $data;
    }

    public function parseKey($temkey = '', $html = '') {
        return preg_replace_callback("|{(" . $temkey . ")\|([a-zA-Z0-9:\|\'\s\-\,]+)}|", [$this, 'filter_variable_callback'], $html);
    }

    function filter_variable_callback($matches) {
        /*
         * Array
          (
          [0] => {title|stringlimit:20}
          [1] => title
          [2] => stringlimit:20
          )
         */
        $key = isset($matches[1]) ? $matches[1] : '';
        $mapkey = isset($this->keymaps[$key]) ? $this->keymaps[$key] : $key;
        $keyvalue = isset($this->data[$mapkey]) ? $this->data[$mapkey] : '';
        
        $funcarr = isset($matches[2]) ? str_getcsv($matches[2], '|', "'", '"') : [];

        $params = isset($funcarr[0]) ? str_getcsv($funcarr[0], ':', "'", '"') : [];

        array_shift($funcarr);

        if (count($params) > 0) {
            $func = isset($params[0]) ? 'filter_' . $params[0] : '';
            array_shift($params);
            array_unshift($params, $keyvalue);
            if (method_exists($this, $func)) {
                if (count($funcarr) == 0) {
                    return call_user_func_array([$this, $func], $params);
                } else {
                    $this->data[$mapkey] = call_user_func_array([$this, $func], $params);
                    $matches[2] = join('|', $funcarr);
                    return $this->filter_variable_callback($matches);
                }
            }
        }

        return $keyvalue;
    }

    public function filter_applyfilter($string, $filtername = '') {
        $customkeyfilter = 'SuperCarouselCustomKey_' . $filtername;
        if (has_filter($customkeyfilter)) {
            return apply_filters($customkeyfilter, $filtername, $this->data);
        }
        return $filtername;
    }
    
    public function filter_striptags($string) {
        return strip_tags($string);
    }
    
    public function filter_uppercase($string) {
        return strtoupper($string);
    }

    public function filter_lowercase($string) {
        return strtolower($string);
    }

    public function filter_ucwords($string) {
        return ucwords($string);
    }

    public function filter_ucfirst($string) {
        return ucfirst($string);
    }

    public function filter_urlencode($string) {
        return urlencode($string);
    }

    public function filter_urldecode($string) {
        return urldecode($string);
    }

    public function filter_trim($string) {
        return trim($string);
    }

    public function filter_ltrim($string) {
        return ltrim($string);
    }

    public function filter_rtrim($string) {
        return rtrim($string);
    }

    public function filter_stringlimit($string, $limit = 0) {
        $limit = (int) $limit;
        if ($limit == 0) {
            return $string;
        }
        return substr($string, 0, $limit);
    }

    public function filter_postmeta($string, $postmeta) {
        if ($postmeta != '') {
            return get_post_meta($this->data['ID'], $postmeta, true);
        }
        return '';
    }

    public function filter_dateformat($string, $dateformat) {
        if ($string != '' and $dateformat != '') {
            return date($dateformat, strtotime($string));
        }
        return '';
    }

    public function filter_category($string) {
        if (isset($this->data['category'])) {
            return $this->data['category']->get_term();
        }
        return '';
    }

    public function filter_copyright($string) {
        return $string;
    }

    public function filter_author($string) {
        return $string;
    }

}

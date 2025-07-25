<?php

/**
 * The public-facing functionality of the plugin.
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
class SuperCarousel_Public {

    /**
     * The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     */
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     */
    public function enqueue_styles() {
        $cssdir = plugin_dir_url(__FILE__) . 'css/';
        $cssfilesarr = ['supercarousel', 'superlightbox'];
        if (SUPER_SINGLE_RESOURCE) {
            $mergedfilepath = SUPER_CAROUSEL_PATH . 'public/css/supercarouselmerged.css';
            if (!file_exists($mergedfilepath) or DEBUG_SUPER_SINGLE_RESOURCE) {
                SuperCarousel_Common::generate_merged_css(SUPER_CAROUSEL_PATH . 'public/css/', $cssfilesarr, $mergedfilepath);
            }
            wp_enqueue_style('sc_merged', $cssdir . 'supercarouselmerged.css', array(), $this->version, 'all');
        } else {
            foreach ($cssfilesarr as $cssfile) {
                $cssfilename = $cssfile . '.css';
                if (SUPER_MINIFIED_RESOURCE) {
                    $cssfilename = $cssfile . '.min.css';
                }
                wp_enqueue_style('sc_' . $cssfile, $cssdir . $cssfilename, array(), $this->version, 'all');
            }
        }
        $this->generate_dynamic_css();
        wp_enqueue_style('sc_dynamic_css', $cssdir . 'supercarousel.dynamic.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        $jsdir = plugin_dir_url(__FILE__) . 'js/';
        wp_enqueue_script('imagesloaded');

        $jsfilesarr = ['jquery.supercarousel', 'jquery.easing', 'jquery.easing.compatibility', 'jquery.feedify', 'jquery.framerate', 'jquery.ismouseover', 'jquery.mousewheel', 'jquery.superlightbox'];

        if (SUPER_SINGLE_RESOURCE) {
            $mergedfilepath = SUPER_CAROUSEL_PATH . 'public/js/supercarouselmerged.js';
            if (!file_exists($mergedfilepath) or DEBUG_SUPER_SINGLE_RESOURCE) {
                SuperCarousel_Common::generate_merged_js(SUPER_CAROUSEL_PATH . 'public/js/', $jsfilesarr, $mergedfilepath);
            }
            wp_enqueue_script('sc_merged', $jsdir . 'supercarouselmerged.js', array('jquery'), $this->version, false);
        } else {
            foreach ($jsfilesarr as $jsfile) {
                $jsfilename = $jsfile . '.js';
                if (SUPER_MINIFIED_RESOURCE) {
                    $jsfilename = $jsfile . '.min.js';
                }
                wp_enqueue_script('sc_' . $jsfile, $jsdir . $jsfilename, array('jquery'), $this->version, false);
            }
        }
    }

    public function generate_dynamic_css() {
        if (get_option('supercarousel_css_updated') == '1') {
            update_option('supercarousel_css_updated', '0');
            global $wp_filesystem;
            $cssfile = SUPER_CAROUSEL_PATH . '/public/css/supercarousel.dynamic.css';
            
            $args = [];
            $args['post_type'] = 'supercarousel';
            $args['posts_per_page'] = -1;
            $loop = new WP_Query($args);

            $cssdata = '';

            $googlefonts = [];

            foreach ($loop->posts as $superpost) {
                $mainclass = '.supercarousel' . $superpost->ID . ' ';
                $slideclass = $mainclass . '.supercarousel > div ';
                $slidehoverclass = $mainclass . '.supercarousel > div:hover ';
                $supertemplate = get_post_meta($superpost->ID, 'supertemplate', true);
                if ($supertemplate != '') {
                    $supertemplate = SuperCarousel_Common::super_unserialize($supertemplate);
                    if (count($supertemplate)) {
                        $type = isset($supertemplate['type']) ? $supertemplate['type'] : 'noprop';
                        $template_data = isset($supertemplate['data']) ? $supertemplate['data'] : '';
                        $expertmode = SuperCarousel_Common::get_array_value($supertemplate, 'expertmode', 0);
                        $template_arr = [];
                        if ($template_data != '' and $expertmode == '0') {
                            $template_arr = json_decode(stripslashes($template_data));
                            if (isset($template_arr->$type)) {
                                //supershow($template_arr->$type);
                                $cssdata .= $slideclass . SuperCarousel_Common::array_css_string($template_arr->$type->slide->css3);

                                foreach ($template_arr->$type->elements as $i => $element) {
                                    $overlayprop = 'overlay-color';
                                    $fontfamily = 'font-family';

                                    if (isset($element->normalcss->$fontfamily) and $element->normalcss->$fontfamily != '') {
                                        $googlefonts[] = $element->normalcss->$fontfamily;
                                    }

                                    if ($element->name == 'Image' and isset($element->normalcss->$overlayprop) and isset($element->hovercss->$overlayprop) and isset($element->normalcss->{'border-radius'})) {
                                        $cssdata .= $slideclass . '.super_overlay' . $i . SuperCarousel_Common::array_css_string(['background-color' => $element->normalcss->$overlayprop, 'transition' => $element->normalcss->transition, 'border-radius' => $element->normalcss->{'border-radius'}]);
                                        $cssdata .= $slidehoverclass . '.super_overlay' . $i . SuperCarousel_Common::array_css_string(['background-color' => $element->hovercss->$overlayprop]);
                                    }

                                    if (isset($element->normalcss->$overlayprop)) {
                                        unset($element->normalcss->$overlayprop);
                                    }
                                    if (isset($element->hovercss->$overlayprop)) {
                                        unset($element->hovercss->$overlayprop);
                                    }

                                    if ($element->name == 'Button') {
                                        $textalign = 'text-align';
                                        $cssdata .= $slideclass . '.super_buttonwrap' . $i . SuperCarousel_Common::array_css_string(['text-align' => $element->normalcss->$textalign]);
                                    }

                                    $eleclass = '.superelement' . $i;
                                    $cssdata .= $slideclass . $eleclass . SuperCarousel_Common::array_css_string($element->normalcss);
                                    $cssdata .= $slideclass . $eleclass . ':hover ' . SuperCarousel_Common::array_css_string($element->hovercss);

                                    $eleclass = 'superelement' . $i . ' a';
                                    $cssdata .= $slideclass . $eleclass . SuperCarousel_Common::array_css_string($element->normalcss);
                                    $cssdata .= $slideclass . $eleclass . ':hover ' . SuperCarousel_Common::array_css_string($element->hovercss);

                                    if (isset($element->elements) and is_array($element->elements) and count($element->elements)) {
                                        foreach ($element->elements as $oi => $oelement) {
                                            $eleclass = '.superoverlayelement' . $oi;
                                            $cssdata .= $slideclass . $eleclass . SuperCarousel_Common::array_css_string($oelement->normalcss);
                                            $cssdata .= $slideclass . ':hover ' . $eleclass . SuperCarousel_Common::array_css_string($oelement->hovercss);

                                            $eleclass = 'superoverlayelement' . $oi . ' a';
                                            $cssdata .= $slideclass . $eleclass . SuperCarousel_Common::array_css_string($oelement->normalcss);
                                            $cssdata .= $slideclass . ':hover ' . $eleclass . SuperCarousel_Common::array_css_string($oelement->hovercss);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $super_csscode_global = stripslashes(get_option('super_csscode_global'));
            $cssdata .= $super_csscode_global;

            if (count($googlefonts)) {
                $googlefontstr = join('|', $googlefonts);
                $googlefontimporturl = "@import url('https://fonts.googleapis.com/css?family={$googlefontstr}:100,200,300,400,500,600,700,800,900');";
                $cssdata = $googlefontimporturl . $cssdata;
            }

            file_put_contents($cssfile, $cssdata);
        }
    }

    function get_slides(&$superdata = [], $id = 0) {
        if (!count($superdata)) {
            return [];
        }
        //supershow($superdata);
        $superSlideObj = new SuperCarousel_Slides($superdata);
        $superSlideObj->carouselId = $id;
        return $superSlideObj->get_slides_data();
    }

    function get_carousel_options(&$superdata = []) {
        if (!count($superdata)) {
            return [];
        }

        $optionsarr = ['respdesktop' => 'respDesktop', 'respdesktopvisible' => 'desktopVisible', 'respdesktopwidth' => 'desktopWidth', 'respdesktopheight' => 'desktopHeight', 'resplaptop' => 'respLaptop', 'resplaptopvisible' => 'laptopVisible', 'resplaptopwidth' => 'laptopWidth', 'resplaptopheight' => 'laptopHeight', 'resptab' => 'respTablet', 'resptabvisible' => 'tabletVisible', 'resptabwidth' => 'tabletWidth', 'resptabheight' => 'tabletHeight', 'respmob' => 'respMobile', 'respmobvisible' => 'mobileVisible', 'respmobwidth' => 'mobileWidth', 'respmobheight' => 'mobileHeight', 'direction' => 'direction', 'effect' => 'effect', 'easing' => 'easing', 'easing_time' => 'easingTime', 'steps' => 'step', 'autoplay' => 'auto', 'pause_time' => 'pauseTime', 'pause_over' => 'pauseOver', 'continuous_scroll' => 'autoscroll', 'scroll_speed' => 'scrollspeed', 'auto_height' => 'autoHeight', 'slide_gap' => 'slideGap', 'next_prev' => 'nextPrev', 'arrow_style' => 'arrowStyle', 'arrowsout' => 'arrowsOut', 'circular' => 'circular', 'mousewheel' => 'mouseWheel', 'touchswipe' => 'swipe', 'keyboard' => 'keys', 'pagination' => 'paging', 'wrapper_class' => 'wrapper_class', 'randomize' => 'randomize', 'hidden_carousel' => 'superhidden'];
        $returnarr = ['source' => $superdata['type']];
        foreach ($optionsarr as $key => $opt) {
            if (isset($superdata[$key])) {
                $returnarr[$opt] = $superdata[$key];
            } else {
                $returnarr[$opt] = '';
            }
        }
        if (isset($superdata['customrespby'])) {
            $returnarr['customrespmin'] = $superdata['customrespmin'];
            $returnarr['customrespmax'] = $superdata['customrespmax'];
            $returnarr['customrespby'] = $superdata['customrespby'];
            $returnarr['customrespvisible'] = $superdata['customrespvisible'];
            $returnarr['customrespwidth'] = $superdata['customrespwidth'];
            $returnarr['customrespheight'] = $superdata['customrespheight'];
        } else {
            $returnarr['customrespmin'] = [];
            $returnarr['customrespmax'] = [];
            $returnarr['customrespby'] = [];
            $returnarr['customrespvisible'] = [];
            $returnarr['customrespwidth'] = [];
            $returnarr['customrespheight'] = [];
        }
        return $returnarr;
    }

    function get_supercarousel_data($id = 0) {
        $id = (int) $id;
        $returnarr = ['slides' => [], 'options' => []];
        if ($id > 0) {
            if ('supercarousel' == get_post_type($id)) {
                $superdata = get_post_meta($id, 'supertemplate', true);
                if ($superdata != '') {
                    $superdata = SuperCarousel_Common::super_unserialize($superdata);
                    if (count($superdata)) {
                        $returnarr['slides'] = $this->get_slides($superdata, $id);
                        $returnarr['options'] = $this->get_carousel_options($superdata);
                        $returnarr['options']['carouselid'] = $id;
                    }
                }
            }
        }
        return $returnarr;
    }

    public function display_carousel($attr = [], $content = '') {
        $carouselid = isset($attr['id']) ? (int) $attr['id'] : 0;
        $carouselslug = isset($attr['slug']) ? $attr['slug'] : '';
        if ($carouselid <= 0 and $carouselslug != '') {
            $superpost = get_page_by_path($carouselslug, OBJECT, 'supercarousel');
            if ($superpost) {
                $carouselid = $superpost->ID;
            }
        }
        if ($carouselid > 0) {
            if ('supercarousel' == get_post_type($carouselid)) {
                ob_start();
                $carouselData = $this->get_supercarousel_data($carouselid);

                if (has_action('SuperCarousel_Before')) {
                    do_action('SuperCarousel_Before', $carouselid);
                }

                if (has_action('SuperCarousel_Before_' . $carouselid)) {
                    do_action('SuperCarousel_Before_' . $carouselid);
                }

                include(SUPER_CAROUSEL_PATH . '/public/views/supercarousel.php');

                if (has_action('SuperCarousel_After_' . $carouselid)) {
                    do_action('SuperCarousel_After_' . $carouselid);
                }

                if (has_action('SuperCarousel_After')) {
                    do_action('SuperCarousel_After', $carouselid);
                }

                $html = ob_get_contents();
                ob_end_clean();
                return $html;
            }
        }
    }

}

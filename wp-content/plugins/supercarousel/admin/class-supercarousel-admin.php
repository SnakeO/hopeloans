<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 */
class SuperCarousel_Admin {

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
     * Register the stylesheets for the admin area.
     */
    public function enqueue_styles() {
        $admincssfile = (SUPER_MINIFIED_RESOURCE) ? 'supercarousel-admin.min.css' : 'supercarousel-admin.css';
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/' . $admincssfile, array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        global $SUPERJS_TRANSLATIONS;
        wp_enqueue_script('json2');
        if (function_exists('wp_enqueue_media')) {
            wp_enqueue_media();
        }

        $commonvariables = array(
            'SUPER_CAROUSEL_URL' => SUPER_CAROUSEL_URL,
            'SUPER_IMAGE_SIZES' => get_intermediate_image_sizes()
        );

        $commonvariables['SUPER_IMAGE_SIZES'][] = 'full';

        $commonjsfile = (SUPER_MINIFIED_RESOURCE) ? 'common.min.js' : 'common.js';
        wp_register_script($this->plugin_name . '-common', SUPER_CAROUSEL_URL . 'admin/js/' . $commonjsfile, array('jquery'), $this->version, false);

        wp_localize_script($this->plugin_name . '-common', 'SUPERVARS', $commonvariables);

        wp_localize_script($this->plugin_name . '-common', 'SUPERTRANS', $SUPERJS_TRANSLATIONS);

        wp_enqueue_script($this->plugin_name . '-common');
    }

    public function supercontent_enqueue() {
        $jsfile = (SUPER_MINIFIED_RESOURCE) ? 'supercarousel-content.min.js' : 'supercarousel-content.js';
        wp_enqueue_script($this->plugin_name . '-content', SUPER_CAROUSEL_URL . 'admin/js/' . $jsfile, array('jquery'), $this->version, false);
    }

    public function superimage_enqueue() {
        $jsfile = (SUPER_MINIFIED_RESOURCE) ? 'supercarousel-image.min.js' : 'supercarousel-image.js';
        wp_enqueue_script($this->plugin_name . '-image', SUPER_CAROUSEL_URL . 'admin/js/' . $jsfile, array('jquery'), $this->version, false);
    }

    public function supercarousel_enqueue() {
        wp_enqueue_style($this->plugin_name . '-spectrumcss', SUPER_CAROUSEL_URL . 'admin/css/spectrum.min.css');
        wp_enqueue_style($this->plugin_name . '-codemirrorcss', SUPER_CAROUSEL_URL . 'admin/css/codemirror.min.css');
        wp_enqueue_style($this->plugin_name . '-codemirror-clipse', SUPER_CAROUSEL_URL . 'admin/css/eclipse.min.css');

        wp_enqueue_script('jquery-ui-autocomplete');

        $jsfilesarr = ['googlefonts', 'spectrum', 'jquery.stringToSlug', 'codemirror', 'htmlmixed/htmlmixed', 'xml/xml', 'css/css', 'jquery.superelementprop', 'supercarousel-template'];

        if (SUPER_SINGLE_RESOURCE) {
            $mergedfilepath = SUPER_CAROUSEL_PATH . 'admin/js/supercarouseladminmerged.js';
            if (!file_exists($mergedfilepath) or DEBUG_SUPER_SINGLE_RESOURCE) {
                SuperCarousel_Common::generate_merged_js(SUPER_CAROUSEL_PATH . 'admin/js/', $jsfilesarr, $mergedfilepath);
            }
            wp_enqueue_script('sc_merged', SUPER_CAROUSEL_URL . 'admin/js/supercarouseladminmerged.js', array('jquery'), $this->version, false);
        } else {
            foreach ($jsfilesarr as $jsfile) {
                $jsfilename = $jsfile . '.js';
                if (SUPER_MINIFIED_RESOURCE) {
                    $jsfilename = $jsfile . '.min.js';
                }
                wp_enqueue_script($this->plugin_name . '-' . $jsfile, SUPER_CAROUSEL_URL . 'admin/js/' . $jsfilename, array('jquery'), $this->version, false);
            }
        }
    }

    public function admin_theme_setup() {
        include(SUPER_CAROUSEL_PATH . 'includes/class-supercarousel-widget.php');
        include(SUPER_CAROUSEL_PATH . 'includes/class-supercarousel-tweetwidget.php');
    }

    public function add_post_types() {
        register_post_type('supercarousel', array('label' => 'Super Carousel', 'public' => false));
        register_taxonomy('supercontentcat', array('supercontent'), array('label' => 'Super Content Category', 'public' => false));
        register_post_type('supercontent', array('label' => 'Super Content', 'public' => false));
        register_post_type('superimage', array('label' => 'Super Image', 'public' => false));
        //register_post_type('supertemplate', array('public' => false));
    }

    public function add_admin_menus() {
        $adminpage = new SuperCarousel_AdminPage();
        $page = add_menu_page('Super Carousel', 'Super Carousel', 'manage_options', 'supercarousel', array($adminpage, 'admin_supercarousel_page'), 'dashicons-editor-kitchensink');

        add_action("admin_print_scripts-$page", array($this, 'supercarousel_enqueue'));

        $page = add_submenu_page('supercarousel', 'Content', 'Content', 'manage_options', 'supercarousel-content', array($adminpage, 'admin_supercontent_page'));

        add_action("admin_print_scripts-$page", array($this, 'supercontent_enqueue'));

        $page = add_submenu_page('supercarousel', 'Images', 'Images', 'manage_options', 'supercarousel-image', array($adminpage, 'admin_superimage_page'));

        add_action("admin_print_scripts-$page", array($this, 'superimage_enqueue'));
    }

    public function ajax_supercarouseladmin() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            exit;
        }
        $adminpage = new SuperCarousel_AdminPage();
        $superaction = SuperCarousel_Common::super_get_post('superaction');
        if ($superaction == 'save_supercarousel') {
            $adminpage->check_supercarousel_save();
        } else if ($superaction == 'save_supercontent') {
            $adminpage->check_supercontent_save();
        } else if ($superaction == 'save_superimage') {
            $adminpage->check_superimage_save();
        } else if ($superaction == 'delete_supercarousel') {
            $adminpage->check_supercarousel_delete();
        } else if ($superaction == 'supercontentcategory') {
            $adminpage->check_supercontent_category();
        } else if ($superaction == 'savepreviewtemplate') {
            $adminpage->save_preview_template();
        } else if ($superaction == 'deletepreviewtemplate') {
            $adminpage->delete_preview_template();
        } else if ($superaction == 'loadpreviewtemplate') {
            $adminpage->load_preview_template();
        } else if ($superaction == 'loadselectpreviewtemplate') {
            $adminpage->load_select_preview_template();
        } else if ($superaction == 'supertempost_autocomplete') {
            $adminpage->search_post_types();
        } else if ($superaction == 'checkyoutubeapi') {
            $adminpage->check_youtube_api();
        } else if ($superaction == 'checkflickrapi') {
            $adminpage->check_flickr_api();
        }
        exit;
    }

}

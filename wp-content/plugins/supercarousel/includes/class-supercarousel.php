<?php

class SuperCarousel {

    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {

        $this->plugin_name = 'SuperCarousel';
        $this->version = '3.0.0';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies() {

        /**
         * The file responsible for common functions
         * core plugin.
         */
        require_once SUPER_CAROUSEL_PATH . 'includes/common.php';

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once SUPER_CAROUSEL_PATH . 'includes/class-supercarousel-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once SUPER_CAROUSEL_PATH . 'includes/class-supercarousel-i18n.php';

        /*
         * Adding Visual Composer and Cornerstone Support
         */
        require_once SUPER_CAROUSEL_PATH . 'includes/class-supercarousel-vc.php';
        require_once SUPER_CAROUSEL_PATH . 'includes/class-supercarousel-cs.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once SUPER_CAROUSEL_PATH . 'admin/class-supercarousel-admin.php';
        require_once SUPER_CAROUSEL_PATH . 'admin/class-supercarousel-adminpage.php';
        require_once SUPER_CAROUSEL_PATH . 'admin/class-supercarousel-importer.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-supercarousel-public.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-supercarousel-elements.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-supercarousel-slides.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-supercarousel-parser.php';

        $this->loader = new SuperCarousel_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
     * with WordPress.
     */
    private function set_locale() {

        $plugin_i18n = new SuperCarousel_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     */
    private function define_admin_hooks() {

        $plugin_admin = new SuperCarousel_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('init', $plugin_admin, 'add_post_types');
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_admin_menus');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('wp_ajax_supercarouseladmin', $plugin_admin, 'ajax_supercarouseladmin');
        $this->loader->add_action('after_setup_theme', $plugin_admin, 'admin_theme_setup');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     */
    private function define_public_hooks() {

        $plugin_public = new SuperCarousel_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_shortcode('supercarousel', $plugin_public, 'display_carousel');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}

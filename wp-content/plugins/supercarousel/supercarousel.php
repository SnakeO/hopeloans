<?php

/**
  Plugin Name: SuperCarousel
  Plugin URI: http://www.supercarousel.com
  Description: A responsive Image and Content carousel wordpress plugin
  Version: 3.0
  Author: Taraprasad Swain
  Author URI: http://www.taraprasad.com

  Copyright 2017 by Taraprasad.com (email : swain.tara@gmail.com)
  Text Domain:       supercarousel
  Domain Path:       /languages
 */
if (!defined('WPINC')) {
    die;
}

/**
 * Define Supercarousel Path and URL
 */
define('SUPER_CAROUSEL_FILE', __FILE__);
define('SUPER_CAROUSEL_PATH', plugin_dir_path(SUPER_CAROUSEL_FILE));
define('SUPER_CAROUSEL_URL', plugin_dir_url(SUPER_CAROUSEL_FILE));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-supercarousel-activator.php
 */
function activate_supercarousel() {
    require_once SUPER_CAROUSEL_PATH . 'includes/class-supercarousel-activator.php';
    SuperCarousel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-supercarousel-deactivator.php
 */
function deactivate_supercarousel() {
    require_once SUPER_CAROUSEL_PATH . 'includes/class-supercarousel-deactivator.php';
    SuperCarousel_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_supercarousel');
register_deactivation_hook(__FILE__, 'deactivate_supercarousel');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require SUPER_CAROUSEL_PATH . 'config.php';
require SUPER_CAROUSEL_PATH . 'includes/class-supercarousel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 */
function run_supercarousel() {
    $plugin = new SuperCarousel();
    $plugin->run();
}

run_supercarousel();

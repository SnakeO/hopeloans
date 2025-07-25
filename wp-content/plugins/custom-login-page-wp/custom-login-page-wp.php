<?php
/*
Plugin Name: Custom Login Page by SeedProd
Plugin URI: https://www.seedprod.com/
Description: A Realtime Custom Login Page Plugin
Version:  1.0.3
Author: SeedProd
Author URI: http://www.seedprod.com
TextDomain: custom-login-page-wp
Domain Path: /languages
License: GPLv2
Copyright 2016 SeedProd LLC (email : john@seedprod.com, twitter : @seedprod)
*/

/**
 * Default Constants
 */
define( 'SEED_CL_SHORTNAME', 'seed_cl' ); // Used to reference namespace functions.
define( 'SEED_CL_SLUG', 'custom-login-page-wp/custom-login-page-wp.php' ); // Used for settings link.
define( 'SEED_CL_TEXTDOMAIN', 'custom-login-page-wp' ); // Your textdomain
define( 'SEED_CL_PLUGIN_NAME', __( 'Custom Login Page', 'custom-login-page-wp' ) ); // Plugin Name shows up on the admin settings screen.
define( 'SEED_CL_VERSION', '1.0.3'); // Plugin Version Number.
define( 'SEED_CL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) ); // Example output: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/seed_cl/
define( 'SEED_CL_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); // Example output: http://localhost:8888/wordpress/wp-content/plugins/seed_cl/


/**
 * Load Translation
 */
function seed_cl_load_textdomain() {
    load_plugin_textdomain( 'custom-login-page-wp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'seed_cl_load_textdomain');


/**
 * Upon activation of the plugin set defaults
 */
function seed_cl_activation(){
	require_once( SEED_CL_PLUGIN_PATH.'admin/default-settings.php' );
  $seed_cl_settings_defaults = array (
    'seed_cl_settings_content' => 'a:1:{s:6:"status";s:1:"0";}',
  );


  $seed_cl_customizer_defaults = array (
    'disabled_fields' => '',
    'first_run' => '',
    'page_id' => '1',
    'logo_height' => '',
    'logo_width' => '',
    'logo' => '',
    'description' => '',
    'rich_description' => '',
    'background_color' => '#f1f1f1',
    'background_image' => '',
    'enable_background_adv_settings' => '1',
    'background_overlay' => '',
    'background_size' => 'cover',
    'background_repeat' => 'no-repeat',
    'background_position' => 'center top',
    'background_attachment' => 'fixed',
    'bg_slideshow_images' => 
    array (
      0 => '',
    ),
    'bg_slideshow_slide_speed' => '0',
    'bg_video_url' => '',
    'container_color' => '#ffffff',
    'container_radius' => '0',
    'container_position' => '0',
    'container_width' => '319',
    'container_effect_animation' => '',
    'text_color' => '#72777c',
    'button_color' => '',
    'form_color' => '',
    'text_link_color' => '',
    'text_font' => "Open Sans'",
    'text_weight' => '400',
    'text_subset' => '',
    'text_size' => '14',
    'text_line_height' => '1.50',
    'theme_css' => '',
    'theme_scripts' => '',
    'custom_css' => '',
    'social_profiles_size' => '',
    'social_profiles_blank' => '1',
    'recaptcha_site_key' => '',
    'recaptcha_secret_key' => '',
    'import_settings' => '',
    'check_mic' => 'sibilance',
  );

  add_option('seed_cl_customizer_settings',$seed_cl_customizer_defaults);
	add_option('seed_cl_settings_content',serialize($seed_cl_settings_defaults) );
}
register_activation_hook( __FILE__, 'seed_cl_activation' );



/***************************************************************************
 * Load Required Files
 ***************************************************************************/
// Global Settings Var
global $seed_cl_settings;

require_once( SEED_CL_PLUGIN_PATH.'admin/get-settings.php' );
$seed_cl_settings = seed_cl_get_settings();

// Class to render pages
require_once( SEED_CL_PLUGIN_PATH.'inc/class-seed-cl.php' );
add_action( 'plugins_loaded', array( 'SEED_CL', 'get_instance' ) );


if( is_admin() ) {
	// Admin Only
	require_once( SEED_CL_PLUGIN_PATH.'admin/config-settings.php' );
    require_once( SEED_CL_PLUGIN_PATH.'admin/admin.php' );
    // Load Admin
    add_action( 'plugins_loaded', array( 'SEED_CL_ADMIN', 'get_instance' ) );
} else {
	// Public only
}

// Welcome Page

register_activation_hook( __FILE__, 'seed_cl_welcome_screen_activate' );
function seed_cl_welcome_screen_activate() {
  set_transient( '_seed_cl_welcome_screen_activation_redirect', true, 30 );
}


add_action( 'admin_init', 'seed_cl_welcome_screen_do_activation_redirect' );
function seed_cl_welcome_screen_do_activation_redirect() {
  // Bail if no activation redirect
    if ( ! get_transient( '_seed_cl_welcome_screen_activation_redirect' ) ) {
    return;
  }

  // Delete the redirect transient
  delete_transient( '_seed_cl_welcome_screen_activation_redirect' );

  // Bail if activating from network, or bulk
  if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
    return;
  }

  // Redirect to bbPress about page
  wp_safe_redirect( add_query_arg( array( 'page' => 'seed_cl' ), admin_url( 'options-general.php' ) ) );
}


/**
 * SeedProd Functions
 */
require_once(SEED_CL_PLUGIN_PATH.'inc/functions.php');



add_action( 'admin_head', 'seed_cl_set_user_settings' );
function seed_cl_set_user_settings() {
  if(isset($_GET['page']) && $_GET['page'] == 'seed_cl'){
              $user_id = get_current_user_id();
              $options = get_user_option( 'user-settings', $user_id );
              parse_str($options,$user_settings);
              $user_settings['imgsize'] = 'full';
              update_user_option( $user_id, 'user-settings', http_build_query($user_settings), false );
              update_user_option( $user_id, 'user-settings-time', time(), false );
  }
}

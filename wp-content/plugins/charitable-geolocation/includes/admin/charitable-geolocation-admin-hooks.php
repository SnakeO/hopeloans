<?php
/**
 * Charitable Geolocation admin hooks.
 *
 * @package     Charitable Geolocation/Functions/Admin
 * @version     1.0.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2017, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Add a direct link to the Extensions settings page from the plugin row.
 *
 * @see     Charitable_Geolocation_Admin::add_plugin_action_links()
 */
add_filter( 'plugin_action_links_' . plugin_basename( charitable_geolocation()->get_path() ), array( Charitable_Geolocation_Admin::get_instance(), 'add_plugin_action_links' ) );

/**
 * Add a "Geolocation" section to the Extensions settings area of Charitable.
 *
 * @see Charitable_Geolocation_Admin::add_geolocation_settings()
 */
add_filter( 'charitable_settings_tab_fields_extensions', array( Charitable_Geolocation_Admin::get_instance(), 'add_geolocation_settings' ), 6 );

/**
 * Add a campaign location meta box to the admin editor.
 *
 * @see     Charitable_Geolocation_Admin::register_campaign_location_meta_box()
 */
add_filter( 'charitable_campaign_meta_boxes', array( Charitable_Geolocation_Admin::get_instance(), 'register_campaign_location_meta_box' ) );

/**
 * Set the view for the campaign location view.
 *
 * @see     Charitable_Geolocation_Admin::admin_view_path()
 */
add_filter( 'charitable_admin_view_path', array( Charitable_Geolocation_Admin::get_instance(), 'admin_view_path' ), 10, 3 );

/**
 * Save the campaign location.
 *
 * @see     Charitable_Geolocation_Admin::save_campaign_location()
 */
add_filter( 'charitable_campaign_meta_keys', array( Charitable_Geolocation_Admin::get_instance(), 'save_campaign_location' ) );

/**
 * Save the campaign's latitude and longitude.
 *
 * @see     Charitable_Geolocation_Admin::save_campaign_lat_long()
 */
add_action( 'charitable_campaign_save', array( Charitable_Geolocation_Admin::get_instance(), 'save_campaign_lat_long' ) );

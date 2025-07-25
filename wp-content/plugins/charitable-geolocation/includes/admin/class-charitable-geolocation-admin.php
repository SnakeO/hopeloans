<?php
/**
 * The class responsible for adding & saving extra settings in the Charitable admin.
 *
 * @package     Charitable Geolocation/Classes/Charitable_Geolocation_Admin
 * @version     1.0.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2017, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Charitable_Geolocation_Admin' ) ) :

	/**
	 * Charitable_Geolocation_Admin
	 *
	 * @since       1.0.0
	 */
	class Charitable_Geolocation_Admin {

		/**
		 * @var     Charitable_Geolocation_Admin
		 * @access  private
		 * @static
		 * @since   1.0.0
		 */
		private static $instance = null;

		/**
		 * Create class object. Private constructor.
		 *
		 * @access  private
		 * @since   1.0.0
		 */
		private function __construct() {
		}

		/**
		 * Create and return the class object.
		 *
		 * @access  public
		 * @static
		 * @since   1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new Charitable_Geolocation_Admin();
			}

			return self::$instance;
		}

		/**
		 * Add custom links to the plugin actions.
		 *
		 * @param   string[] $links
		 * @return  string[]
		 * @access  public
		 * @since   1.0.0
		 */
		public function add_plugin_action_links( $links ) {
			$links[] = '<a href="' . admin_url( 'admin.php?page=charitable-settings&tab=extensions' ) . '">' . __( 'Settings', 'charitable-geolocation' ) . '</a>';
			return $links;
		}

		/**
		 * Add settings to the Extensions settings tab.
		 *
		 * @param   array[] $fields
		 * @return  array[]
		 * @access  public
		 * @since   1.0.0
	 	*/
		public function add_geolocation_settings( $fields = array() ) {
			if ( ! charitable_is_settings_view( 'extensions' ) ) {
				return $fields;
			}

			$custom_fields = array(
				'section_geolocation' => array(
					'title'    => __( 'Geolocation', 'charitable-geolocation' ),
					'type'     => 'heading',
					'priority' => 60,
				),
				'google_places_api_key' => array(
					'title'    => __( 'Google Places API Key', 'charitable-geolocation' ),
					'type'     => 'text',
					'priority' => 62,
					'class'    => 'wide',
					'default'  => __( '', 'charitable-geolocation' ),
					'help'     => __( 'See <a href="https://www.wpcharitable.com/documentation/charitable-geolocation/" target="_blank">https://www.wpcharitable.com/documentation/charitable-geolocation/</a> for a step-by-step guide to finding your Google Places API Key.', 'charitable-geolocation' ),
				),
			);

			$fields = array_merge( $fields, $custom_fields );

			return $fields;
		}

		/**
		 * Register campaign updates section in campaign metabox.
		 *
		 * @param   array[] $meta_boxes
		 * @return  array[]
		 * @access  public
		 * @since   1.0.0
		 */
		public function register_campaign_location_meta_box( $meta_boxes ) {
			$meta_boxes[] = array(
				'id'          => 'campaign-location',
				'title'       => __( 'Location', 'charitable-geolocation' ),
				'context'     => 'campaign-advanced',
				'priority'    => 'high',
				'view'        => 'metaboxes/campaign-location',
				'view_source' => 'charitable-geolocation',
				'description' => __( 'Enter an address or location for your campaign.', 'charitable-geolocation' ),
			);

			return $meta_boxes;
		}

		/**
		 * Set the admin view path to our views folder for any of our views.
		 *
		 * @param   string  $path
		 * @param   string  $view
		 * @param   array   $view_args
		 * @return  string
		 * @access  public
		 * @since   1.0.0
		 */
		public function admin_view_path( $path, $view, $view_args ) {
			if ( isset( $view_args['view_source'] ) && 'charitable-geolocation' == $view_args['view_source'] ) {
				$path = charitable_geolocation()->get_path( 'includes' ) . 'admin/views/' . $view . '.php';
			}

			return $path;
		}

		/**
		 * Save campaign updates when saving campaign via the admin editor.
		 *
		 * @param   string[] $meta_keys
		 * @return  string[]
		 * @access  public
		 * @since   1.0.0
		 */
		public function save_campaign_location( $meta_keys ) {
			$meta_keys[] = '_campaign_location';
			return $meta_keys;
		}

		/**
		 * Saves the latitude and longtitude for the campaign.
		 *
		 * @param   WP_Post $post
		 * @return  void
		 * @access  public
		 * @since   1.0.0
		 */
		public function save_campaign_lat_long( WP_Post $post ) {

			/** 
			 * If the latitude & longitude were passed in hidden fields, 
			 * no need to get the coordinates again.
			 */
			if ( array_key_exists( '_campaign_longitude', $_POST ) && array_key_exists( '_campaign_latitude', $_POST ) ) {
				update_post_meta( $post->ID, '_campaign_longitude', $_POST['_campaign_longitude'] );
				update_post_meta( $post->ID, '_campaign_latitude', $_POST['_campaign_latitude'] );

				if ( array_key_exists( '_gmaps_place_id', $_POST ) ) {
					update_post_meta( $post->ID, '_gmaps_place_id', $_POST['_gmaps_place_id'] );
				}

				return;
			}

			$location = get_post_meta( $post->ID, '_campaign_location', true );

			if ( strlen( $location ) < 8 ) {
				update_post_meta( $post->ID, '_campaign_longitude', 0 );
				update_post_meta( $post->ID, '_campaign_latitude', 0 );
				update_post_meta( $post->ID, '_gmaps_place_id', 0 );
				return;
			}

			$coordinates = charitable_geolocation_get_coordinates_from_address( $location );

			if ( ! $coordinates || is_wp_error( $coordinates ) ) {
				return;
			}

			update_post_meta( $post->ID, '_campaign_longitude', $coordinates['long'] );
			update_post_meta( $post->ID, '_campaign_latitude', $coordinates['lat'] );
			update_post_meta( $post->ID, '_gmaps_place_id', $coordinates['place_id'] );
		}
	}

endif; // End class_exists check

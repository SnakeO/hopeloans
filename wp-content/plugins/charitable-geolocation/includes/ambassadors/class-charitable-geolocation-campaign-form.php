<?php
/**
 * The class that is responsible for adding the location field to the campaign submission form.
 *
 * @package     Charitable Geolocation/Classes/Charitable_Geolocation_Campaign_Form
 * @version     1.0.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2017, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Charitable_Geolocation_Campaign_Form' ) ) :

	/**
	 * Charitable_Geolocation_Campaign_Form
	 *
	 * @since       1.0.0
	 */
	class Charitable_Geolocation_Campaign_Form {

		/**
		 * @var     Charitable_Geolocation_Campaign_Form
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
				self::$instance = new Charitable_Geolocation_Campaign_Form();
			}

			return self::$instance;
		}

		/**
		 * Add a location field to the campaign submission form.
		 *
		 * @param   array[] $fields
		 * @param   Charitable_Ambassadors_Campaign_Form $form
		 * @return  array[]
		 * @access  public
		 * @since   1.0.0
		 */
		public function add_location_field( $fields, Charitable_Ambassadors_Campaign_Form $form ) {
			$fields['location'] = array(
				'label'     => __( 'Location', 'charitable-geolocation' ),
				'type'      => 'map',
				'priority'  => 20,
				'required'  => false,
				'fullwidth' => true,
				'value'     => $form->get_campaign_value( 'location' ),
				'latitude'  => $form->get_campaign_value( '_campaign_latitude' ),
				'longitude' => $form->get_campaign_value( '_campaign_longitude' ),
				'place_id'  => $form->get_campaign_value( '_gmaps_place_id' ),
				'data_type' => 'meta',
			);

			return $fields;
		}

		/**
		 * Save the location details.
		 *
		 * @param 	array $submitted
		 * @param 	int   $campaign_id
		 * @return  void
		 * @access  public
		 * @since   1.1.0
		 */
		public function save_campaign_location_details( $submitted, $campaign_id ) {

			/**
			 * If the latitude & longitude were passed in hidden fields,
			 * no need to get the coordinates again.
			 */
			if ( array_key_exists( '_campaign_longitude', $submitted ) && array_key_exists( '_campaign_latitude', $submitted ) ) {
				update_post_meta( $campaign_id, '_campaign_longitude', $submitted['_campaign_longitude'] );
				update_post_meta( $campaign_id, '_campaign_latitude', $submitted['_campaign_latitude'] );

				if ( array_key_exists( '_gmaps_place_id', $submitted ) ) {
					update_post_meta( $campaign_id, '_gmaps_place_id', $submitted['_gmaps_place_id'] );
				}

				return;
			}

			$location = get_post_meta( $campaign_id, '_campaign_location', true );

			if ( strlen( $location ) < 8 ) {
				update_post_meta( $campaign_id, '_campaign_longitude', 0 );
				update_post_meta( $campaign_id, '_campaign_latitude', 0 );
				update_post_meta( $campaign_id, '_gmaps_place_id', 0 );
				return;
			}

			$coordinates = charitable_geolocation_get_coordinates_from_address( $location );

			if ( ! $coordinates || is_wp_error( $coordinates ) ) {
				return;
			}

			update_post_meta( $campaign_id, '_campaign_longitude', $coordinates['long'] );
			update_post_meta( $campaign_id, '_campaign_latitude', $coordinates['lat'] );
			update_post_meta( $campaign_id, '_gmaps_place_id', $coordinates['place_id'] );

		}
	}

endif; // End class_exists check

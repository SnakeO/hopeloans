<?php
/**
 * Charitable Geolocation template
 *
 * @version     1.0.0
 * @package     Charitable Geolocation/Classes/Charitable_Geolocation_Template
 * @author      Eric Daams
 * @copyright   Copyright (c) 2017, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Charitable_Geolocation_Template' ) ) :

	/**
	 * Charitable_Geolocation_Template
	 *
	 * @since       1.0.0
	 */
	class Charitable_Geolocation_Template extends Charitable_Template {

		/**
		 * Set theme template path.
		 *
		 * @return  string
		 * @access  public
		 * @since   1.0.0
		 */
		public function get_theme_template_path() {
			return trailingslashit( apply_filters( 'charitable_geolocation_theme_template_path', 'charitable/charitable-geolocation' ) );
		}

		/**
		 * Return the base template path.
		 *
		 * @return  string
		 * @access  public
		 * @since   1.0.0
		 */
		public function get_base_template_path() {
			return charitable_geolocation()->get_path( 'templates' );
		}
	}

endif;

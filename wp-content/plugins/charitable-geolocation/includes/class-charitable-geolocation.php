<?php
/**
 * The main Charitable Geolocation class.
 *
 * The responsibility of this class is to load all the plugin's functionality.
 *
 * @package   Charitable Geolocation
 * @copyright Copyright (c) 2017, Eric Daams
 * @license   http://opensource.org/licenses/gpl-1.0.0.php GNU Public License
 * @since     1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Charitable_Geolocation' ) ) :

	/**
	 * Charitable_Geolocation
	 *
	 * @since   1.0.0
	 */
	class Charitable_Geolocation {

		/**
		 * @var string
		 */
		const VERSION = '1.1.4';

		/**
		 * @var string  A date in the format: YYYYMMDD
		 */
		const DB_VERSION = '20151021';

		/**
		 * @var string The product name.
		 */
		const NAME = 'Charitable Geolocation';

		/**
		 * @var string The product author.
		 */
		const AUTHOR = 'Studio 164a';

		/**
	 * @var Charitable_Geolocation
	 */
		private static $instance = null;

		/**
		 * The root file of the plugin.
		 *
		 * @var     string
		 * @access  private
		 */
		private $plugin_file;

		/**
		 * The root directory of the plugin.
		 *
		 * @var     string
		 * @access  private
		 */
		private $directory_path;

		/**
		 * The root directory of the plugin as a URL.
		 *
		 * @var     string
		 * @access  private
		 */
		private $directory_url;

		/**
		 * Create class instance.
		 *
		 * @return  void
		 * @since   1.0.0
		 */
		public function __construct( $plugin_file ) {
			$this->plugin_file      = $plugin_file;
			$this->directory_path   = plugin_dir_path( $plugin_file );
			$this->directory_url    = plugin_dir_url( $plugin_file );

			add_action( 'charitable_start', array( $this, 'start' ), 6 );
		}

		/**
		 * Returns the original instance of this class.
		 *
		 * @return  Charitable
		 * @since   1.0.0
		 */
		public static function get_instance() {
			return self::$instance;
		}

		/**
		 * Run the startup sequence on the charitable_start hook.
		 *
		 * This is only ever executed once.
		 *
		 * @return  void
		 * @access  public
		 * @since   1.0.0
		 */
		public function start() {
			// If we've already started (i.e. run this function once before), do not pass go.
			if ( $this->started() ) {
				return;
			}

			// Set static instance
			self::$instance = $this;

			$this->load_dependencies();

			$this->maybe_start_admin();

			$this->maybe_start_public();

			$this->maybe_start_ambassadors();

			$this->attach_hooks_and_filters();

			$this->setup_licensing();

			$this->setup_i18n();

			// Hook in here to do something when the plugin is first loaded.
			do_action( 'charitable_geolocation_start', $this );
		}

		/**
		 * Include necessary files.
		 *
		 * @return  void
		 * @access  private
		 * @since   1.0.0
		 */
		private function load_dependencies() {
			require_once( $this->get_path( 'includes' ) . 'charitable-geolocation-core-functions.php' );
		}

		/**
		 * Load the admin-only functionality.
		 *
		 * @return  void
		 * @access  private
		 * @since   1.0.0
		 */
		private function maybe_start_admin() {
			if ( ! is_admin() ) {
				return;
			}

			require_once( $this->get_path( 'includes' ) . 'admin/class-charitable-geolocation-admin.php' );
			require_once( $this->get_path( 'includes' ) . 'admin/charitable-geolocation-admin-hooks.php' );
		}

		/**
		 * Load the public-only functionality.
		 *
		 * @return 	void
		 * @access 	private
		 * @since 	1.0.0
		 */
		private function maybe_start_public() {
			require_once( $this->get_path( 'includes' ) . 'public/class-charitable-geolocation-template.php' );
			require_once( $this->get_path( 'includes' ) . 'public/charitable-geolocation-template-hooks.php' );
			require_once( $this->get_path( 'includes' ) . 'public/charitable-geolocation-template-functions.php' );
		}

		/**
		 * Load up the Ambassadors integration if Ambassadors is installed.
		 *
		 * @return  void
		 * @access  private
		 * @since   1.0.0
		 */
		private function maybe_start_ambassadors() {
			if ( ! class_exists( 'Charitable_Ambassadors' ) ) {
				return;
			}

			require_once( $this->get_path( 'includes' ) . 'ambassadors/class-charitable-geolocation-campaign-form.php'
			);
			require_once( $this->get_path( 'includes' ) . 'ambassadors/charitable-geolocation-campaign-form-hooks.php' );
		}

		/**
		 * Set up hook and filter callback functions.
		 *
		 * @return  void
		 * @access  private
		 * @since   1.0.0
		 */
		private function attach_hooks_and_filters() {
			add_action( 'wp_enqueue_scripts', array( $this, 'setup_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'setup_scripts' ) );
			add_filter( 'shortcode_atts_campaigns', array( $this, 'add_map_attribute_to_campaigns_shortcode' ), 10, 3 );
			add_filter( 'charitable_campaigns_shortcode_template', array( $this, 'campaigns_map_template' ), 10, 2 );
			add_filter( 'charitable_campaigns_shortcode_view_args', array( $this, 'send_map_args_to_template' ), 10, 2 );
			add_filter( 'charitable_form_field_template', array( $this, 'map_form_field_template' ), 10, 2 );
		}

		/**
		 * Set up licensing for the extension.
		 *
		 * @return  void
		 * @access  private
		 * @since   1.0.0
		 */
		private function setup_licensing() {
			charitable_get_helper( 'licenses' )->register_licensed_product(
				Charitable_Geolocation::NAME,
				Charitable_Geolocation::AUTHOR,
				Charitable_Geolocation::VERSION,
				$this->plugin_file
			);
		}

		/**
		 * Set up the internationalisation for the plugin.
		 *
		 * @return  void
		 * @access  private
		 * @since   1.0.0
		 */
		private function setup_i18n() {
			if ( class_exists( 'Charitable_i18n' ) ) {

				require_once( $this->get_path( 'includes' ) . 'i18n/class-charitable-geolocation-i18n.php' );

				Charitable_Geolocation_i18n::get_instance();
			}
		}

		/**
		 * Register the Google Map scripts.
		 *
		 * @return  void
		 * @access  public
		 * @since   1.0.0
		 */
		public function setup_scripts() {
			$assets    = $this->get_path( 'directory', false ) . 'assets';
			$api_key   = charitable_get_option( 'google_places_api_key' );
			$gmaps_api = 'https://maps.googleapis.com/maps/api/js';

			if ( $api_key ) {
				$gmaps_api .= '?key=' . $api_key . '&libraries=places';
			}

			if ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) {
				$suffix  = '';
				$version = time();
				$version = '';
			} else {
				$suffix  = '.min';
				$version = $this->get_version();
			}

			wp_register_script(
				'google-maps',
				$gmaps_api,
				array(),
				'3',
				false
			);

			wp_register_script(
				'google-maps-markerclusterer',
				$assets . '/js/libraries/markerclusterer' . $suffix . '.js',
				array( 'google-maps' ), 
				'1.0.1'
			);

			wp_register_script(
				'charitable-geolocation',
				$assets . '/js/charitable-geolocation' . $suffix . '.js',
				array( 'google-maps', 'google-maps-markerclusterer' ), 
				$version
			);

			ob_start();

			charitable_geolocation_template( 'map-marker.php' );

			$marker = ob_get_clean();

			$args = apply_filters( 'charitable_geolocation_map_args', array(
				'marker'       			  => $marker,
				'default_lat'  			  => $this->get_default_lat(),
				'default_long' 			  => $this->get_default_long(),
				'default_zoom' 			  => 2,
				'markerclusterer_options' => json_encode( array( 
					'gridSize'  => 50,
					'maxZoom'   => 15,
					'imagePath' => $this->get_path( 'directory', false ) . 'assets/images/m',
            	), JSON_FORCE_OBJECT ),
			) );

			wp_localize_script(
				'charitable-geolocation',
				'CHARITABLE_GEOLOCATION',
				$args
			);

			wp_register_style(
				'charitable-geolocation-map',
				$assets . '/css/charitable-geolocation-map' . $suffix . '.css',
				$version
			);

			wp_enqueue_style( 'charitable-geolocation-map' );
		}

		/**
		 * Include extra attributes in the campaigns shortcode.
		 *
		 * @param   string[] $out The output array of shortcode attributes.
		 * @param   string[] $pairs The supported attributes and their defaults.
		 * @param   string[] $atts The user defined shortcode attributes.
		 * @return  string[]
		 * @access  public
		 * @since   1.0.0
		 */
		public function add_map_attribute_to_campaigns_shortcode( $out, $pairs, $atts ) {
			$out['map']    = isset( $atts['map'] ) ? $atts['map'] : 0;
			$out['zoom']   = isset( $atts['zoom'] ) ? $atts['zoom'] : 'auto';
			$out['width']  = isset( $atts['width'] ) ? $atts['width'] : '100%';
			$out['height'] = isset( $atts['height'] ) ? $atts['height'] : '500px';

			return $out;
		}

		/**
		 * Use our Campaigns Map template for the [campaigns] shortcode when map is set to true.
		 *
		 * @param   false|Charitable_Geolocation_Template $template
		 * @param   string[] 							  $args
		 * @return  false|Charitable_Geolocation_Template
		 * @access  public
		 * @since   1.0.0
		 */
		public function campaigns_map_template( $template, $args ) {
			if ( $args['map'] ) {
				$template = new Charitable_Geolocation_Template( 'shortcodes/campaigns-map.php', false );
			}

			return $template;
		}

		/**
		 * Pass the zoom, width and height arguments through to the template.
		 *
		 * @param   mixed[] $view_args
		 * @param   mixed[] $args
		 * @return  mixed[]
		 * @access  public
		 * @since   1.0.0
		 */
		public function send_map_args_to_template( $view_args, $args ) {
			$view_args['zoom']   = $args['zoom'];
			$view_args['width']  = $args['width'];
			$view_args['height'] = $args['height'];

			return $view_args;
		}

		/**
		 * Define our custom 'map' form field.
		 *
		 * @return  Charitable_Template|false
		 * @access  public
		 * @since   1.1.0
		 */
		public function map_form_field_template( $template, $field ) {
			if ( 'map' != $field['type'] ) {
				return $template;
			}

			return new Charitable_Geolocation_Template( 'form-fields/map.php', false );
		}

		/**
		 * Get default coordinates for maps. Based on the 'country' setting in Charitable.
		 *
		 * @return  false|array
		 * @access  public
		 * @since   1.0.0
		 */
		public function get_default_coordinates() {
			$coordinates = charitable_get_option( 'geolocation_default_coordinates' );
			$countries   = charitable_get_location_helper()->get_countries();
			$country     = $countries[ charitable_get_option( 'country', 'AU' ) ];

			if ( ! $coordinates ) {
				$countries   = charitable_get_location_helper()->get_countries();
				$country     = $countries[ charitable_get_option( 'country', 'AU' ) ];
				$coordinates = charitable_geolocation_get_coordinates_from_address( $country );

				if ( is_array( $coordinates ) ) {
					$options 									= get_option( 'charitable_settings' );
					$options['geolocation_default_coordinates'] = $coordinates;

					update_option( 'charitable_settings', $options );
				}				
			}

			return $coordinates;				
		}

		/**
		 * Get default latitude for maps. Based on the 'country' setting in Charitable.
		 *
		 * @return  int
		 * @access  public
		 * @since   1.0.0
		 */
		public function get_default_lat() {
			$coordinates = $this->get_default_coordinates();

			return is_array( $coordinates ) ? $coordinates['lat'] : 0;
		}

		/**
		 * Get default longtitude for maps. Based on the 'country' setting in Charitable.
		 *
		 * @return  int
		 * @access  public
		 * @since   1.0.0
		 */
		public function get_default_long() {
			$coordinates = $this->get_default_coordinates();
			
			return is_array( $coordinates ) ? $coordinates['long'] : 0;
		}

		/**
		 * Returns whether we are currently in the start phase of the plugin.
		 *
		 * @return  bool
		 * @access  public
		 * @since   1.0.0
		 */
		public function is_start() {
			return current_filter() == 'charitable_geolocation_start';
		}

		/**
		 * Returns whether the plugin has already started.
		 *
		 * @return  bool
		 * @access  public
		 * @since   1.0.0
		 */
		public function started() {
			return did_action( 'charitable_geolocation_start' ) || current_filter() == 'charitable_geolocation_start';
		}

		/**
		 * Returns the plugin's version number.
		 *
		 * @return  string
		 * @access  public
		 * @since   1.0.0
		 */
		public function get_version() {
			return self::VERSION;
		}

		/**
		 * Returns plugin paths.
		 *
		 * @param   string $path            // If empty, returns the path to the plugin.
		 * @param   bool $absolute_path     // If true, returns the file system path. If false, returns it as a URL.
		 * @return  string
		 * @since   1.0.0
		 */
		public function get_path( $type = '', $absolute_path = true ) {
			$base = $absolute_path ? $this->directory_path : $this->directory_url;

			switch ( $type ) {
				case 'includes' :
					$path = $base . 'includes/';
					break;

				case 'templates' :
					$path = $base . 'templates/';
					break;

				case 'directory' :
					$path = $base;
					break;

				default :
					$path = $this->plugin_file;
			}

			return $path;
		}

		/**
		 * Throw error on object clone.
		 *
		 * This class is specifically designed to be instantiated once. You can retrieve the instance using charitable()
		 *
		 * @since   1.0.0
		 * @access  public
		 * @return  void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'charitable-geolocation' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @return  void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'charitable-geolocation' ), '1.0.0' );
		}
	}

endif; // End if class_exists check

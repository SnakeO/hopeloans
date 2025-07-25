<?php
/*
Plugin Name:    Google Maps PLUS for Visual Composer
Plugin URI:     https://codecanyon.net/item/google-maps-plus-for-visual-composer/13510102
Version:        2.1.0
Description:    A plugin to add an advanced Google Maps element to Visual Composer, allowing for multiple markers, overlays, filter options, JSON import, and much more
Author:         Tekanewa Scripts by Kraut Coding
Author URI:     http://www.googlemapsvc.krautcoding.com
Text Domain:    ts_visual_composer_extend
Domain Path:	/locale
*/


// Do NOT Load Directly
// --------------------
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
if (!defined('ABSPATH')) exit;


// Define Global Variables
// -----------------------
if (!defined('GOOGLEMAPS_VCEXTENSIONS')){
	define('GOOGLEMAPS_VCEXTENSIONS', 		dirname(__FILE__));
}
if (!defined('GOOGLEMAPS_VCVERSION')){
	define('GOOGLEMAPS_VCVERSION', 			'2.1.0');
}
if (!defined('GOOGLEMAPS_VCSLUG')){
	define('GOOGLEMAPS_VCSLUG', 			plugin_basename(__FILE__));
}
if (!defined('GOOGLEMAPS_NAME')){
	define('GOOGLEMAPS_NAME', 				'Google Maps PLUS for Visual Composer');
}


// Ensure that Function for Network Activate is Ready
// --------------------------------------------------
if (!function_exists('is_plugin_active_for_network')) {
	require_once(ABSPATH . '/wp-admin/includes/plugin.php');
}


// Functions that need to be available immediately
// -----------------------------------------------
if (!function_exists('TS_GMVC_GetResourceURL')){
	function TS_GMVC_GetResourceURL($relativePath){
		return plugins_url($relativePath, plugin_basename(__FILE__));
	}
}
if (!function_exists('TS_GMVC_WordPressCheckup')) {
	function TS_GMVC_WordPressCheckup($version = '3.8') {
		global $wp_version;		
		if (version_compare($wp_version, $version, '>=')) {
			return "true";
		} else {
			return "false";
		}
	}
}
if (!function_exists('TS_GMVC_IsEditPagePost')){
	function TS_GMVC_IsEditPagePost($new_edit = null){
		global $pagenow, $typenow;
		$frontend = TS_GMVC_CheckFrontEndEditor();
		if (function_exists('vc_is_inline')){
			$vc_is_inline = vc_is_inline();
			if ((vc_is_inline() == false) && (vc_is_inline() != '') && (vc_is_inline() != true) && (!is_admin())) {
				return false;
			} else if ((vc_is_inline() == true) && (vc_is_inline() != '') && (vc_is_inline() != true) && (!is_admin())) {
				return true;
			} else if (((vc_is_inline() == NULL) || (vc_is_inline() == '')) && (!is_admin())) {
				if ($frontend == true) {
					$vc_is_inline = true;
					return true;
				} else {
					$vc_is_inline = false;
					return false;
				}
			}
		} else {
			$vc_is_inline = false;
			if (!is_admin()) return false;
		}
		if (($frontend == true) && (!is_admin())) {
			return true;
		} else if ($new_edit == "edit") {
			return in_array($pagenow, array('post.php'));
		} else if ($new_edit == "new") {
			return in_array($pagenow, array('post-new.php'));
		} else if ($vc_is_inline == true) {
			return true;
		} else {
			return in_array($pagenow, array('post.php', 'post-new.php'));
		}
	}
}
if (!function_exists('TS_GMVC_CheckFrontEndEditor')){
	function TS_GMVC_CheckFrontEndEditor() {
		$url 		= 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		if ((strpos($url, "vc_editable=true") !== false) || (strpos($url, "vc_action=vc_inline") !== false)) {
			return true;
		} else {
			return false;
		}
	}
}
if (!function_exists('TS_GMVC_GetPluginVersion')){
	function TS_GMVC_GetPluginVersion() {
		$plugin_data 		= get_plugin_data( __FILE__ );
		$plugin_version 	= $plugin_data['Version'];
		return $plugin_version;
	}
}
if (!function_exists('TS_GMVC_VersionCompare')){
	function TS_GMVC_VersionCompare($a, $b) {
		//Compare two sets of versions, where major/minor/etc. releases are separated by dots. 
		//Returns 0 if both are equal, 1 if A > B, and -1 if B < A. 
		$a = explode(".", TS_GMVC_CustomSTRrTrim($a, ".0")); //Split version into pieces and remove trailing .0 
		$b = explode(".", TS_GMVC_CustomSTRrTrim($b, ".0")); //Split version into pieces and remove trailing .0 
		//Iterate over each piece of A 
		foreach ($a as $depth => $aVal) {
			if (isset($b[$depth])) {
			//If B matches A to this depth, compare the values 
				if ($aVal > $b[$depth]) {
					return 1; //Return A > B
					//break;
				} else if ($aVal < $b[$depth]) {
					return -1; //Return B > A
					//break;
				}
			//An equal result is inconclusive at this point 
			} else  {
				//If B does not match A to this depth, then A comes after B in sort order 
				return 1; //so return A > B
				//break;
			} 
		} 
		//At this point, we know that to the depth that A and B extend to, they are equivalent. 
		//Either the loop ended because A is shorter than B, or both are equal. 
		return (count($a) < count($b)) ? -1 : 0; 
	}
}
if (!function_exists('TS_GMVC_CustomSTRrTrim')){
	function TS_GMVC_CustomSTRrTrim($message, $strip) {
		$lines = explode($strip, $message); 
		$last  = ''; 
		do { 
			$last = array_pop($lines); 
		} while (empty($last) && (count($lines)));
		return implode($strip, array_merge($lines, array($last))); 
	}
}


// Main Class for Advanced Google Maps for Visual Composer
// -------------------------------------------------------
if (!class_exists("GOOGLEMAPS_PLUS_VC")) {
	// Register / Remove Plugin Settings on Plugin Activation / Removal
	// ----------------------------------------------------------------
	require_once('assets/ts_gmvc_registerplugin.php');
	
	// Load Global Helper Functions
	// ----------------------------
	require_once('assets/ts_gmvc_registerfunctions.php');
	
	// WordPres Register Hooks
	// -----------------------
	register_activation_hook(__FILE__, 					array('GOOGLEMAPS_PLUS_VC', 		'TS_GMVC_On_Activation'));
	register_deactivation_hook(__FILE__, 				array('GOOGLEMAPS_PLUS_VC', 		'TS_GMVC_On_Deactivation'));
	register_uninstall_hook(__FILE__, 					array('GOOGLEMAPS_PLUS_VC', 		'TS_GMVC_On_Uninstall'));
	
	// Create Plugin Class
	// -------------------
	class GOOGLEMAPS_PLUS_VC {	
		
		// Functions for Plugin Activation / Deactivation / Uninstall
		// ----------------------------------------------------------
		public static function TS_GMVC_On_Activation($network_wide) {
			if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];
			global $wpdb;
			if (!current_user_can('activate_plugins')) {
				return;
			}	
			if (function_exists('is_multisite') && is_multisite()) {
				// Check if it is a Network Activation - if so, run the Activation Function for each Blog ID
				if ($network_wide) {
					$old_blog = $wpdb->blogid;
					// Get all Blog ID's
					$blogids = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");
					foreach ($blogids as $blog_id) {
						switch_to_blog($blog_id);
						TS_GMVC_Callback_Activation();
					}
					switch_to_blog($old_blog);
					return;
				}	
			} 
			TS_GMVC_Callback_Activation();
		}	
		public static function TS_GMVC_On_Deactivation($network_wide) {
			if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];
			global $wpdb;
			if (!current_user_can('activate_plugins')) {
				return;
			}
		}
		public static function TS_GMVC_On_Uninstall($network_wide) {
			if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];
			global $wpdb;
			if (!current_user_can('activate_plugins')) {
				return;
			}
			if ( __FILE__ != WP_UNINSTALL_PLUGIN) {
				return;
			}
			if (function_exists('is_multisite') && is_multisite()) {
				if ($network_wide) {
					$old_blog 	= $wpdb->blogid;
					$blogids 	= $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
					foreach ($blogids as $blog_id) {
						switch_to_blog($blog_id);
						TS_GMVC_Callback_Uninstall();
					}
					switch_to_blog($old_blog);
					return;
				}
			}
			TS_GMVC_Callback_Uninstall();
		}
		
		
		// Define Global Plugin Variables
		// ------------------------------
		public $TS_GMVC_ComposiumStandard				= "false";
		public $TS_GMVC_VCFrontEditMode					= "false";
		public $TS_GMVC_VCStandardEditMode				= "false";
		public $TS_GMVC_VisualComposer_LeanMap			= "false";
		public $TS_GMVC_VisualComposer_Version			= "";
		public $TS_GMVC_VisualComposer_Element			= array();
		public $TS_GMVC_ParameterLinkPicker				= array();
		public $TS_GMVC_ComposerParameters				= array();
		public $TS_GMVC_PluginSlug						= "";
		public $TS_GMVC_PluginPath						= "";
		public $TS_GMVC_PluginDir						= "";
		public $TS_GMVC_PluginAJAX						= "false";
		public $TS_GMVC_PluginAlways					= "false";
		public $TS_GMVC_UseExtendedNesting				= "false";
		

		// Class Constructor Routine
		// -------------------------
		function __construct() {
			$this->assets_js 								= plugin_dir_path( __FILE__ ) . 'js/';
			$this->assets_css 								= plugin_dir_path( __FILE__ ) . 'css/';
			$this->assets_dir 								= plugin_dir_path( __FILE__ ) . 'assets/';
			$this->images_dir 								= plugin_dir_path( __FILE__ ) . 'images/';
			$this->parameters_dir 							= plugin_dir_path( __FILE__ ) . 'parameters/';
			
			$this->TS_GMVC_PluginSlug						= plugin_basename(__FILE__);
			$this->TS_GMVC_PluginPath						= plugin_dir_url(__FILE__);
			$this->TS_GMVC_PluginDir 						= plugin_dir_path( __FILE__ );

			// Check for Visual Composer Version
			// ---------------------------------
			if (defined('WPB_VC_VERSION')){
				$this->TS_GMVC_VisualComposer_Version		= WPB_VC_VERSION;
				if ((TS_GMVC_VersionCompare(WPB_VC_VERSION, '4.9.0') >= 0) && (function_exists('vc_lean_map'))) {
					$this->TS_GMVC_VisualComposer_LeanMap	= "true";
				} else {
					$this->TS_GMVC_VisualComposer_LeanMap	= "false";
				}
			} else {
				$this->TS_GMVC_VisualComposer_LeanMap		= "false";
			}
			
			// Check for Standalone Composium Plugin
			// -------------------------------------
			if ((in_array('ts-visual-composer-extend/ts-visual-composer-extend.php', apply_filters('active_plugins', get_option('active_plugins')))) || (class_exists('VISUAL_COMPOSER_EXTENSIONS'))) {
				$this->TS_GMVC_ComposiumStandard			= "true";
			} else {
				$this->TS_GMVC_ComposiumStandard			= "false";
			}				
			
			// Add Additional Links to Plugin Listing Page
			// -------------------------------------------
			$plugin 										= plugin_basename( __FILE__ );
			add_filter("plugin_action_links_$plugin", 		array($this,		"TS_GMVC_PluginAddSettingsLink"));
			
			// Create Plugin Settings Menu Item
			// --------------------------------
			add_action('admin_menu', 						array($this,		'TS_GMVC_RegisterMenu'));	
		
			// Proceed Only If No Active "Composium" Plugin
			// --------------------------------------------
			if ($this->TS_GMVC_ComposiumStandard == "false") {				
				require_once($this->assets_dir . 'ts_gmvc_registervariables.php');
				
				// Determine Loading + Element Statuses
				// ------------------------------------
				add_action('init',							array($this, 		'TS_GMVC_DetermineLoadingStatus'),			1);
				
				// Load Language / Translation Files
				// ---------------------------------
				if ((get_option('ts_vcsc_extend_settings_translationsDomain', 1) == 1) && (substr(get_bloginfo('language'), 0, 2) != "en")) {
					add_action('init',						array($this, 		'TS_GMVC_LoadTextDomains'), 				9);
				}
				
				// Function to Register / Load External Files on Back-End
				// ------------------------------------------------------
				add_action('admin_enqueue_scripts', 		array($this, 		'TS_GMVC_Admin_Files'),						999999999);
				if (($this->TS_GMVC_ParameterLinkPicker['enabled'] == "true") && ($this->TS_GMVC_ParameterLinkPicker['global'] == "true")) {
					add_action('admin_footer',				array($this, 		'TS_GMVC_Admin_Footer'));
				}
				
				// Function to Register / Load External Files on Front-End
				// -------------------------------------------------------
				add_action('wp_enqueue_scripts', 			array($this, 		'TS_GMVC_Front_Main'), 						999999999);				
				
				// Register Elements + Shortcodes
				// ------------------------------
				add_action('init',							array($this, 		'TS_GMVC_RegisterWithComposer'), 			999999999);
				//add_action('after_setup_theme',			array($this,		'TS_GMVC_RegisterWithComposer'));
				//add_action('vc_before_init',				array($this, 		'TS_GMVC_RegisterWithComposer'), 			999999999);
				
				// Register AJAX Callbacks
				// -----------------------
				add_action('wp_ajax_ts_getpostspages',		array($this, 		'TS_GMVC_GetPostsPages_Ajax'));
			} else {
				// Function to Register / Load External Files on Back-End
				// ------------------------------------------------------
				add_action('admin_enqueue_scripts', 		array($this, 		'TS_GMVC_Admin_Files'),						999999999);
			}
		}
			
		// Load Language Domain
		// --------------------
		function TS_GMVC_LoadTextDomains(){
			if (($this->TS_GMVC_VCFrontEditMode == "true") || ($this->TS_GMVC_VisualComposer_Loading == "true")) {
				load_plugin_textdomain('ts_visual_composer_extend', false, dirname(plugin_basename( __FILE__ )) . '/locale');
			}
		}		
		
		// Add additional "Settings" Link to Plugin Listing Page
		// -----------------------------------------------------
		function TS_GMVC_PluginAddSettingsLink($links) {
			if (current_user_can('manage_options')) {
				$links[] = '<a href="options-general.php?page=TS_GMVC_Settings" target="_parent">' . __( "Settings", "ts_visual_composer_extend" ) . '</a>';
			}
			$links[] = '<a href="http://www.googlemapsvc.krautcoding.com/documentation" target="_blank">' . __( "Documentation", "ts_visual_composer_extend" ) . '</a>';
			$links[] = '<a href="http://helpdesk.krautcoding.com/changelog-google-maps-for-visual-composer/" target="_blank">' . __( "Changelog", "ts_visual_composer_extend" ) . '</a>';
			return $links;
		}		
		
		// Register Settings Page
		// ----------------------
		function TS_GMVC_RegisterMenu() {
			global $ts_gmvc_settings_page;
			$ts_gmvc_settings_page = add_options_page("Google Maps for VC", "Google Maps for VC", 'manage_options', 'TS_GMVC_Settings', array($this,'TS_GMVC_RenderSettingsPage'));
		}		
		
		// Register CSS + JS Files
		// -----------------------
		function TS_GMVC_RegisterFiles() {
			require_once($this->assets_dir . 'ts_gmvc_registerfiles.php');
		}		
		
		// Load Files in Admin Sections
		// ----------------------------
		function TS_GMVC_Admin_Files($hook_suffix) {
			global $pagenow, $typenow;
			$screen 		= get_current_screen();
			require_once($this->assets_dir . 'ts_gmvc_registerfiles.php');
			if (empty($typenow) && !empty($_GET['post'])) {
				$post 		= get_post($_GET['post']);
				$typenow 	= $post->post_type;
			}
			$url			= plugin_dir_url( __FILE__ );
			// Files to be loaded on VC Settings Page
			if (($pagenow == "admin.php") && $screen != '' && $screen != "false" && $screen != false && $screen->id == "visual-composer_page_vc-roles") {
				if ($this->TS_GMVC_ComposiumStandard == "false") {
					wp_enqueue_style('ts-googlemapsvc-composer');
				}
			}
			// Files to be loaded with Visual Composer
			if ((TS_GMVC_IsEditPagePost()) && (($this->TS_GMVC_ComposiumStandard == "false"))) {
				wp_enqueue_style('dashicons');
				wp_enqueue_style('ts-extend-nouislider');				
				wp_enqueue_script('ts-extend-nouislider');
				wp_enqueue_style('ts-extend-multiselect');
				wp_enqueue_script('ts-extend-multiselect');
				wp_enqueue_style('ts-extend-preloaders');
				wp_enqueue_style('ts-font-mapmarker');
				wp_enqueue_script('ts-extend-iconpicker');
				wp_enqueue_style('ts-extend-iconpicker');
				wp_enqueue_script('ts-googlemapsvc-parameters');
				wp_enqueue_style('ts-googlemapsvc-parameters');
				wp_enqueue_style('ts-googlemapsvc-composer');
			}
			// Settings Page Files
			global $ts_gmvc_settings_page;
			if ($ts_gmvc_settings_page == $hook_suffix) {
				wp_enqueue_style('dashicons');
				wp_enqueue_style('ts-extend-nouislider');
				wp_enqueue_script('ts-extend-nouislider');
				wp_enqueue_style('ts-extend-sweetalert');
				wp_enqueue_script('ts-extend-sweetalert');
				wp_enqueue_style('ts-extend-preloaders');
				wp_enqueue_script('validation-engine');
				wp_enqueue_style('validation-engine');
				wp_enqueue_script('validation-engine-en');
				wp_enqueue_style('ts-googlemapsvc-buttons');
				wp_enqueue_style('ts-googlemapsvc-settings');
				wp_enqueue_script('ts-googlemapsvc-settings');
			}
		}
		function TS_GMVC_Admin_Footer() {
			if (TS_GMVC_IsEditPagePost()) {
				$randomizer         = mt_rand(999999, 9999999);
                $totalPages         = wp_count_posts('page')->publish;
                $totalPosts         = wp_count_posts('post')->publish;
                $totalCustom        = 0;
                // Get Custom Post Types
				if ($this->TS_GMVC_ParameterLinkPicker['custom'] == "true") {
					$args = array(
					   'public'                 => true,
					   'publicly_queryable'     => true,
					   'exclude_from_search'    => false,
					   '_builtin'               => false
					);
					$availableTypes	= get_post_types($args, 'names', 'and');
				}
				// Create Output
				$output 			= '';
				$output .= '<div class="ts-advancedbackup-wrapper" style="display: none !important; visibility: hidden !important; width: 0; height: 0; margin: 0; padding: 0; border: none;">';
					// Starter Pages Listing
					$availablePages	= TS_GMVC_GetPostOptions(array('post_type' => 'page', 'posts_per_page' => $this->TS_GMVC_ParameterLinkPicker['offset'], 'offset' => 0, 'orderby' => $this->TS_GMVC_ParameterLinkPicker['orderby'], 'order' => $this->TS_GMVC_ParameterLinkPicker['order']));
					//TS_GMVC_SortMultiArray($availablePages, 'name');
					$output .= '<ul name="ts-advancedbackup-pages-' . $randomizer . '" id="ts-advancedbackup-pages-' . $randomizer . '" class="ts-advancedbackup-scroller ts-advancedbackup-pages" data-requests="0" data-offset="0" data-current="' . count($availablePages) . '" data-total="' . $totalPages . '">';
						foreach ($availablePages as $page) {
							$output .= '<li class="" data-link="' . $page['link'] . '" data-name="' . $page['name'] . '" data-id="' . $page['value'] . '">';
								$output .= '' . $page['name'] . ' (' . $page['value'] . ')';
							$output .= '</li>';
						}
					$output .= '</ul>';
					// Starter Posts Listing
					if ($this->TS_GMVC_ParameterLinkPicker['posts'] == "true") {
						$availablePosts	= TS_GMVC_GetPostOptions(array('post_type' => 'post', 'posts_per_page' => $this->TS_GMVC_ParameterLinkPicker['offset'], 'offset' => 0, 'orderby' => $this->TS_GMVC_ParameterLinkPicker['orderby'], 'order' => $this->TS_GMVC_ParameterLinkPicker['order']));
						//TS_GMVC_SortMultiArray($availablePosts, 'name');
						$output .= '<ul name="ts-advancedbackup-posts-' . $randomizer . '" id="ts-advancedbackup-posts-' . $randomizer . '" class="ts-advancedbackup-scroller ts-advancedbackup-posts" data-requests="0" data-offset="0" data-current="' . count($availablePosts) . '" data-total="' . $totalPosts . '">';
							foreach ($availablePosts as $post) {
								$output .= '<li class="" data-link="' . $post['link'] . '" data-name="' . $post['name'] . '" data-id="' . $post['value'] . '">';
									$output .= '' . $post['name'] . ' (' . $post['value'] . ')';
								$output .= '</li>';
							}
						$output .= '</ul>';
					}
					// Starter Custom Listing
					if ($this->TS_GMVC_ParameterLinkPicker['custom'] == "true") {
						$availableCustom    = array();
						$availableRequest   = array();
						if (count($availableTypes) > 0) {
							foreach ($availableTypes as $type) {
								$totalCustom        = $totalCustom + wp_count_posts($type)->publish;
								$availableRequest   = TS_GMVC_GetPostOptions(array('post_type' => $type, 'posts_per_page' => $this->TS_GMVC_ParameterLinkPicker['offset'], 'offset' => 0, 'orderby' => $this->TS_GMVC_ParameterLinkPicker['orderby'], 'order' => $this->TS_GMVC_ParameterLinkPicker['order']));
								$availableCustom    = array_merge($availableCustom, $availableRequest);
							}
							//TS_GMVC_SortMultiArray($availableCustom, 'name');
							$output .= '<ul name="ts-advancedbackup-custom-' . $randomizer . '" id="ts-advancedbackup-custom-' . $randomizer . '" class="ts-advancedbackup-scroller ts-advancedbackup-custom" data-requests="0" data-offset="0" data-current="' . count($availableCustom) . '" data-total="' . $totalCustom . '">';
								foreach ($availableCustom as $post) {
									$output .= '<li class="" data-link="' . $post['link'] . '" data-name="' . $post['name'] . '" data-id="' . $post['value'] . '">';
										$output .= '' . $post['type'] . ' - ' . $post['name'] . ' (' . $post['value'] . ')';
									$output .= '</li>';
								}
							$output .= '</ul>'; 
						}
					}
				$output .= '</div>';
				unset($availablePages);
				unset($availablePosts);
				unset($availableTypes);
				unset($availableCustom);
				unset($availableRequest);
				echo $output;
			}
		}
		
		// Load Files on Frontend
		// ----------------------
		function TS_GMVC_Front_Main() {
			global $post;
			global $wp_query;
			$url = plugin_dir_url( __FILE__ );
			require_once($this->assets_dir . 'ts_gmvc_registerfiles.php');
			// Check For Standard Frontend Page
			if (!is_404() && !is_search() && !is_archive()) {
				$TS_GMVC_StandardFrontendPage		= "true";
			} else {
				$TS_GMVC_StandardFrontendPage		= "false";
			}
			// Load Scripts As Needed
			if (!empty($post)){
				
			}
		}		
		
		// Load + Render Settings Page
		// ---------------------------
		function TS_GMVC_RenderSettingsPage() {
			if (current_user_can('manage_options')) {
				echo '<div class="wrap ts-settings" id="ts_vcsc_extend_frame" style="direction: ltr;">' . "\n";					
					require_once($this->assets_dir . 'ts_gmvc_settings.php');
				echo '</div>' . "\n";
			} else {
				wp_die('You do not have sufficient permissions to access this page.');
			}
		}		
		
		// Function to Register Scripts and Stylesheets
		// --------------------------------------------
		function TS_GMVC_Extensions_Registrations() {
			require_once($this->assets_dir . 'ts_gmvc_registrations_files.php');
		}
		
		
		// Determine Load Status for Visual Composer
		// -----------------------------------------
		function TS_GMVC_DetermineLoadingStatus() {
			// Check for Visual Composer Roles Manager
			$TS_GMVC_Extension_Browser							= 'http://';
			if (isset($_SERVER['SERVER_NAME'])) {
				$TS_GMVC_Extension_Browser						.= $_SERVER['SERVER_NAME'];
			} else if (isset($_SERVER['HTTP_HOST'])) {
				$TS_GMVC_Extension_Browser						.= $_SERVER['HTTP_HOST'];
			}			
			if (isset($_SERVER['REQUEST_URI'])) {
				$TS_GMVC_Extension_Browser 						.= $_SERVER['REQUEST_URI'];
			}			
			if (strpos($TS_GMVC_Extension_Browser, '?page=vc-roles') !== false) {
				$TS_GMVC_Extension_RoleManager					= "true";		
			} else {
				$TS_GMVC_Extension_RoleManager					= "false";
			}
			// Check for Elements for Users - Addon for Visual Composer
			if (strpos($TS_GMVC_Extension_Browser, '?page=mcw_elements_for_users') !== false) {
				$TS_GMVC_Extension_ElementsUser					= "true";		
			} else {
				$TS_GMVC_Extension_ElementsUser					= "false";
			}
			// Determine if Visual Composer Form Request
			if (array_key_exists('action', $_REQUEST)) {
				$TS_GMVC_Extension_Request						= ($_REQUEST["action"] != "vc_edit_form" ? "false" : "true");
			} else {
				$TS_GMVC_Extension_Request						= "false";
			}
			// Determine Standard Page Editor
			$this->TS_GMVC_VCStandardEditMode					= (TS_GMVC_IsEditPagePost() == 1 ? "true" : "false");
			// Determine Frontend Editor Status
			if (function_exists('vc_is_inline')){
				if (vc_is_inline() == true) {
					$this->TS_GMVC_VCFrontEditMode 				= "true";
				} else {
					if ((vc_is_inline() == NULL) || (vc_is_inline() == '')) {
						if (TS_GMVC_CheckFrontEndEditor() == true) {
							$this->TS_GMVC_VCFrontEditMode 		= "true";
						} else {
							$this->TS_GMVC_VCFrontEditMode 		= "false";
						}	
					} else {
						$this->TS_GMVC_VCFrontEditMode 			= "false";
					}
				}
			} else {
				$this->TS_GMVC_VCFrontEditMode 					= "false";
			}
			// Set Global Load Status
			if (($this->TS_GMVC_VCStandardEditMode == "false") && ($TS_GMVC_Extension_Request == "false") && (is_admin()) && ($TS_GMVC_Extension_RoleManager == "false") && ($TS_GMVC_Extension_ElementsUser == "false") && (defined('WPB_VC_VERSION'))) {
				$this->TS_GMVC_VisualComposer_Loading			= "false";
			} else if (defined('WPB_VC_VERSION')) {
				$this->TS_GMVC_VisualComposer_Loading			= "true";
			} else {
				$this->TS_GMVC_VisualComposer_Loading			= "false";
			}
			// Check AJAX Request Status
			$this->TS_GMVC_PluginAJAX							= ($this->TS_GMVC_RequestIsFrontendAJAX() == 1 ? "true" : "false");
		}
		
		// Register Shortcodes + Elements + Parameters with VC
		// ---------------------------------------------------
		function TS_GMVC_RegisterWithComposer() {
			if (($this->TS_GMVC_VCFrontEditMode == "true") || ($this->TS_GMVC_VisualComposer_Loading == "true")) {
				$this->TS_GMVC_AddParametersToComposer();					
				$this->TS_GMVC_AddElementsToComposer();
			} else {
				$this->TS_GMVC_AddElementsToComposer();
			}
			// Add Mapped Shortcodes to VC (AJAX Callabck Fix)
			if (class_exists("WPBMap") && method_exists("WPBMap", "addAllMappedShortcodes")) {
				WPBMap::addAllMappedShortcodes();
			}
		}
		function TS_GMVC_AddParametersToComposer() {
			if ($this->TS_GMVC_VisualComposer_Loading == "true") {
				foreach ($this->TS_GMVC_ComposerParameters as $ParameterName => $parameter) {
					if ($parameter['file'] == "advancedlinks") {
						if ($this->TS_GMVC_ParameterLinkPicker['enabled'] == "true") {
							require_once($this->parameters_dir . 'ts_vcsc_parameter_' . $parameter['file'] . '.php');
						}
					} else {
						require_once($this->parameters_dir . 'ts_vcsc_parameter_' . $parameter['file'] . '.php');
					}
				}
			}
		}
		function TS_GMVC_AddElementsToComposer() {
			if (($this->TS_GMVC_VisualComposer_Loading == "true") || ($this->TS_GMVC_PluginAJAX == "true") || ($this->TS_GMVC_PluginAlways == "true")) {
				require_once($this->assets_dir . 'ts_gmvc_font_mapmarker.php');
				require_once($this->assets_dir . 'ts_gmvc_googlemap.php');
			}
		}
		
		// Function that handles the AJAX request of appending List of Posts/Pages
		// -----------------------------------------------------------------------
		function TS_GMVC_GetPostsPages_Ajax() {
			//if (check_ajax_referer('vc-admin-nonce', $_GET['_vcnonce'])) {
			if (vc_verify_admin_nonce($_GET['_vcnonce'])) {
				$selector 						= $_GET['selector'];
				$loadcount						= $_GET['loadcount'];
				$offset							= $_GET['offset'];
				$orderby						= $_GET['orderby'];
				$order							= $_GET['order'];
				// Page Selector
				if ($selector == "page") {
					$availablePages				= TS_GMVC_GetPostOptions(array('post_type' => 'page', 'posts_per_page' => $loadcount, 'offset' => $offset, 'orderby' => $orderby, 'order' => $order));
					$output						= '';
					foreach ($availablePages as $page) {
						$output .= '<li class="" data-link="' . $page['link'] . '" data-name="' . $page['name'] . '" data-id="' . $page['value'] . '" value="' . $page['value'] . '">' . $page['name'] . ' (' . $page['value'] . ')</li>';
					}
				}
				// Post Selector
				if ($selector == "post") {
					$availablePosts				= TS_GMVC_GetPostOptions(array('post_type' => 'post', 'posts_per_page' => $loadcount, 'offset' => $offset, 'orderby' => $orderby, 'order' => $order));
					$output						= '';
					foreach ($availablePosts as $post) {
						$output .= '<li class="" data-link="' . $post['link'] . '" data-name="' . $post['name'] . '" data-id="' . $post['value'] . '" value="' . $post['value'] . '">' . $post['name'] . ' (' . $post['value'] . ')</li>';
					}
				}
				// Custom Selector
				if ($selector == "custom") {
					// Get Custom Post Types
					$args = array(
					   'public'                 => true,
					   'publicly_queryable'     => true,
					   'exclude_from_search'    => false,
					   '_builtin'               => false
					);
					$availableTypes     		= get_post_types($args, 'names', 'and');
					$availableCustom    		= array();
					$availableRequest   		= array();
					if (count($availableTypes) > 0) {
						foreach ($availableTypes as $type) {
							$totalCustom        = $totalCustom + wp_count_posts($type)->publish;
							$availableRequest   = TS_GMVC_GetPostOptions(array('post_type' => $type, 'posts_per_page' => $loadcount, 'offset' => $offset, 'orderby' => $orderby, 'order' => $order));
							$availableCustom    = array_merge($availableCustom, $availableRequest);
						}
						foreach ($availableCustom as $custom) {
							$output .= '<li class="" data-link="' . $post['link'] . '" data-name="' . $custom['name'] . '" data-id="' . $custom['value'] . '" value="' . $custom['value'] . '">' . $post['type'] . ' - ' . $custom['name'] . ' (' . $custom['value'] . ')</li>';
						}
					}
				}
				unset($availablePages);
				unset($availablePosts);
				unset($availableTypes);
				unset($availableCustom);
				unset($availableRequest);
				echo $output;
			}
			die();
		}
		
		// Function to Check if AJAX Request Originates in Frontend
		// --------------------------------------------------------
		function TS_GMVC_RequestIsFrontendAJAX() {
			$script_filename = isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : '';		   
			// Try to figure out if frontend AJAX request... If we are DOING_AJAX; let's look closer
			if ((defined('DOING_AJAX') && DOING_AJAX)) {
				$ref = '';
				if (!empty($_REQUEST['_wp_http_referer'])) {
					$ref = wp_unslash( $_REQUEST['_wp_http_referer'] );
				} elseif (!empty($_SERVER['HTTP_REFERER'])) {
					$ref = wp_unslash( $_SERVER['HTTP_REFERER']);
				}		   
				// If referer does not contain admin URL and we are using the admin-ajax.php endpoint, this is likely a frontend AJAX request
				if (((strpos($ref, admin_url()) === false) && (basename($script_filename) === 'admin-ajax.php'))) {
					return true;
				}
			}
			// If no checks triggered, we end up here - not an AJAX request.
			return false;
		}
	}
}

// Initialize Plugin Class
// -----------------------
global $GOOGLEMAPS_PLUS_VC;
if (class_exists("GOOGLEMAPS_PLUS_VC") && !$GOOGLEMAPS_PLUS_VC) {
    $GOOGLEMAPS_PLUS_VC = new GOOGLEMAPS_PLUS_VC();	
}
?>
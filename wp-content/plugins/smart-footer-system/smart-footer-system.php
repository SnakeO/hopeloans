<?php 
/*
 * Plugin Name: 		Smart Footer System
 * Plugin URI: 			http://metaplugin.com/
 * Description: 		Footer plugin All-In-One for Wordpress
 * Version: 			2.0.1
 * Author: 				Meta Plugin
 * Author URI: 			http://metaplugin.com/
 * License: 			Regular Licence
 * License URI: 		http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 		smart-footer-system
 * Domain Path: 		/languages
 */

/**
 * Current Version Constant
 */
define("SFS_VERSION", "2.0.1");

/**
 * Default constants
 */
define("SFS_PREFIX", "Sfs");
define("SFS_PATH", plugin_dir_path(__FILE__));
define("SFS_URL", plugin_dir_url(__FILE__));
define("SFS_OPTIONS_KEY", "sfs-settings");

/**
* Autoloder class
*/
spl_autoload_register(function($className = '') {
	if(strpos($className, SFS_PREFIX) === false) {
		return;
	}
	$className = str_replace(SFS_PREFIX, "", $className);
	require_once(SFS_PATH.'inc/'.$className.'.class.php');
});

/**
 * Core class of plugin
 */
class SmartFooterSystem {
	public static function init() {
		SfsPostType::init();
		SfsBackend::init();
		SfsFrontend::init();
		if (  defined( 'WPB_VC_VERSION' )  ) {
			add_action("vc_after_init", function(){

				global $vc_manager;

				if( $vc_manager ) {

					$existing_vc_post_types = $vc_manager->editorPostTypes();

					$existing_vc_post_types[] = 'sfs-footer';

					$vc_manager->setEditorPostTypes( $existing_vc_post_types );

				}			
			});
		}
		add_action('plugins_loaded', function() {
			load_plugin_textdomain( 'smart-footer-system', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
		});
	}
}

/**
 * Initializate plugin
 */
SmartFooterSystem::init();

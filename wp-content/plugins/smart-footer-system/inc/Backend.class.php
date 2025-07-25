<?php
/**
* Smart Footer System - Backend Class
*/
class SfsBackend {
	/**
	 * Initializate the class
	 * @return null
	 */
	public static function init() {
		if(!is_admin()) return;
		add_action("admin_menu", function(){
			self::registerAdminPage();
		});		
		add_action("admin_init", function(){
			if(isset($_REQUEST['page']) && $_REQUEST['page'] != 'smart-footer-system') return;
			self::save();
		});

		add_action("admin_enqueue_scripts", function(){
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script('jquery-ui-slider');			
			wp_enqueue_style('smart-footer-system-admin', SFS_URL.'dist/css/sfs.backend.css');
			wp_enqueue_script('smart-footer-system-admin', SFS_URL.'dist/js/sfs.backend.js', ['jquery', 'jquery-ui-slider']);

			global $post;
			if(isset($post) && $post->post_type != 'sfs-footer' || (isset($_GET['post_type'] ) && $_GET['post_type'] != 'sfs-footer')) return;
			
			wp_enqueue_style( 'wp-color-picker' );

			$font2 = SFS_URL. 'vendor/icon-picker/fonts/font-awesome/css/font-awesome.css';
			wp_enqueue_style( 'font-awesome', $font2,'','');

			$font3 = SFS_URL. 'vendor/icon-picker/fonts/genericons/genericons.css';
			wp_enqueue_style( 'genericons', $font3, '', '');

			$css = SFS_URL. 'vendor/icon-picker/css/icon-picker.css';
			wp_enqueue_style( 'dashicons-picker', $css, array( 'dashicons' ), '1.0' );

			$js = SFS_URL. 'vendor/icon-picker/js/icon-picker.js';
			wp_enqueue_script( 'dashicons-picker', $js, array( 'jquery' ), '1.0' );
		});

		add_action( 'wp_ajax_sfs-import', function(){
			global $wpdb;
			$backup = base64_decode(sanitize_text_field($_POST['backup']));
			$backup = unserialize($backup);
			if(empty($backup)) {
				echo json_encode([
					"errors" 		=> 0,
					"errorsText"	=> [],
					"imported" 		=> 0,
					"empty"			=> true
				]);
				die();
				return;
			}
			$imported = 0;
			$errors   = [];
			foreach($backup as $sfsPost) {
				if(empty($sfsPost['meta']))	{
					continue;
				}				
				$returnInsertId = wp_insert_post([
					"post_title" 	=> $sfsPost['post_title'],
					"post_content"	=> $sfsPost['post_content'],
					"post_status"	=> 'publish',
					"post_type"	 	=> 'sfs-footer'
				], $wp_error );
				if(!$returnInsertId) {
					$errors[] =  $sfsPost["post_title"].": ".__("Cannot insert post", 'smart-footer-system');
					continue;
				}
				foreach($sfsPost["meta"] as $key => $sfsPostMeta){
					$metaValue = "";
					if(isset($sfsPostMeta[0])) {
						$metaValue = $sfsPostMeta[0];
					}
					else {
						$errors[] = $sfsPost["post_title"].": ". __("Post haven't meta", 'smart-footer-system');
						continue;
					}
					$unserializeData = @unserialize($metaValue);
					if($serializeData !== false) {
						$metaValue = $unserializeData;
					}
					add_post_meta($returnInsertId, $key, $metaValue);
				}
				$imported++;
			}
			echo json_encode([
				"errors" 		=> count($errors),
				"errorsText"	=> $errors,
				"imported" 		=> $imported,
				"empty"			=> false
			]);
			die();
			return;
		});
		self::themeCompatibility();
	}
	/**
	 * Register admin page
	 * @return null
	 */
	public static function registerAdminPage() {
		add_submenu_page('edit.php?post_type=sfs-footer', __("Settings", 'smart-footer-system'), __("Settings", 'smart-footer-system'), 'manage_options', 'smart-footer-system', function(){	
			ob_start();
			require_once(SFS_PATH.'inc/backend/admin-page.php');
			echo ob_get_clean();
		});
	}
	/**
	 * Save settings
	 * @return null
	 */
	protected static function save() {
		if(isset($_REQUEST['_wpnonce']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'sfs-save-settings')){
			SfsSettings::set($_POST['sfs']);
			add_action( 'admin_notices',  function(){
			?>
				<div class="notice notice-success is-dismissible">
					<p><?php echo __( 'Settings updated!', 'smart-footer-system' ); ?></p>
				</div>
			<?php
			});
		}
		
	}
	/**
	 * Check for theme compatibility
	 * @return null
	 */
	public static function themeCompatibility() {
		add_filter('avf_builder_boxes', function ($metabox) {
			foreach($metabox as &$meta) {
				if($meta['id'] == 'avia_builder' || $meta['id'] == 'layout') {
					$meta['page'][] = 'sfs-footer'; 
				}
			}

			return $metabox;
		});
	}
}
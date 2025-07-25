<?php
/**
* Smart Footer System - PostType Class
*/
class SfsPostType {

	/**
	 * Initializate class
	 * @return null
	 */
	public static function init() {
		self::register();
		self::addMetaboxToPostTypes();
	}

	/**
	 * Register a new Post Type
	 * @return null
	 */
	protected static function register() {

		add_action( 'init', function() {

			$labels = [
				'name'                => __( 'Smart Footer System', "smart-footer-system"),
				'singular_name'       => __( 'Footer', "smart-footer-system"),
				'add_new'             => _x( 'Add New Footer', 'text-domain', "smart-footer-system"),
				'add_new_item'        => __( 'Add New Footer', "smart-footer-system"),
				'edit_item'           => __( 'Edit Footer', "smart-footer-system"),
				'all_items'			  => __( 'Footers', 'smart-footer-system'),
				'new_item'            => __( 'New Footer', "smart-footer-system"),
				'view_item'           => __( 'View Footer', "smart-footer-system"),
				'search_items'        => __( 'Search Footers', "smart-footer-system"),
				'not_found'           => __( 'No footers found', "smart-footer-system"),
				'not_found_in_trash'  => __( 'No footers found in trash', "smart-footer-system"),
				'parent_item_colon'   => __( 'Parent footer', "smart-footer-system"),
				'menu_name'           => __( 'Smart Footer System', "smart-footer-system"),
			];
		
			$publicly_queryable = false;
			$settings = SfsSettings::get();
			if(isset($settings["slug_active"]) && $settings["slug_active"]) {
				$publicly_queryable = true;
			}

			$args = [
				'labels'              => $labels,
				'hierarchical'        => false,
				'description'         => 'description',
				'taxonomies'          => array(),
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => null,
				'menu_icon'           => SFS_URL.'/img/menuicon.png',
				'show_in_nav_menus'   => true,
				'publicly_queryable'  => $publicly_queryable,
				'exclude_from_search' => true,
				'has_archive'         => false,
				'query_var'           => true,
				'can_export'          => true,
				'rewrite'             => false,
				'capability_type'     => 'post',
				'supports'            => ['title', 'editor'],
			];
			register_post_type( 'sfs-footer', $args );
		});
	}

	/**
	 * Add custom metabox to all post types
	 */
	protected static function addMetaboxToPostTypes() {

		add_action( 'add_meta_boxes', function(){
			$postTypes = self::getAllPostTypes('names');
			add_meta_box('sfs-metabox', __("Smart Footer System", 'smart-footer-system'), function(){
				global $post;
				$sfsFooters 			= self::get();
				$sfsPostFooter	 		= self::getPostFooter();
				include_once(SFS_PATH.'inc/backend/metabox-post-types.php');
			}, $postTypes, 'advanced', 'high');
			add_meta_box('sfs-footer-metabox', __("Smart Footer System - Footer Settings", 'smart-footer-system'), function(){
				global $post;
				$sfsFooterSettings = get_post_meta($post->ID, 'sfs-footer-metabox', true);
				include_once(SFS_PATH.'inc/backend/metabox-footer.php');
			}, 'sfs-footer', 'advanced', 'high');
		});

		add_action("save_post", function($postId, $post, $update){
			if($post->post_type == 'sfs-footer') {
				if(!isset($_POST['sfs'])) return;
				return update_post_meta($postId, 'sfs-footer-metabox', (array) $_POST['sfs']);
			}
			$postTypes = self::getAllPostTypes('names');
			if(!array_key_exists($post->post_type, $postTypes)) return;
			$sfsMetabox = (isset($_POST['sfs'])) ? $_POST['sfs'] : [];
			return update_post_meta($postId, 'sfs-footer', $sfsMetabox);
		}, 10, 3);
	}

	/**
	 * Get the footer by post
	 * @param  integer|optional $id the $post->ID
	 * @return array posts or post array
	 */
	public static function get($id = false) {
		if($id) {
			return get_post($id);
		}
		return get_posts([
			"post_type" => 'sfs-footer',
			"post_status" => 'publish',
			"posts_per_page" => 999999999,
			"suppress_filter" => false
		]);
	}

	/**
	 * Get the current post footer
	 * @return array Data of current footer
	 */
	public static function getPostFooter(){
		global $post;
		if(!$post) return;
		$sfsSettings 			= SfsSettings::get();
		$currentMetabox 		= get_post_meta($post->ID, 'sfs-footer', true);
		$currentSettingsFooter  = self::getCurrentSettingsFooter($sfsSettings, $post->post_type);
		$currentFooter 			= $currentSettingsFooter;
		if(isset($currentMetabox["override"]) && $currentMetabox["override"]) {
			if (class_exists('WooCommerce') && !is_shop() && !is_product() && !is_shop() && !is_product_category()){
				$currentFooter = $currentMetabox['footer'];
			}
			else {
				$currentFooter = $currentMetabox['footer'];
			}
		}
		$currentFooterType 		= get_post_meta($currentFooter, 'sfs-footer-metabox', true);
		$currentFooterCss  		= get_post_meta($currentFooter, '_wpb_post_custom_css', true );
		$shortcodesCustomCss 	= get_post_meta($currentFooter, '_wpb_shortcodes_custom_css', true );
		$postContent 			= "";
		$postName 				= "";
		if($currentFooter && $currentFooter != "false"){
			$objFooter 		= self::get($currentFooter);
			$postContent	= $objFooter->post_content;	
			$postName 		= sanitize_title($objFooter->post_title);
		}

		return [
			"hide_footer" 				=> (isset($sfsSettings["hide_footer"])) ? true : false,
			"override"	  				=> (isset($currentMetabox["override"])) ? true : false,
			"disable"	  				=> (isset($currentMetabox["disable"])) ? true : false,			
			"footer"	  				=> $currentFooterType,
			"name"						=> $postName,
			"content"	  				=> $postContent,
			"currentFooterCss" 			=> $currentFooterCss,
			"currentFooterCustomCss" 	=> (isset($currentFooterType["custom-css"])) ? $currentFooterType["custom-css"] : '',			
			"shortcodesCustomCss" 		=> $shortcodesCustomCss,
			"id"						=> $currentFooter
		];
	}

	/**
	 * Get general footer settings by page type or post type
	 * @param  string $postType post type slug
	 * @return array 
	 */
	public static function getCurrentSettingsFooter($sfsSettings, $postType = ''){
		$haveWooCommerce = class_exists( 'WooCommerce' );
		if ($haveWooCommerce){
			if(is_shop() ){
				return (isset($sfsSettings["footers"]["shop"])) ? $sfsSettings["footers"]["shop"] : false;
			}
			else if(is_cart()){
				return (isset($sfsSettings["footers"]["cart"])) ? $sfsSettings["footers"]["cart"] : false;
			}
			else if(is_checkout()){
				return (isset($sfsSettings["footers"]["checkout"])) ? $sfsSettings["footers"]["checkout"] : false;
			}	
			else if(is_account_page()){
				return (isset($sfsSettings["footers"]["account"])) ? $sfsSettings["footers"]["account"] : false;
			}	
			else if(is_product()){
				return (isset($sfsSettings["footers"]["product"])) ? $sfsSettings["footers"]["product"] : false;
			}			
			else if(is_product_category() || is_product_tag()) {
				return (isset($sfsSettings["footers"]["archive_product"])) ? $sfsSettings["footers"]["archive_product"] : false;
			}
		}
		if(is_home() ){
			return (isset($sfsSettings["footers"]["blog"])) ? $sfsSettings["footers"]["blog"] : false;
		}
		else if (is_front_page()) {
			if($haveWooCommerce && is_woocommerce()) return;
			return (isset($sfsSettings["footers"]["home"])) ? $sfsSettings["footers"]["home"] : false;
		}
		else if(is_archive()) {
			return (isset($sfsSettings["footers"]["archive_".$postType])) ? $sfsSettings["footers"]["archive_".$postType] : false;
		}
		else {
			return (isset($sfsSettings["footers"][$postType])) ? $sfsSettings["footers"][$postType] : false;
		}
	}

	/**
	 * Get all registered post types
	 * @param string $returnType How to return the post types
	 * @return array names of objects of post types
	 */
	public static function getAllPostTypes($returnType = 'objects'){
		return get_post_types([
			"public" => true,
			"exclude_from_search" => false
		], $returnType);
	}
}
<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_PostType_ProductVariation {

	private $post_type = 'product_variation';

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Menu
		add_filter( 'woocommerce_register_post_type_' . $this->post_type, array( $this, 'enable_variation_list_table' ), 10, 2 );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		// Load correct list table classes for current screen.
		add_action( 'current_screen', array( $this, 'setup_screen' ) );
		add_action( 'check_ajax_referer', array( $this, 'setup_screen' ) );
	}

	/**
	 * @param array $args
	 *
	 * @return array
	 */
	public function enable_variation_list_table( $args ) {
		$args['show_ui'] = true;
		$args['show_in_menu'] = true;

		if ( ! isset( $args['capabilities'] ) ) {
			$args['capabilities'] = array();
		}

		$args['capabilities']['create_posts'] = 'do_not_allow';
		$args['capabilities']['delete_posts'] = true;

		if ( ! isset( $args['labels'] ) ) {
			$args['labels'] = array(
				'name'                  => __( 'Product Variations', 'woocommerce' ),
				'singular_name'         => __( 'Product Variation', 'woocommerce' ),
				'all_items'             => __( 'Product Variations', 'woocommerce' ),
				'menu_name'             => _x( 'Variations', 'Admin menu name', 'woocommerce' ),
				'add_new'               => __( 'Add New', 'woocommerce' ),
				'add_new_item'          => __( 'Add new variation', 'woocommerce' ),
				'edit'                  => __( 'Edit', 'woocommerce' ),
				'edit_item'             => __( 'Edit variation', 'woocommerce' ),
				'new_item'              => __( 'New variation', 'woocommerce' ),
				'view'                  => __( 'View variation', 'woocommerce' ),
				'view_item'             => __( 'View variation', 'woocommerce' ),
				'search_items'          => __( 'Search Product', 'woocommerce' ),
				'not_found'             => __( 'No variations found', 'woocommerce' ),
				'not_found_in_trash'    => __( 'No variations found in trash', 'woocommerce' ),
				'parent'                => __( 'Parent variation', 'woocommerce' ),
				'featured_image'        => __( 'Variation image', 'woocommerce' ),
				'set_featured_image'    => __( 'Set variation image', 'woocommerce' ),
				'remove_featured_image' => __( 'Remove variation image', 'woocommerce' ),
				'use_featured_image'    => __( 'Use as variation image', 'woocommerce' ),
				'insert_into_item'      => __( 'Insert into variation', 'woocommerce' ),
				'uploaded_to_this_item' => __( 'Uploaded to this variation', 'woocommerce' ),
				'filter_items_list'     => __( 'Filter variations', 'woocommerce' ),
				'items_list_navigation' => __( 'Variations navigation', 'woocommerce' ),
				'items_list'            => __( 'Variations list', 'woocommerce' ),
			);
		}

		return $args;
	}

	/**
	 * Place variations menu under products
	 */
	public function admin_menu() {
		global $submenu;

		$slug_variation = 'edit.php?post_type=' . $this->post_type;

		if ( ! isset( $submenu[ $slug_variation ] ) ) {
			return;
		}

		$variation = reset( $submenu[ $slug_variation ] );

		$slug_product = 'edit.php?post_type=product';

		if ( ! isset( $submenu[ $slug_product ] ) ) {
			return;
		}

		// Place on first available position after position x
		for ( $pos = 10; $pos < 100; $pos++ ) {
			if ( isset( $submenu[ $slug_product ][ $pos ] ) ) {
				continue;
			}

			$submenu[ $slug_product ][ $pos ] = $variation;
			break;
		}

		ksort( $submenu[ $slug_product ] );

		remove_menu_page( $slug_variation );
	}

	/**
	 * Load List Table
	 */
	public function setup_screen() {
		if ( 'edit-' . $this->post_type === $this->get_current_screen_id() ) {
			new ACA_WC_ListTable_ProductVariation();
		}
	}

	/**
	 * @return false|string
	 */
	private function get_current_screen_id() {
		$screen_id = false;

		if ( function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();
			$screen_id = isset( $screen, $screen->id ) ? $screen->id : '';
		}

		if ( AC()->is_doing_ajax() && ! empty( $_REQUEST['screen'] ) ) {
			$screen_id = wc_clean( wp_unslash( $_REQUEST['screen'] ) );
		}

		return $screen_id;
	}

}

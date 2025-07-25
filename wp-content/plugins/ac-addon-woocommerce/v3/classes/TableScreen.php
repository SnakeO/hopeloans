<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
final class ACA_WC_TableScreen {

	public function __construct() {
		add_action( 'ac/table_scripts', array( $this, 'table_scripts' ) );
		add_action( 'ac/table_scripts/editing', array( $this, 'table_scripts_editing' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'product_scripts' ), 100 );
		add_filter( 'ac/editing/role_group', array( $this, 'set_editing_role_group' ), 10, 2 );

		// Add quick action to product overview
		if ( ac_addon_wc()->is_version_gte( '3.3' ) ) {
			add_filter( 'post_row_actions', array( $this, 'add_quick_action_variation' ), 10, 2 );
			add_action( 'manage_product_posts_custom_column', array( $this, 'add_quick_link_variation' ), 11, 2 );
		}
	}

	/**
	 * @param AC_ListScreen $list_screen
	 *
	 * @return bool
	 */
	private function is_wc_list_screen( $list_screen ) {
		return $list_screen instanceof ACA_WC_ListScreen_ShopOrder ||
		       $list_screen instanceof ACA_WC_ListScreen_ShopCoupon ||
		       $list_screen instanceof ACA_WC_ListScreen_Product ||
		       $list_screen instanceof ACA_WC_ListScreen_ProductVariation ||
		       $list_screen instanceof AC_ListScreen_User;
	}

	/**
	 * @param AC_ListScreen $list_screen
	 */
	public function table_scripts_editing( $list_screen ) {
		if ( ! $this->is_wc_list_screen( $list_screen ) ) {
			return;
		}

		wp_enqueue_script( 'aca-wc-xeditable', ac_addon_wc()->get_plugin_url() . 'assets/js/xeditable.js', array( 'jquery', 'acp-editing-table' ), ac_addon_wc()->get_version() );

		// Translations
		wp_localize_script( 'acp-editing-table', 'acp_woocommerce_i18n', array(
			'woocommerce' => array(
				'stock_qty'              => __( 'Stock Qty', 'woocommerce' ),
				'manage_stock'           => __( 'Manage stock?', 'woocommerce' ),
				'stock_status'           => __( 'Stock status', 'woocommerce' ),
				'in_stock'               => __( 'In stock', 'woocommerce' ),
				'out_of_stock'           => __( 'Out of stock', 'woocommerce' ),
				'regular'                => __( 'Regular', 'codepress-admin-columns' ),
				'sale'                   => __( 'Sale', 'woocommerce' ),
				'sale_from'              => __( 'Sale from', 'codepress-admin-columns' ),
				'sale_to'                => __( 'Sale To', 'codepress-admin-columns' ),
				'schedule'               => __( 'Schedule', 'woocommerce' ),
				'usage_limit_per_coupon' => __( 'Usage limit per coupon', 'woocommerce' ),
				'usage_limit_per_user'   => __( 'Usage limit per user', 'woocommerce' ),
				'usage_limit_products'   => __( 'Usage limit products', 'woocommerce' ),
				'length'                 => __( 'Length', 'woocommerce' ),
				'width'                  => __( 'Width', 'woocommerce' ),
				'height'                 => __( 'Height', 'woocommerce' ),
			),
		) );

		if ( $list_screen instanceof ACA_WC_ListScreen_ProductVariation ) {

			wp_localize_script( 'acp-editing-table', 'woocommerce_admin_meta_boxes', array(
				'calendar_image'         => WC()->plugin_url() . '/assets/images/calendar.png',
				'currency_format_symbol' => get_woocommerce_currency_symbol(),
			) );
		}
	}

	/**
	 * @since 1.3
	 *
	 * @param AC_ListScreen $list_screen
	 */
	public function table_scripts( $list_screen ) {
		if ( ! $this->is_wc_list_screen( $list_screen ) ) {
			return;
		}

		wp_enqueue_style( 'aca-wc-column', ac_addon_wc()->get_plugin_url() . 'assets/css/table.css', array(), ac_addon_wc()->get_version() );
		wp_enqueue_script( 'aca-wc-table', ac_addon_wc()->get_plugin_url() . 'assets/js/table.js', array( 'jquery' ), ac_addon_wc()->get_version() );
	}

	/**
	 * Single product scripts
	 */
	public function product_scripts( $hook ) {
		global $post;

		if ( in_array( $hook, array( 'post-new.php', 'post.php' ) ) && $post && 'product' === $post->post_type ) {
			wp_enqueue_script( 'aca-wc-product', ac_addon_wc()->get_plugin_url() . 'assets/js/product.js', array( 'jquery' ), ac_addon_wc()->get_version() );
		}
	}

	/**
	 * @param string $group
	 * @param string $role
	 *
	 * @return string
	 */
	public function set_editing_role_group( $group, $role ) {
		if ( in_array( $role, array( 'customer', 'shop_manager' ) ) ) {
			$group = __( 'WooCommerce', 'codepress-admin-columns' );
		}

		return $group;
	}

	/**
	 * @param int $product_id
	 *
	 * @return string
	 */
	private function get_list_table_link( $product_id ) {
		$product = wc_get_product( $product_id );

		if ( ! $product || 'variable' !== $product->get_type() ) {
			return false;
		}

		return add_query_arg( array( 'post_type' => 'product_variation', 'post_parent' => $product_id ), admin_url( 'edit.php' ) );
	}

	/**
	 * Add a quick action on the product overview which links to the product variations page.
	 *
	 * @param array   $actions
	 * @param WP_Post $post
	 *
	 * @return array
	 */
	public function add_quick_action_variation( $actions, $post ) {
		if ( 'product' !== $post->post_type ) {
			return $actions;
		}

		if ( $link = $this->get_list_table_link( $post->ID ) ) {
			$actions['variation'] = ac_helper()->html->link( $link, __( 'View Variations', 'codepress-admin-columns' ) );
		}

		return $actions;
	}

	/**
	 * Display an icon on the product name column which links to the product variations page.
	 *
	 * @see WP_Posts_List_Table::column_default
	 *
	 * @param string $column
	 * @param int    $post_id
	 */
	public function add_quick_link_variation( $column, $post_id ) {
		if ( 'name' !== $column ) {
			return;
		}

		$link = $this->get_list_table_link( $post_id );

		if ( ! $link ) {
			return;
		}

		$label = ac_helper()->html->tooltip( '<span class="ac-wc-view"></span>', __( 'View Variations', 'codepress-admin-columns' ) );

		echo ac_helper()->html->link( $link, $label, array( 'class' => 'view-variations' ) );
	}

}

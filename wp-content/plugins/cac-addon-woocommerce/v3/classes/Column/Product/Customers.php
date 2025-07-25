<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_Product_Customers extends AC_Column
	implements ACP_Column_SortingInterface {

	public function __construct() {
		$this->set_type( 'column-wc-product_customers' );
		$this->set_label( __( 'Customers Purchased', 'codepress-admin-columns' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_raw_value( $id ) {
		global $wpdb;

		$sql = "
			SELECT DISTINCT pm.meta_value AS cid
			FROM {$wpdb->postmeta} AS pm
			INNER JOIN {$wpdb->posts} AS p
				ON p.ID = pm.post_id AND p.post_status = 'wc-completed'
			INNER JOIN {$wpdb->prefix}woocommerce_order_items AS oi
				ON oi.order_id = p.ID AND oi.order_item_type = 'line_item'
			INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS oim
				ON oi.order_item_id = oim.order_item_id AND oim.meta_key = '_product_id'
			WHERE pm.meta_key = '_customer_user'
			AND oim.meta_value = %d
		";

		$stmt = $wpdb->prepare( $sql, array( $id ) );
		$results = $wpdb->get_results( $stmt );

		return is_array( $results ) ? count( $results ) : 0;
	}

	public function sorting() {
		$sorting = new ACP_Sorting_Model( $this );
		$sorting->set_data_type( 'numeric' );

		return $sorting;
	}

}

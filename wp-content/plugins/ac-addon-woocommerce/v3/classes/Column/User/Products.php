<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_User_Products extends AC_Column
	implements ACP_Column_SortingInterface {

	public function __construct() {
		$this->set_type( 'column-wc-user_products' );
		$this->set_label( __( 'Products', 'codepress-admin-columns' ) );
		$this->set_group( 'woocommerce' );
	}

	public function register_settings() {
		$this->add_setting( new ACA_WC_Settings_User_Products( $this ) );
	}

	/**
	 * @param int $id
	 *
	 * @return int
	 */
	public function get_raw_value( $id ) {
		$count = 0;

		if ( $this->is_uniquely_purchased() ) {
			$count = count( $this->get_products( $id ) );
		} else {
			foreach ( $this->get_products( $id ) as $product ) {
				$count += $product->qty;
			}
		}

		return $count;
	}

	/**
	 * @param int $id User ID
	 *
	 * @return stdClass[] [ $product_id, $order_id, $qty ]
	 */
	private function get_products( $id ) {
		global $wpdb;

		// Unique products
		$sql_parts = array(
			'select' => "
				SELECT DISTINCT oim.meta_value AS product_id",
			'from'   => "
				FROM {$wpdb->postmeta} AS pm",
			'joins'  => array(
				"
				INNER JOIN {$wpdb->posts} AS p 
					ON p.ID = pm.post_id 
					AND p.post_status = 'wc-completed'",
				"
				INNER JOIN {$wpdb->prefix}woocommerce_order_items AS oi
					ON oi.order_id = p.ID 
					AND oi.order_item_type = 'line_item'",
				"
				INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS oim
					ON oi.order_item_id = oim.order_item_id AND oim.meta_key = '_product_id'",
			),
			'where'  => "WHERE pm.meta_key = '_customer_user'
				AND pm.meta_value = %d",
		);

		// Total products
		if ( ! $this->is_uniquely_purchased() ) {

			$sql_parts['select'] = "
				SELECT oim.meta_value AS product_id, pm.post_id AS order_id, oim2.meta_value as qty";

			$sql_parts['joins'][] = "
				INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS oim2 
					ON oi.order_item_id = oim2.order_item_id 
					AND oim2.meta_key = '_qty'";
		}

		$sql = $this->built_sql( $sql_parts );

		$stmt = $wpdb->prepare( $sql, array( $id ) );
		$results = $wpdb->get_results( $stmt );

		if ( empty( $results ) ) {
			return array();
		}

		return $results;
	}

	/**
	 * @param array $parts
	 *
	 * @return string
	 */
	private function built_sql( $parts ) {
		$sql = '';

		foreach ( $parts as $part ) {
			if ( is_array( $part ) ) {
				$sql .= $this->built_sql( $part );
			} else {
				$sql .= ' ' . $part;
			}
		}

		return $sql;
	}

	/**
	 * @return bool
	 */
	private function is_uniquely_purchased() {
		$setting = $this->get_setting( 'user_products' );

		if ( ! $setting instanceof ACA_WC_Settings_User_Products ) {
			return false;
		}

		return 'unique' === $setting->get_user_products();
	}

	public function sorting() {
		$sorting = new ACP_Sorting_Model_Disabled( $this );

		// Query would be too heavy on all products..
		if ( $this->is_uniquely_purchased() ) {

			$sorting = new ACP_Sorting_Model( $this );
			$sorting->set_data_type( 'numeric' );
		}

		return $sorting;
	}

}

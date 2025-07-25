<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_Product_Coupons extends AC_Column
	implements ACP_Column_FilteringInterface, ACP_Export_Column {

	public function __construct() {
		$this->set_type( 'column-wc-product_coupons' );
		$this->set_label( __( 'Coupons', 'codepress-admin-columns' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_value( $id ) {
		$coupon_ids = $this->get_raw_value( $id );

		if ( empty( $coupon_ids ) ) {
			return $this->get_empty_char();
		}

		$values = array();

		foreach ( $coupon_ids as $id ) {
			$values[] = ac_helper()->html->link( get_edit_post_link( $id ), get_the_title( $id ) );
		}

		return implode( $this->get_separator(), $values );
	}

	/**
	 * @param int $id
	 *
	 * @return array
	 */
	public function get_raw_value( $id ) {
		global $wpdb;

		$sql = "SELECT p.ID 
				FROM {$wpdb->posts} as p
				INNER JOIN {$wpdb->postmeta} as pm ON p.ID = pm.post_id
				WHERE post_type = 'shop_coupon'
				AND meta_key = 'product_ids'
				AND FIND_IN_SET( %d, pm.meta_value )";

		$query = $wpdb->prepare( $sql, array( $id ) );

		return $wpdb->get_col( $query );
	}

	public function filtering() {
		return new ACA_WC_Filtering_Product_Coupons( $this );
	}

	public function export() {
		return new ACP_Export_Model_StrippedValue( $this );
	}

}

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0.3
 */
class ACA_WC_Column_Product_Sales extends AC_Column {

	public function __construct() {
		$this->set_type( 'column-wc-product_sales' );
		$this->set_label( __( 'Sales', 'codepress-admin-columns' ) );
		$this->set_group( 'woocommerce' );
	}

	// Display

	public function get_value( $product_id ) {
		$value = $this->get_raw_value( $product_id );

		if ( ! $value ) {
			return $this->get_empty_char();
		}

		return $value;
	}

	public function get_raw_value( $product_id ) {
		global $wpdb;

		$num_orders = $wpdb->get_var( $wpdb->prepare( "
			SELECT 
				SUM( meta_value )
			FROM 
				wp_woocommerce_order_itemmeta
			WHERE 
				meta_key = '_qty'
			 	AND 
			 	order_item_id IN (
					SELECT DISTINCT( wc_oim.order_item_id )
					FROM {$wpdb->prefix}woocommerce_order_itemmeta wc_oim
					WHERE wc_oim.meta_key = '_product_id'
					AND wc_oim.meta_value = %d
				)",
			$product_id
		) );

		if ( ! $num_orders ) {
			return false;
		}

		return $num_orders;
	}

}

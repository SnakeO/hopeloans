<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_Product_SoldIndividually extends AC_Column_Meta
	implements ACP_Column_EditingInterface, ACP_Column_FilteringInterface, ACP_Column_SortingInterface {

	public function __construct() {
		$this->set_type( 'column-wc-product_sold_individually' );
		$this->set_label( __( 'Sold Individually', 'woocommerce' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_meta_key() {
		return '_sold_individually';
	}

	public function get_value( $id ) {
		if ( ! $this->get_raw_value( $id ) ) {
			return $this->get_empty_char();
		}

		return ac_helper()->icon->yes( false, false, 'blue' );
	}

	public function get_raw_value( $id ) {
		return wc_get_product( $id )->is_sold_individually();
	}

	public function sorting() {
		return new ACP_Sorting_Model_Meta( $this );
	}

	public function editing() {
		return new ACA_WC_Editing_Product_SoldIndividually( $this );
	}

	public function filtering() {
		return new ACA_WC_Filtering_Product_SoldIndividually( $this );
	}

}

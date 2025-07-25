<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ShopOrder_Currency extends AC_Column_Meta
	implements ACP_Column_FilteringInterface, ACP_Column_SortingInterface, ACP_Export_Column {

	public function __construct() {
		$this->set_label( 'Currency' );
		$this->set_type( 'column-wc-order_currency' );
		$this->set_group( 'woocommerce' );
	}

	// Meta

	public function get_meta_key() {
		return '_order_currency';
	}

	// Display

	public function get_value( $id ) {
		$value = $this->get_raw_value( $id );

		if ( ! $value ) {
			return $this->get_empty_char();
		}

		return $value;
	}

	// Pro

	public function filtering() {
		return new ACA_WC_Filtering_MetaWithoutEmptyOption( $this );
	}

	public function export() {
		return new ACP_Export_Model_RawValue( $this );
	}

	public function sorting() {
		return new ACP_Sorting_Model_Meta( $this );
	}

}

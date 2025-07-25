<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Column_Product_PurchaseNote extends AC_Column_Meta
	implements ACP_Export_Column, ACP_Column_EditingInterface, ACP_Column_FilteringInterface, ACP_Column_SortingInterface {

	public function __construct() {
		$this->set_type( 'column-wc-product_purchase_note' );
		$this->set_label( __( 'Purchase Note', 'woocommerce' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_meta_key() {
		return '_purchase_note';
	}

	public function export() {
		return new ACP_Export_Model_StrippedRawValue( $this );
	}

	public function editing() {
		return new ACA_WC_Editing_Product_PurchaseNote( $this );
	}

	public function filtering() {
		return new ACA_WC_Filtering_Product_PurchaseNote( $this );
	}

	public function sorting() {
		return new ACP_Sorting_Model_Meta( $this );
	}

	public function register_settings() {
		$this->add_setting( new ACA_WC_Settings_UseIcon( $this ) );
	}

}

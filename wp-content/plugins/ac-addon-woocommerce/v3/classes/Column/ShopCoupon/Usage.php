<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 1.0
 */
class ACA_WC_Column_ShopCoupon_Usage extends AC_Column_Meta
	implements ACP_Column_SortingInterface, ACP_Column_EditingInterface, ACP_Export_Column {

	public function __construct() {
		$this->set_type( 'usage' );
		$this->set_original( true );
	}

	public function get_meta_key() {
		return 'usage_count';
	}

	public function get_value( $id ) {
		return '';
	}

	// Pro

	public function editing() {
		return new ACA_WC_Editing_ShopCoupon_Usage( $this );
	}

	public function sorting() {
		$model = new ACP_Sorting_Model_Meta( $this );
		$model->set_data_type( 'numeric' );

		return $model;
	}

	public function export() {
		return new ACA_WC_Export_ShopCoupon_Usage( $this );
	}

}

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Column_ShopCoupon_Limit extends AC_Column_Meta
	implements ACP_Column_SortingInterface, ACP_Column_EditingInterface, ACP_Column_FilteringInterface {

	public function __construct() {
		$this->set_type( 'column-shop-coupon_limit' );
		$this->set_label( __( 'Coupon limit', 'codepress-admin-columns' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_meta_key() {
		return $this->get_setting( 'coupon_limit' )->get_value();
	}

	protected function register_settings() {
		$this->add_setting( new ACA_WC_Settings_ShopCoupon_Limit( $this ) );
	}

	// Pro
	public function filtering() {
		$model = new ACP_Filtering_Model_Meta( $this );
		$model->set_data_type( 'numeric' );
		$model->set_ranged( true );

		return $model;
	}

	public function editing() {
		return new ACP_Editing_Model_Meta( $this );
	}

	public function sorting() {
		$model = new ACP_Sorting_Model_Meta( $this );
		$model->set_data_type( 'numeric' );

		return $model;
	}

}

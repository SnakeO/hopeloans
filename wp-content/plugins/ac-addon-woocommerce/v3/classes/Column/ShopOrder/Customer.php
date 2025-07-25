<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 2.0
 */
class ACA_WC_Column_ShopOrder_Customer extends AC_Column_Meta
	implements ACP_Export_Column, ACP_Column_FilteringInterface {

	public function __construct() {
		$this->set_label( 'Customer' );
		$this->set_type( 'column-wc-order_customer' );
		$this->set_group( 'woocommerce' );
	}

	public function get_meta_key() {
		return '_customer_user';
	}

	public function register_settings() {
		$this->add_setting( new ACA_WC_Settings_Customer( $this ) );
	}

	/**
	 * @return ACP_Export_Model
	 */
	public function export() {
		return new ACP_Export_Model_StrippedValue( $this );
	}

	/**
	 * @return ACP_Filtering_Model
	 */
	public function filtering() {

		switch ( $this->get_user_property() ) {
			case 'roles':

				return new ACA_WC_Filtering_ShopOrder_CustomerRole( $this );
			default:

				return new ACP_Filtering_Model_Disabled( $this );
		}

	}

	/**
	 * @return string
	 */
	public function get_user_property() {
		$setting = $this->get_setting( 'user' );

		if ( ! $setting instanceof ACA_WC_Settings_Customer ) {
			return false;
		}

		return $setting->get_display_author_as();
	}

}

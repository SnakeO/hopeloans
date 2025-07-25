<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ShopOrder_IP extends ACP_Column_Meta
	implements ACP_Column_SortingInterface {

	public function __construct() {
		$this->set_type( 'column-wc-order_ip' );
		$this->set_label( __( 'Customer IP address', 'codepress-admin-columns' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_meta_key() {
		switch ( $this->get_setting( 'ip_property' )->get_value() ) {
			case 'country':
				$key = '_customer_ip_country';

				break;
			default:
				$key = '_customer_ip_address';
		};

		return $key;
	}

	public function register_settings() {
		$this->add_setting( new ACA_WC_Settings_IP( $this ) );
	}

	public function filtering() {
		if ( '_customer_ip_address' === $this->get_meta_key() ) {
			return new ACP_Filtering_Model_Disabled( $this );
		}

		return parent::filtering();
	}

}

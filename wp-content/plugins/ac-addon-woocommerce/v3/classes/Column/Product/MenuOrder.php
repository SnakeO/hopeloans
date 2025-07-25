<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_Product_MenuOrder extends ACP_Column_Post_Order {

	public function __construct() {
		parent::__construct();

		$this->set_label( __( 'Menu Order' ) );
		$this->set_group( 'woocommerce' );
	}

	public function is_valid() {
		return true;
	}

}

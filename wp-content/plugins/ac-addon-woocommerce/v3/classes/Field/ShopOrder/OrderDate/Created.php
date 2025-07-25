<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Field_ShopOrder_OrderDate_Created extends ACA_WC_Field_ShopOrder_OrderDate {

	public function set_label() {
		$this->label = __( 'Created', 'codepress-admin-columns' );
	}

	public function get_date( WC_Order $order ) {
		return $order->get_date_created();
	}

	public function filtering() {
		return new ACP_Filtering_Model_Post_Date( $this->column );
	}

}

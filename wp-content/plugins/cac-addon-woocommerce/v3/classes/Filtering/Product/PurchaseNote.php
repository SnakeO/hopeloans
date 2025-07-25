<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Filtering_Product_PurchaseNote extends ACP_Filtering_Model_Meta {

	public function get_filtering_data() {
		return array(
			'empty_option' => $this->get_empty_labels( __( 'Purchase Note', 'woocommerce' ) ),
		);
	}

}

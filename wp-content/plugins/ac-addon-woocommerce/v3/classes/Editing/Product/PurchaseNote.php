<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Editing_Product_PurchaseNote extends ACP_Editing_Model_Meta {

	public function get_view_settings() {
		return array(
			'type' => 'textarea',
		);
	}

}

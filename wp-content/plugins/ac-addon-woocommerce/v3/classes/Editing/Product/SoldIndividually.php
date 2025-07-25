<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Editing_Product_SoldIndividually extends ACP_Editing_Model {

	public function get_view_settings() {
		return array(
			'type'    => 'togglable',
			'options' => array( '', '1' ),
		);
	}

	public function save( $id, $value ) {
		$product = wc_get_product( $id );
		$product->set_sold_individually( $value );
		$product->save();
	}

}

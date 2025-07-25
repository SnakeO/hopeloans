<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Editing_ShopCoupon_FreeShipping extends ACP_Editing_Model {

	public function get_view_settings() {
		return array(
			'type'    => 'togglable',
			'options' => array( 'no', 'yes' ),
		);
	}

	public function save( $id, $value ) {
		$coupon = new WC_Coupon( $id );

		try {
			$coupon->set_free_shipping( 'yes' === $value );
		} catch ( WC_Data_Exception $e ) {
			return new WP_Error( $e->getErrorCode(), $e->getMessage() );
		}

		return $coupon->save();
	}

}

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Editing_ShopCoupon_MaximumAmount extends ACP_Editing_Model {

	public function save( $id, $value ) {
		$coupon = new WC_Coupon( $id );

		try {
			$coupon->set_maximum_amount( $value );
		} catch ( WC_Data_Exception $e ) {
			return new WP_Error( $e->getErrorCode(), $e->getMessage() );
		}

		return $coupon->save();
	}

}

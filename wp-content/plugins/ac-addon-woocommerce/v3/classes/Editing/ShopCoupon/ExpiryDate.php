<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Editing_ShopCoupon_ExpiryDate extends ACP_Editing_Model {

	public function get_view_settings() {
		return array(
			'type' => 'date',
		);
	}

	public function get_edit_value( $id ) {
		$coupon = new WC_Coupon( $id );
		$date = $coupon->get_date_expires();

		if ( ! $date ) {
			return false;
		}

		// Uses GMT offset
		return $date->date( 'Ymd' );
	}

	public function save( $id, $value ) {
		$coupon = new WC_Coupon( $id );

		try {
			$coupon->set_date_expires( strtotime( $value ) );
		} catch ( WC_Data_Exception $e ) {
			return new WP_Error( $e->getErrorCode(), $e->getMessage() );
		}

		return $coupon->save();
	}

}

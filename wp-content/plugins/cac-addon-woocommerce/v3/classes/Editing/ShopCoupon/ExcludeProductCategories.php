<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Editing_ShopCoupon_ExcludeProductCategories extends ACA_WC_Editing_ShopCoupon_ProductCategories {

	public function save( $id, $value ) {
		$coupon = new WC_Coupon( $id );

		try {
			$coupon->set_excluded_product_categories( $value );
		} catch ( WC_Data_Exception $e ) {
			return new WP_Error( $e->getErrorCode(), $e->getMessage() );
		}

		return $coupon->save();
	}

}

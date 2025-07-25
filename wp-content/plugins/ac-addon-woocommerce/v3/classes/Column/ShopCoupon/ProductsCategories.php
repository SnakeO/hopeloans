<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ShopCoupon_ProductsCategories extends ACA_WC_Column_CouponProductCategories
	implements ACP_Column_FilteringInterface, ACP_Column_EditingInterface {

	public function __construct() {
		parent::__construct();

		$this->set_type( 'column-wc-coupon_product_categories' );
		$this->set_label( __( 'Product Categories', 'woocommerce' ) );
	}

	public function get_meta_key() {
		return 'product_categories';
	}

	public function filtering() {
		return new ACA_WC_Filtering_ShopCoupon_ProductCategories( $this );
	}

	public function editing() {
		return new ACA_WC_Editing_ShopCoupon_ProductCategories( $this );
	}

}

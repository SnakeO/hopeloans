<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ProductVariation_SKU extends AC_Column_Meta
	implements ACP_Column_EditingInterface {

	public function __construct() {
		$this->set_type( 'variation_sku' );
		$this->set_label( __( 'SKU', 'woocommerce' ) );
		$this->set_original( true );
	}

	public function get_value( $id ) {
		$variation = new WC_Product_Variation( $id );

		return $variation->get_sku();
	}

	public function get_meta_key() {
		return '_sku';
	}

	public function editing() {
		return new ACA_WC_Editing_ProductVariation_SKU( $this );
	}

}

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ProductVariation_Price extends AC_Column_Meta
	implements ACP_Column_EditingInterface, ACP_Column_SortingInterface, ACP_Column_FilteringInterface {

	public function __construct() {
		$this->set_type( 'variation_price' );
		$this->set_label( __( 'Price', 'woocommerce' ) );
		$this->set_original( true );
	}

	public function get_value( $id ) {
		$variation = new WC_Product_Variation( $id );

		$regular = $variation->get_regular_price();
		$price = $variation->get_price();

		if ( ! $price ) {
			return $this->get_empty_char();
		}

		$value = wc_price( $price );
		if ( $price < $regular ) {
			$value = sprintf( '<del>%s</del> <ins>%s</ins>', wc_price( $regular ), $value );
		}

		return $value;
	}

	public function get_meta_key() {
		return '_regular_price';
	}

	public function editing() {
		return new ACA_WC_Editing_ProductVariation_Price( $this );
	}

	public function sorting() {
		return new ACP_Sorting_Model_Meta( $this );
	}

	public function filtering(){
		return new ACA_WC_Filtering_Numeric( $this );
	}

}

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 1.1
 */
class ACA_WC_Column_ProductVariation_Stock extends AC_Column
	implements ACP_Column_EditingInterface {

	public function __construct() {
		$this->set_type( 'variation_stock' );
		$this->set_label( __( 'Stock', 'woocommerce' ) );
		$this->set_original( true );
	}

	// Pro
	public function get_value( $id ) {
		$variation = new WC_Product_Variation( $id );

		$label = __( 'Out of stock', 'woocommerce' );
		if ( 'instock' === $variation->get_stock_status() ) {
			$label = __( 'In stock', 'woocommerce' );
		}

		$quantity = false;
		if ( $variation->get_stock_quantity() ) {
			$quantity = sprintf( '(%s)', $variation->get_stock_quantity() );
		}

		$icon = false;
		if ( 'parent' === $variation->get_manage_stock() ) {
			$icon = ac_helper()->html->tooltip( '<span class="woocommerce-help-tip"></span>', __( 'Stock managed by product', 'codepress-admin-columns' ) );
		}

		return sprintf( '<mark class="%s">%s</mark> %s %s', $variation->get_stock_status(), $label, $quantity, $icon );
	}

	public function editing() {
		return new ACA_WC_Editing_ProductVariation_Stock( $this );
	}

}

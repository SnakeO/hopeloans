<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ProductVariation_Enabled extends AC_Column
	implements ACP_Column_EditingInterface {

	public function __construct() {
		$this->set_type( 'column-wc-variation_enabled' );
		$this->set_label( __( 'Enabled', 'woocommerce' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_value( $id ) {
		$variation = new WC_Product_Variation( $id );

		return ac_helper()->icon->yes_or_no( 'publish' === $variation->get_status() );
	}

	public function editing() {
		return new ACA_WC_Editing_ProductVariation_Enabled( $this );
	}

}

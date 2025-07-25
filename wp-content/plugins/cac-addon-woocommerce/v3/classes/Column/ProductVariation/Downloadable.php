<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ProductVariation_Downloadable extends AC_Column_Meta
	implements ACP_Column_EditingInterface, ACP_Column_FilteringInterface {

	public function __construct() {
		$this->set_type( 'column-wc-variation_downloadable' );
		$this->set_label( __( 'Downloadable', 'woocommerce' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_meta_key() {
		return '_downloadable';
	}

	public function get_value( $id ) {
		$variation = new WC_Product_Variation( $id );

		return ac_helper()->icon->yes_or_no( $variation->get_downloadable() );
	}

	public function editing() {
		return new ACA_WC_Editing_ProductVariation_Downloadable( $this );
	}

	public function filtering() {
		return new ACA_WC_Filtering_ProductVariation_Downloadable( $this );
	}

}

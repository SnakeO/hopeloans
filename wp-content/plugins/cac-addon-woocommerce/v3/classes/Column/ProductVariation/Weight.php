<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ProductVariation_Weight extends ACA_WC_Column_Product_Weight {

	public function __construct() {
		parent::__construct();
		$this->set_type( 'column-wc-variation_weight' );
	}

	public function editing() {
		return new ACA_WC_Editing_ProductVariation_Weight( $this );
	}

	public function filtering() {
		return new ACP_Filtering_Model_Disabled( $this );
	}

}

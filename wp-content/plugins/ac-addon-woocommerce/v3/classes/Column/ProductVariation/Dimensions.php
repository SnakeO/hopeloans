<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ProductVariation_Dimensions extends ACA_WC_Column_Product_Dimensions {

	public function __construct() {
		parent::__construct();
		$this->set_type( 'column-wc-variation_dimensions' );
	}


}

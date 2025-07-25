<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce product type (default column) exportability model
 *
 * @since 2.2.1
 */
class ACA_WC_Export_Product_Type extends ACP_Export_Model {

	public function get_value( $id ) {
		$product = wc_get_product( $id );

		$type = $product->get_type();

		if ( $product->is_downloadable() ) {
			$type = 'downloadable';
		}

		if ( $product->is_virtual() ) {
			$type = 'virtual';
		}

		return $type;
	}

}

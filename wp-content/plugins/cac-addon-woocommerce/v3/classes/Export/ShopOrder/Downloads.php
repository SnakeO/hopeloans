<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Export_ShopOrder_Downloads extends ACP_Export_Model {

	public function get_value( $id ) {
		$values = array();

		foreach ( $this->column->get_raw_value( $id ) as $download ) {
			$product = new WC_Product( $download['product_id'] );

			$values[] = $product->get_file_download_path( $download['download_id'] );
		}

		if ( empty( $values ) ) {
			return false;
		}

		return implode( $this->column->get_separator(), $values );
	}

}

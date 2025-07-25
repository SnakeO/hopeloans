<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 *
 * @property ACA_WC_Column_Product_Sale $column
 */
class ACA_WC_Export_Product_Sale extends ACP_Export_Model {

	public function __construct( ACA_WC_Column_Product_Sale $column ) {
		parent::__construct( $column );
	}

	public function get_value( $id ) {
		$product = new WC_Product( $id );

		if ( $this->column->is_scheduled( $product ) ) {
			return $product->get_date_on_sale_from( 'edit' )->format( 'Y-m-d' ) . ' / ' . $product->get_date_on_sale_to( 'edit' )->format( 'Y-m-d' );
		}

		return $product->is_on_sale( 'edit' );
	}

}

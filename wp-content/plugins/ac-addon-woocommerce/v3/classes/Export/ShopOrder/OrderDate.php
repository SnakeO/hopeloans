<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @property ACA_WC_Column_ShopOrder_OrderDate $column
 */
class ACA_WC_Export_ShopOrder_OrderDate extends ACP_Export_Model {

	public function __construct( ACA_WC_Column_ShopOrder_OrderDate $column ) {
		parent::__construct( $column );
	}

	public function get_value( $id ) {
		if ( ! $this->column->get_field() ) {
			return false;
		}

		$date = $this->column->get_field()->get_date( new WC_Order( $id ) );

		if ( ! $date ) {
			return false;
		}

		return $date->format( 'Y-m-d H:i' );
	}

}

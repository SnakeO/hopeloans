<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 * @property AC_Column_Meta $column
 */
abstract class ACA_WC_Field_ShopOrder_OrderDate extends ACA_WC_Field
	implements ACP_Export_Column, ACP_Column_SortingInterface {

	/**
	 * @param WC_Order $order
	 *
	 * @return WC_DateTime|false
	 */
	abstract public function get_date( WC_Order $order );

	public function get_value( $id ) {
		$order = new WC_Order( $id );

		$date = $this->get_date( $order );

		if ( ! $date ) {
			return false;
		}

		return $date->getTimestamp();
	}

	public function get_meta_key() {
		return false;
	}

	public function export() {
		return new ACP_Export_Model_RawValue( $this->column );
	}

	public function sorting() {
		if ( $this->get_meta_key() ) {
			return new ACP_Sorting_Model_Meta( $this->column );
		}

		return new ACP_Sorting_Model_Value( $this->column );
	}

	public function filtering() {
		return new ACP_Filtering_Model_Disabled( $this->column );
	}

}

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 *
 * @property ACA_WC_Column_Product_Attributes $column
 */
class ACA_WC_Export_Product_Attributes extends ACP_Export_Model {

	public function __construct( ACA_WC_Column_Product_Attributes $column ) {
		parent::__construct( $column );
	}

	/**
	 * @return string
	 */
	private function get_delimiter() {
		return defined( 'WC_DELIMITER' ) && WC_DELIMITER ? WC_DELIMITER : ' | ';
	}

	/**
	 * @param int $id
	 *
	 * @return string
	 */
	public function get_value( $id ) {
		$values = array();

		foreach ( $this->column->get_raw_value( $id ) as $name => $attribute ) {
			$options = $attribute->get_options();

			if ( $attribute->is_taxonomy() ) {
				$options = wc_get_product_terms( $id, $name, array( 'fields' => 'names' ) );
			}

			$value = implode( ' ' . $this->get_delimiter() . ' ', $options );

			if ( ! $this->column->get_attribute() ) {
				$value = wc_attribute_label( $name ) . ': ' . $value;
			}

			$values[] = $value;
		}

		return implode( ", ", $values );
	}

}

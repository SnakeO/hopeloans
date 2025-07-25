<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 *
 * @property ACA_WC_Column_Product_Downloads $column
 */
class ACA_WC_Export_Product_Downloads extends ACP_Export_Model {

	public function get_value( $id ) {
		$values = array();

		foreach ( $this->column->get_raw_value( $id ) as $id => $download ) {
			$values[] = $download->get_file();
		}

		return implode( $this->column->get_separator(), $values );
	}

}

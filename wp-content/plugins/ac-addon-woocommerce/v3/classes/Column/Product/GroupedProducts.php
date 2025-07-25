<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_Product_GroupedProducts extends AC_Column_Meta
	implements ACP_Column_EditingInterface, ACP_Column_FilteringInterface, ACP_Export_Column {

	public function __construct() {
		$this->set_group( 'woocommerce' );
		$this->set_type( 'column-wc-product-grouped_products' );
		$this->set_label( __( 'Grouped Products', 'woocommerce' ) );
	}

	public function get_value( $id ) {
		$children = $this->get_raw_value( $id );

		if ( empty( $children ) ) {
			return $this->get_empty_char();
		}

		/**
		 * @var AC_Collection $values
		 */
		$values = $this->get_formatted_value( new AC_Collection( $children ) );

		return $values->implode( $this->get_separator() );
	}

	// Meta

	public function get_meta_key() {
		return '_children';
	}

	public function register_settings() {
		$this->add_setting( new AC_Settings_Column_Post( $this ) );
	}

	public function editing() {
		return new ACA_WC_Editing_Product_GroupedProducts( $this );
	}

	public function filtering() {
		return new ACA_WC_Filtering_Product_GroupedProducts( $this );
	}

	public function export() {
		return new ACP_Export_Model_StrippedValue( $this );
	}

}

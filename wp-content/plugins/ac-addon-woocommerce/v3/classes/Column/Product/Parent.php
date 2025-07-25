<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_Product_Parent extends AC_Column
	implements ACP_Export_Column {

	public function __construct() {
		$this->set_group( 'woocommerce' );
		$this->set_type( 'column-wc-product-parent' );
		$this->set_label( __( 'Grouped By', 'codepress-admin-columns' ) );
	}

	public function get_value( $id ) {
		$parents = $this->get_raw_value( $id );

		if ( empty( $parents ) ) {
			return $this->get_empty_char();
		}

		/**
		 * @var AC_Collection $values
		 */
		$values = $this->get_formatted_value( new AC_Collection( $parents ) );

		return $values->implode( $this->get_separator() );
	}

	public function get_raw_value( $id ) {
		return get_posts( array(
			'fields'         => 'ids',
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'     => '_children',
					'value'   => serialize( intval( $id ) ),
					'compare' => 'LIKE',
				),
			),
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'grouped',
				),
			),
		) );
	}

	public function register_settings() {
		$this->add_setting( new AC_Settings_Column_Post( $this ) );
	}

	public function export() {
		return new ACP_Export_Model_StrippedValue( $this );
	}

}

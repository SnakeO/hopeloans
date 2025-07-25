<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
abstract class ACA_WC_Column_CouponProductCategories extends AC_Column_Meta
	implements ACP_Export_Column {

	public function __construct() {
		$this->set_group( 'woocommerce' );
		$this->set_serialized( true );
	}

	public function get_taxonomy() {
		return 'product_cat';
	}

	public function get_value( $id ) {
		$taxonomy_ids = $this->get_raw_value( $id );

		if ( ! $taxonomy_ids ) {
			return $this->get_empty_char();
		}

		$terms = array();
		foreach ( $taxonomy_ids as $term_id ) {
			$term = get_term( $term_id, $this->get_taxonomy() );

			if ( ! $term ) {
				continue;
			}

			$terms[] = $term->name;
		}

		return implode( ', ', $terms );
	}

	public function export() {
		return new ACP_Export_Model_Value( $this );
	}

}

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @property ACA_WC_Column_CouponProductCategories $column
 */
class ACA_WC_Filtering_ShopCoupon_ProductCategories extends ACP_Filtering_Model_Meta {

	public function __construct( ACA_WC_Column_CouponProductCategories $column ) {
		parent::__construct( $column );
	}

	public function get_filtering_vars( $vars ) {
		if ( in_array( $this->get_filter_value(), array( 'cpac_empty', 'cpac_nonempty' ) ) ) {
			return $this->get_filtering_vars_empty_nonempty( $vars );
		}

		return $this->get_filtering_vars_serialized( $vars, (int) $this->get_filter_value() );
	}

	protected function get_filtering_vars_empty_nonempty( $vars ) {
		$empty = array(
			'key'     => $this->column->get_meta_key(),
			'value'   => serialize( array() ),

			// Non empty
			'compare' => '!=',
		);

		if ( 'cpac_empty' === $this->get_filter_value() ) {

			// Empty
			$empty['compare'] = '=';
		}

		$vars['meta_query'][] = $empty;

		return $vars;
	}

	public function get_filtering_data() {
		$options = array();

		foreach ( $this->get_meta_values_unserialized() as $key => $term_id ) {
			$term = get_term( $term_id, $this->column->get_taxonomy() );

			if ( ! $term || is_wp_error( $term ) ) {
				continue;
			}

			$options[ $term_id ] = $term->name;
		}

		return array(
			'options'      => $options,
			'empty_option' => true,
		);
	}

}

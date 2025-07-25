<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Filtering_Product_SoldIndividually extends ACP_Filtering_Model_Meta {

	public function get_filtering_vars( $vars ) {
		$operator = 'yes' == $this->get_filter_value() ? '=' : '!=';

		$vars['meta_query'] = array(
			array(
				'key'     => $this->column->get_meta_key(),
				'value'   => 'yes',
				'compare' => $operator,
			),
		);

		return $vars;
	}

	public function get_filtering_data() {
		return array(
			'order'   => false,
			'options' => array(
				'yes' => __( 'Sold Individually', 'codepress-admin-columns' ),
				'no'  => __( 'Not Sold Individually', 'codepress-admin-columns' ),
			),
		);
	}

}

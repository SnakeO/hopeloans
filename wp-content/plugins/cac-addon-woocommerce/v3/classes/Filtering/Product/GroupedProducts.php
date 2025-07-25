<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Filtering_Product_GroupedProducts extends ACP_Filtering_Model_Meta {

	public function get_filtering_vars( $vars ) {

		$vars['meta_query'][] = array(
			'key'     => $this->column->get_meta_key(),
			'value'   => serialize( intval( $this->get_filter_value() ) ),
			'compare' => 'LIKE',
		);

		$vars['tax_query'][] = array(
			'taxonomy' => 'product_type',
			'field'    => 'slug',
			'terms'    => 'grouped',
		);

		return $vars;
	}

	public function get_grouped_products() {
		return get_posts( array(
			'fields'         => 'ids',
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'grouped',
				),
			),
		) );

	}

	public function get_filtering_data() {
		$products = array();
		$options = array();

		foreach ( $this->get_grouped_products() as $product_id ) {
			$product = wc_get_product( $product_id );
			$products = array_merge( $products, $product->get_children() );
		}

		foreach ( $products as $product_id ) {
			$product = wc_get_product( $product_id );
			$options[ $product_id ] = $product->get_title();
		}

		return array(
			'options' => $options,
		);
	}

}

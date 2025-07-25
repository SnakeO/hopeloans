<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Filtering_Product_Sale extends ACP_Filtering_Model {

	public function get_filtering_vars( $vars ) {
		$on_sale_products = wc_get_product_ids_on_sale();

		switch ( $this->get_filter_value() ) {
			case 'onsale':
				$vars['post__in'] = $on_sale_products;

				break;
			case 'regular':
				$vars['post__not_in'] = $on_sale_products;

				break;
			case 'scheduled':
				$vars['post__not_in'] = $on_sale_products;
				$vars['meta_query'][] = array(
					'key'     => '_sale_price_dates_from',
					'value'   => time(),
					'compare' => '>',
				);

				break;
		}

		return $vars;
	}

	public function get_filtering_data() {
		return array(
			'options' => array(
				'onsale'    => __( 'On Sale', 'codepress-admin-columns' ),
				'regular'   => __( 'Not on Sale', 'codepress-admin-columns' ),
				'scheduled' => __( 'Scheduled', 'codepress-admin-columns' ),
			),
		);
	}

}

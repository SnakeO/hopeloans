<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Filtering_Product_Coupons extends ACP_Filtering_Model {

	public function get_filtering_vars( $vars ) {
		$product_ids = $this->get_products_with_coupon_applied();

		if ( ! empty( $product_ids ) ) {

			switch ( $this->get_filter_value() ) {
				case 'cpac_nonempty':
					$vars['post__in'] = $product_ids;

					break;
				case 'cpac_empty':

					$vars['post__not_in'] = $product_ids;
					break;
			}
		}

		return $vars;
	}

	/**
	 * @return array
	 */
	private function get_products_with_coupon_applied() {
		$coupons = get_posts( array(
			'post_type'  => 'shop_coupon',
			'fields'     => 'ids',
			'meta_query' => array(
				array(
					'key'     => 'product_ids',
					'value'   => '',
					'compare' => '!=',
				),
			),
		) );

		if ( ! $coupons ) {
			return array();
		}

		$products = array();

		foreach ( $coupons as $coupon_id ) {
			$product_ids = explode( ',', get_post_meta( $coupon_id, 'product_ids', true ) );
			$products = array_merge( $products, $product_ids );
		}

		return $products;
	}

	public function get_filtering_data() {
		return array(
			'empty_option' => $this->get_empty_labels( __( 'Coupons Applied', 'woocommerce' ) ),
		);
	}

}

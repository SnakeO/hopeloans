<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @property ACA_WC_Column_ShopCoupon_ProductsCategories $column
 */
class ACA_WC_Editing_ShopCoupon_ProductCategories extends ACP_Editing_Model {

	public function __construct( ACA_WC_Column_CouponProductCategories $column ) {
		parent::__construct( $column );
	}

	public function get_view_settings() {
		return array(
			'type'          => 'select2_dropdown',
			'ajax_populate' => true,
			'multiple'      => true,
		);
	}

	public function get_ajax_options( $request ) {
		$args = array(
			'taxonomy'   => $this->column->get_taxonomy(),
			'hide_empty' => false,
		);

		if ( $request['paged'] ) {
			$args['offset'] = ( $request['paged'] - 1 ) * 40;
			$args['number'] = 40;
		}

		if ( isset( $request['search'] ) ) {
			$args['search'] = $request['search'];
		}

		$terms = acp_editing_helper()->get_terms_list( $args );

		return $terms;
	}

	public function get_edit_value( $id ) {
		$term_ids = $this->column->get_raw_value( $id );

		if ( empty( $term_ids ) ) {
			return false;
		}

		$values = array();

		foreach ( $term_ids as $id ) {
			$term = get_term( $id, $this->column->get_taxonomy() );
			if ( ! $term ) {
				continue;
			}

			$values[ $term->term_id ] = htmlspecialchars_decode( $term->name );
		}

		return $values;
	}

	public function save( $id, $value ) {
		$coupon = new WC_Coupon( $id );

		try {
			$coupon->set_product_categories( $value );
		} catch ( WC_Data_Exception $e ) {
			return new WP_Error( $e->getErrorCode(), $e->getMessage() );
		}

		return $coupon->save();
	}

}

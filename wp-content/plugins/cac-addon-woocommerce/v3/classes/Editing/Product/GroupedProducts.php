<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Editing_Product_GroupedProducts extends ACP_Editing_Model_Meta {

	public function get_view_settings() {
		return array(
			'type'          => 'select2_dropdown',
			'ajax_populate' => true,
			'multiple'      => true,
		);
	}

	public function get_ajax_options( $request ) {
		return ac_addon_wc_helper()->search_products( $request['search'], array( 'paged' => $request['paged'] ) );
	}

	public function get_edit_value( $id ) {
		$product = wc_get_product( $id );

		if ( 'grouped' !== $product->get_type() ) {
			return null;
		}

		return ac_addon_wc_helper()->get_editable_posts_values( $product->get_children() );
	}

	public function save( $id, $values ) {
		parent::save( $id, array_map( 'intval', $values ) );
	}

}

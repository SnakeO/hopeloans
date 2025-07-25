<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Editing_ProductVariation_Weight extends ACP_Editing_Model {

	public function get_edit_value( $post_id ) {
		$product = wc_get_product( $post_id );

		return $product->get_weight();
	}

	public function get_view_settings() {
		return array(
			'type' => 'text',
		);
	}

	public function save( $id, $value ) {
		$product = wc_get_product( $id );
		$product->set_weight( $value );
		$product->save();
	}

	public function register_settings() {
		parent::register_settings();

		$this->column->get_setting( 'edit' )->set_default( 'on' );
	}

}

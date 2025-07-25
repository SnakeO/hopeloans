<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Editing_ProductVariation_Description extends ACP_Editing_Model {

	public function get_edit_value( $post_id ) {
		$product = new WC_Product_Variation( $post_id );

		return $product->get_description();
	}

	public function get_view_settings() {
		return array(
			'type' => 'textarea',
		);
	}

	public function save( $id, $value ) {
		$product = new WC_Product_Variation( $id );
		$product->set_description( $value );
		$product->save();
	}

	public function register_settings() {
		parent::register_settings();

		$this->column->get_setting( 'edit' )->set_default( 'on' );
	}

}

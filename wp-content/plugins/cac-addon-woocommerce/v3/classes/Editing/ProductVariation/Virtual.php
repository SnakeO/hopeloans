<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Editing_ProductVariation_Virtual extends ACP_Editing_Model {

	public function get_view_settings() {
		return array(
			'type'    => 'togglable',
			'options' => array( 'yes', 'no' ),
		);
	}

	public function get_edit_value( $id ) {
		$variation = new WC_Product_Variation( $id );

		return $variation->get_virtual() ? 'yes' : 'no';
	}

	public function save( $id, $value ) {
		$variation = new WC_Product_Variation( $id );

		$variation->set_virtual( $value );
		$variation->save();
	}

	public function register_settings() {
		parent::register_settings();

		$this->column->get_setting( 'edit' )->set_default( 'on' );
	}

}

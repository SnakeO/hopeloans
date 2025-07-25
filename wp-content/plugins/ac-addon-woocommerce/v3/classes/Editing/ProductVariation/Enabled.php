<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Editing_ProductVariation_Enabled extends ACP_Editing_Model {

	public function get_view_settings() {
		return array(
			'type'    => 'togglable',
			'options' => array( 'private', 'publish' ),
		);
	}

	public function get_edit_value( $id ) {
		$variation = new WC_Product_Variation( $id );

		return $variation->get_status();
	}

	public function save( $id, $value ) {
		$variation = new WC_Product_Variation( $id );

		$variation->set_status( $value );
		$variation->save();
	}

	public function register_settings() {
		parent::register_settings();

		$this->column->get_setting( 'edit' )->set_default( 'on' );
	}

}

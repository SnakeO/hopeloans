<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Editing_ProductVariation_Stock extends ACA_WC_Editing_Product_Stock {

	// TODO
	public function get_edit_value( $id ) {
		$product = wc_get_product( $id );

		$data = new stdClass();

		$data->stock_status = $product->get_stock_status();
		$data->woocommerce_option_manage_stock = false;
		$data->stock = false;

		if ( 'yes' === get_option( 'woocommerce_manage_stock' ) ) {
			$data->woocommerce_option_manage_stock = true;
			$data->manage_stock = $product->get_manage_stock() == '1' ? 'yes' : 'no';
			$data->stock = $product->get_stock_quantity();
		}

		return $data;
	}

	public function register_settings() {
		parent::register_settings();

		$this->column->get_setting( 'edit' )->set_default( 'on' );
	}

}

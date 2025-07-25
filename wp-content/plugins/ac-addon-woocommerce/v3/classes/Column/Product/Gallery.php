<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 2.0
 */
class ACA_WC_Column_Product_Gallery extends AC_Column_Meta
	implements ACP_Column_EditingInterface {

	public function __construct() {
		$this->set_group( 'woocommerce' );
		$this->set_type( 'column-wc-product-gallery' );
		$this->set_label( __( 'Gallery', 'woocommerce' ) );
	}

	public function get_meta_key() {
		return '_product_image_gallery';
	}

	public function get_raw_value( $id ) {
		return explode( ',', parent::get_raw_value( $id ) );
	}

	public function editing() {
		return new ACA_WC_Editing_Product_Gallery( $this );
	}

	public function register_settings() {
		$this->add_setting( new AC_Settings_Column_Images( $this ) );
	}

}

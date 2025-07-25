<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 1.0
 */
class ACA_WC_Column_ProductVariation_Thumb extends AC_Column_Meta
	implements ACP_Column_EditingInterface {

	public function __construct() {
		$this->set_type( 'column-wc-variation_thumb' );
		$this->set_label( __( 'Product image', 'woocommerce' ) );
		$this->set_group( 'woocommerce' );
	}

	// Display

	// Meta

	public function get_meta_key() {
		return '_thumbnail_id';
	}

	// Display

	public function get_raw_value( $post_id ) {
		return has_post_thumbnail( $post_id ) ? get_post_thumbnail_id( $post_id ) : false;
	}

	// Pro

	public function editing() {
		return new ACP_Editing_Model_Post_FeaturedImage( $this );
	}

	public function register_settings() {
		$this->add_setting( new AC_Settings_Column_Image( $this ) );
	}

}

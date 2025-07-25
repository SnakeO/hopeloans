<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_Product_ShortDescription extends ACP_Column_Post_Excerpt {

	public function __construct() {
		parent::__construct();

		$this->set_type( 'column-wc-product_short_description' );
		$this->set_label( __( 'Short Description' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_value( $post_id ) {
		if ( ! has_excerpt( $post_id ) ) {
			return $this->get_empty_char();
		}

		return parent::get_value( $post_id );
	}

	public function editing() {
		return new ACA_WC_Editing_Product_ShortDescription( $this );
	}

	public function filtering() {
		return new ACA_WC_Filtering_Product_ShortDescription( $this );
	}

}

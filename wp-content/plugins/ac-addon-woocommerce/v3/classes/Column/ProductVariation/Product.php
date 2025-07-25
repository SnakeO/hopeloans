<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ProductVariation_Product extends AC_Column
	implements ACP_Column_SortingInterface {

	public function __construct() {
		$this->set_type( 'variation_product' );
		$this->set_original( true );
	}

	public function get_value( $id ) {
		$product_id = $this->get_raw_value( $id );

		return ac_helper()->html->link( get_edit_post_link( $product_id ) . '#variation_' . $id, get_the_title( $product_id ) );
	}

	public function get_raw_value( $id ) {
		return get_post_field( 'post_parent', $id );
	}

	public function sorting() {
		return new ACP_Sorting_Model_Post_Parent( $this );
	}

}

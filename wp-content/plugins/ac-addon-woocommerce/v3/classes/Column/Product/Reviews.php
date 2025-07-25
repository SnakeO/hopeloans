<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_Product_Reviews extends AC_Column_Meta
	implements ACP_Column_FilteringInterface, ACP_Column_SortingInterface {

	public function __construct() {
		$this->set_type( 'column-wc-product_reviews' );
		$this->set_label( __( 'Reviews', 'woocommerce' ) );
		$this->set_group( 'woocommerce' );
	}

	// Display

	public function get_value( $id ) {
		$count = $this->get_raw_value( $id );

		if ( ! $count ) {
			return $this->get_empty_char();
		}

		$link = add_query_arg( array( 'p' => $id, 'status' => 'approved' ), get_admin_url( null, 'edit-comments.php' ) );

		return ac_helper()->html->link( $link, $count );
	}

	public function get_raw_value( $post_id ) {
		$product = wc_get_product( $post_id );

		return $product->get_review_count();
	}

	// Meta

	public function get_meta_key() {
		return '_wc_review_count';
	}

	// Pro

	public function sorting() {
		return new ACP_Sorting_Model_Meta( $this );
	}

	public function filtering() {
		return new ACA_WC_Filtering_Numeric( $this );
	}

}

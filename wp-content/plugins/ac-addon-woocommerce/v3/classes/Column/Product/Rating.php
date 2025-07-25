<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_Product_Rating extends AC_Column_Meta
	implements ACP_Column_FilteringInterface, ACP_Column_SortingInterface {

	public function __construct() {
		$this->set_type( 'column-wc-product_rating' );
		$this->set_label( __( 'Average Rating' ) );
		$this->set_group( 'woocommerce' );
	}

	// Display

	public function get_value( $id ) {
		$product = wc_get_product( $id );
		$rating = $product->get_average_rating();

		if ( ! $rating ) {
			return $this->get_empty_char();
		}

		$link = add_query_arg( array( 'p' => $id, 'status' => 'approved' ), get_admin_url( null, 'edit-comments.php' ) );
		$count = ac_helper()->html->link( $link, $product->get_rating_count() );
		$stars = ac_helper()->html->tooltip( ac_helper()->html->stars( $rating, 5 ), $rating );

		return sprintf( '%s (%s)', $stars, $count );
	}

	public function get_raw_value( $post_id ) {
		$product = wc_get_product( $post_id );

		return $product->get_average_rating();
	}

	// Meta

	public function get_meta_key() {
		return '_wc_average_rating';
	}

	// Pro

	public function sorting() {
		return new ACP_Sorting_Model_Meta( $this );
	}

	public function filtering() {
		return new ACA_WC_Filtering_Numeric( $this );
	}

}

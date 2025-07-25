<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_Comment_ProductReview extends AC_Column
	implements ACP_Column_FilteringInterface {

	public function __construct() {
		$this->set_group( 'woocommerce' );
		$this->set_type( 'column-wc-comment_product_review' );
		$this->set_label( __( 'Product Review', 'codepress-admin-columns' ) );
	}

	// Display

	public function get_value( $id ) {
		if ( ! $this->get_raw_value( $id ) ) {
			return false;
		}

		return ac_helper()->icon->yes();
	}

	public function get_raw_value( $id ) {
		$comment = get_comment( $id );

		if ( 'product' !== get_post_type( $comment->comment_post_ID ) ) {
			return false;
		}

		return true;
	}

	public function filtering() {
		return new ACA_WC_Filtering_Comment_ProductReview( $this );
	}

}

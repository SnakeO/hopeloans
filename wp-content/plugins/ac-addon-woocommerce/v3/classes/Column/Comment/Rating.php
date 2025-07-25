<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_Comment_Rating extends AC_Column_Meta
	implements ACP_Column_EditingInterface, ACP_Column_FilteringInterface, ACP_Column_SortingInterface {

	public function __construct() {
		$this->set_group( 'woocommerce' );
		$this->set_type( 'column-wc-comment_rating' );
		$this->set_label( __( 'Rating', 'woocommerce' ) );
	}

	// Meta

	public function get_meta_key() {
		return 'rating';
	}

	// Display

	public function get_value( $id ) {
		$rating = $this->get_raw_value( $id );

		if ( ! $rating ) {
			return $this->get_empty_char();
		}

		return ac_helper()->html->stars( $rating, 5 );
	}

	// Pro

	public function editing() {
		return new ACA_WC_Editing_Comment_Rating( $this );
	}

	public function filtering() {
		return new ACA_WC_Filtering_Numeric( $this );
	}

	public function sorting() {
		return new ACA_WC_Sorting_Comment_Rating( $this );
	}

}

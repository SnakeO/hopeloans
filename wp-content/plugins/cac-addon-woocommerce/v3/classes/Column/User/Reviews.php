<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_User_Reviews extends AC_Column
	implements ACP_Column_SortingInterface, ACP_Export_Column {

	public function __construct() {
		$this->set_type( 'column-wc-user-reviews' );
		$this->set_label( __( 'Reviews', 'woocommerce' ) );
		$this->set_group( 'woocommerce' );
	}

	// Display

	public function get_value( $id ) {
		$count = $this->get_raw_value( $id );

		if ( ! $count ) {
			return $this->get_empty_char();
		}

		$comments_url = add_query_arg( array( 'user_id' => $id, 'post_type' => 'product' ), admin_url( 'edit-comments.php' ) );

		return ac_helper()->html->link( $comments_url, $count );
	}

	public function get_raw_value( $user_id ) {
		global $wpdb;

		$sql = "
			SELECT COUNT( comment_ID )
			FROM {$wpdb->comments} AS c
			INNER JOIN {$wpdb->posts} AS p ON c.comment_post_ID = p.ID AND p.post_type = 'product'
			WHERE c.user_id = %d
			AND c.comment_approved = 1
		";

		$stmt = $wpdb->prepare( $sql, array( $user_id ) );

		return (int) $wpdb->get_var( $stmt );
	}

	// Pro
	public function export() {
		return new ACP_Export_Model_RawValue( $this );
	}

	public function sorting() {
		$sorting = new ACP_Sorting_Model( $this );
		$sorting->set_data_type( 'numeric' );

		return $sorting;
	}

}

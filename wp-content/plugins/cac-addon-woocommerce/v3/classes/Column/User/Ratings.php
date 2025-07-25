<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_User_Ratings extends AC_Column
	implements ACP_Column_SortingInterface, ACP_Export_Column {

	public function __construct() {
		$this->set_type( 'column-wc-user-ratings' );
		$this->set_label( __( 'Ratings', 'woocommerce' ) );
		$this->set_group( 'woocommerce' );
	}

	public function register_settings() {
		$this->add_setting( new ACA_WC_Settings_User_Ratings( $this ) );
	}

	// Display

	public function get_raw_value( $user_id ) {
		global $wpdb;

		$display = $this->get_setting( 'user_ratings' )->get_value();
		$is_avg = $display === 'avg';
		$af = $is_avg ? 'AVG' : 'COUNT';

		$sql = "
			SELECT {$af}(cm.meta_value)
			FROM {$wpdb->comments} AS c
			INNER JOIN {$wpdb->posts} AS p 
				ON c.comment_post_ID = p.ID 
				AND p.post_type = 'product'
			INNER JOIN {$wpdb->commentmeta} AS cm 
				ON cm.comment_id = c.comment_ID
			WHERE c.user_id = %d
			AND c.comment_approved = 1
			AND cm.meta_key = 'rating'
		";

		$stmt = $wpdb->prepare( $sql, array( $user_id ) );
		$value = $wpdb->get_var( $stmt );

		if ( $is_avg ) {
			$value = round( $value, 3 );
		}

		return $value;
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

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Filtering_Comment_ProductReview extends ACP_Filtering_Model {

	public function get_filtering_vars( $vars ) {
		add_filter( 'comments_clauses', array( $this, 'filter_on_product_reviews' ) );

		return $vars;
	}

	public function filter_on_product_reviews( $comments_clauses ) {
		global $wpdb;

		$comments_clauses['join'] .= " JOIN wp_posts as pst ON {$wpdb->comments}.comment_post_ID = pst.ID";

		if ( 'yes' === $this->get_filter_value() ) {
			$comments_clauses['where'] .= " AND pst.post_type = 'product'";
		} else {
			$comments_clauses['where'] .= " AND pst.post_type != 'product'";
		}

		return $comments_clauses;
	}

	public function get_filtering_data() {
		return array(
			'options' => array(
				'no'  => __( 'Exclude Product Reviews', 'codepress-admin-columns' ),
				'yes' => __( 'Only Product Reviews', 'codepress-admin-columns' ),
			),
		);
	}

}

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Filtering_Product_ShortDescription extends ACP_Filtering_Model_Post_Excerpt {

	public function get_filtering_data() {
		return array(
			'options' => array(
				'without_exerpt' => __( "Without Short Description", 'codepress-admin-columns' ),
				'has_excerpt'    => __( "Has Short Description", 'codepress-admin-columns' ),
			),
		);
	}

}

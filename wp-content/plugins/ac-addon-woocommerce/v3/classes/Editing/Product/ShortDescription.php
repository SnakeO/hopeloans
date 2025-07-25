<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Editing_Product_ShortDescription extends ACP_Editing_Model_Post_Excerpt {

	public function get_view_settings() {
		return array(
			'type' => 'textarea',
		);
	}

}

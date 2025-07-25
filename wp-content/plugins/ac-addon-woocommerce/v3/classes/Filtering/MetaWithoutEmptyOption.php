<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Filtering_MetaWithoutEmptyOption extends ACP_Filtering_Model_Meta {

	public function get_filtering_data() {
		$data = parent::get_filtering_data();
		$data['empty_option'] = false;

		return $data;
	}

}

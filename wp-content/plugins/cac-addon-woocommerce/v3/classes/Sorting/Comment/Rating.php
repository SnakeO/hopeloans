<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Sorting_Comment_Rating extends ACP_Sorting_Model_Meta {

	public function get_sorting_vars() {
		$key = $this->column->get_meta_key();

		$id = uniqid();

		$vars = array(
			'meta_query' => array(
				$id => array(
					'key'     => $key,
					'type'    => $this->get_data_type(),
					'value'   => '',
					'compare' => '!=',
				),
			),
			'orderby'    => $id,
		);

		return $vars;
	}

}

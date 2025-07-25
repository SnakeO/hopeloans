<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Editing_Strategy extends ACP_Editing_Strategy_Post {

	/**
	 * @return int[]
	 */
	public function get_rows() {

		$table = new ACA_WC_Admin_Variations( );
		$table->prepare_items();

		return $this->get_editable_rows( $table->items );
	}

}

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ProductVariation_ID extends ACP_Column_Post_ID {

	public function __construct() {
		parent::__construct();

		$this->set_label( null );
		$this->set_type( 'variation_id' );
		$this->set_original( true );
	}

	public function get_raw_value( $id ) {
		return $id;
	}

}

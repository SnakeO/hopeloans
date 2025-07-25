<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Filtering_ShopOrder_MetaDate extends ACP_Filtering_Model_MetaDate {

	public function __construct( $column ) {
		parent::__construct( $column );

		$this->set_date_format( 'U' );
	}

}

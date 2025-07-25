<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_ListScreen_ProductVariation extends ACP_ListScreen_Post {

	public function __construct() {
		parent::__construct( 'product_variation' );

		$this->set_group( 'woocommerce' );
	}

	protected function register_column_types() {

		$this->register_column_type( new ACP_Column_Actions );
		$this->register_column_type( new ACP_Column_Post_AuthorName );
		$this->register_column_type( new ACP_Column_Post_DatePublished );
		$this->register_column_type( new ACP_Column_Post_ID );
		$this->register_column_type( new ACP_Column_Post_LastModifiedAuthor );
		$this->register_column_type( new ACP_Column_Post_Slug );
		$this->register_column_type( new ACP_Column_Post_Status );
		$this->register_column_type( new ACP_Column_CustomField );

		$this->register_column_types_from_dir( ac_addon_wc()->get_plugin_dir() . 'classes/Column/ProductVariation', ac_addon_wc()->get_prefix() );
	}

}

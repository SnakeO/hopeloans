<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_ListScreen_ShopOrder extends ACP_ListScreen_Post {

	public function __construct() {
		parent::__construct( 'shop_order' );

		$this->set_group( 'woocommerce' );
	}

	protected function register_column_types() {
		parent::register_column_types();

		$this->register_column_types_from_dir( ac_addon_wc()->get_plugin_dir() . 'classes/Column/ShopOrder/Address', ac_addon_wc()->get_prefix() );
		$this->register_column_types_from_dir( ac_addon_wc()->get_plugin_dir() . 'classes/Column/ShopOrder', ac_addon_wc()->get_prefix() );
	}

}

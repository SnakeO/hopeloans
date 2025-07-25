<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Editing_ShopOrder_MetaCountry extends ACP_Editing_Model_Meta {

	public function get_view_settings() {

		$options = array_merge( array(
			'' => __( 'None', 'codepress-admin-columns' ),
		), WC()->countries->get_countries() );

		return array(
			'type'    => 'select',
			'options' => $options,
		);
	}

}

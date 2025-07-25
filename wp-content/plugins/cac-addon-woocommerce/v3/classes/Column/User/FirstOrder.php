<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_User_FirstOrder extends ACA_WC_Column_UserOrder {

	public function __construct() {
		parent::__construct();

		$this->set_type( 'column-wc-user-first_order' );
		$this->set_label( __( 'First Order', 'codepress-admin-columns' ) );
	}

	public function get_order_by_user_id( $id ) {
		$order = $this->get_order_for_user( $id, array( 'order' => 'ASC' ) );

		return $order;
	}

	public function register_settings() {
		$this->add_setting( new ACA_WC_Settings_Order( $this ) );
	}

}

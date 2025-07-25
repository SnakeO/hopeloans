<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Settings_Customer extends ACP_Settings_Column_User {

	protected function get_display_options() {
		$options = parent::get_display_options();

		$options[] = array(
			'title'   => __( 'WooCommerce', 'codepress-admin-columns' ),
			'options' => array(
				'billing_address'  => __( 'Billing Address', 'woocommerce' ),
				'customer_since'   => __( 'Customer Since', 'codepress-admin-columns' ),
				'shipping_address' => __( 'Shipping Address', 'woocommerce' ),
				'order_count'      => __( 'Order Count', 'codepress-admin-columns' ),
			),
		);

		return $options;
	}

	public function get_dependent_settings() {

		switch ( $this->get_display_author_as() ) {
			case 'customer_since' :
				return array( new AC_Settings_Column_Date( $this->column ) );

			default :
				return parent::get_dependent_settings();
		}
	}

	/**
	 * @param int $user_id
	 * @param int $order_id
	 *
	 * @return string|false
	 */
	public function format( $user_id, $order_id ) {

		switch ( $this->get_display_author_as() ) {

			case 'billing_address' :
				return wc_get_order( $order_id )->get_formatted_billing_address();

			case 'customer_since' :
				$fto = $this->get_first_order_for_user( $user_id );

				if ( ! $fto ) {
					return false;
				}

				return get_post_field( 'post_date', $fto );

			case 'order_count' :
				$orders = $this->get_order_ids_for_user( $user_id );

				if ( ! $orders ) {
					return false;
				}

				return ac_helper()->html->link( add_query_arg( '_customer_user', $user_id ), count( $orders ) );

			case 'shipping_address' :

				return wc_get_order( $order_id )->get_formatted_shipping_address();
			default :

				return parent::format( $user_id, $order_id );
		}
	}

	/**
	 * @param int $user_id
	 *
	 * @return int[]|false
	 */
	private function get_order_ids_for_user( $user_id ) {
		if ( ! $user_id ) {
			return false;
		}

		$args = array(
			'post_type'      => wc_get_order_types(),
			'post_status'    => array_keys( wc_get_order_statuses() ),
			'meta_query'     => array(
				array(
					'key'   => '_customer_user',
					'value' => $user_id,
				),
			),
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'ASC',
			'fields'         => 'ids',
		);

		return get_posts( $args );
	}

	/**
	 * @param int $user_id
	 *
	 * @return int|false
	 */
	private function get_first_order_for_user( $user_id ) {
		$orders = $this->get_order_ids_for_user( $user_id );

		if ( empty( $orders ) ) {
			return false;
		}

		return current( $orders );
	}

}

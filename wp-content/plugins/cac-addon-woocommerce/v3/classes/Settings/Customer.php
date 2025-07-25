<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Settings_Customer extends ACP_Settings_Column_User
	implements AC_Settings_FormatValueInterface {

	protected function get_display_options() {
		$options = parent::get_display_options();

		$display_options = array(
			'default'     => array(
				'title'   => __( 'Default' ),
				'options' => array(),
			),
			'woocommerce' => array(
				'title'   => __( 'WooCommerce', 'codepress-admin-columns' ),
				'options' => array(
					'billing_address'  => __( 'Billing Address', 'woocommerce' ),
					'customer_since'   => __( 'Customer Since', 'codepress-admin-columns' ),
					'shipping_address' => __( 'Shipping Address', 'woocommerce' ),
					'order_count'      => __( 'Order Count', 'codepress-admin-columns' ),
				),
			),
		);

		if ( isset( $options['custom_field'] ) ) {
			$display_options['custom_field'] = array(
				'title'   => __( 'Custom Field', 'codepress-admin-columns' ),
				'options' => array(
					'custom_field' => $options['custom_field'],
				),
			);
			unset( $options['custom_field'] );
		}

		$display_options['default']['options'] = $options;

		return $display_options;
	}

	public function get_dependent_settings() {

		switch ( $this->get_display_author_as() ) {
			case 'customer_since' :
				$settings[] = new AC_Settings_Column_Date( $this->column );

				break;
			case 'custom_field':
				$settings[] = new ACP_Settings_Column_UserCustomField( $this->column );

				break;
			default :
				$settings = array();
		}

		return $settings;
	}

	public function format( $user_id, $order_id ) {
		$value = $user_id;

		switch ( $this->get_display_author_as() ) {
			case 'billing_address':
				$value = wc_get_order( $order_id )->get_formatted_billing_address();

				break;
			case 'customer_since':
				if ( $fto = $this->get_first_order_for_user( $user_id ) ) {
					$value = get_post_field( 'post_date', $fto );
				};

				break;
			case 'order_count':
				if ( $orders = $this->get_orders_for_user( $user_id ) ) {
					$value = ac_helper()->html->link( add_query_arg( '_customer_user', $user_id ), count( $orders ) );
				}

				break;
			case 'shipping_address':
				$value = wc_get_order( $order_id )->get_formatted_shipping_address();

				break;
			default:
				$value = parent::format( $value, $user_id );
		}

		return $value;
	}

	/**
	 * @param int $user_id
	 *
	 * @return array|false
	 */
	private function get_orders_for_user( $user_id ) {
		if ( ! $user_id ) {
			return false;
		}

		return get_posts( array(
			'numberposts' => -1,
			'meta_key'    => '_customer_user',
			'meta_value'  => $user_id,
			'post_type'   => wc_get_order_types(),
			'post_status' => array_keys( wc_get_order_statuses() ),
			'fields'      => 'ids',
			'order_by'    => 'date',
			'order'       => 'ASC',
		) );
	}

	/**
	 * @param int $user_id
	 *
	 * @return int|false
	 */
	private function get_first_order_for_user( $user_id ) {
		$orders = $this->get_orders_for_user( $user_id );

		if ( empty( $orders ) ) {
			return false;
		}

		return current( $orders );
	}

}

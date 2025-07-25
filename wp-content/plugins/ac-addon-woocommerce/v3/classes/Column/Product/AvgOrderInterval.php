<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_Product_AvgOrderInterval extends AC_Column {

	private $start_order = null;

	public function __construct() {
		$this->set_type( 'column-wc-avg_order_interval' );
		$this->set_label( __( 'Avarage Order Interval', 'codepress-admin-columns' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_value( $post_id ) {
		$days = $this->get_raw_value( $post_id );

		if ( ! $days ) {
			return $this->get_empty_char();
		}

		return human_time_diff( 0, $days * DAY_IN_SECONDS );
	}

	public function get_raw_value( $post_id ) {
		$orders = $this->get_product_order_count( $post_id );

		if ( ! $orders ) {
			return false;
		}

		return round( $this->get_period_in_days() / $orders, 3 );
	}

	public function register_settings() {
		$this->add_setting( new ACA_WC_Settings_Period( $this ) );
	}

	/**
	 * @param $post_id
	 *
	 * @return false|int
	 */
	public function get_product_order_count( $post_id ) {
		global $wpdb;

		$start_order = $this->get_start_order();

		if ( ! $start_order ) {
			return false;
		}

		$num_orders = $wpdb->get_var( $wpdb->prepare( "
			SELECT COUNT( wc_oi.order_id )
			FROM {$wpdb->prefix}woocommerce_order_items wc_oi
			JOIN {$wpdb->prefix}woocommerce_order_itemmeta wc_oim
				ON wc_oi.order_item_id = wc_oim.order_item_id
			WHERE wc_oim.meta_key = '_product_id'
				AND wc_oim.meta_value = %d
				AND wc_oi.order_id > %d",
			$post_id,
			$start_order
		) );

		if ( ! $num_orders ) {
			return false;
		}

		return $num_orders;
	}

	/**
	 * @return false|int
	 */
	private function get_start_order() {
		if ( null === $this->start_order ) {
			$start_order = false;

			$start_date = new DateTime();
			$start_date->modify( '-' . $this->get_period_in_days() . 'days' );

			$order = get_posts( array(
				'post_type'      => 'shop_order',
				'post_status'    => 'completed',
				'order'          => 'ASC',
				'fields'         => 'ids',
				'date_query'     => array(
					array(
						'after'     => $start_date->format( 'Y-m-d' ),
						'inclusive' => true,
					),
				),
				'posts_per_page' => 1,

			) );

			if ( ! empty( $order ) ) {
				$start_order = $order[0];
			}

			$this->start_order = $start_order;
		}

		return $this->start_order;
	}

	/**
	 * @return int|false
	 */
	private function get_period_in_days() {
		$setting = $this->get_setting( 'period' );

		if ( ! $setting instanceof ACA_WC_Settings_Period ) {
			return false;
		}

		return $setting->get_period();
	}

}

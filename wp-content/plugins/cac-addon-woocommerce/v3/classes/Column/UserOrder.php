<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
abstract class ACA_WC_Column_UserOrder extends AC_Column
	implements ACP_Column_SortingInterface {

	public function __construct() {
		$this->set_group( 'woocommerce' );
	}

	/**
	 * @param int   $id
	 * @param array $args
	 *
	 * @return int[]
	 */
	abstract protected function get_order_by_user_id( $id );

	/**
	 * @param int $id
	 *
	 * @return array|string
	 */
	public function get_raw_value( $id ) {
		return $this->get_order_by_user_id( $id );
	}

	/**
	 * @param int   $user_id
	 * @param array $args
	 *
	 * @return int|false
	 */
	protected function get_order_for_user( $user_id, array $args ) {
		$args = wp_parse_args( $args, array(
			'fields'         => 'ids',
			'post_type'      => 'shop_order',
			'posts_per_page' => 1,
			'post_status'    => 'wc-completed',
			'meta_query'     => array(
				array(
					'key'   => '_customer_user',
					'value' => $user_id,
				),
			),
		) );

		$order_ids = get_posts( $args );

		if ( ! $order_ids ) {
			return false;
		}

		return $order_ids[0];
	}

	public function sorting() {
		$model = new ACP_Sorting_Model( $this );
		$model->set_data_type( 'numeric' );

		return $model;
	}

}

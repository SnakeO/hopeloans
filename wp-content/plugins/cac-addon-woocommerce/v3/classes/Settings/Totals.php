<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Settings_Totals extends AC_Settings_Column {

	/**
	 * @var string
	 */
	private $order_total_property;

	protected function define_options() {
		return array(
			'order_total_property' => 'total',
		);
	}

	public function create_view() {
		$select = $this->create_element( 'select' )
		               ->set_attribute( 'data-refresh', 'column' )
		               ->set_attribute( 'data-label', 'update' )
		               ->set_options( $this->get_display_options() );

		$view = new AC_View( array(
			'label'   => __( 'Display', 'codepress-admin-columns' ),
			'setting' => $select,
		) );

		return $view;
	}

	protected function get_display_options() {
		$options = array(
			'total'    => __( 'Total', 'codepress-admin-columns' ),
			'subtotal' => __( 'Subtotal', 'codepress-admin-columns' ),
			'shipping' => __( 'Shipping Costs', 'codepress-admin-columns' ),
			'tax'      => __( 'Tax', 'codepress-admin-columns' ),
			'refunded' => __( 'Refunds', 'codepress-admin-columns' ),
			'discount' => __( 'Discounts', 'codepress-admin-columns' ),
			'paid'     => __( 'Paid', 'codepress-admin-columns' ),
		);

		natcasesort( $options );

		return $options;
	}

	/**
	 * @return string
	 */
	public function get_order_total_property() {
		return $this->order_total_property;
	}

	/**
	 * @param string $order_total_property
	 */
	public function set_order_total_property( $order_total_property ) {
		$this->order_total_property = $order_total_property;
	}

}

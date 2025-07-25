<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Settings_User_Products extends AC_Settings_Column {

	/**
	 * @var string
	 */
	private $user_products;

	protected function set_name() {
		$this->name = 'user_products';
	}

	protected function define_options() {
		return array(
			'user_products' => 'total',
		);
	}

	public function create_view() {
		$select = $this->create_element( 'select' )
		               ->set_attribute( 'data-refresh', 'column' )
		               ->set_options( $this->get_display_options() );

		$view = new AC_View( array(
			'label'   => __( 'Display', 'codepress-admin-columns' ),
			'setting' => $select,
		) );

		return $view;
	}

	protected function get_display_options() {
		$options = array(
			'total'  => __( 'Total products purchased', 'codepress-admin-columns' ),
			'unique' => __( 'Unique products purchased', 'codepress-admin-columns' ),
		);

		return $options;
	}

	/**
	 * @return string
	 */
	public function get_user_products() {
		return $this->user_products;
	}

	/**
	 * @param string $user_products
	 */
	public function set_user_products( $user_products ) {
		$this->user_products = $user_products;
	}

}

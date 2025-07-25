<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Settings_IP extends AC_Settings_Column {

	/**
	 * @var string
	 */
	private $ip_property;

	protected function set_name() {
		$this->name = 'ip_property';
	}

	protected function define_options() {
		return array(
			'ip_property' => 'ip',
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
		return array(
			'ip'      => __( 'IP Address', 'codepress-admin-columns' ),
			'country' => __( 'IP Country Code', 'codepress-admin-columns' ),
		);
	}

	/**
	 * @return string
	 */
	public function get_ip_property() {
		return $this->ip_property;
	}

	/**
	 * @param string $ip_property
	 */
	public function set_ip_property( $ip_property ) {
		$this->ip_property = $ip_property;
	}

}

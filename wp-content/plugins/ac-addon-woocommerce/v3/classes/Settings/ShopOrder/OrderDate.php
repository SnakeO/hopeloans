<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 * @property ACA_WC_Column_ShopOrder_OrderDate $column
 */
class ACA_WC_Settings_ShopOrder_OrderDate extends AC_Settings_Column
	implements AC_Settings_FormatValueInterface {

	/**
	 * @var string
	 */
	private $date_type;

	public function __construct( ACA_WC_Column_ShopOrder_OrderDate $column ) {
		parent::__construct( $column );
	}

	/**
	 * @return array
	 */
	protected function define_options() {
		return array(
			'date_type',
		);
	}

	/**
	 * @return AC_View
	 */
	public function create_view() {
		$select = $this->create_element( 'select' )
		               ->set_attribute( 'data-label', 'update' )
		               ->set_attribute( 'data-refresh', 'column' )
		               ->set_options( $this->get_display_options() );

		$view = new AC_View( array(
			'label'   => __( 'Display', 'codepress-admin-columns' ),
			'setting' => $select,
		) );

		return $view;
	}

	public function get_dependent_settings() {
		return array( new AC_Settings_Column_Date( $this->column ) );
	}

	/**
	 * @return array
	 */
	protected function get_display_options() {
		$options = array();

		foreach ( $this->column->get_fields() as $field ) {
			$options[ $field->get_key() ] = $field->get_label();
		}

		asort( $options );

		return $options;
	}

	/**
	 * @param string $date_type
	 */
	public function set_date_type( $date_type ) {
		$this->date_type = $date_type;
	}

	/**
	 * @return string
	 */
	public function get_date_type() {
		return $this->date_type;
	}

	/**
	 * @param string $value
	 * @param int    $id
	 *
	 * @return string|false
	 */
	public function format( $value, $id ) {
		$field = $this->column->get_field();

		if ( ! $field ) {
			return false;
		}

		return $field->get_value( $id );
	}

}

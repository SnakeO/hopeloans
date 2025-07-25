<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
abstract class ACA_WC_Field {

	/**
	 * @var AC_Column
	 */
	protected $column;

	/**
	 * @var string
	 */
	protected $label;

	/**
	 * @return string
	 */
	abstract public function set_label();

	/**
	 * @return string
	 */
	abstract public function get_value( $id );

	/**
	 * @param AC_Column $column
	 */
	public function __construct( AC_Column $column ) {
		$this->column = $column;

		$this->set_label();
	}

	/**
	 * @return string
	 */
	public function get_label() {
		return $this->label;
	}

	/**
	 * @return string
	 */
	public function get_key() {
		return get_class( $this );
	}

}

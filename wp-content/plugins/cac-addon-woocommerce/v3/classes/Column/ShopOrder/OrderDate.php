<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ShopOrder_OrderDate extends AC_Column_Meta
	implements ACP_Export_Column, ACP_Column_SortingInterface, ACP_Column_FilteringInterface {

	/**
	 * @var ACA_WC_Field_ShopOrder_OrderDate
	 */
	private $field;

	public function __construct() {
		$this->set_label( 'Date' );
		$this->set_type( 'column-wc-order_date' );
		$this->set_group( 'woocommerce' );
	}

	public function register_settings() {
		$this->add_setting( new ACA_WC_Settings_ShopOrder_OrderDate( $this ) );
	}

	public function get_meta_key() {
		if ( ! $this->get_field() ) {
			return false;
		}

		return $this->get_field()->get_meta_key();
	}

	public function export() {
		if ( ! $this->get_field() ) {
			return new ACP_Export_Model_Disabled( $this );
		}

		return $this->get_field()->export();
	}

	public function sorting() {
		if ( ! $this->get_field() ) {
			return new ACP_Sorting_Model_Disabled( $this );
		}

		return $this->get_field()->sorting();
	}

	public function filtering() {
		if ( ! $this->get_field() ) {
			return new ACP_Filtering_Model_Disabled( $this );
		}

		return $this->get_field()->filtering();
	}

	private function set_field() {
		$type = $this->get_setting( 'date_type' )->get_value();

		foreach ( $this->get_fields() as $field ) {
			if ( $field->get_key() === $type ) {
				$this->field = $field;
			}
		}
	}

	/**
	 * @return ACA_WC_Field_ShopOrder_OrderDate|false
	 */
	public function get_field() {
		if ( null === $this->field ) {
			$this->set_field();
		}

		return $this->field;
	}

	/**
	 * @return ACA_WC_Field_ShopOrder_OrderDate[]
	 */
	public function get_fields() {
		$childs = array();

		$classes = AC()->autoloader()->get_class_names_from_dir( ac_addon_wc()->get_plugin_dir() . 'classes/Field/ShopOrder/OrderDate', ac_addon_wc()->get_prefix() );

		foreach ( $classes as $name ) {
			$childs[] = new $name( $this );
		}

		return $childs;
	}

}

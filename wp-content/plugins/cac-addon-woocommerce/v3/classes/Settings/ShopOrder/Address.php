<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Settings_ShopOrder_Address extends AC_Settings_Column
	implements AC_Settings_FormatValueInterface {

	/**
	 * @var string
	 */
	private $address_property;

	protected function set_name() {
		$this->name = 'address_property';
	}

	protected function define_options() {
		return array(
			'address_property' => '',
		);
	}

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

	protected function get_display_options() {
		$options = array(
			''           => __( 'Full Address', 'codepress-admin-columns' ),
			'address_1'  => $this->column->get_label() . ' 1',
			'address_2'  => $this->column->get_label() . ' 2',
			'city'       => __( 'City', 'woocommerce' ),
			'company'    => __( 'Company', 'woocommerce' ),
			'country'    => __( 'Country', 'woocommerce' ),
			'first_name' => __( 'First Name', 'woocommerce' ),
			'last_name'  => __( 'Last Name', 'woocommerce' ),
			'postcode'   => __( 'Postcode', 'woocommerce' ),
			'state'      => __( 'State', 'woocommerce' ),
		);

		return $options;
	}

	public function format( $value, $original_value ) {

		switch ( $this->get_address_property() ) {
			case 'country' :
				$countries =  WC()->countries->get_countries();

				if ( isset( $countries[ $value ] ) ) {
					$value = $countries[ $value ];
				}

				break;
		}

		return $value;
	}

	/**
	 * @return string
	 */
	public function get_address_property() {
		return $this->address_property;
	}

	/**
	 * @param string $address_property
	 */
	public function set_address_property( $address_property ) {
		$this->address_property = $address_property;
	}

}

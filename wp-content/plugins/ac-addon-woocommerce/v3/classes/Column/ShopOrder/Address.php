<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
abstract class ACA_WC_Column_ShopOrder_Address extends AC_Column_Meta
	implements ACP_Column_FilteringInterface, ACP_Column_SortingInterface, ACP_Column_EditingInterface, ACP_Export_Column {

	/**
	 * @param WC_Order $order
	 *
	 * @return string
	 */
	abstract protected function get_formatted_address( WC_Order $order );

	/**
	 * @return ACA_WC_Settings_ShopOrder_Address
	 */
	abstract protected function get_setting_address_object();

	/**
	 * @return false|string
	 */
	protected function get_address_property() {
		$setting = $this->get_setting( 'address_property' );

		if ( ! $setting instanceof ACA_WC_Settings_ShopOrder_Address ) {
			return false;
		}

		return $setting->get_address_property();
	}

	public function get_raw_value( $id ) {
		if ( ! $this->get_meta_key() ) {
			return $this->get_formatted_address( wc_get_order( $id ) );
		}

		return parent::get_raw_value( $id );
	}

	public function register_settings() {
		$this->add_setting( $this->get_setting_address_object() );
	}

	public function filtering() {
		if ( ! $this->get_meta_key() ) {
			return new ACP_Filtering_Model_Disabled( $this );
		}

		return new ACP_Filtering_Model_Meta( $this );
	}

	public function sorting() {
		if ( ! $this->get_meta_key() ) {
			return new ACP_Sorting_Model_Disabled( $this );
		}

		return new ACP_Sorting_Model_Meta( $this );
	}

	public function editing() {
		switch ( $this->get_address_property() ) {
			case '' :
				return new ACP_Editing_Model_Disabled( $this );

			case 'country' :
				return new ACA_WC_Editing_ShopOrder_MetaCountry( $this );

			default :
				return new ACP_Editing_Model_Meta( $this );
		}
	}

	public function export() {
		return new ACP_Export_Model_StrippedValue( $this );
	}

}

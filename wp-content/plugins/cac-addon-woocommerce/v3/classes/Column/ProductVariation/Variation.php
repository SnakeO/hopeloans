<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ProductVariation_Variation extends AC_Column
	implements ACP_Column_EditingInterface {

	public function __construct() {
		$this->set_type( 'variation_attributes' );
		$this->set_original( true );
	}

	/**
	 * @return ACA_WC_Settings_ProductVariation_Variation|false
	 */
	public function get_setting_variation() {
		$setting = $this->get_setting( 'variation_display' );

		if ( ! $setting instanceof ACA_WC_Settings_ProductVariation_Variation ) {
			return false;
		}

		return $setting;
	}

	public function register_settings() {
		$this->add_setting( new ACA_WC_Settings_ProductVariation_Variation( $this ) );
	}

	public function editing() {
		return new ACA_WC_Editing_ProductVariation_Variation( $this );
	}

}

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Settings_Product extends AC_Settings_Column_Post
	implements AC_Settings_FormatValueInterface {

	protected function get_post_type() {
		return 'product';
	}

	protected function get_display_options() {
		$options = parent::get_display_options();

		unset( $options['thumbnail'] );

		$display_options = array(
			'default'      => array(
				'title'   => __( 'Post' ),
				'options' => $options,
			),
			'product'  => array(
				'title'   => __( 'Product', 'codepress-admin-columns' ),
				'options' => array(
					'sku'       => __( 'SKU', 'woocommerce' ),
					'thumbnail' => __( 'Product image', 'woocommerce' ),
				),
			),
			'custom_field' => array(
				'title'   => __( 'Custom Field', 'codepress-admin-columns' ),
				'options' => array(
					'custom_field' => __( 'Custom Field', 'codepress-admin-columns' ),
				),
			),
		);

		return $display_options;
	}

	public function format( $value, $original_value ) {

		switch ( $this->get_post_property_display() ) {
			case 'sku' :
				return esc_html( get_post_meta( $original_value, '_sku', true ) );

			case 'custom_field' :
				return get_post_meta( $original_value, $this->column->get_setting( 'custom_field' )->get_value(), true );

			default:
				return parent::format( $value, $original_value );
		}
	}

	public function get_dependent_settings() {
		$settings = parent::get_dependent_settings();

		if ( 'custom_field' === $this->get_post_property_display() ) {
			$settings[] = new ACA_WC_Settings_ProductMeta( $this->column );
			$settings[] = new AC_Settings_Column_BeforeAfter( $this->column );
		}

		return $settings;
	}

}

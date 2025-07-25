<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @property ACA_WC_Column_Product_Attributes $column
 */
class ACA_WC_Editing_Product_Attributes extends ACP_Editing_Model {

	public function __construct( ACA_WC_Column_Product_Attributes $column ) {
		parent::__construct( $column );
	}

	public function get_view_settings() {
		return array(
			'type' => 'multi_input',
		);
	}

	public function get_edit_value( $id ) {
		$attribute = $this->get_attribute_object( $id );

		if ( ! $attribute ) {
			return array();
		}

		return array_flip( $attribute->get_options() );
	}

	/**
	 * @param $id
	 *
	 * @return false|WC_Product_Attribute
	 */
	private function get_attribute_object( $id ) {
		$attributes = wc_get_product( $id )->get_attributes();

		if ( ! isset( $attributes[ $this->column->get_attribute() ] ) ) {
			return false;
		}

		return $attributes[ $this->column->get_attribute() ];
	}

	/**
	 * @return false|WC_Product_Attribute
	 */
	private function create_taxonomy_attribute() {
		global $wc_product_attributes;

		if ( ! isset( $wc_product_attributes[ $this->column->get_attribute() ] ) ) {
			return false;
		}

		$data = $wc_product_attributes[ $this->column->get_attribute() ];

		$attribute = new WC_Product_Attribute();

		$attribute->set_id( $data->attribute_id );
		$attribute->set_name( $this->column->get_attribute() );

		return $attribute;
	}

	/**
	 * @return false|WC_Product_Attribute
	 */
	private function create_custom_attribute() {
		$labels = $this->column->get_setting_attribute()->get_attributes_custom_labels();

		if ( ! isset( $labels[ $this->column->get_attribute() ] ) ) {
			return false;
		}

		$attribute = new WC_Product_Attribute();
		$attribute->set_name( $labels[ $this->column->get_attribute() ] );

		return $attribute;
	}

	/**
	 * @return false|WC_Product_Attribute
	 */
	private function create_attribute() {
		if ( $this->column->get_taxonomy() ) {
			return $this->create_taxonomy_attribute();
		}

		return $this->create_custom_attribute();
	}

	/**
	 * @param int          $id
	 * @param array|string $options
	 *
	 * @return WP_Error|array
	 */
	public function save( $id, $options ) {
		$attribute = $this->get_attribute_object( $id );

		if ( ! $attribute ) {
			$attribute = $this->create_attribute();
		}

		if ( ! $attribute ) {
			return new WP_Error( 'non-existing-attribute' );
		}

		$attribute->set_options( $options );

		$product = wc_get_product( $id );

		$attributes = $product->get_attributes();
		$attributes[] = $attribute;

		$product->set_attributes( $attributes );
		$product->save();

		return $attributes;
	}

}

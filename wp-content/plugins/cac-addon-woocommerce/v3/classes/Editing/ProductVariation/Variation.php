<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @property ACA_WC_Column_ProductVariation_Variation $column
 */
class ACA_WC_Editing_ProductVariation_Variation extends ACP_Editing_Model {

	public function __construct( ACA_WC_Column_ProductVariation_Variation $column ) {
		parent::__construct( $column );
	}

	public function get_view_settings() {
		return array(
			'type' => 'wc_variation',
		);
	}

	/**
	 * @param int $id
	 *
	 * @return stdClass
	 */
	public function get_edit_value( $id ) {
		$variation = new WC_Product_Variation( $id );
		$product = new WC_Product( $variation->get_parent_id() );

		return (object) array(
			'value'   => $variation->get_attributes(),
			'options' => $this->get_product_variation_options( $product ),
		);
	}

	/**
	 * @param WC_Product $product
	 *
	 * @return array
	 */
	private function get_product_variation_options( WC_Product $product ) {
		$results = array();

		foreach ( $product->get_attributes() as $key => $attribute ) {
			if ( ! $attribute instanceof WC_Product_Attribute ) {
				continue;
			}

			// Is used for variations
			if ( ! $attribute->get_variation() ) {
				continue;
			}

			$options = array();

			if ( $attribute->is_taxonomy() ) {
				foreach ( $attribute->get_terms() as $term ) {
					if ( $term instanceof WP_Term ) {
						$options[ $term->slug ] = $term->name;
					}
				}
			} else {
				$options = array_combine( $attribute->get_options(), $attribute->get_options() );
			}

			$results[ $key ] = array(
				'label'   => $this->column->get_setting_variation()->get_attribute_label( $attribute ),
				'options' => $options,
			);
		}

		return $results;
	}

	public function save( $id, $value ) {
		$variation = new WC_Product_Variation( $id );
		$variation->set_attributes( $value );
		$variation->save();
	}

	public function register_settings() {
		parent::register_settings();

		$this->column->get_setting( 'edit' )->set_default( 'on' );
	}

}

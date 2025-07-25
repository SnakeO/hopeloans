<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Settings_ProductVariation_Variation extends AC_Settings_Column
	implements AC_Settings_FormatValueInterface {

	/**
	 * @var string
	 */
	private $variation_display;

	protected function set_name() {
		$this->name = 'variation_display';
	}

	protected function define_options() {
		return array(
			'variation_display' => 'short',
		);
	}

	public function create_view() {
		$select = $this->create_element( 'select' )
		               ->set_options( $this->get_display_options() );

		$view = new AC_View( array(
			'label'   => __( 'Display', 'codepress-admin-columns' ),
			'setting' => $select,
		) );

		return $view;
	}

	protected function get_display_options() {
		return array(
			''      => __( 'With label' ),
			'short' => __( 'Without label', 'codepress-admin-columns' ),
		);
	}

	/**
	 * @return string
	 */
	public function get_variation_display() {
		return $this->variation_display;
	}

	/**
	 * @param string $variation_display
	 */
	public function set_variation_display( $variation_display ) {
		$this->variation_display = $variation_display;
	}

	/**
	 * @param string $value
	 * @param int    $product_id
	 *
	 * @return string
	 */
	public function format( $value, $variation_id ) {
		$variation = new WC_Product_Variation( $variation_id );

		switch ( $this->get_variation_display() ) {
			case 'short' :
				$items = array();
				foreach ( $variation->get_attributes() as $attribute_name => $attribute_value ) {
					$items[] = ac_helper()->html->tooltip( urldecode( $attribute_value ), $this->get_attribute_label_by_variation( $variation, $attribute_name ) );
				}

				$value = implode( ' | ', array_filter( $items ) );

				break;
			default:
				$product = wc_get_product( $variation->get_parent_id() );

				$labels = array();

				foreach ( $variation->get_attributes() as $attribute_name => $attribute_value ) {
					$attribute = $this->get_product_attribute( $product, $attribute_name );

					$label = $this->get_attribute_label( $attribute );

					if ( $attribute_value && $attribute->is_taxonomy() ) {
						if ( $term = get_term_by( 'slug', $attribute_value, $attribute->get_taxonomy() ) ) {
							$attribute_value = $term->name;
						}
					}

					if ( ! $attribute_value ) {
						$attribute_value = __( 'Any', 'codepress-admin-columns' );
					}

					$labels[] = sprintf( '<strong>%s</strong>: %s', $label, $attribute_value );
				}

				$value = implode( '<br>', array_filter( $labels ) );
		}

		return $value;
	}

	/**
	 * @param WC_Product_Variation $variation
	 * @param string               $attribute_name
	 *
	 * @return string
	 */
	private function get_attribute_label_by_variation( WC_Product_Variation $variation, $attribute_name ) {
		$attribute = $this->get_product_attribute( new WC_Product( $variation->get_parent_id() ), $attribute_name );

		return $this->get_attribute_label( $attribute );
	}

	/**
	 * @param WC_Product_Attribute $attribute
	 *
	 * @return string
	 */
	public function get_attribute_label( WC_Product_Attribute $attribute ) {
		$label = $attribute->get_name();

		if ( $attribute->is_taxonomy() ) {
			/** @var stdClass $taxonomy */
			$taxonomy = $attribute->get_taxonomy_object();
			$label = $taxonomy->attribute_label;
		}

		return $label;
	}

	/**
	 * @param WC_Product $product
	 * @param string     $attribute_name
	 *
	 * @return false|WC_Product_Attribute
	 */
	private function get_product_attribute( WC_Product $product, $attribute_name ) {
		$product_attributes = $product->get_attributes();

		if ( ! isset( $product_attributes[ $attribute_name ] ) ) {
			return false;
		}

		return $product_attributes[ $attribute_name ];
	}

}

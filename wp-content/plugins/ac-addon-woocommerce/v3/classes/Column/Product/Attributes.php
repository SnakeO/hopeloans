<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 1.1
 */
class ACA_WC_Column_Product_Attributes extends AC_Column
	implements ACP_Export_Column, ACP_Column_EditingInterface, ACP_Column_FilteringInterface {

	public function __construct() {
		$this->set_type( 'column-wc-attributes' );
		$this->set_label( __( 'Attributes', 'woocommerce' ) );
		$this->set_group( 'woocommerce' );
	}

	/**
	 * @param array|string $attributes
	 * @param int          $product_id
	 *
	 * @return string
	 */
	public function get_value( $product_id ) {
		$rows = array();

		foreach ( $this->get_raw_value( $product_id ) as $name => $attribute ) {

			if ( $attribute->is_taxonomy() ) {
				$label = wc_attribute_label( $name );
				$options = wc_get_product_terms( $product_id, $name, array( 'fields' => 'names' ) );
			} else {
				$label = $attribute->get_name();
				$options = $attribute->get_options();
			}

			// Don't show label for single attribute
			if ( $this->get_attribute() ) {
				$rows[] = implode( $this->get_separator(), $options );
			} else {
				$tooltip = $this->get_tooltip( $attribute );

				if ( $label && $tooltip ) {
					$label = '<span ' . ac_helper()->html->get_tooltip_attr( $tooltip ) . '">' . esc_html( $label ) . '</span>';
				}

				$rows[] = '
				<div class="attribute">
					<strong class="label">' . $label . ':</strong>
					<span class="values">' . implode( $this->get_separator(), $options ) . '</span>
				</div>
				';
			}
		}

		if ( ! $rows ) {
			return $this->get_empty_char();
		}

		return implode( $rows );
	}

	/**
	 * @param WC_Product_Attribute $attribute
	 *
	 * @return string
	 */
	private function get_tooltip( WC_Product_Attribute $attribute ) {
		// Tooltip
		$tooltip = array();

		if ( $attribute->get_visible() ) {
			$tooltip[] = __( 'Visible on the product page', 'woocommerce' );
		}

		if ( $attribute->get_variation() ) {
			$tooltip[] = __( 'Used for variations', 'woocommerce' );
		}

		if ( $attribute->is_taxonomy() ) {
			$tooltip[] = __( 'Is a taxonomy', 'codepress-admin-columns' );
		}

		return implode( '<br/>', $tooltip );
	}

	/**
	 * @param int $id
	 *
	 * @return WC_Product_Attribute[]
	 */
	public function get_raw_value( $id ) {
		$attributes = wc_get_product( $id )->get_attributes();

		if ( $this->get_attribute() ) {
			$value = array();

			if ( isset( $attributes[ $this->get_attribute() ] ) ) {
				$value = array(
					$this->get_attribute() => $attributes[ $this->get_attribute() ],
				);
			}
		} else {
			$value = (array) $attributes;
		}

		return $value;
	}

	// Settings

	public function register_settings() {
		$this->add_setting( new ACA_WC_Settings_Product_Attributes( $this ) );
	}

	public function export() {
		return new ACA_WC_Export_Product_Attributes( $this );
	}

	public function editing() {
		if ( $this->is_taxonomy_attribute() ) {
			return new ACA_WC_Editing_Product_Attributes_Taxonomy( $this );
		}

		if ( $this->is_custom_attribute() ) {
			return new ACA_WC_Editing_Product_Attributes( $this );
		}

		return new ACP_Editing_Model_Disabled( $this );
	}

	public function filtering() {
		if ( $this->is_taxonomy_attribute() ) {
			return new ACP_Filtering_Model_Post_Taxonomy( $this );
		}

		return new ACP_Filtering_Model_Disabled( $this );
	}

	/**
	 * @return false|string
	 */
	public function get_taxonomy() {
		return $this->is_taxonomy_attribute() ? $this->get_attribute() : false;
	}

	/**
	 * @return ACA_WC_Settings_Product_Attributes|false
	 */
	public function get_setting_attribute() {
		$setting = $this->get_setting( 'product_attributes' );

		if ( ! $setting instanceof ACA_WC_Settings_Product_Attributes ) {
			return false;
		}

		return $setting;
	}

	/**
	 * @return string
	 */
	public function get_attribute() {
		return $this->get_setting_attribute()->get_product_taxonomy_display();
	}

	/**
	 * @return bool
	 */
	private function is_taxonomy_attribute() {
		$taxonomies = $this->get_setting_attribute()->get_attributes_taxonomy_labels();

		return isset( $taxonomies[ $this->get_attribute() ] );
	}

	/**
	 * @return bool
	 */
	private function is_custom_attribute() {
		return $this->get_attribute() && ! $this->is_taxonomy_attribute();
	}

}

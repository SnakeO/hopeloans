<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 1.1
 */
class ACA_WC_Column_Product_ProductType extends AC_Column
	implements ACP_Column_SortingInterface, ACP_Column_FilteringInterface {

	public function __construct() {
		$this->set_type( 'column-wc-product_type' );
		$this->set_label( __( 'Type', 'codepress-admin-columns' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_value( $post_id ) {
		$product_type = $this->get_raw_value( $post_id );

		switch ( $product_type ) {
			case 'downloadable' :
				$label = __( 'Downloadable', 'woocommerce' );

				break;
			case 'virtual' :
				$label = __( 'Virtual', 'woocommerce' );

				break;
			default :
				$types = wc_get_product_types();

				$label = $product_type;

				if ( isset( $types[ $product_type ] ) ) {
					$label = $types[ $product_type ];
				}
		}

		return $label;
	}

	public function get_raw_value( $post_id ) {
		$product = wc_get_product( $post_id );
		$type = $product->get_type();

		if ( $product->is_downloadable() ) {
			$type = 'downloadable';
		}

		if ( $product->is_virtual() ) {
			$type = 'virtual';
		}

		return $type;
	}

	public function sorting() {
		return new ACP_Sorting_Model_Value( $this );
	}

	public function filtering() {
		return new ACP_Filtering_Model_Delegated( $this, 'dropdown_product_type' );
	}

}

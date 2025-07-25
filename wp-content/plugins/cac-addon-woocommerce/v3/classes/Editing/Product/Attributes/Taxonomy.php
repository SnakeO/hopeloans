<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @property ACA_WC_Column_Product_Attributes $column
 */
class ACA_WC_Editing_Product_Attributes_Taxonomy extends ACP_Editing_Model_Post_Taxonomy {

	public function __construct( ACA_WC_Column_Product_Attributes $column ) {
		parent::__construct( $column );
	}

	/**
	 * Save attributes to product
	 *
	 * @param int   $id
	 * @param int[] $term_ids
	 */
	private function save_to_product( $id, $term_ids ) {
		if ( ! $term_ids ) {
			return;
		}

		$options = array();

		foreach ( $term_ids as $term_id ) {
			$options[ $term_id ] = ac_helper()->taxonomy->get_term_field( 'name', $term_id, $this->column->get_taxonomy() );
		}

		$model = new ACA_WC_Editing_Product_Attributes( $this->column );
		$model->save( $id, $options );
	}

	/**
	 * @param int   $id
	 * @param array $value
	 */
	public function save( $id, $value ) {
		$term_ids = parent::save( $id, $value );

		$this->save_to_product( $id, $term_ids );
	}

}

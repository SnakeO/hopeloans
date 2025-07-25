<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_Product_Sale extends AC_Column
	implements ACP_Column_EditingInterface, ACP_Column_FilteringInterface, ACP_Export_Column {

	public function __construct() {
		$this->set_type( 'column-wc-product_sale' );
		$this->set_label( __( 'Sale', 'codepress-admin-columns' ) );
		$this->set_group( 'woocommerce' );
	}

	// Display
	public function get_value( $id ) {
		$product = wc_get_product( $id );
		$is_scheduled = $this->is_scheduled( $product );

		if ( ! $product->is_on_sale() && ! $is_scheduled ) {
			return $this->get_empty_char();
		}

		if ( $is_scheduled ) {
			return ac_helper()->html->tooltip( ac_helper()->icon->dashicon( array( 'icon' => 'clock' ) ), '<strong>' . __( 'Scheduled' ) . '</strong><br><em>' . $this->get_scheduled_label( $product ) . '</em>' );
		}

		return ac_helper()->html->tooltip( ac_helper()->icon->yes( false, false ), $this->get_scheduled_label( $product ) );
	}

	private function format_scheduled_label( $label, WC_DateTime $date_time = null ) {
		if ( ! $date_time ) {
			return false;
		}

		return sprintf( '%s: %s',
			$label,
			ac_helper()->date->date_by_timestamp( $date_time->format( 'U' ), 'wp_date' )
		);
	}

	/**
	 * Returns a formatted period
	 *
	 * @param WC_Product $product
	 *
	 * @return string
	 */
	private function get_scheduled_label( WC_Product $product ) {
		$labels = array(
			$this->format_scheduled_label( _x( 'From', 'Product on sale from (date)', 'codepress-admin-columns' ), $product->get_date_on_sale_from() ),
			$this->format_scheduled_label( _x( 'Until', 'Product on sale until (date)', 'codepress-admin-columns' ), $product->get_date_on_sale_to() ),
		);

		if ( ! array_filter( $labels ) ) {
			return false;
		}

		return implode( '<br>', $labels );
	}

	/**
	 * Sales price is scheduled for future
	 *
	 * @param WC_Product $product
	 *
	 * @return bool
	 */
	public function is_scheduled( WC_Product $product ) {
		return $product->get_date_on_sale_from() > new WC_DateTime();
	}

	public function get_raw_value( $id ) {
		$product = wc_get_product( $id );

		return $product->is_on_sale();
	}

	public function editing() {
		return new ACA_WC_Editing_Product_Price( $this );
	}

	public function filtering() {
		return new ACA_WC_Filtering_Product_Sale( $this );
	}

	public function export() {
		return new ACA_WC_Export_Product_Sale( $this );
	}

}

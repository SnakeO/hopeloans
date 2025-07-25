<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 1.0
 */
class ACA_WC_Column_Product_Downloads extends AC_Column
	implements ACP_Export_Column {

	public function __construct() {
		$this->set_type( 'column-wc-product_downloads' );
		$this->set_label( __( 'Downloads', 'woocommerce' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_value( $id ) {
		$values = array();

		$description = $this->get_description( $id );

		foreach ( $this->get_raw_value( $id ) as $id => $download ) {

			$label = ac_helper()->html->link( $download->get_file(), $download->get_name() );
			$tooltip = array_merge( array( wc_get_filename_from_url( $download->get_file() ) ), $description );

			$values[] = ac_helper()->html->tooltip( $label, implode( "<br/>", $tooltip ) );
		}

		if ( ! $values ) {
			return $this->get_empty_char();
		}

		return implode( $this->get_separator(), $values );
	}

	/**
	 * @param int $id
	 *
	 * @return array
	 */
	private function get_description( $id ) {
		$description = array();

		$product = new WC_Product( $id );

		if ( ( $limit = $product->get_download_limit() ) > 0 ) {
			$description[] = __( 'Download limit', 'woocommerce' ) . ': ' . $limit;
		}

		if ( ( $days = $product->get_download_expiry() ) > 0 ) {
			$description[] = __( 'Download expiry', 'woocommerce' ) . ': ' . sprintf( _n( '%s day', '%s days', $days ), $days );
		}

		return $description;
	}

	/**
	 * @param int $id
	 *
	 * @return WC_Product_Download[]
	 */
	public function get_raw_value( $id ) {
		$product = new WC_Product( $id );

		return $product->get_downloads();
	}

	public function export() {
		return new ACA_WC_Export_Product_Downloads( $this );
	}

}

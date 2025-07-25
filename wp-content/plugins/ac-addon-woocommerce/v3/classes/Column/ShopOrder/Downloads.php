<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 2.0
 */
class ACA_WC_Column_ShopOrder_Downloads extends AC_Column
	implements ACP_Export_Column {

	public function __construct() {
		$this->set_type( 'column-wc-order_downloads' );
		$this->set_label( 'Downloads' );
		$this->set_group( 'woocommerce' );
	}

	/**
	 * @param int $id
	 *
	 * @return string
	 */
	public function get_value( $id ) {
		$downloadables = $this->get_raw_value( $id );

		if ( ! $downloadables ) {
			return $this->get_empty_char();
		}

		$values = array();

		foreach ( $downloadables as $download ) {
			$product = new WC_Product( $download['product_id'] );

			$download_url = $product->get_file_download_path( $download['download_id'] );
			$label = ac_helper()->html->link( $download_url, $download['download_name'] ? $download['download_name'] : $download['product_name'] );

			$values[] = ac_helper()->html->tooltip( $label, $this->get_description( $download ) );
		}

		return implode( ', ', $values );
	}

	/**
	 * @param $download
	 *
	 * @return string
	 */
	private function get_description( $download ) {
		$product = new WC_Product( $download['product_id'] );

		$description = array(
			wc_get_filename_from_url( $product->get_file_download_path( $download['download_id'] ) ),
		);

		if ( ! empty( $download['downloads_remaining'] ) ) {
			$description[] = __( 'Downloads remaining', 'woocommerce' ) . ': ' . $download['downloads_remaining'];
		}

		if ( ! empty( $download['access_expires'] ) ) {
			/* @var WC_DateTime $date */
			$date = $download['access_expires'];

			if ( $date->getTimestamp() > time() ) {
				$description[] = __( 'Access expires', 'woocommerce' ) . ': ' . human_time_diff( $date->getTimestamp() );
			}
		}

		return implode( "<br/>", $description );
	}

	/**
	 * @param int $id
	 *
	 * @return array
	 */
	public function get_raw_value( $id ) {
		$order = new WC_Order( $id );

		return $order->get_downloadable_items();
	}

	public function export() {
		return new ACA_WC_Export_ShopOrder_Downloads( $this );
	}

}

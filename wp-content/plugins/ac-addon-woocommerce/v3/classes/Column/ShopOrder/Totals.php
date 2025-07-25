<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 3.0
 */
class ACA_WC_Column_ShopOrder_Totals extends AC_Column_Meta
	implements ACP_Column_FilteringInterface, ACP_Column_SortingInterface {

	/**
	 * @var WC_Order[]
	 */
	private $orders;

	public function __construct() {
		$this->set_type( 'column-wc-order_totals' );
		$this->set_label( __( 'Totals', 'codepress-admin-columns' ) );
		$this->set_group( 'woocommerce' );
	}

	public function get_meta_key() {
		switch ( $this->get_setting_total_property() ) {
			case 'total' :
				$key = '_order_total';

				break;
			case 'discount' :
				$key = '_cart_discount';

				break;
			case 'shipping' :
				$key = '_order_shipping';

				break;
			default:
				$key = false;
		}

		return $key;
	}

	public function get_value( $id ) {
		$price = $this->get_raw_value( $id );

		if ( ! $price ) {
			return $this->get_empty_char();
		}

		return wc_price( $this->get_raw_value( $id ), array( 'currency' => $this->get_order( $id )->get_currency() ) );
	}

	public function get_raw_value( $id ) {

		switch ( $this->get_setting_total_property() ) {
			case 'subtotal' :
				$value = $this->get_order( $id )->get_subtotal();

				break;
			case 'discount' :
				$value = $this->get_order( $id )->get_total_discount();

				break;
			case 'refunded' :
				$value = $this->get_order( $id )->get_total_refunded();

				break;
			case 'tax' :
				$value = $this->get_order( $id )->get_total_tax();

				break;
			case 'shipping' :
				$value = $this->get_order( $id )->get_shipping_total();

				break;
			case 'paid' :
				$value = 0;

				if ( $this->get_order( $id )->is_paid() ) {
					$value = $this->get_order( $id )->get_total() - $this->get_order( $id )->get_total_refunded();
				}
				break;
			default :
				$value = $this->get_order( $id )->get_total();
		}

		return $value;
	}

	/**
	 * @param int $id
	 *
	 * @return WC_Order
	 */
	private function get_order( $id ) {
		if ( ! isset( $this->orders[ $id ] ) ) {
			$this->orders[ $id ] = new WC_Order( $id );
		}

		return $this->orders[ $id ];
	}

	/**
	 * @return string|false
	 */
	private function get_setting_total_property() {
		$setting = $this->get_setting( 'order_total_property' );

		if ( ! $setting instanceof ACA_WC_Settings_Totals ) {
			return false;
		}

		return $setting->get_order_total_property();
	}

	public function register_settings() {
		$this->add_setting( new ACA_WC_Settings_Totals( $this ) );
	}

	public function filtering() {
		if ( $this->get_meta_key() ) {
			return new ACA_WC_Filtering_Numeric( $this );
		}

		return new ACP_Filtering_Model_Disabled( $this );
	}

	public function sorting() {
		if ( $this->get_meta_key() ) {
			return new ACP_Sorting_Model_Meta( $this );
		}

		return new ACP_Sorting_Model_Disabled( $this );
	}

}

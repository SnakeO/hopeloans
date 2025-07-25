<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_WC_Settings_UseIcon extends AC_Settings_Column
	implements AC_Settings_FormatValueInterface {

	/**
	 * @var bool
	 */
	private $use_icon;

	protected function define_options() {
		return array( 'use_icon' => '' );
	}

	public function get_dependent_settings() {
		$setting = array();

		if ( ! $this->get_use_icon() ) {
			$setting[] = new AC_Settings_Column_StringLimit( $this->column );
		}

		return $setting;
	}

	public function create_view() {

		$setting = $this->create_element( 'radio' )
		                ->set_attribute( 'data-refresh', 'column' )
		                ->set_options( array(
			                '1' => __( 'Yes' ),
			                ''  => __( 'No' ),
		                ) );

		$view = new AC_View( array(
			'label'   => __( 'Use an icon?', 'codepress-admin-columns' ),
			'tooltip' => __( 'Use an icon instead of text for displaying the note.', 'codepress-admin-columns' ),
			'setting' => $setting,
		) );

		return $view;
	}

	/**
	 * @return int
	 */
	public function get_use_icon() {
		return $this->use_icon;
	}

	/**
	 * @param int $use_icons
	 *
	 * @return bool
	 */
	public function set_use_icon( $use_icon ) {
		$this->use_icon = $use_icon;

		return true;
	}

	/**
	 * @param string $status
	 * @param int    $post_id
	 *
	 * @return string
	 */
	public function format( $value, $post_id ) {
		if ( $this->get_use_icon() && $value ) {
			$icon = ac_helper()->icon->dashicon( array( 'icon' => 'media-text', 'class' => 'gray' ) );
			$value = ac_helper()->html->tooltip( $icon, $value );
		}

		return $value;
	}

}

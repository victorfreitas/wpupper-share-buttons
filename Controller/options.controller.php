<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Options Admin Page
 * @since 2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
}

class WPUSB_Options_Controller {

	/**
	 * Adds needed actions initialize class
	 *
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'register_options_settings' ) );
	}

	/**
	 * Register options settings general
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	public function register_options_settings() {
		$this->_register_options_settings();
		$this->_register_options_social_media();
		$this->_register_options_extra_settings();
	}

	/**
	 * Register options settings
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	private function _register_options_settings() {
		$option = WPUSB_Utils::get_option_group_name( 'settings' );

		register_setting( $option['group'], $option['name'], array( 'WPUSB_Utils', 'rm_tags' ) );
	}

	/**
	 * Register options social media
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	private function _register_options_social_media() {
		$option = WPUSB_Utils::get_option_group_name( 'social_media', 'settings_group' );

		register_setting( $option['group'], $option['name'], array( 'WPUSB_Utils', 'rm_tags' ) );
	}

	/**
	 * Register options extra settings
	 *
	 * @since 1.1
	 * @param Null
	 * @return void
	 */
	private function _register_options_extra_settings() {
		$option = WPUSB_Utils::get_option_group_name( 'extra_settings' );

		register_setting( $option['group'], $option['name'], array( 'WPUSB_Utils', 'rm_tags' ) );
	}
}

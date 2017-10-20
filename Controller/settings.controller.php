<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Settings Controller
 * @version 2.2
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
}

//Model
WPUSB_App::uses( 'setting', 'Model' );

//View
if ( is_admin() ) {
	WPUSB_App::uses( 'settings', 'View' );
	WPUSB_App::uses( 'settings-extra', 'View' );
	WPUSB_App::uses( 'settings-custom-css', 'View' );
	WPUSB_App::uses( 'settings-faq', 'View' );
	WPUSB_App::uses( 'addons', 'View' );
}

class WPUSB_Settings_Controller {

	/**
	* Initialize the plugin by setting localization, filters, and administration functions.
	*
	* @since 1.2
	*/
	public function __construct() {
		$prefix = WPUSB_App::SLUG;

		add_filter( WPUSB_Utils::basename( 'plugin_action_links_' ), array( $this, 'plugin_link' ) );
		add_action( 'admin_menu', array( $this, 'menu_page' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( "update_option_{$prefix}_settings", array( $this, 'rebuild_custom_css' ), 10, 3 );
		add_action( 'admin_body_class', array( $this, 'body_class' ) );
	}

	/**
	 * Adds links page plugin action
	 *
	 * @since 1.0
	 * @param Array $links
	 * @return Array links action plugins
	 */
	public function plugin_link( $links ) {
		$link = sprintf(
			'<a href="%s">%s</a>',
			WPUSB_Utils::get_page_url(),
			__( 'Settings', 'wpupper-share-buttons' )
		);

		array_splice( $links, 0, 0, array( $link ) );

		return $links;
	}

	/**
	 * Register menu page and submenus
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	public function menu_page() {
		$capability = WPUSB_Utils::get_capability();

		add_menu_page(
			__( 'WPUpper Share Buttons', 'wpupper-share-buttons' ),
			__( 'WPUpper Share', 'wpupper-share-buttons' ),
			$capability,
			WPUSB_Setting::HOME_SETTINGS,
			array( 'WPUSB_Settings_View', 'render_settings_page' ),
			'dashicons-share'
		);

		  $title = __( 'Extensions', 'wpupper-share-buttons' );
		  add_submenu_page(
			  WPUSB_App::SLUG,
			  $title,
			  $title,
			  $capability,
			  WPUSB_Setting::EXTENSIONS,
			  array( 'WPUSB_Addons', 'render' )
		  );

		$title = __( 'Extra Settings', 'wpupper-share-buttons' );
		  add_submenu_page(
			  WPUSB_App::SLUG,
			  $title,
			  $title,
			  $capability,
			  WPUSB_Setting::EXTRA_SETTINGS,
			  array( 'WPUSB_Settings_Extra_View', 'render_settings_extra' )
		  );

		  $title = __( 'Custom CSS', 'wpupper-share-buttons' );
		  add_submenu_page(
			  WPUSB_App::SLUG,
			  $title,
			  $title,
			  $capability,
			  WPUSB_Setting::CUSTOM_CSS,
			  array( 'WPUSB_Settings_Custom_CSS_View', 'render' )
		  );

		  $title = __( 'Use options', 'wpupper-share-buttons' );
		  add_submenu_page(
			  WPUSB_App::SLUG,
			  $title,
			  $title,
			  $capability,
			  WPUSB_Setting::USE_OPTIONS,
			  array( 'WPUSB_Settings_Faq_View', 'render_page_faq' )
		  );
	}

	/**
	 * Action for admin init
	 *
	 * @since 3.25
	 * @param Null
	 * @return void
	 */
	public function admin_init() {
		$this->_plugin_update();
	}

	/**
	 * Register plugin updates
	 *
	 * @since 3.6.0
	 * @param Null
	 * @return void
	 */
	private function _plugin_update() {
		$option     = WPUSB_Utils::get_options_name( 1 );
		$db_version = WPUSB_Utils::get_option( $option );

		if ( $db_version === WPUSB_App::VERSION ) {
			return;
		}

		WPUSB_Utils::update_option( $option, WPUSB_App::VERSION );
		WPUSB_Core::alter_table();

		$this->_rebuild_css();
	}

	/**
	 * Rebuild custom css file
	 *
	 * @since 3.25
	 * @param mixed  $old_value
	 * @param mixed  $value
	 * @param string $option
	 * @return void
	 */
	public function rebuild_custom_css( $old_value, $value, $option ) {
		$this->_rebuild_css( $value );
	}

	/**
	 * Rebuild custom css file
	 *
	 * @since 3.25
	 * @param Array $value
	 * @return void
	 */
	private function _rebuild_css( $value = array() ) {
		$custom_css = WPUSB_Utils::get_all_custom_css( null, $value );
		WPUSB_Utils::build_css( $custom_css );
	}

	/**
	 * Add class plugin page
	 *
	 * @since 3.32
	 * @param String $classes
	 * @return String
	 */
	public function body_class( $classes ) {
		if ( WPUSB_Utils::is_dashboard_page() ) {
			$classes .= WPUSB_Utils::add_prefix( '-settings', ' ' );
		}

		return $classes;
	}
}

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
	exit(0);
}

//Model
WPUSB_App::uses( 'setting', 'Model' );

//View
if ( WPUSB_App::is_admin() ) {
	WPUSB_App::uses( 'settings', 'View' );
	WPUSB_App::uses( 'settings-extra', 'View' );
	WPUSB_App::uses( 'settings-custom-css', 'View' );
	WPUSB_App::uses( 'settings-faq', 'View' );
}

class WPUSB_Settings_Controller {

	/**
	* Initialize the plugin by setting localization, filters, and administration functions.
	*
	* @since 1.2
	*/
	public function __construct() {
		$prefix = WPUSB_App::SLUG;

		add_filter( WPUSB_Utils::base_name( 'plugin_action_links_' ), array( $this, 'plugin_link' ) );
		add_action( 'admin_menu', array( $this, 'menu_page' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( "update_option_{$prefix}_settings", array( $this, 'rebuild_custom_css' ), 10, 3 );
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
			__( 'Settings', WPUSB_App::TEXTDOMAIN )
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
		add_menu_page(
			__( 'WPUpper Share Buttons', WPUSB_App::TEXTDOMAIN ),
			__( 'WPUpper Share', WPUSB_App::TEXTDOMAIN ),
			'manage_options',
			WPUSB_Setting::HOME_SETTINGS,
			array( 'WPUSB_Settings_View', 'render_settings_page' ),
			'dashicons-share'
	  	);

		$title = __( 'Extra Settings', WPUSB_App::TEXTDOMAIN );
	  	add_submenu_page(
	  		WPUSB_App::SLUG,
	  		$title,
	  		$title,
	  		'manage_options',
	  		WPUSB_Setting::EXTRA_SETTINGS,
	  		array( 'WPUSB_Settings_Extra_View', 'render_settings_extra' )
	  	);

	  	$title = __( 'Custom CSS', WPUSB_App::TEXTDOMAIN );
	  	add_submenu_page(
	  		WPUSB_App::SLUG,
	  		$title,
	  		$title,
	  		'manage_options',
	  		WPUSB_Setting::CUSTOM_CSS,
	  		array( 'WPUSB_Settings_Custom_CSS_View', 'render' )
	  	);

	  	add_submenu_page(
	  		WPUSB_App::SLUG,
	  		__( 'Use options', WPUSB_App::TEXTDOMAIN ),
	  		__( 'Use options', WPUSB_App::TEXTDOMAIN ),
	  		'manage_options',
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
		$this->_build_custom_css();
	}

	/**
	 * Register plugin updates
	 *
	 * @since 3.6.0
	 * @param Null
	 * @return void
	 */
	private function _plugin_update() {
		$option          = WPUSB_Utils::get_options_name( 1 );
		$current_version = WPUSB_Setting::DB_VERSION;
		$db_version      = WPUSB_Utils::get_option( $option );

	    if ( $db_version === $current_version ) {
	    	return;
	    }

    	WPUSB_Utils::update_option( $option, $current_version );
    	WPUSB_Core::alter_table();
	}

	/**
	 * Build custom css
	 *
	 * @since 3.25
	 * @param Null
	 * @return void
	 */
	private function _build_custom_css() {
		if ( WPUSB_Utils::file_css_min_exists() ) {
			return;
		}

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
	 * @param null
	 * @return void
	 */
	private function _rebuild_css( $option = array() ) {
		$custom_css = WPUSB_Utils::get_all_custom_css( null, $option );
		WPUSB_Utils::build_css( $custom_css );
	}
}
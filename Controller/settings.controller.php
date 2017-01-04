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
	WPUSB_App::uses( 'settings-faq', 'View' );
}

class WPUSB_Settings_Controller {

	/**
	* Initialize the plugin by setting localization, filters, and administration functions.
	*
	* @since 1.2
	*/
	public function __construct() {
		add_filter( WPUSB_Utils::base_name( 'plugin_action_links_' ), array( &$this, 'plugin_link' ) );
		add_action( 'admin_menu', array( &$this, 'menu_page' ) );
		add_action( 'admin_init', array( &$this, 'plugin_updates' ) );
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

	  	add_submenu_page(
	  		WPUSB_App::SLUG,
	  		__( 'Extra Settings | WPUpper Share Buttons', WPUSB_App::TEXTDOMAIN ),
	  		__( 'Extra Settings', WPUSB_App::TEXTDOMAIN ),
	  		'manage_options',
	  		WPUSB_Setting::EXTRA_SETTINGS,
	  		array( 'WPUSB_Settings_Extra_View', 'render_settings_extra' )
	  	);

	  	add_submenu_page(
	  		WPUSB_App::SLUG,
	  		__( 'Use options | WPUpper Share Buttons', WPUSB_App::TEXTDOMAIN ),
	  		__( 'Use options', WPUSB_App::TEXTDOMAIN ),
	  		'manage_options',
	  		WPUSB_Setting::USE_OPTIONS,
	  		array( 'WPUSB_Settings_Faq_View', 'render_page_faq' )
	  	);
	}

	/**
	 * Register plugin updates
	 *
	 * @since 3.6.0
	 * @param Null
	 * @return void
	 */
	public function plugin_updates() {
		$option = WPUSB_Setting::TABLE_NAME . '_db_version';
		$value  = get_site_option( $option );

	    if ( $value !== WPUSB_Setting::DB_VERSION ) {
	    	WPUSB_Utils::add_update_option( $option, $value );
	    	WPUSB_Core::alter_table();
	    }
	}
}
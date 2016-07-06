<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Settings Controller
 * @version 2.1.0
 */

if ( ! function_exists( 'add_action' ) )
	exit(0);

use WPUSB_Utils as Utils;
use WPUSB_Setting as Setting;
use WPUSB_App as App;

//View
App::uses( 'settings', 'View' );
App::uses( 'settings-extra', 'View' );
App::uses( 'settings-faq', 'View' );

//Model
App::uses( 'setting', 'Model' );

class WPUSB_Settings_Controller
{
	/**
	* Initialize the plugin by setting localization, filters, and administration functions.
	*
	* @since 1.2
	*/
	public function __construct()
	{
		add_action( 'wp_enqueue_scripts', array( &$this, 'add_scripts' ) );
		add_filter( 'plugin_action_links_' . Utils::base_name(), array( &$this, 'plugin_link' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_scripts' ) );
		add_action( 'admin_menu', array( &$this, 'menu_page' ) );
	}

	/**
	 * Adds links page plugin action
	 *
	 * @since 1.0
	 * @param Array $links
	 * @return Array links action plugins
	 */
	public function plugin_link( $links )
	{
		$page_link     = get_admin_url( null,  'admin.php?page=' . App::SLUG );
		$settings      = __( 'Settings', App::TEXTDOMAIN );
		$settings_link = "<a href=\"{$page_link}\">{$settings}</a>";
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Enqueue scripts and styles
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public function add_scripts()
	{
		if ( ! Utils::is_active() )
			return;

		$this->_front_scripts();
		$this->_front_styles();
	}

	/**
	 * Enqueue front scripts
	 *
	 * @since 3.1.0
	 * @param Null
	 * @return Void
	 */
	private function _front_scripts()
	{
		if ( 'on' === Utils::option( 'disable_js' ) )
			return;

		wp_enqueue_script(
			Setting::PREFIX . '-scripts',
			Utils::plugin_url( 'javascripts/built.js' ),
			array( 'jquery' ),
			App::VERSION,
			true
		);

		wp_localize_script(
			Setting::PREFIX . '-scripts',
			'WPUpperVars',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

	/**
	 * Enqueue front styles
	 *
	 * @since 3.1.0
	 * @param Null
	 * @return Void
	 */
	private function _front_styles()
	{
		if ( 'on' === Utils::option( 'disable_css' ) )
			return;

		wp_enqueue_style(
			Setting::PREFIX . '-style',
			Utils::plugin_url( 'stylesheets/style.css' ),
			array(),
			App::VERSION
		);
	}

	/**
	 * Enqueue scripts and stylesheets on admin
	 *
	 * @since 1.2
	 * @param Null
	 * @return Void
	 */
	public function admin_scripts()
	{
		$page_settings = ( App::SLUG == Utils::get( 'page' ) );
		$deps          = ( $page_settings ) ? array( Setting::PREFIX . '-style' ) : array();

		wp_enqueue_script(
			Setting::PREFIX . '-admin-scripts',
			Utils::plugin_url( 'javascripts/built.admin.js' ),
			array( 'jquery', 'jquery-ui-sortable' ),
			App::VERSION,
			true
		);

		wp_localize_script(
			Setting::PREFIX . '-admin-scripts',
			'WPUpperVars',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'WPLANG'  => get_locale(),
			)
		);

		wp_enqueue_style(
			Setting::PREFIX . '-admin-style',
			Utils::plugin_url( 'stylesheets/admin.css' ),
			$deps,
			App::VERSION
		);

		if ( $page_settings ) :
			wp_enqueue_style(
				Setting::PREFIX . '-style',
				Utils::plugin_url( 'stylesheets/style.css' ),
				array(),
				App::VERSION
			);
		endif;
	}

	/**
	 * Register menu page and submenus
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	public function menu_page()
	{
		add_menu_page(
			__( 'WPUpper Share Buttons', App::TEXTDOMAIN ),
			__( 'WPUpper Share', App::TEXTDOMAIN ),
			'manage_options',
			Setting::HOME_SETTINGS,
			array( 'WPUSB_Settings_View', 'render_settings_page' ),
			'dashicons-share'
	  	);

	  	add_submenu_page(
	  		App::SLUG,
	  		__( 'Extra Settings | WPUpper Share Buttons', App::TEXTDOMAIN ),
	  		__( 'Extra Settings', App::TEXTDOMAIN ),
	  		'manage_options',
	  		Setting::EXTRA_SETTINGS,
	  		array( 'WPUSB_Settings_Extra_View', 'render_settings_extra' )
	  	);

	  	add_submenu_page(
	  		App::SLUG,
	  		__( 'Use options | WPUpper Share Buttons', App::TEXTDOMAIN ),
	  		__( 'Use options', App::TEXTDOMAIN ),
	  		'manage_options',
	  		Setting::USE_OPTIONS,
	  		array( 'WPUSB_Settings_Faq_View', 'render_page_faq' )
	  	);
	}
}

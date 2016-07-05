<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Settings Controller
 * @version 2.0.0
 */

if ( ! function_exists( 'add_action' ) )
	exit(0);

//View
WPUSB_App::uses( 'settings', 'View' );
WPUSB_App::uses( 'settings-extra', 'View' );
WPUSB_App::uses( 'settings-faq', 'View' );

//Model
WPUSB_App::uses( 'setting', 'Model' );

class WPUSB_Settings_Controller
{
	/**
	* Initialize the plugin by setting localization, filters, and administration functions.
	*
	* @since 1.2
	*/
	public function __construct()
	{
		add_filter( 'plugin_action_links_' . WPUSB_Utils::base_name(), array( &$this, 'plugin_link' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'scripts' ) );
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
		$page_link     = get_admin_url( null,  'admin.php?page=' . WPUSB_App::SLUG );
		$settings      = __( 'Settings', WPUSB_App::TEXTDOMAIN );
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
	public function scripts()
	{
		if ( 'on' !== WPUSB_Utils::option( 'disable_js' ) ) :
			wp_enqueue_script(
				WPUSB_Setting::PREFIX . '-scripts',
				WPUSB_Utils::plugin_url( 'javascripts/built.js' ),
				array( 'jquery' ),
				WPUSB_App::VERSION,
				true
			);

			wp_localize_script(
				WPUSB_Setting::PREFIX . '-scripts',
				'WPUpperVars',
				array(
					'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				)
			);
		endif;

		if ( 'on' !== WPUSB_Utils::option( 'disable_css' ) ) :
			wp_enqueue_style(
				WPUSB_Setting::PREFIX . '-style',
				WPUSB_Utils::plugin_url( 'stylesheets/style.css' ),
				array(),
				WPUSB_App::VERSION
			);
		endif;
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
		$page_settings = ( WPUSB_App::SLUG == WPUSB_Utils::get( 'page' ) );
		$deps          = ( $page_settings ) ? array( WPUSB_Setting::PREFIX . '-style' ) : array();

		wp_enqueue_script(
			WPUSB_Setting::PREFIX . '-admin-scripts',
			WPUSB_Utils::plugin_url( 'javascripts/built.admin.js' ),
			array( 'jquery', 'jquery-ui-sortable' ),
			WPUSB_App::VERSION,
			true
		);

		wp_localize_script(
			WPUSB_Setting::PREFIX . '-admin-scripts',
			'WPUpperVars',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'WPLANG'  => get_locale(),
			)
		);

		wp_enqueue_style(
			WPUSB_Setting::PREFIX . '-admin-style',
			WPUSB_Utils::plugin_url( 'stylesheets/admin.css' ),
			$deps,
			WPUSB_App::VERSION
		);

		if ( $page_settings ) :
			wp_enqueue_style(
				WPUSB_Setting::PREFIX . '-style',
				WPUSB_Utils::plugin_url( 'stylesheets/style.css' ),
				array(),
				WPUSB_App::VERSION
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
}

<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Settings Controller
 * @version 2.1.0
 */
if ( ! function_exists( 'add_action' ) ) {
	exit(0);
}

use WPUSB_Utils as Utils;
use WPUSB_Setting as Setting;
use WPUSB_Settings_View as View;
use WPUSB_App as App;
use WPUSB_Core as Core;

//Model
App::uses( 'setting', 'Model' );

//View
if ( App::$is_admin ) {
	App::uses( 'settings', 'View' );
	App::uses( 'settings-extra', 'View' );
	App::uses( 'settings-faq', 'View' );
}

class WPUSB_Settings_Controller
{
	/**
	* Initialize the plugin by setting localization, filters, and administration functions.
	*
	* @since 1.2
	*/
	public function __construct()
	{
		add_filter( 'plugin_action_links_' . Utils::base_name(), array( &$this, 'plugin_link' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_scripts' ) );
		add_action( 'admin_menu', array( &$this, 'menu_page' ) );
		add_action( 'admin_init', array( &$this, 'plugin_updates' ) );
		add_action( 'admin_notices', array( &$this, 'admin_notices' ) );
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
		$page_url      = Utils::get_page_url();
		$settings      = __( 'Settings', App::TEXTDOMAIN );
		$settings_link = "<a href=\"{$page_url}\">{$settings}</a>";
		array_unshift( $links, $settings_link );

		return $links;
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
			'WPUSBVars',
			array(
				'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
				'WPLANG'        => get_locale(),
				'previewTitles' => array(
					'titleRemove'   => __( 'View Untitled', App::TEXTDOMAIN ),
					'counterRemove' => __( 'View without count', App::TEXTDOMAIN ),
					'titleInsert'   => __( 'See with title', App::TEXTDOMAIN ),
					'counterInsert' => __( 'See with count', App::TEXTDOMAIN ),
				),
			)
		);

		wp_enqueue_style(
			Setting::PREFIX . '-admin-style',
			Utils::plugin_url( 'stylesheets/admin.css' ),
			$deps,
			App::VERSION
		);

		if ( $page_settings ) {
			wp_enqueue_style(
				Setting::PREFIX . '-style',
				Utils::plugin_url( 'stylesheets/style.css' ),
				array(),
				App::VERSION
			);
		}
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

	/**
	 * Register plugin updates
	 *
	 * @since 3.6.0
	 * @param Null
	 * @return void
	 */
	public function plugin_updates()
	{
		$db_version = get_site_option( Setting::TABLE_NAME . '_db_version' );

	    if ( $db_version !== Setting::DB_VERSION ) {
	    	Utils::add_update_option( Setting::TABLE_NAME . '_db_version' );
	    	add_site_option( App::SLUG . '-admin-notices', "true" );
	        $this->redirect_plugin_page();
	    }
	}

	/**
	 * Notice admin
	 *
	 * @since 3.6.0
	 * @param Null
	 * @return void
	 */
	public function admin_notices()
	{
		$option = get_site_option( App::SLUG . '-admin-notices' );

		if ( ! $option ) {
			return;
		}

		$prefix = Setting::PREFIX;
		$nonce  = Utils::nonce( Setting::AJAX_ADMIN_NONCE );

		View::admin_notice( $prefix, $nonce );
	}

	/**
	 * redirect from plugin page settings
	 *
	 * @since 3.6.0
	 * @param Null
	 * @return Void
	 */
	public function redirect_plugin_page()
	{
		if ( ! Utils::get( 'activate-multi', false ) ) {
			$plugin_url = Utils::get_page_url();
			wp_redirect( $plugin_url );
			exit(1);
		}
	}
}

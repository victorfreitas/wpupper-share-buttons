<?php
/**
 *
 * @package WPUpper Share Buttons
 * @subpackage Functions
 * @author  Victor Freitas
 * @since 3.1.0
 * @version 1.0
 */
if ( ! function_exists( 'add_action' ) )
	exit(0);

use WPUSB_App as App;
use WPUSB_Setting as Setting;
use WPUSB_Utils as Utils;

class WPUSB_Core
{
	/**
	 * Intance class share report controller
	 *
	 * @since 1.0
	 * @var Object
	 */
	private static $report;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.2
	 */
	public function __construct()
	{
		static::_share_report_update_db();
		static::_load_text_domain();
		static::_register_actions();
		static::_instantiate_controllers();

	}

	/**
	 * Registers actions activation, deactivation and uninstall plugin
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _register_actions()
	{
		register_activation_hook( App::FILE, array( __CLASS__, 'activate' ) );
		register_deactivation_hook( App::FILE, array( __CLASS__, 'deactivate' ) );
		register_uninstall_hook( App::FILE, array( __CLASS__, 'uninstall' ) );
	}

	/**
	 * Instantiate controllers
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _instantiate_controllers()
	{
		$settings       = new WPUSB_Settings_Controller();
		$share          = new WPUSB_Shares_Controller();
		$option         = new WPUSB_Options_Controller();
		$ajax           = new WPUSB_Ajax_Controller();
		static::$report = new WPUSB_Share_Reports_Controller();
	}

	/**
	 * Register Activation Hook
	 *
	 * @since 1.1
	 * @param Null
	 * @return Void
	 */
	public static function activate()
	{
		self::$report->create_table();
		Utils::add_options_defaults();
	}

	/**
	 * Register Deactivation Hook
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function deactivate()
	{

	}

	/**
	 * Register Uninstall Hook
	 *
	 * @since 1.3
	 * @param Null
	 * @return Void
	 */
	public static function uninstall()
	{
		$prefix = Setting::PREFIX;
		static::_delete_options( $prefix );
		static::_delete_site_options( $prefix );
		static::_delete_transients();
		static::_delete_table();
	}

	private static function _delete_options( $prefix )
	{
		// Options
		delete_option( $prefix );
		delete_option( "{$prefix}_settings" );
		delete_option( "{$prefix}_style_settings" );
	}

	/**
	 * Delete site option on plugin uninstallation
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _delete_site_options( $prefix )
	{
		//Options multisite
		if ( is_multisite() ) :
			delete_site_option( $prefix );
			delete_site_option( "{$prefix}_settings" );
			delete_site_option( "{$prefix}_style_settings" );
		endif;
	}

	/**
	 * Delete transient on plugin uninstallation
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _delete_transients()
	{
		// Transients
		delete_transient( Setting::TRANSIENT );
		delete_transient( Setting::TRANSIENT_SELECT_COUNT );
		delete_transient( Setting::TRANSIENT_GOOGLE_PLUS );
	}

	/**
	 * Delete table sharing report on plugin uninstallation
	 *
	 * @since 1.3
	 * @global $wpdb
	 * @param Null
	 * @return Void
	 */
	private static function _delete_table()
	{
		global $wpdb;

		$table = $wpdb->prefix . Setting::TABLE_NAME;
		$sql   = "DROP TABLE IF EXISTS `{$table}`";

		$wpdb->query( $sql );
	}

	/**
	 * Verify database version and update database
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function _share_report_update_db()
	{
		$db_version = get_site_option( Setting::TABLE_NAME . '_db_version' );

	    if ( $db_version !== Setting::DB_VERSION )
	        self::activate();
	}

	/**
	 * Initialize text domain hook, plugin translate
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function _load_text_domain()
	{
		$plugin_dir = basename( dirname( App::FILE ) );
		load_plugin_textdomain( App::TEXTDOMAIN, false, "{$plugin_dir}/languages/" );
	}
}
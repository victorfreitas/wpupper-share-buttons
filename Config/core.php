<?php
/**
 * @package WPUpper Share Buttons
 * @subpackage Functions
 * @author  Victor Freitas
 * @since 3.19
 * @version 2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

/*
 * Helpers
 */
WPUSB_App::uses( 'utils-share', 'Helper' );
WPUSB_App::uses( 'utils', 'Helper' );

/*
 * Load scripts admin and frontend
 */
WPUSB_App::uses( 'enqueue-scripts', 'Config' );

/*
 * Templates
 */
WPUSB_App::uses( 'layouts-primary', 'Templates' );
WPUSB_App::uses( 'square-plus', 'Templates' );
WPUSB_App::uses( 'fixed-left', 'Templates' );
WPUSB_App::uses( 'modal', 'Templates' );

/*
 * Social networks
 */
WPUSB_App::uses( 'social-elements', 'Config' );

/*
 * Controllers frontend
 */
WPUSB_App::uses( 'settings', 'Controller' );
WPUSB_App::uses( 'shares', 'Controller' );

/*
 * Controllers admin
 */
if ( WPUSB_App::is_admin() ) {
	WPUSB_App::uses( 'ajax', 'Controller' );
	WPUSB_App::uses( 'options', 'Controller' );
	WPUSB_App::uses( 'share-reports', 'Controller' );
}

final class WPUSB_Core {

	private static $_instance = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.2
	 */
	private function __construct() {
		add_action( 'init', array( __CLASS__, 'load_textdomain' ) );
		self::instantiate_controllers();
		self::register_actions();
	}

	public static function load_textdomain() {
		load_plugin_textdomain( WPUSB_App::TEXTDOMAIN, false, WPUSB_Utils::dirname( 'languages' ) );
	}

	/**
	 * Registers actions activation, deactivation and uninstall plugin
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	protected static function register_actions() {
		register_activation_hook( WPUSB_App::FILE, array( __CLASS__, 'activate' ) );
		register_deactivation_hook( WPUSB_App::FILE, array( __CLASS__, 'deactivate' ) );
	}

	/**
	 * Instantiate controllers
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	protected static function instantiate_controllers() {
		$share    = new WPUSB_Shares_Controller();
		$settings = new WPUSB_Settings_Controller();

		self::instantiate_controllers_admin();
	}

	/**
	 * Instantiate controller used in admin
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	protected static function instantiate_controllers_admin() {
		if ( ! WPUSB_App::is_admin() ) {
			return;
		}

		new WPUSB_Ajax_Controller();
		new WPUSB_Options_Controller();

		if ( ! WPUSB_Utils::is_sharing_report_disabled() ) {
			new WPUSB_Share_Reports_Controller();
		}
	}

	/**
	 * Register Activation Hook
	 *
	 * @since 1.1
	 * @param Null
	 * @return Void
	 */
	public static function activate() {
		self::create_table();

		WPUSB_Utils::add_options_defaults();

		register_uninstall_hook( WPUSB_App::FILE, array( __CLASS__, 'uninstall' ) );
	}

	/**
	 * Register Deactivation Hook
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function deactivate() {

	}

	/**
	 * Register Uninstall Hook
	 *
	 * @since 1.3
	 * @param Null
	 * @return Void
	 */
	public static function uninstall() {
		self::delete_options();
		self::delete_transients();
		self::delete_table();
	}

	protected static function delete_options() {
		$options_name = WPUSB_Utils::get_options_name();

		foreach ( $options_name as $option ) {
			delete_option( $option );
			delete_site_option( $option );
		}
	}

	/**
	 * Delete transient on plugin uninstallation
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	protected static function delete_transients() {
		// Transients
		delete_transient( WPUSB_Setting::TRANSIENT );
		delete_transient( WPUSB_Setting::TRANSIENT_SELECT_COUNT );
		delete_transient( WPUSB_Setting::TRANSIENT_GOOGLE_PLUS );
	}

	/**
	 * Delete table sharing report on plugin uninstallation
	 *
	 * @since 1.3
	 * @global $wpdb
	 * @param Null
	 * @return Void
	 */
	protected static function delete_table() {
		global $wpdb;

		$table = $wpdb->prefix . WPUSB_Setting::TABLE_NAME;
		$wpdb->query( "DROP TABLE IF EXISTS {$table}" );
	}

	/**
	 * Create table sharing reports.
	 *
	 * @since 1.1
	 * @global $wpdb
	 * @param Null
	 * @global $wpdb
	 * @return Void
	 */
	public static function create_table() {
		global $wpdb;

		$charset    = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . WPUSB_Setting::TABLE_NAME;
		$query      = "
			CREATE TABLE IF NOT EXISTS {$table_name} (
				id         BIGINT(20) NOT NULL AUTO_INCREMENT,
				post_id    BIGINT(20) UNSIGNED NOT NULL,
				post_title TEXT       NOT NULL,
				facebook   BIGINT(20) UNSIGNED NOT NULL,
				twitter    BIGINT(20) UNSIGNED NOT NULL,
				google     BIGINT(20) UNSIGNED NOT NULL,
				linkedin   BIGINT(20) UNSIGNED NOT NULL,
				pinterest  BIGINT(20) UNSIGNED NOT NULL,
				tumblr     BIGINT(20) UNSIGNED NOT NULL,
				total      BIGINT(20) UNSIGNED NOT NULL,
				PRIMARY KEY id ( id ),
				UNIQUE( post_id )
			) {$charset};
		";

		self::db_delta( $query );
	}

	/**
	 * Create table db delta support
	 *
	 * @since 1.0
	 * @param String $query
	 * @return Void
	 */
	public static function db_delta( $query ) {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $query );
	}

	/**
	 * Alter table on update
	 *
	 * @since 3.13
	 * @version 1.2
	 * @param Null
	 * @global $wpdb
	 * @return Void
	 */
	public static function alter_table() {
		global $wpdb;

		$table        = $wpdb->prefix . WPUSB_Setting::TABLE_NAME;
		$table_exists = $wpdb->query( "SHOW TABLES LIKE '{$table}'" );

		if ( $table_exists && ! $wpdb->get_var( "SHOW COLUMNS FROM {$table} LIKE 'tumblr';" ) ) {
			$wpdb->query( "ALTER TABLE {$table} ADD tumblr BIGINT(20) UNSIGNED NOT NULL AFTER pinterest;" );
		}
	}

	/**
	 * Singleton instance
	 *
	 * @since 3.22
	 * @param Null
	 * @return Void
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self;
		}
	}
}
WPUSB_Core::instance();
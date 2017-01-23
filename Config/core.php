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
 * Social networks
 */
WPUSB_App::uses( 'social-elements', 'Config' );

/*
 * Controllers frontend
 */
WPUSB_App::uses( 'settings', 'Controller' );
WPUSB_App::uses( 'shares', 'Controller' );
WPUSB_App::uses( 'widgets', 'Controller' );

/*
 * Templates
 */
WPUSB_App::uses( 'layouts-primary', 'Templates' );
WPUSB_App::uses( 'square-plus', 'Templates' );
WPUSB_App::uses( 'fixed-left', 'Templates' );
WPUSB_App::uses( 'modal', 'Templates' );

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
		add_action( 'widgets_init', array( __CLASS__, 'add_widgets' ) );
		self::init_controllers();
	}

	public static function add_widgets()
	{
		register_widget( 'WPUSB_Widgets_Controller' );
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
	public static function register_actions() {
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
	protected static function init_controllers() {
		$share    = new WPUSB_Shares_Controller();
		$settings = new WPUSB_Settings_Controller();

		self::init_controllers_admin();
	}

	/**
	 * Instantiate controller used in admin
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	protected static function init_controllers_admin() {
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
	public static function activate( $network_wide = false ) {
		register_uninstall_hook( WPUSB_App::FILE, array( __CLASS__, 'uninstall' ) );

		if ( $network_wide ) {
			return self::_create_table_for_network();
		}

		WPUSB_Utils::add_default_options();
		self::_create_table();
	}

	/**
	 * Register Deactivation Hook
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function deactivate( $network_wide = false ) {

	}

	/**
	 * Register Uninstall Hook
	 *
	 * @since 1.3
	 * @param Null
	 * @return Void
	 */
	public static function uninstall() {
		if ( ! is_multisite() ) {
			return self::delete_settings();
		}

		$sites = WPUSB_Utils::get_sites();

		if ( ! $sites ) {
			return;
		}

		foreach ( $sites as $site ) :
			$current = (array)$site;
			$blog_id = (int)$current['blog_id'];

			if ( ! $blog_id || ! $current['public'] ) {
				continue;
			}

			switch_to_blog( $blog_id );
			self::delete_settings();
			restore_current_blog();
		endforeach;
	}

	/**
	 * Delete settings
	 *
	 * @since 3.25
	 * @param Null
	 * @return Void
	 */
	protected static function delete_settings() {
		self::delete_options();
		self::delete_transients();
		self::drop_table();
	}

	/**
	 * Delete options settings
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	protected static function delete_options() {
		$options_name = WPUSB_Utils::get_options_name();

		foreach ( $options_name as $option ) {
			WPUSB_Utils::delete_option( $option );
		}
	}

	/**
	 * Delete transients
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
	protected static function drop_table() {
		global $wpdb;

		$table = WPUSB_Utils::get_table_name();
		$wpdb->query( "DROP TABLE IF EXISTS {$table}" );
	}

	/**
	 * Create table sharing reports for networks activation
	 *
	 * @since 3.25
	 * @global $wpdb
	 * @param Null
	 * @return Void
	 */
	private static function _create_table_for_network() {
		global $wpdb;

		$sites = WPUSB_Utils::get_sites();

		if ( ! $sites ) {
			return;
		}

		foreach ( $sites as $site ) :
			$current = (array)$site;
			$blog_id = (int)$current['blog_id'];

			if ( ! $blog_id || ! $current['public'] ) {
				continue;
			}

			switch_to_blog( $blog_id );
			self::_create_table();
			WPUSB_Utils::add_default_options();
			restore_current_blog();
		endforeach;
	}

	/**
	 * Create table sharing reports.
	 *
	 * @since 1.1
	 * @global $wpdb
	 * @param Null
	 * @return Void
	 */
	private static function _create_table() {
		global $wpdb;

		$charset    = $wpdb->get_charset_collate();
		$table_name = WPUSB_Utils::get_table_name();
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

		$table        = WPUSB_Utils::get_table_name();
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
WPUSB_Core::register_actions();
add_action( 'plugins_loaded', array( 'WPUSB_Core', 'instance' ) );
add_action( 'init', array( 'WPUSB_Core', 'load_textdomain' ) );
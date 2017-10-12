<?php
/**
 * @package WPUpper Share Buttons
 * @subpackage Functions
 * @author  Victor Freitas
 * @since 1.0
 * @version 2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
}

/*
 * Helpers
 */
WPUSB_App::uses( 'utils-share', 'Helper' );
WPUSB_App::uses( 'utils', 'Helper' );
WPUSB_App::uses( 'utils', 'View' );

/*
 * Widget
 */
WPUSB_App::uses( 'widget', 'Widget' );

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
WPUSB_App::uses( 'url-shortener', 'Controller' );
WPUSB_App::uses( 'settings', 'Controller' );
WPUSB_App::uses( 'shares', 'Controller' );
WPUSB_App::uses( 'widgets', 'Controller' );
WPUSB_App::uses( 'widget-follow', 'Controller' );

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
if ( is_admin() ) {
	WPUSB_App::uses( 'ajax', 'Controller' );
	WPUSB_App::uses( 'ajax-sharing-reports', 'Controller' );
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

	/**
	 * Widget register
	 *
	 * @since 3.25
	 * @param Null
	 * @return Void
	 */
	public static function add_widgets() {
		register_widget( 'WPUSB_Widgets_Controller' );
		register_widget( 'WPUSB_Widget_Follow_Controller' );
	}

	public static function load_textdomain() {
		load_plugin_textdomain( 'wpupper-share-buttons', false, WPUSB_Utils::plugin_basename() . '/languages' );
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
		new WPUSB_Shares_Controller();
		new WPUSB_Settings_Controller();

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
		if ( ! is_admin() ) {
			return;
		}

		new WPUSB_Ajax_Controller();
		new WPUSB_Ajax_Sharing_Reports_Controller();
		new WPUSB_Options_Controller();

		if ( ! WPUSB_Utils::is_sharing_report_disabled() && class_exists( 'Walker_Category_Checklist' ) ) {
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

		self::_create_table();

		WPUSB_Utils::add_default_options();
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

		if ( empty( $sites ) ) {
			return;
		}

		foreach ( $sites as $blog_id ) :
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
		self::delete_metabox();
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
		delete_transient( WPUSB_Setting::TRANSIENT_SHARING_REPORT );
		delete_transient( WPUSB_Setting::TRANSIENT_SHARING_REPORT_COUNT );
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

		$table_share_report  = WPUSB_Utils::get_table_name();
		$table_url_shortener = $wpdb->prefix . WPUSB_URL_Shortener::TABLE_NAME;

		$wpdb->query( "DROP TABLE IF EXISTS {$table_share_report}" );
		$wpdb->query( "DROP TABLE IF EXISTS {$table_url_shortener}" );
	}

	/**
	 * Delete metabox plugin on uninstall
	 *
	 * @since 3.27
	 * @global $wpdb
	 * @param Null
	 * @return Void
	 */
	public static function delete_metabox() {
		global $wpdb;

		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM `{$wpdb->postmeta}` WHERE `meta_key` = %s",
				WPUSB_Setting::META_KEY
			)
		);
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
		$sites = WPUSB_Utils::get_sites();

		if ( empty( $sites ) ) {
			return;
		}

		foreach ( $sites as $blog_id ) :
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
				id         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				post_title TEXT       NOT NULL,
				post_id    BIGINT(20) NOT NULL DEFAULT 0,
				facebook   BIGINT(20) NOT NULL DEFAULT 0,
				twitter    BIGINT(20) NOT NULL DEFAULT 0,
				google     BIGINT(20) NOT NULL DEFAULT 0,
				linkedin   BIGINT(20) NOT NULL DEFAULT 0,
				pinterest  BIGINT(20) NOT NULL DEFAULT 0,
				tumblr     BIGINT(20) NOT NULL DEFAULT 0,
				buffer     BIGINT(20) NOT NULL DEFAULT 0,
				total      BIGINT(20) NOT NULL DEFAULT 0,
				post_date  DATE       NOT NULL,
				PRIMARY KEY id ( id ),
				UNIQUE( post_id ),
				INDEX( post_id )
			) {$charset};
		";

		self::db_delta( $query );
		self::_create_table_short_url();
		self::alter_table();
	}

	/**
	 * Create table short url.
	 *
	 * @since 1.1
	 * @global $wpdb
	 * @param Null
	 * @return Void
	 */
	private static function _create_table_short_url() {
		global $wpdb;

		$charset    = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . WPUSB_URL_Shortener::TABLE_NAME;
		$query      = "
			CREATE TABLE IF NOT EXISTS {$table_name} (
				id         BIGINT(20)   UNSIGNED NOT NULL AUTO_INCREMENT,
				post_id    BIGINT(20)   NOT NULL DEFAULT 0,
				hash       VARCHAR(32)  NOT NULL,
				short_url  VARCHAR(100) NOT NULL,
				expires    INT(11)      NOT NULL DEFAULT 0,
				PRIMARY KEY id ( id ),
				UNIQUE( hash, post_id ),
				INDEX( hash, post_id )
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
		// Include upgrade file if dbDelta function not exists
		if ( ! function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		}

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

		if ( self::is_new_installation() ) {
			return;
		}

		$table = WPUSB_Utils::get_table_name();

		self::_set_column_tumblr( $wpdb, $table );
		self::_set_column_buffer( $wpdb, $table );
		self::_set_column_post_date( $wpdb, $table );
		self::_create_table_short_url();
	}

	private static function _set_column_tumblr( $wpdb, $table ) {
		if ( self::column_exists( 'tumblr' ) ) {
			return;
		}

		$wpdb->query( "ALTER TABLE {$table} ADD tumblr BIGINT(20) NOT NULL DEFAULT 0 AFTER pinterest;" );
	}

	private static function _set_column_post_date( $wpdb, $table ) {
		if ( self::column_exists( 'post_date' ) ) {
			return;
		}

		$inserted = $wpdb->query( "ALTER TABLE {$table} ADD post_date DATE NOT NULL;" );

		if ( ! $inserted ) {
			return;
		}

		$results = $wpdb->get_results( "SELECT `id`, `post_id` FROM `{$table}`" );

		if ( empty( $results ) ) {
			return;
		}

		foreach ( $results as $result ) :
			$post_date = $wpdb->get_var(
				$wpdb->prepare(
					"SELECT `post_date` FROM `{$wpdb->posts}` WHERE `ID` = %d",
					$result->post_id
				)
			);

			$wpdb->query(
				$wpdb->prepare(
					"UPDATE `{$table}` SET `post_date` = %s WHERE `id` = %d",
					date_i18n( 'Y-m-d', strtotime( $post_date ) ),
					$result->id
				)
			);
		endforeach;
	}

	private static function _set_column_buffer( $wpdb, $table ) {
		if ( self::column_exists( 'buffer' ) ) {
			return;
		}

		$wpdb->query( "ALTER TABLE {$table} ADD buffer BIGINT(20) NOT NULL DEFAULT 0 AFTER tumblr;" );
	}

	/**
	 * Check column exists
	 *
	 * @since 3.27
	 * @param String $column
	 * @return String
	 */
	public static function column_exists( $column ) {
		global $wpdb;

		$table = WPUSB_Utils::get_table_name();
		$query = $wpdb->prepare(
			'SELECT
                COLUMN_NAME
             FROM
                information_schema.COLUMNS
             WHERE
                    TABLE_SCHEMA = %s
                AND TABLE_NAME = %s
                AND COLUMN_NAME = %s;
            ',
			$wpdb->dbname,
			$table,
			$column
		);

		return $wpdb->get_var( $query );
	}

	public static function is_new_installation() {
		$option = WPUSB_Utils::get_options_name( 1 );

		return WPUSB_Utils::get_option( $option ) ? false : true;
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
			self::$_instance = new self();
		}
	}
}

WPUSB_Core::register_actions();

add_action( 'plugins_loaded', array( 'WPUSB_Core', 'instance' ) );
add_action( 'init', array( 'WPUSB_Core', 'load_textdomain' ) );

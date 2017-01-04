<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Scripts
 * @version 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

final class WPUSB_Scripts {

	private static $instance = null;

	/**
	* Initialize the plugin by setting localization, filters, and administration functions.
	*
	* @since 1.2
	*/
	private function __construct() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'add_front_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_scripts' ) );
	}

	/**
	 * Enqueue scripts and stylesheets on admin
	 *
	 * @since 1.2
	 * @param Null
	 * @return Void
	 */
	public static function admin_scripts() {
		if ( ! WPUSB_Utils::is_plugin_page() ) {
			return;
		}

		wp_enqueue_script(
			WPUSB_App::SLUG . '-admin-scripts',
			WPUSB_Utils::plugin_url( 'javascripts/admin/built.js' ),
			array( 'jquery', 'jquery-ui-sortable' ),
			WPUSB_App::VERSION,
			true
		);

		wp_localize_script(
			WPUSB_App::SLUG . '-admin-scripts',
			'WPUSBVars',
			array(
				'ajaxUrl'       => esc_url( admin_url( 'admin-ajax.php' ) ),
				'WPLANG'        => get_locale(),
				'previewTitles' => array(
					'titleRemove'   => __( 'View Untitled', WPUSB_App::TEXTDOMAIN ),
					'counterRemove' => __( 'View without count', WPUSB_App::TEXTDOMAIN ),
					'titleInsert'   => __( 'See with title', WPUSB_App::TEXTDOMAIN ),
					'counterInsert' => __( 'See with count', WPUSB_App::TEXTDOMAIN ),
				),
			)
		);

		$page_settings = ( WPUSB_App::SLUG === WPUSB_Utils::get( 'page' ) );
		$handle        = WPUSB_App::SLUG . '-front-style';

		if ( $page_settings ) {
			wp_register_style(
				$handle,
				WPUSB_Utils::plugin_url( 'stylesheets/style.css' ),
				array(),
				WPUSB_App::VERSION
			);
		}

		wp_enqueue_style(
			WPUSB_App::SLUG . '-admin-style',
			WPUSB_Utils::plugin_url( 'stylesheets/admin.css' ),
			( $page_settings ) ? array( $handle ) : array(),
			WPUSB_App::VERSION
		);
	}

	/**
	 * Enqueue scripts and styles
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function add_front_scripts() {
		$is_active = WPUSB_Utils::is_active();

		if ( ! apply_filters( WPUSB_App::SLUG , '-add-scripts', $is_active ) ) {
			return;
		}

		self::front_javascripts();

		if ( 'on' === WPUSB_Utils::option( 'css_footer' ) ) {
			return add_action( 'wp_footer', array( __CLASS__, 'front_styles' ) );
		}

		self::front_styles();
	}

	/**
	 * Enqueue front scripts
	 *
	 * @since 3.1.0
	 * @param Null
	 * @return Void
	 */
	public static function front_javascripts() {
		if ( 'on' === WPUSB_Utils::option( 'disable_js' ) ) {
			return;
		}

		$context = WPUSB_Utils::option( 'fixed_context' );

		wp_enqueue_script(
			WPUSB_App::SLUG . '-scripts',
			WPUSB_Utils::plugin_url( 'javascripts/front/built.js' ),
			array( 'jquery' ),
			WPUSB_App::VERSION,
			true
		);

		wp_localize_script(
			WPUSB_App::SLUG . '-scripts',
			'WPUSBVars',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'context' => str_replace( '{id}', WPUSB_Utils::get_id(), $context ),
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
	public static function front_styles() {
		if ( 'on' === WPUSB_Utils::option( 'disable_css' ) ) {
			return;
		}

		wp_enqueue_style(
			WPUSB_App::SLUG . '-style',
			WPUSB_Utils::plugin_url( 'stylesheets/style.css' ),
			array(),
			WPUSB_App::VERSION
		);
	}

	/**
	 * Singleton instance
	 *
	 * @since 3.22
	 * @param Null
	 * @return Void
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}
	}
}
WPUSB_Scripts::instance();
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

		self::codemirror_scripts();

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
				WPUSB_Utils::plugin_url( self::get_front_css_path() ),
				array(),
				filemtime( WPUSB_Utils::file_path( self::get_front_css_path() ) )
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
			WPUSB_Utils::plugin_url( self::get_front_css_path() ),
			array(),
			filemtime( WPUSB_Utils::file_path( self::get_front_css_path() ) )
		);
	}

	public static function codemirror_scripts() {
		if ( WPUSB_Utils::get( 'page' ) !== WPUSB_Setting::CUSTOM_CSS ) {
			return;
		}

		$path_codemirror = 'Vendor/codemirror/';

		//Lib
		wp_enqueue_script(
			WPUSB_App::SLUG . '-codemirror-js',
			WPUSB_Utils::plugin_url( 'lib/codemirror.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);
		wp_enqueue_style(
			WPUSB_App::SLUG . '-codemirror-css',
			WPUSB_Utils::plugin_url( 'lib/codemirror.css', $path_codemirror ),
			array(),
			WPUSB_App::VERSION
		);

		//Theme
		wp_enqueue_style(
			WPUSB_App::SLUG . '-codemirror-theme-seti',
			WPUSB_Utils::plugin_url( 'theme/seti.css', $path_codemirror ),
			array(),
			'5.22'
		);

		//Mode
		wp_enqueue_script(
			WPUSB_App::SLUG . '-codemirror-mode-css',
			WPUSB_Utils::plugin_url( 'mode/css/css.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);

		//AddOn Edit
		wp_enqueue_script(
			WPUSB_App::SLUG . '-codemirror-addon-edit-closebrackets',
			WPUSB_Utils::plugin_url( 'addon/edit/closebrackets.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);
		wp_enqueue_script(
			WPUSB_App::SLUG . '-codemirror-addon-edit-matchbrackets',
			WPUSB_Utils::plugin_url( 'addon/edit/matchbrackets.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);
		wp_enqueue_script(
			WPUSB_App::SLUG . '-codemirror-addon-edit-trailingspace',
			WPUSB_Utils::plugin_url( 'addon/edit/trailingspace.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);

		//AddOn Display
		wp_enqueue_script(
			WPUSB_App::SLUG . '-codemirror-addon-display-placeholder',
			WPUSB_Utils::plugin_url( 'addon/display/placeholder.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);

		//AddOn Hint
		wp_enqueue_script(
			WPUSB_App::SLUG . '-codemirror-addon-hint-css-hint',
			WPUSB_Utils::plugin_url( 'addon/hint/css-hint.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);
		wp_enqueue_script(
			WPUSB_App::SLUG . '-codemirror-addon-hint-show-hint-js',
			WPUSB_Utils::plugin_url( 'addon/hint/show-hint.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);
		wp_enqueue_style(
			WPUSB_App::SLUG . '-codemirror-addon-hint-show-hint',
			WPUSB_Utils::plugin_url( 'addon/hint/show-hint.css', $path_codemirror ),
			array(),
			'5.22'
		);

		//AddOn Lint
		wp_enqueue_style(
			WPUSB_App::SLUG . '-codemirror-addon-lint-lint',
			WPUSB_Utils::plugin_url( 'addon/lint/lint.css', $path_codemirror ),
			array(),
			'5.22'
		);
		wp_enqueue_script(
			WPUSB_App::SLUG . '-codemirror-addon-lint-lint-js',
			WPUSB_Utils::plugin_url( 'addon/lint/lint.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);
		wp_enqueue_script(
			WPUSB_App::SLUG . '-codemirror-addon-lint-css-lint',
			WPUSB_Utils::plugin_url( 'addon/lint/css-lint.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);

		//AddOn Selection
		wp_enqueue_script(
			WPUSB_App::SLUG . '-codemirror-addon-selection-active-line',
			WPUSB_Utils::plugin_url( 'addon/selection/active-line.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);
	}


	public static function get_front_css_path() {
		if ( WPUSB_Utils::file_css_min_exists() ) {
			return 'stylesheets/style.min.css';
		}

		return 'stylesheets/style.css';
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
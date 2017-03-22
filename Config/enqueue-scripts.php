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

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'jquery-ui-sortable' );

		if ( self::_is_sharing_report_page() ) {
			wp_enqueue_script( 'jquery-ui-datepicker' );
		}

		wp_enqueue_script(
			WPUSB_Utils::add_prefix( '-admin-scripts' ),
			WPUSB_Utils::plugin_url( 'javascripts/admin/built.js' ),
			array( 'jquery' ),
			WPUSB_App::VERSION,
			true
		);

		wp_localize_script(
			WPUSB_Utils::add_prefix( '-admin-scripts' ),
			'WPUSBVars',
			self::_localize_script_args()
		);

		$page_settings = self::_is_panel_home();
		$handle        = WPUSB_Utils::add_prefix( '-front-style' );

		if ( $page_settings ) {
			wp_register_style(
				$handle,
				WPUSB_Utils::plugin_url( self::get_front_css_path() ),
				array(),
				WPUSB_Utils::filetime( WPUSB_Utils::file_path( self::get_front_css_path() ) )
			);
		}

		wp_enqueue_style(
			WPUSB_Utils::add_prefix( '-admin-style' ),
			WPUSB_Utils::plugin_url( 'stylesheets/admin.css' ),
			( $page_settings ) ? array( $handle ) : array(),
			WPUSB_App::VERSION
		);
	}

	/**
	 * Check is home dashboard
	 *
	 * @since 3.32
	 * @param Null
	 * @return Boolean
	 */
	private static function _is_panel_home() {
		return ( WPUSB_App::SLUG === WPUSB_Utils::get( 'page' ) );
	}

	/**
	 * Check is sharing report page
	 *
	 * @since 3.32
	 * @param Null
	 * @return Boolean
	 */
	private static function _is_sharing_report_page() {
		return ( WPUSB_Setting::SHARING_REPORT === WPUSB_Utils::get( 'page' ) );
	}

	/**
	 * Check is custom css page
	 *
	 * @since 3.32
	 * @param Null
	 * @return Boolean
	 */
	private static function is_custom_css_page() {
		return ( WPUSB_Setting::CUSTOM_CSS === WPUSB_Utils::get( 'page' ) );
	}

	/**
	 * Arguments admin plugin scripts
	 *
	 * @since 3.32
	 * @param Null
	 * @return Array
	 */
	private static function _localize_script_args() {
		$args = array(
			'ajaxUrl' => WPUSB_Utils::get_admin_url( 'admin-ajax.php' ),
			'homeUrl' => esc_url( get_home_url() ),
			'WPLANG'  => get_locale(),
		);

		if ( self::_is_panel_home() ) {
			$args['previewTitles'] = array(
				'titleRemove'   => __( 'View Untitled', WPUSB_App::TEXTDOMAIN ),
				'counterRemove' => __( 'View without count', WPUSB_App::TEXTDOMAIN ),
				'titleInsert'   => __( 'See with title', WPUSB_App::TEXTDOMAIN ),
				'counterInsert' => __( 'See with count', WPUSB_App::TEXTDOMAIN ),
			);
		}

		if ( self::_is_sharing_report_page() ) {
			$tag = WPUSB_Utils::add_prefix( '_datepicker_defaults' );

			$args['datepickerDefaults'] = apply_filters( $tag, self::get_localize_datepicker() );
		}

		return $args;
	}

	/**
	 * Localizes the jQuery UI datepicker.
	 *
	 * @since 3.32
	 * @link http://api.jqueryui.com/datepicker/#options
	 * @global WP_Locale $wp_locale
	 * @return Array
	 */
	public static function get_localize_datepicker() {
		global $wp_locale;

		if ( function_exists( 'wp_localize_jquery_ui_datepicker' ) ) {
			return array();
		}

		return array(
			'closeText'       => __( 'Close', WPUSB_App::TEXTDOMAIN ),
			'currentText'     => __( 'Today', WPUSB_App::TEXTDOMAIN ),
			'dayNames'        => array_values( $wp_locale->weekday ),
			'dayNamesMin'     => array_values( $wp_locale->weekday_initial ),
			'dayNamesShort'   => array_values( $wp_locale->weekday_abbrev ),
			'firstDay'        => absint( get_option( 'start_of_week' ) ),
			'isRTL'           => $wp_locale->is_rtl(),
			'monthNames'      => array_values( $wp_locale->month ),
			'monthNamesShort' => array_map( 'ucfirst', array_values( $wp_locale->month_abbrev ) ),
			'nextText'        => __( 'Next', WPUSB_App::TEXTDOMAIN ),
			'prevText'        => __( 'Previous', WPUSB_App::TEXTDOMAIN ),
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
		if ( WPUSB_Utils::is_disabled_by_meta() && WPUSB_Utils::is_active_widget_follow() ) {
			self::front_styles();
			return;
		}

		$tag               = WPUSB_Utils::add_prefix( '-add-scripts' );
		$load_scripts      = apply_filters( $tag, WPUSB_Utils::is_active() );
		$customize_preview = WPUSB_Utils::is_customize_preview();

		if ( ! $customize_preview && ( ! WPUSB_Utils::is_active_widget() && ! $load_scripts ) ) {
			return;
		}

		self::front_javascripts();
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
			WPUSB_Utils::add_prefix( '-scripts' ),
			WPUSB_Utils::plugin_url( 'javascripts/front/built.js' ),
			array( 'jquery' ),
			WPUSB_App::VERSION,
			true
		);

		wp_localize_script(
			WPUSB_Utils::add_prefix( '-scripts' ),
			'WPUSBVars',
			array(
				'ajaxUrl'  => WPUSB_Utils::get_admin_url( 'admin-ajax.php' ),
				'context'  => str_replace( '{id}', WPUSB_Utils::get_id(), $context ),
				'minCount' => WPUSB_Utils::option( 'min_count_display', 0, 'absint' ),
			)
		);
	}

	/**
	 * Front styles validate
	 *
	 * @since 3.1.0
	 * @param Null
	 * @return Void
	 */
	public static function front_styles() {
		if ( WPUSB_Utils::is_disabled_css() ) {
			return;
		}

		if ( 'on' === WPUSB_Utils::option( 'css_footer' ) ) {
			return add_action( 'wp_footer', array( __CLASS__, 'add_style_front' ) );
		}

		self::add_style_front();
	}

	/**
	 * Enqueue front styles
	 *
	 * @since 3.1.0
	 * @param Null
	 * @return Void
	 */
	public static function add_style_front() {
		wp_enqueue_style(
			WPUSB_Utils::add_prefix( '-style' ),
			WPUSB_Utils::plugin_url( self::get_front_css_path() ),
			array(),
			WPUSB_Utils::filetime( WPUSB_Utils::file_path( self::get_front_css_path() ) )
		);
	}

	public static function codemirror_scripts() {
		if ( ! self::is_custom_css_page() ) {
			return;
		}

		$path_codemirror = 'Vendor/codemirror/';

		//Lib
		wp_enqueue_script(
			WPUSB_Utils::add_prefix( '-codemirror-js' ),
			WPUSB_Utils::plugin_url( 'lib/codemirror.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);
		wp_enqueue_style(
			WPUSB_Utils::add_prefix( '-codemirror-css' ),
			WPUSB_Utils::plugin_url( 'lib/codemirror.css', $path_codemirror ),
			array(),
			WPUSB_App::VERSION
		);

		//Theme
		wp_enqueue_style(
			WPUSB_Utils::add_prefix( '-codemirror-theme-seti' ),
			WPUSB_Utils::plugin_url( 'theme/seti.css', $path_codemirror ),
			array(),
			'5.22'
		);

		//Mode
		wp_enqueue_script(
			WPUSB_Utils::add_prefix( '-codemirror-mode-css' ),
			WPUSB_Utils::plugin_url( 'mode/css/css.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);

		//AddOn Edit
		wp_enqueue_script(
			WPUSB_Utils::add_prefix( '-codemirror-addon-edit-closebrackets' ),
			WPUSB_Utils::plugin_url( 'addon/edit/closebrackets.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);
		wp_enqueue_script(
			WPUSB_Utils::add_prefix( '-codemirror-addon-edit-matchbrackets' ),
			WPUSB_Utils::plugin_url( 'addon/edit/matchbrackets.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);
		wp_enqueue_script(
			WPUSB_Utils::add_prefix( '-codemirror-addon-edit-trailingspace' ),
			WPUSB_Utils::plugin_url( 'addon/edit/trailingspace.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);

		//AddOn Display
		wp_enqueue_script(
			WPUSB_Utils::add_prefix( '-codemirror-addon-display-placeholder' ),
			WPUSB_Utils::plugin_url( 'addon/display/placeholder.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);

		//AddOn Hint
		wp_enqueue_script(
			WPUSB_Utils::add_prefix( '-codemirror-addon-hint-css-hint' ),
			WPUSB_Utils::plugin_url( 'addon/hint/css-hint.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);
		wp_enqueue_script(
			WPUSB_Utils::add_prefix( '-codemirror-addon-hint-show-hint-js' ),
			WPUSB_Utils::plugin_url( 'addon/hint/show-hint.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);
		wp_enqueue_style(
			WPUSB_Utils::add_prefix( '-codemirror-addon-hint-show-hint' ),
			WPUSB_Utils::plugin_url( 'addon/hint/show-hint.css', $path_codemirror ),
			array(),
			'5.22'
		);

		//AddOn Lint
		wp_enqueue_style(
			WPUSB_Utils::add_prefix( '-codemirror-addon-lint-lint' ),
			WPUSB_Utils::plugin_url( 'addon/lint/lint.css', $path_codemirror ),
			array(),
			'5.22'
		);
		wp_enqueue_script(
			WPUSB_Utils::add_prefix( '-codemirror-addon-lint-lint-js' ),
			WPUSB_Utils::plugin_url( 'addon/lint/lint.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);
		wp_enqueue_script(
			WPUSB_Utils::add_prefix( '-codemirror-addon-lint-css-lint' ),
			WPUSB_Utils::plugin_url( 'addon/lint/css-lint.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);

		//AddOn Selection
		wp_enqueue_script(
			WPUSB_Utils::add_prefix( '-codemirror-addon-selection-active-line' ),
			WPUSB_Utils::plugin_url( 'addon/selection/active-line.js', $path_codemirror ),
			array(),
			'5.22',
			true
		);
	}


	public static function get_front_css_path() {
		if ( WPUSB_Utils::file_css_min_exists() ) {
			return WPUSB_Utils::get_path_css_min();
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
<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Settings Model
 * @version 1.3.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit;
}

class WPUSB_Setting {

	/**
	 * All Options
	 *
	 * @since 1.0
	 * @var array
	 */
	private $options;

	/**
	 * Single value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $single;

	/**
	 * Archive and categories value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $archive_category;

	/**
	 * Before value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $before;

	/**
	 * After value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $after;

	/**
	 * Pages value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $pages;

	/**
	 * Home value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $home;

	/**
	 * Class value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $class;

	/**
	 * Print friendly value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $printer;

	/**
	 * Pinterest value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $pinterest;

	/**
	 * Linkedin value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $linkedin;

	/**
	 * Facebook value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $facebook;

	/**
	 * Whatsapp value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $whatsapp;

	/**
	 * Twitter value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $twitter;

	/**
	 * Tumblr value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $tumblr;

	/**
	 * Email value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $email;

	/**
	 * Disabled css value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $disable_css;

	/**
	 * Disabled scripts value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $disable_js;

	/**
	 * Layout value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $layout;

	/**
	 * Layout position fixed value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $fixed_layout;

	/**
	 * Twitter username value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $twitter_username;

	/**
	 * Twitter hashtags value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $twitter_hashtags;

	/**
	 * UTM Tracking value
	 *
	 * @since 1.0
	 * @var string
	 */
	private $tracking;

	/**
	 * Social Media active
	 *
	 * @since 1.0
	 * @var array
	 */
	private $social_media;

	/**
	 * Remove count buttons
	 *
	 * @since 1.0
	 * @var int
	 */
	private $disabled_count;

	/**
	 * Remove inside buttons name
	 *
	 * @since 1.0
	 * @var int
	 */
	private $disabled_inside;

	/**
	 * Elements position fixed
	 *
	 * @since 1.0
	 * @var string
	 */
	private $position_fixed;

	/**
	 * Elements position fixed right
	 *
	 * @since 3.1.0
	 * @var string
	 */
	private $fixed_right;

	/**
	 * Layout posisition
	 *
	 * @since 1.0
	 * @var string
	 */
	private $fixed;

	/**
	 * Layout scroll fixed top
	 *
	 * @since 1.0
	 * @var string
	 */
	private $fixed_top;

	/**
	 * Twitter text in share
	 *
	 * @since 1.0
	 * @var string
	 */
	private $twitter_text;

	/**
	 * Short url
	 *
	 * @since 1.0
	 * @var string
	 */
	private $bitly_token;

	/**
	 * Featured by referrence
	 *
	 * @since 1.0
	 * @var string
	 */
	private $referrer;

	/**
	 * The context to search
	 *
	 * @since 1.0
	 * @var string
	 */
	private $fixed_context;

	/**
	 * Style CSS in footer
	 *
	 * @since 1.0
	 * @var string
	 */
	private $css_footer;

	/**
	 * WooCommerce share
	 *
	 * @since 1.0
	 * @var string
	 */
	private $woocommerce;

	/**
	 * Disable sharing report counts
	 *
	 * @since 1.0
	 * @var string
	 */
	private $sharing_report_disabled;

	/**
	 * Share count label
	 *
	 * @since 1.0
	 * @var string
	 */
	private $share_count_label;

	/**
	 * Title above share buttons
	 *
	 * @since 1.0
	 * @var string
	 */
	private $title;

	/**
	 * Custom icons size
	 *
	 * @since 1.0
	 * @var int
	 */
	private $icons_size;

	/**
	 * Custom icons color
	 *
	 * @since 1.0
	 * @var string
	 */
	private $icons_color;

	/**
	 * Custom icons background color
	 *
	 * @since 1.0
	 * @var string
	 */
	private $button_bg_color;

	/**
	 * Minify html output
	 *
	 * @since 1.0
	 * @var string
	 */
	private $minify_html;

	/**
	 * Text color layout fixed default
	 *
	 * @since 3.27
	 * @var string
	 */
	private $text_label_fixed_default;

	/**
	 * Title color layout button
	 *
	 * @since 3.27
	 * @var string
	 */
	private $btn_inside_color;

	/**
	 * Share count text color
	 *
	 * @since 3.27
	 * @var string
	 */
	private $counts_text_color;

	/**
	 * Share count background color
	 *
	 * @since 3.27
	 * @var string
	 */
	private $counts_bg_color;

	/**
	 * Bitly URL shortener domain
	 *
	 * @since 3.27
	 * @var string
	 */
	private $bitly_domain;

	/**
	 * Min count to display
	 *
	 * @since 3.29
	 * @var int
	 */
	private $min_count_display;

	/**
	 * Pinterest alt description
	 *
	 * @since 3.31
	 * @var string
	 */
	private $pin_image_alt;

	/**
	 * Active post types
	 *
	 * @since 3.31
	 * @var string
	 */
	private $post_types;

	/**
	 * Instance singleton
	 *
	 * @since 1.0
	 * @var null|Object class
	 */
	private static $instance = null;

	/**
	 * Plugin general prefix
	 *
	 * @since 1.0
	 * @var string
	 */
	const PREFIX = 'wpusb';

	/**
	 * Sharing report table name
	 *
	 * @since 1.0
	 * @var string
	 */
	const TABLE_NAME = 'wpusb_report';

	/**
	 * Post meta key
	 *
	 * @since 1.0
	 * @var string
	 */
	const META_KEY = 'wpusb_post_meta';

	/**
	 * Directory separator AND File name
	 *
	 * @since 1.0
	 * @var string
	 */
	const DS = DIRECTORY_SEPARATOR;

	/**
	 * Name for transient function
	 *
	 * @since 1.0
	 * @var string
	 */
	const TRANSIENT_SHARING_REPORT = 'transient-wpusb-report';
	const TRANSIENT_SHARING_REPORT_COUNT = 'transient-wpusb-report-count';

	/**
	 *  Define name menus
	 *
	 * @since 2.8.2
	 * @var string
	*/
	const HOME_SETTINGS  = 'wpusb';
	const EXTRA_SETTINGS = 'wpusb-extra-settings';
	const USE_OPTIONS    = 'wpusb-faq';
	const CUSTOM_CSS     = 'wpusb-custom-css';
	const SHARING_REPORT = 'wpusb-sharing-report';

	/**
	* Nonce inset social share counts
	*
	* @since 1.0
	* @var string
	*/
	const NONCE_SHARING_REPORT = 'wpusb-social-share-counts';

	private function __construct() {
		$this->set_options();
	}

	/**
	 * Magic function to retrieve the value of the attribute more easily.
	 *
	 * @since 1.0
	 * @param string $prop_name The attribute name
	 * @return mixed The attribute value
	 */
	public function __get( $prop_name ) {
		if ( isset( $this->{$prop_name} ) ) {
			return $this->{$prop_name};
		}

		return $this->_get_property( $prop_name );
	}

	/**
	 * Use in __get() magic method to retrieve the value of the attribute
	 * on demand. If the attribute is unset get his value before.
	 *
	 * @since 1.0
	 * @param string $prop_name The attribute name
	 * @return mixed String/Integer The value of the attribute
	 */
	private function _get_property( $prop_name ) {
		switch ( $prop_name ) {

			case 'social_media':
				$this->social_media = WPUSB_Utils::get_option( WPUSB_Utils::add_prefix( '_social_media' ) );
				break;

			default:
				$this->{$prop_name} = WPUSB_Utils::get_value_by( $this->options, $prop_name );
		}

		return $this->{$prop_name};
	}

	/**
	 * Get all options
	 *
	 * @since 1.1
	 * @return array
	 */
	public function get_options() {
		return $this->options;
	}

	/**
	  * Set all options
	  *
	 * @since 1.1
	 * @return array
	 */
	public function set_options() {
		$this->options = $this->_get_merged_options();
	}

	/**
	  * Merge array all options
	  *
	 * @since 1.0
	 * @param string $settings
	 * @param string $social
	 * @param string $extra
	 * @return array
	 */
	private function _get_merged_options() {
		$options_name = WPUSB_Utils::get_options_name();
		$options      = array();

		unset( $options_name[1] );
		unset( $options_name[5] );

		foreach ( $options_name as $option_name ) :
			$option = WPUSB_Utils::get_option( $option_name );

			if ( is_array( $option ) ) {
				$options = array_merge( $options, $option );
			}
		endforeach;

		return apply_filters( WPUSB_App::SLUG . 'options-args', $options );
	}

	/**
	  * Singleton instance generate
	  *
	 * @since 1.0
	 * @return object class
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

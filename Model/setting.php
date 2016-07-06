<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Settings Model
 * @version 1.3.0
 */

if ( ! function_exists( 'add_action' ) )
	exit(0);

class WPUSB_Setting
{
	/**
	 * Full Options
	 *
	 * @since 1.0
	 * @var Array
	 */
	private $full_options;

	/**
	 * Single value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $single;

	/**
	 * Before value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $before;

	/**
	 * After value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $after;

	/**
	 * Pages value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $pages;

	/**
	 * Home value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $home;

	/**
	 * Class value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $class;

	/**
	 * Print friendly value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $printer;

	/**
	 * Google value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $google;

	/**
	 * Pinterest value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $pinterest;

	/**
	 * Linkedin value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $linkedin;

	/**
	 * Facebook value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $facebook;

	/**
	 * Whatsapp value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $whatsapp;

	/**
	 * Twitter value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $twitter;

	/**
	 * Tumblr value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $tumblr;

	/**
	 * Email value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $email;

	/**
	 * Disabled css value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $disable_css;

	/**
	 * Disabled scripts value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $disable_js;

	/**
	 * Layout value verify option
	 *
	 * @since 1.0
	 * @var String
	 */
	private $layout;

	/**
	 * Twitter username value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $twitter_username;

	/**
	 * UTM Tracking value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $tracking;

	/**
	 * Report cache time value verify option
	 *
	 * @since 1.0
	 * @var Integer
	 */
	private $report_cache_time;

	/**
	 * Social Media active
	 *
	 * @since 1.0
	 * @var Array
	 */
	private $social_media;

	/**
	 * Remove count buttons
	 *
	 * @since 1.0
	 * @var Integer
	 */
	private $remove_count;

	/**
	 * Remove inside buttons name
	 *
	 * @since 1.0
	 * @var Integer
	 */
	private $remove_inside;

	/**
	 * Elements position fixed
	 *
	 * @since 1.0
	 * @var String
	 */
	private $position_fixed;

	/**
	 * Elements position fixed right
	 *
	 * @since 3.1.0
	 * @var String
	 */
	private $fixed_right;

	/**
	 * Layout posisition
	 *
	 * @since 1.0
	 * @var String
	 */
	private $fixed;

	/**
	 * Layout scroll fixed top
	 *
	 * @since 1.0
	 * @var String
	 */
	private $fixed_top;

	/**
	 * Twitter text in share
	 *
	 * @since 1.0
	 * @var String
	 */
	private $twitter_text;

	/**
	 * ID of post
	 *
	 * @since 1.0
	 * @var Integer
	 */
	private $ID;

	/**
	 * Short url
	 *
	 * @since 1.0
	 * @var String
	 */
	private $bitly_token;

	/**
	 * Featured by referrence
	 *
	 * @since 1.0
	 * @var String
	 */
	private $referrer;

	/**
	 * Plugin general prefix
	 *
	 * @since 1.0
	 * @var string
	 */
	const PREFIX = 'wpusb';

	/**
	 * Sharing report db version
	 *
	 * @since 1.0
	 * @var string
	 */
	const DB_VERSION = '1.0';

	/**
	 * Sharing report table name
	 *
	 * @since 1.0
	 * @var string
	 */
	const TABLE_NAME = 'wpusb_report';

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
	const TRANSIENT = 'transient-wpusb-report';
	const TRANSIENT_SELECT_COUNT = 'transient-wpusb-report-count';
	const TRANSIENT_GOOGLE_PLUS = 'transient-wpusb-google-plus';

	/**
	 *	Define name menus
	 *
	 * @since 2.8.2
	 * @var string
	*/
	const HOME_SETTINGS  = 'wpusb';
	const EXTRA_SETTINGS = 'wpusb-extra-settings';
	const USE_OPTIONS    = 'wpusb-faq';
	const SHARING_REPORT = 'wpusb-sharing-report';

	public function __construct( $ID = false )
	{
		if ( false !== $ID )
			$this->ID = abs( intval( $ID ) );
	}

	/**
	 * Magic function to retrieve the value of the attribute more easily.
	 *
	 * @since 1.0
	 * @param string $prop_name The attribute name
	 * @return mixed The attribute value
	 */
	public function __get( $prop_name )
	{
		if ( isset( $this->$prop_name ) )
			return $this->$prop_name;

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
	private function _get_property( $prop_name )
	{
		switch ( $prop_name ) :

			case 'full_options' :
				if ( ! isset( $this->full_options ) )
					$this->full_options = $this->get_options();
				break;

			case 'social_media' :
				if ( ! isset( $this->social_media ) )
					$this->social_media = get_option( self::PREFIX . '_social_media' );
				break;

			default :
				if ( ! isset( $this->$prop_name ) )
					$this->$prop_name = WPUSB_Utils::option( $prop_name );

		endswitch;

		return $this->$prop_name;
	}

	/**
 	 * Set all options
 	 *
	 * @since 1.1
	 * @param Null
	 * @return Array
	 */
	private function _set_options()
	{
		$prefix   = self::PREFIX;
		$settings = "{$prefix}_settings";
		$social   = "{$prefix}_social_media";
		$extra    = "{$prefix}_extra_settings";
		$options  = $this->_merge_options( $settings, $social, $extra );

		return apply_filters( WPUSB_App::SLUG . 'options-args', $options );
	}

	/**
 	 * Merge array all options
 	 *
	 * @since 1.0
	 * @param String $settings - Settings page
	 * @param String $social - Social media items
	 * @param String $extra - Settings extra page
	 * @return Array
	 */
	private function _merge_options( $settings, $social, $extra )
	{
		return array_merge(
			(array) get_option( $settings ),
			(array) get_option( $social ),
			(array) get_option( $extra )
		);
	}

	/**
	 * Get all options
	 *
	 * @since 1.1
	 * @param Null
	 * @return Array
	 */
	public function get_options()
	{
		return $this->_set_options();
	}
}
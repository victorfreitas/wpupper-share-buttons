<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  WPUpper
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
	private $google_plus;

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
	 * Layout posisition
	 *
	 * @since 1.0
	 * @var String
	 */
	private $fixed;

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
	 * Transiente name for cache share objects
	 *
	 * @since 1.0
	 * @var string
	 */
	const TRANSIENT_SHARE_OBJECTS = 'wpusb-objects';

	/**
	 * Name for transient function
	 *
	 * @since 1.0
	 * @var string
	 */
	const TRANSIENT = 'transient-wpusb-report';
	const TRANSIENT_SELECT_COUNT = 'transient-wpusb-report-count';
	const TRANSIENT_GOOGLE_PLUS = 'transient-wpusb-google-plus';

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

			case 'single' :
				if ( ! isset( $this->single ) )
					$this->single = WPUSB_Utils::option( 'single' );
				break;

			case 'before' :
				if ( ! isset( $this->before ) )
					$this->before = WPUSB_Utils::option( 'before' );
				break;

			case 'after' :
				if ( ! isset( $this->after ) )
					$this->after = WPUSB_Utils::option( 'after' );
				break;

			case 'pages' :
				if ( ! isset( $this->pages ) )
					$this->pages = WPUSB_Utils::option( 'pages' );
				break;

			case 'home' :
				if ( ! isset( $this->home ) )
					$this->home = WPUSB_Utils::option( 'home' );
				break;

			case 'class' :
				if ( ! isset( $this->class ) )
					$this->class = WPUSB_Utils::option( 'class' );
				break;

			case 'printer' :
				if ( ! isset( $this->printer ) )
					$this->printer = WPUSB_Utils::option( 'printer' );
				break;

			case 'google_plus' :
				if ( ! isset( $this->google_plus ) )
					$this->google_plus = WPUSB_Utils::option( 'google-plus' );
				break;

			case 'pinterest' :
				if ( ! isset( $this->pinterest ) )
					$this->pinterest = WPUSB_Utils::option( 'pinterest' );
				break;

			case 'linkedin' :
				if ( ! isset( $this->linkedin ) )
					$this->linkedin = WPUSB_Utils::option( 'linkedin' );
				break;

			case 'facebook' :
				if ( ! isset( $this->facebook ) )
					$this->facebook = WPUSB_Utils::option( 'facebook' );
				break;

			case 'whatsapp' :
				if ( ! isset( $this->whatsapp ) )
					$this->whatsapp = WPUSB_Utils::option( 'whatsapp' );
				break;

			case 'twitter' :
				if ( ! isset( $this->twitter ) )
					$this->twitter = WPUSB_Utils::option( 'twitter' );
				break;

			case 'tumblr' :
				if ( ! isset( $this->tumblr ) )
					$this->tumblr = WPUSB_Utils::option( 'tumblr' );
				break;

			case 'email' :
				if ( ! isset( $this->email ) )
					$this->email = WPUSB_Utils::option( 'email' );
				break;

			case 'disable_css' :
				if ( ! isset( $this->disable_css ) )
					$this->disable_css = WPUSB_Utils::option( 'disable_css' );
				break;

			case 'disable_js' :
				if ( ! isset( $this->disable_js ) )
					$this->disable_js = WPUSB_Utils::option( 'disable_js' );
				break;

			case 'layout' :
				if ( ! isset( $this->layout ) )
					$this->layout = WPUSB_Utils::option( 'layout', 'default' );
				break;

			case 'twitter_username' :
				if ( ! isset( $this->twitter_username ) )
					$this->twitter_username = WPUSB_Utils::option( 'twitter_via' );
				break;

			case 'tracking' :
				if ( ! isset( $this->tracking ) )
					$this->tracking = WPUSB_Utils::option( 'tracking' );
				break;

			case 'report_cache_time' :
				if ( ! isset( $this->report_cache_time ) )
					$this->report_cache_time = WPUSB_Utils::option( 'report_cache_time', 10, 'intval' );
				break;

			case 'social_media' :
				if ( ! isset( $this->social_media ) )
					$this->social_media = get_option( self::PREFIX . '_social_media' );
				break;

			case 'remove_count' :
				if ( ! isset( $this->remove_count ) )
					$this->remove_count = WPUSB_Utils::option( 'remove_count', 0, 'intval' );
				break;

			case 'remove_inside' :
				if ( ! isset( $this->remove_inside ) )
					$this->remove_inside = WPUSB_Utils::option( 'remove_inside', 0, 'intval' );
				break;

			case 'position_fixed' :
				if ( ! isset( $this->position_fixed ) )
					$this->position_fixed = WPUSB_Utils::option( 'position_fixed' );
				break;

			case 'fixed' :
				if ( ! isset( $this->fixed ) )
					$this->fixed = WPUSB_Utils::option( 'fixed' );
				break;

			case 'bitly_token' :
				if ( ! isset( $this->bitly_token ) )
					$this->bitly_token = WPUSB_Utils::option( 'bitly_token' );
				break;

			default :
				return false;
				break;

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
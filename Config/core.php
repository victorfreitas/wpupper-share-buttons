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

/*
* Automatic include files
* in Helper, Controller and Templates
*/
App::require_files();

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
		add_action( 'plugins_loaded', array( __CLASS__, 'share_report_update_db_check' ) );
		add_action( 'plugins_loaded', array( __CLASS__, 'load_text_domain' ) );
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
	 * Generate object all social icons
	 *
	 * @since 2.4
	 * @param String $title
	 * @param String $url
	 * @param String $tracking
	 * @param String $thumbnail
	 * @param String $body_mail
	 * @param String $twitter_username
	 * @return Object all data links
	 */
	private static function _set_elements( $title, $url, $tracking, $thumbnail, $body_mail, $twitter_username )
	{
		$action         = 'data-action="open-popup"';
		$url_like       = rawurldecode( $url );
		$url            = ( is_admin() ) ? '' : static::_generate_short_url( $url, $tracking );
		$prefix         = Setting::PREFIX;
		$item           = "{$prefix}-item";
		$class_button   = "{$prefix}-button";
		$twitter_text_a = apply_filters( App::SLUG . '-twitter-after', __( 'I just saw', App::TEXTDOMAIN ) );
		$twitter_text_b = apply_filters( App::SLUG . '-twitter-before', __( 'Click to see also', App::TEXTDOMAIN ) );
		$caracter       = apply_filters( App::SLUG . '-caracter', html_entity_decode( '&#x261B;' ) );
		$twitter_text   = Utils::get_twitter_text( $title, $twitter_text_a, $twitter_text_b, $caracter );
		$option_tt_text = Utils::option( 'twitter_text' );
		$twitter_text   = ( ! empty( $option_tt_text ) ) ? str_replace( '{title}', $title, $option_tt_text ) : $twitter_text;
		$twitter_text   = Utils::rip_tags( $twitter_text );
		$viber_text     = apply_filters( App::SLUG . '-viber-text', "{$title}%20{$caracter}%20", $title );
		$whatsapp_text  = apply_filters( App::SLUG . '-whatsapp-text', "{$title}%20{$caracter}%20", $title );
		$twitter_via    = ( ! empty( $twitter_username ) ) ? "&via={$twitter_username}" : '';
		$share_items    = array(
			'facebook'  => array(
				'name'        => 'Facebook',
				'element'     => 'facebook',
				'link'        => "https://www.facebook.com/sharer/sharer.php?u={$url}",
				'title'       => __( 'Share on Facebook', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-facebook",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-facebook",
 				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => true,
			),
			'twitter'   => array(
				'name'        => 'Twitter',
				'element'     => 'twitter',
				'link'        => "https://twitter.com/share?url={$url}&text={$twitter_text}{$twitter_via}",
				'title'       => __( 'Tweet', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-twitter",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-twitter",
				'popup'       => $action,
				'inside'      => __( 'Tweet', App::TEXTDOMAIN ),
				'has_counter' => true,
			),
			'google'    => array(
				'name'        => 'Google Plus',
				'element'     => 'google-plus',
				'link'        => "https://plus.google.com/share?url={$url}",
				'title'       => __( 'Share on Google+', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-google-plus",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-google-plus",
				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => true,
			),
			'whatsapp'  => array(
				'name'        => 'WhatsApp',
				'element'     => 'whatsapp',
				'link'        => "whatsapp://send?text={$whatsapp_text}{$url}",
				'title'       => __( 'Share on WhatsApp', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-whatsapp",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-whatsapp",
				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'pinterest' => array(
				'name'        => 'Pinterest',
				'element'     => 'pinterest',
				'link'        => "https://pinterest.com/pin/create/button/?url={$url}&media={$thumbnail}&description={$title}",
				'title'       => __( 'Share on Pinterest', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-pinterest",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-pinterest",
				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => true,
			),
			'linkedin'  => array(
				'name'        => 'Linkedin',
				'element'     => 'linkedin',
				'link'        => "https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}",
				'title'       => __( 'Share on Linkedin', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-linkedin",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-linkedin",
				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => true,
			),
			'tumblr'    => array(
				'name'        => 'Tumblr',
				'element'     => 'tumblr',
				'link'        => 'http://www.tumblr.com/share',
				'title'       => __( 'Share on Tumblr', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-tumblr",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-tumblr",
				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'email'     => array(
				'name'        => 'Email',
				'element'     => 'email',
				'link'        => "mailto:?subject={$title}&body={$url}\n{$body_mail}",
				'title'       => __( 'Send by email', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-email",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-email",
				'popup'       => $action,
				'inside'      => 'Email',
				'has_counter' => false,
			),
			'gmail'     => array(
				'name'        => 'Gmail',
				'element'     => 'gmail',
				'link'        => "https://mail.google.com/mail/u/0/?view=cm&fs=1&su={$title}&body={$url}\n{$body_mail}&tf=1",
				'title'       => __( 'Send by Gmail', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-gmail",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-gmail",
				'popup'       => $action,
				'inside'      => 'Gmail',
				'has_counter' => false,
			),
			'printer'   => array(
				'name'        => 'PrintFriendly',
				'element'     => 'printer',
				'link'        => "http://www.printfriendly.com/print?url={$url}",
				'title'       => __( 'Print via PrintFriendly', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-printer",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-printer",
				'popup'       => $action,
				'inside'      => __( 'Print', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'telegram'  => array(
				'name'        => 'Telegram',
				'element'     => 'telegram',
				'link'        => "tg://msg_url?url={$url}&text={$title}",
				'title'       => __( 'Share on Telegram', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-telegram",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-telegram",
				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'skype'  => array(
				'name'        => 'Skype',
				'element'     => 'skype',
				'link'        => "https://web.skype.com/share?url={$url}&text={$title}",
				'title'       => __( 'Share on Skype', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-skype",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-skype",
				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'viber'  => array(
				'name'        => 'Viber',
				'element'     => 'viber',
				'link'        => "viber://forward?text={$viber_text}{$url}",
				'title'       => __( 'Share on Viber', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-viber",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-viber",
				'popup'       => $action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'like'  => array(
				'name'        => 'Like',
				'element'     => 'like',
				'link'        => "http://victorfreitas.github.io/wpupper-share-buttons/?href={$url_like}",
				'title'       => __( 'Like on Facebook', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-like",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-like",
				'popup'       => $action,
				'inside'      => __( 'Like', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'share'  => array(
				'name'        => 'Modal Share',
				'element'     => 'share',
				'link'        => "#",
				'title'       => __( 'Open modal social networks', App::TEXTDOMAIN ),
				'class'       => "{$prefix}-share",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-share",
				'popup'       => 'data-action="open-modal-networks"',
				'inside'      => __( 'More', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
		);

		$elements = new ArrayIterator( $share_items );

		return apply_filters( App::SLUG . '-elements-share', $elements, $title, $url );
	}

	/**
	 * Transform elements array in objects and sortable
	 *
	 * @since 1.2
	 * @param Array $elements
	 * @return Object
	 */
	private static function _elements_transform( $elements )
	{
		$elements = static::_ksort( $elements );
		$elements = Utils::parse( $elements );

		return $elements;
	}

	/**
	 * Sortable elements share
	 *
	 * @since 1.2
	 * @param Array $elements
	 * @return Object
	 */
	private static function _ksort( $elements )
	{
		$order    = Utils::option( 'order', false );
		$defaluts = $elements;
		$sort     = array();


		if ( $order ) :
			$order = json_decode( $order );

			foreach ( $order as $key => $item )
				$sort[$item] = apply_filters( App::SLUG . "-{$item}-items", $elements[$item] );

			$elements = array_merge( $sort, $elements->getArrayCopy() );
		endif;

		return apply_filters( App::SLUG . '-elements-args', $elements );
	}

	/**
	 * Encode all items from data services
	 *
	 * @since 1.2
	 * @param Null
	 * @return Object
	 */
	private static function _get_elements()
	{
		$arguments = self::_get_arguments();
		$tracking  = Utils::option( 'tracking' );
		$tracking  = Utils::html_decode( $tracking );
		$elements  = self::_set_elements(
			rawurlencode( $arguments['title'] ),
			rawurlencode( $arguments['link'] ),
			rawurlencode( $tracking ),
			rawurlencode( $arguments['thumbnail'] ),
			rawurlencode( $arguments['body_mail'] ),
			Utils::option( 'twitter_username' )
		);

		return apply_filters( App::SLUG . 'elements-econded', $elements );
	}

	/**
	 * Get arguments for social url elements
	 *
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	private static function _get_arguments()
	{
		$title     = Utils::get_title();
		$body_mail = Utils::body_mail();
		$arguments = array(
			'title'     => $title,
			'link'      => Utils::get_permalink(),
			'thumbnail' => Utils::get_image(),
			'body_mail' => "\n\n{$title}\n\n{$body_mail}\n",
		);

		return apply_filters( App::SLUG . 'arguments', $arguments );
	}

	/**
	 * Generate short url by bitly
	 *
	 * @since 1.0
	 * @param string $url
	 * @param string $tracking
	 * @return String
	 */
	private static function _generate_short_url( $url, $tracking )
	{
		$bitly_token = Utils::option( 'bitly_token', false );

		if ( ! $bitly_token )
			return static::_url_clean( "{$url}{$tracking}" );

		return Utils::bitly_short_url_cache( $bitly_token, "{$url}{$tracking}" );
	}

	/**
	 * Return clean url and add implements filter
	 *
	 * @since 1.0
	 * @param string $url
	 * @return String
	 */
	private static function _url_clean( $url )
	{
		$name = App::SLUG . '-url-share';
		return apply_filters( $name, $url );
	}

	/**
	 * Implements [] to facilitate replace shorturl bitly
	 *
	 * @since 1.0
	 * @param string $url
	 * @return String
	 */
	private static function _url_facilitate_replace( $url )
	{
		$name = App::SLUG . '-url-share';
		return apply_filters( $name, "[{$url}]" );
	}

	/**
	 * Get all items from data services sortable
	 *
	 * @since 1.2
	 * @param Null
	 * @return Object
	 */
	public static function social_media_objects()
	{
		$elements          = self::_get_elements();
		$elements_sortable = static::_elements_transform( $elements );

		return apply_filters( App::SLUG . '-elements-share-sortable', $elements_sortable );
	}

	/**
	 * Get all items defaults
	 *
	 * @since 1.2
	 * @param Null
	 * @return array
	 */
	public static function get_all_elements()
	{
		return self::social_media_objects();
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
	public static function share_report_update_db_check()
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
	public static function load_text_domain()
	{
		$plugin_dir = basename( dirname( App::FILE ) );
		load_plugin_textdomain( App::TEXTDOMAIN, false, "{$plugin_dir}/languages/" );
	}
}
<?php
/**
 *
 * @package WPUpper Share Buttons
 * @subpackage Functions
 * @author  Victor Freitas
 * @since 3.1.4
 * @version 1.0.0
 */
if ( ! function_exists( 'add_action' ) )
	exit(0);

use WPUSB_App as App;
use WPUSB_Setting as Setting;
use WPUSB_Utils as Utils;

class WPUSB_Social_Elements
{
	public static $action;
	public static $url_like;
	public static $url;
	public static $item;
	public static $class_button;
	public static $caracter;
	public static $twitter_text;
	public static $twitter_via;
	public static $viber_text;
	public static $whatsapp_text;
	public static $thumbnail;
	public static $title;
	public static $tracking;
	public static $body_mail;

	/**
	 * Generate object all social icons
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param Null
	 * @return Object
	 */
	private static function _get_elements()
	{
		$prefix      = Setting::PREFIX;
		$share_items = array(
			'facebook'  => array(
				'name'        => 'Facebook',
				'element'     => 'facebook',
				'link'        => 'https://www.facebook.com/sharer/sharer.php?u=' . self::$url,
				'title'       => __( 'Share on Facebook', App::TEXTDOMAIN ),
				'class'       => $prefix . '-facebook',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-facebook',
 				'popup'       => self::$action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => true,
			),
			'twitter'   => array(
				'name'        => 'Twitter',
				'element'     => 'twitter',
				'link'        => 'https://twitter.com/share?url=' . self::$url . '&text=' . self::$twitter_text . self::$twitter_via,
				'title'       => __( 'Tweet', App::TEXTDOMAIN ),
				'class'       => $prefix . '-twitter',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-twitter',
				'popup'       => self::$action,
				'inside'      => __( 'Tweet', App::TEXTDOMAIN ),
				'has_counter' => true,
			),
			'google'    => array(
				'name'        => 'Google Plus',
				'element'     => 'google-plus',
				'link'        => 'https://plus.google.com/share?url=' . self::$url,
				'title'       => __( 'Share on Google+', App::TEXTDOMAIN ),
				'class'       => $prefix . '-google-plus',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-google-plus',
				'popup'       => self::$action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => true,
			),
			'whatsapp'  => array(
				'name'        => 'WhatsApp',
				'element'     => 'whatsapp',
				'link'        => 'whatsapp://send?text=' . self::$whatsapp_text . self::$url,
				'title'       => __( 'Share on WhatsApp', App::TEXTDOMAIN ),
				'class'       => $prefix . '-whatsapp',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-whatsapp',
				'popup'       => self::$action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'pinterest' => array(
				'name'        => 'Pinterest',
				'element'     => 'pinterest',
				'link'        => 'https://pinterest.com/pin/create/button/?url=' . self::$url . '&media=' . self::$thumbnail . '&description=' . self::$title,
				'title'       => __( 'Share on Pinterest', App::TEXTDOMAIN ),
				'class'       => $prefix . '-pinterest',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-pinterest',
				'popup'       => self::$action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => true,
			),
			'linkedin'  => array(
				'name'        => 'Linkedin',
				'element'     => 'linkedin',
				'link'        => 'https://www.linkedin.com/shareArticle?mini=true&url=' . self::$url . '&title=' . self::$title,
				'title'       => __( 'Share on Linkedin', App::TEXTDOMAIN ),
				'class'       => $prefix . '-linkedin',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-linkedin',
				'popup'       => self::$action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => true,
			),
			'tumblr'    => array(
				'name'        => 'Tumblr',
				'element'     => 'tumblr',
				'link'        => 'http://www.tumblr.com/share',
				'title'       => __( 'Share on Tumblr', App::TEXTDOMAIN ),
				'class'       => $prefix . '-tumblr',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-tumblr',
				'popup'       => self::$action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'email'     => array(
				'name'        => 'Email',
				'element'     => 'email',
				'link'        => 'mailto:?subject=' . self::$title . '&body=' . self::$url . "\n" . self::$body_mail,
				'title'       => __( 'Send by email', App::TEXTDOMAIN ),
				'class'       => $prefix . '-email',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-email',
				'popup'       => self::$action,
				'inside'      => 'Email',
				'has_counter' => false,
			),
			'gmail'     => array(
				'name'        => 'Gmail',
				'element'     => 'gmail',
				'link'        => 'https://mail.google.com/mail/u/0/?view=cm&fs=1&su=' . self::$title . '&body=' . self::$url . "\n" . self::$body_mail . '&tf=1',
				'title'       => __( 'Send by Gmail', App::TEXTDOMAIN ),
				'class'       => $prefix . '-gmail',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-gmail',
				'popup'       => self::$action,
				'inside'      => 'Gmail',
				'has_counter' => false,
			),
			'printer'   => array(
				'name'        => 'PrintFriendly',
				'element'     => 'printer',
				'link'        => 'http://www.printfriendly.com/print?url=' . self::$url,
				'title'       => __( 'Print via PrintFriendly', App::TEXTDOMAIN ),
				'class'       => $prefix . '-printer',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-printer',
				'popup'       => self::$action,
				'inside'      => __( 'Print', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'telegram'  => array(
				'name'        => 'Telegram',
				'element'     => 'telegram',
				'link'        => 'tg://msg_url?url=' . self::$url . '&text=' . self::$title,
				'title'       => __( 'Share on Telegram', App::TEXTDOMAIN ),
				'class'       => $prefix . '-telegram',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-telegram',
				'popup'       => self::$action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'skype'  => array(
				'name'        => 'Skype',
				'element'     => 'skype',
				'link'        => 'https://web.skype.com/share?url=' . self::$url . '&text=' . self::$title,
				'title'       => __( 'Share on Skype', App::TEXTDOMAIN ),
				'class'       => $prefix . '-skype',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-skype',
				'popup'       => self::$action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'viber'  => array(
				'name'        => 'Viber',
				'element'     => 'viber',
				'link'        => 'viber://forward?text=' . self::$viber_text . self::$url,
				'title'       => __( 'Share on Viber', App::TEXTDOMAIN ),
				'class'       => $prefix . '-viber',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-viber',
				'popup'       => self::$action,
				'inside'      => __( 'Share', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'like'  => array(
				'name'        => 'Like',
				'element'     => 'like',
				'link'        => 'http://victorfreitas.github.io/wpupper-share-buttons/?href=' . self::$url_like,
				'title'       => __( 'Like on Facebook', App::TEXTDOMAIN ),
				'class'       => $prefix . '-like',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-like',
				'popup'       => self::$action,
				'inside'      => __( 'Like', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
			'share'  => array(
				'name'        => 'Modal Share',
				'element'     => 'share',
				'link'        => "#",
				'title'       => __( 'Open modal social networks', App::TEXTDOMAIN ),
				'class'       => $prefix . '-share',
				'class_item'  => self::$item,
				'class_link'  => self::$class_button,
				'class_icon'  => $prefix . '-icon-share',
				'popup'       => 'data-action="open-modal-networks"',
				'inside'      => __( 'More', App::TEXTDOMAIN ),
				'has_counter' => false,
			),
		);

		$elements = new ArrayIterator( $share_items );

		return apply_filters( App::SLUG . '-elements-share', $elements, self::$title, self::$url );
	}

	/**
	 * Transform elements array in objects and sortable
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param Array $elements
	 * @return Object
	 */
	private static function _elements_sort( $elements )
	{
		$elements = static::_ksort( $elements );
		$elements = Utils::parse( $elements );

		return $elements;
	}

	/**
	 * Sortable elements share
	 *
	 * @since 3.1.4
	 * @version 1.0.0
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
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param Null
	 * @return Object
	 */
	public static function get_elements()
	{
		$arguments = self::_get_arguments();
		$tracking  = Utils::option( 'tracking' );
		$tracking  = Utils::html_decode( $tracking );

		static::_set_properts(
			rawurlencode( $arguments['title'] ),
			rawurlencode( $arguments['link'] ),
			rawurlencode( $tracking ),
			rawurlencode( $arguments['thumbnail'] ),
			rawurlencode( $arguments['body_mail'] )
		);
		$elements  = self::_get_elements();

		return apply_filters( App::SLUG . 'elements-econded', $elements );
	}

	/**
	 * Get arguments for social url elements
	 *
	 * @since 3.1.4
	 * @version 1.0.0
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
	 * @since 3.1.4
	 * @version 1.0.0
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
	 * @since 3.1.4
	 * @version 1.0.0
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
	 * @since 3.1.4
	 * @version 1.0.0
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
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param Null
	 * @return Object
	 */
	public static function social_media()
	{
		$elements          = self::get_elements();
		$elements_sortable = static::_elements_sort( $elements );

		return apply_filters( App::SLUG . '-elements-share-sortable', $elements_sortable );
	}

	/**
	 * Set properts for social elements
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param String $title
	 * @param String $url
	 * @param String $tracking
	 * @param String $thumbnail
	 * @param String $body_mail
	 * @return Void
	 */
	private static function _set_properts( $title, $url, $tracking, $thumbnail, $body_mail )
	{
		$post_id             = Utils::get_id();
		$prefix              = Setting::PREFIX;
		$title               = apply_filters( 'the_title', $title, Utils::get_id() );
		$tracking            = apply_filters( App::SLUG . '-tracking', $tracking, $post_id );
		self::$thumbnail     = apply_filters( App::SLUG . '-thumbnail', $thumbnail, $post_id );
		self::$body_mail     = apply_filters( App::SLUG . '-body-mail', $body_mail, $post_id );
		self::$title         = $title;
		self::$tracking      = $tracking;
		self::$action        = 'data-action="open-popup"';
		$caracter            = apply_filters( App::SLUG . '-caracter', html_entity_decode( '&#x261B;' ) );
		self::$caracter      = $caracter;
		self::$url_like      = rawurldecode( $url );
		self::$url           = ( is_admin() ) ? '' : static::_generate_short_url( $url, $tracking );
		self::$item          = $prefix . '-item';
		self::$class_button  = $prefix . '-button';
		self::$viber_text    = apply_filters( App::SLUG . '-viber-text', "{$title}%20{$caracter}%20", $title );
		self::$whatsapp_text = apply_filters( App::SLUG . '-whatsapp-text', "{$title}%20{$caracter}%20", $title );

		static::_set_properts_twitter();
	}

	/**
	 * Set properts for Twitter
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param Null
	 * @return Void
	 */
	private static function _set_properts_twitter()
	{
		$via                = Utils::option( 'twitter_username' );
		$text_a             = apply_filters( App::SLUG . '-twitter-after', __( 'I just saw', App::TEXTDOMAIN ) );
		$text_b             = apply_filters( App::SLUG . '-twitter-before', __( 'Click to see also', App::TEXTDOMAIN ) );
		$text               = Utils::get_twitter_text( self::$title, $text_a, $text_b, self::$caracter );
		$option_text        = Utils::option( 'twitter_text' );
		self::$twitter_text = ( ! empty( $option_text ) ) ? str_replace( '{title}', self::$title, $option_text ) : $text;
		self::$twitter_via  = ( ! empty( $via ) ) ? "&via={$via}" : '';
	}
}
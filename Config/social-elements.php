<?php
/**
 *
 * @package WPUpper Share Buttons
 * @subpackage Functions
 * @author  Victor Freitas
 * @since 3.7.0
 * @version 2.1.0
 */
if ( ! function_exists( 'add_action' ) ) {
	exit(0);
}

use WPUSB_App as App;
use WPUSB_Setting as Setting;
use WPUSB_Utils as Utils;

class WPUSB_Social_Elements {

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

	public static $items_available = array(
		'facebook'  => 'facebook',
		'twitter'   => 'twitter',
		'google'    => 'google',
		'whatsapp'  => 'whatsapp',
		'pinterest' => 'pinterest',
		'linkedin'  => 'linkedin',
		'tumblr'    => 'tumblr',
		'email'     => 'email',
		'gmail'     => 'gmail',
		'printer'   => 'printer',
		'telegram'  => 'telegram',
		'skype'     => 'skype',
		'viber'     => 'viber',
		'like'      => 'like',
		'share'     => 'share',
		'reddit'    => 'reddit',
		'flipboard' => 'flipboard',
	);

	/**
	 * Check social media available exists
	 *
	 * @since 3.7.0
	 * @version 1.0.0
	 * @param String $item
	 * @return Boolean
	 */
	public static function items_available( $item ) {
		$items = apply_filters( App::SLUG . '-items-available', self::$items_available );

		if ( isset( $items[ $item ] ) )
			return true;

		return false;
	}

	/**
	 * Generate object all social icons
	 *
	 * @since 3.1.4
	 * @version 1.1.0
	 * @param Null
	 * @return Object
	 */
	private static function _get_elements() {
		$prefix       = App::SLUG;
		$prefix_icons = apply_filters( "{$prefix}_prefix_class_icons", "{$prefix}-icon-" );
		$std          = new stdClass();

		/**
		 * @var Object
		 * @see Facebook
		 */
		$std->facebook              = new stdClass();
		$std->facebook->name        = 'Facebook';
		$std->facebook->element     = 'facebook';
		$std->facebook->link        = 'https://www.facebook.com/sharer/sharer.php?u=' . self::$url;
		$std->facebook->title       = __( 'Share on Facebook', App::TEXTDOMAIN );
		$std->facebook->class       = $prefix . '-facebook';
		$std->facebook->class_item  = self::$item;
		$std->facebook->class_link  = self::$class_button;
		$std->facebook->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'facebook' );
		$std->facebook->popup       = self::$action;
		$std->facebook->inside      = __( 'Share', App::TEXTDOMAIN );
		$std->facebook->has_counter = true;

		/**
		 * @var Object
		 * @see Twitter
		 */
		$std->twitter              = new stdClass();
		$std->twitter->name        = 'Twitter';
		$std->twitter->element     = 'twitter';
		$std->twitter->link        = 'https://twitter.com/share?url=' . self::$url . '&text=' . self::$twitter_text . self::$twitter_via;
		$std->twitter->title       = __( 'Tweet', App::TEXTDOMAIN );
		$std->twitter->class       = $prefix . '-twitter';
		$std->twitter->class_item  = self::$item;
		$std->twitter->class_link  = self::$class_button;
		$std->twitter->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'twitter' );
		$std->twitter->popup       = self::$action;
		$std->twitter->inside      = __( 'Tweet', App::TEXTDOMAIN );
		$std->twitter->has_counter = true;

		/**
		 * @var Object
		 * @see Google Plus
		 */
		$std->google              = new stdClass();
		$std->google->name        = 'Google Plus';
		$std->google->element     = 'google-plus';
		$std->google->link        = 'https://plus.google.com/share?url=' . self::$url;
		$std->google->title       = __( 'Share on Google+', App::TEXTDOMAIN );
		$std->google->class       = $prefix . '-google-plus';
		$std->google->class_item  = self::$item;
		$std->google->class_link  = self::$class_button;
		$std->google->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'google-plus' );
		$std->google->popup       = self::$action;
		$std->google->inside      = __( 'Share', App::TEXTDOMAIN );
		$std->google->has_counter = true;

		/**
		 * @var Object
		 * @see WhatsApp
		 */
		$std->whatsapp              = new stdClass();
		$std->whatsapp->name        = 'WhatsApp';
		$std->whatsapp->element     = 'whatsapp';
		$std->whatsapp->link        = 'whatsapp://send?text=' . self::$whatsapp_text . self::$url;
		$std->whatsapp->title       = __( 'Share on WhatsApp', App::TEXTDOMAIN );
		$std->whatsapp->class       = $prefix . '-whatsapp';
		$std->whatsapp->class_item  = self::$item;
		$std->whatsapp->class_link  = self::$class_button;
		$std->whatsapp->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'whatsapp' );
		$std->whatsapp->popup       = self::$action;
		$std->whatsapp->inside      = __( 'Share', App::TEXTDOMAIN );
		$std->whatsapp->has_counter = false;

		/**
		 * @var Object
		 * @see Pinterest
		 */
		$std->pinterest              = new stdClass();
		$std->pinterest->name        = 'Pinterest';
		$std->pinterest->element     = 'pinterest';
		$std->pinterest->link        = 'https://pinterest.com/pin/create/button/?url=' . self::$url . '&media=' . self::$thumbnail . '&description=' . self::$title;
		$std->pinterest->title       = __( 'Share on Pinterest', App::TEXTDOMAIN );
		$std->pinterest->class       = $prefix . '-pinterest';
		$std->pinterest->class_item  = self::$item;
		$std->pinterest->class_link  = self::$class_button;
		$std->pinterest->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'pinterest' );
		$std->pinterest->popup       = self::$action;
		$std->pinterest->inside      = __( 'Share', App::TEXTDOMAIN );
		$std->pinterest->has_counter = true;

		/**
		 * @var Object
		 * @see Linkedin
		 */
		$std->linkedin              = new stdClass();
		$std->linkedin->name        = 'Linkedin';
		$std->linkedin->element     = 'linkedin';
		$std->linkedin->link        = 'https://www.linkedin.com/shareArticle?mini=true&url=' . self::$url . '&title=' . self::$title;
		$std->linkedin->title       = __( 'Share on Linkedin', App::TEXTDOMAIN );
		$std->linkedin->class       = $prefix . '-linkedin';
		$std->linkedin->class_item  = self::$item;
		$std->linkedin->class_link  = self::$class_button;
		$std->linkedin->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'linkedin' );
		$std->linkedin->popup       = self::$action;
		$std->linkedin->inside      = __( 'Share', App::TEXTDOMAIN );
		$std->linkedin->has_counter = true;

		/**
		 * @var Object
		 * @see Tumblr
		 */
		$std->tumblr              = new stdClass();
		$std->tumblr->name        = 'Tumblr';
		$std->tumblr->element     = 'tumblr';
		$std->tumblr->link        = 'http://www.tumblr.com/share';
		$std->tumblr->title       = __( 'Share on Tumblr', App::TEXTDOMAIN );
		$std->tumblr->class       = $prefix . '-tumblr';
		$std->tumblr->class_item  = self::$item;
		$std->tumblr->class_link  = self::$class_button;
		$std->tumblr->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'tumblr' );
		$std->tumblr->popup       = self::$action;
		$std->tumblr->inside      = __( 'Share', App::TEXTDOMAIN );
		$std->tumblr->has_counter = false;

		/**
		 * @var Object
		 * @see Email
		 */
		$std->email              = new stdClass();
		$std->email->name        = 'Email';
		$std->email->element     = 'email';
		$std->email->link        = 'mailto:?subject=' . self::$title . '&body=' . self::$url . "\n" . self::$body_mail;
		$std->email->title       = __( 'Send by email', App::TEXTDOMAIN );
		$std->email->class       = $prefix . '-email';
		$std->email->class_item  = self::$item;
		$std->email->class_link  = self::$class_button;
		$std->email->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'email' );
		$std->email->popup       = self::$action;
		$std->email->inside      = 'Email';
		$std->email->has_counter = false;

		/**
		 * @var Object
		 * @see Gmail
		 */
		$std->gmail              = new stdClass();
		$std->gmail->name        = 'Gmail';
		$std->gmail->element     = 'gmail';
		$std->gmail->link        = 'https://mail.google.com/mail/u/0/?view=cm&fs=1&su=' . self::$title . '&body=' . self::$url . "\n" . self::$body_mail . '&tf=1';
		$std->gmail->title       = __( 'Send by Gmail', App::TEXTDOMAIN );
		$std->gmail->class       = $prefix . '-gmail';
		$std->gmail->class_item  = self::$item;
		$std->gmail->class_link  = self::$class_button;
		$std->gmail->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'gmail' );
		$std->gmail->popup       = self::$action;
		$std->gmail->inside      = 'Gmail';
		$std->gmail->has_counter = false;

		/**
		 * @var Object
		 * @see PrintFriendly
		 */
		$std->printer              = new stdClass();
		$std->printer->name        = 'PrintFriendly';
		$std->printer->element     = 'printer';
		$std->printer->link        = 'http://www.printfriendly.com/print?url=' . self::$url;
		$std->printer->title       = __( 'Print via PrintFriendly', App::TEXTDOMAIN );
		$std->printer->class       = $prefix . '-printer';
		$std->printer->class_item  = self::$item;
		$std->printer->class_link  = self::$class_button;
		$std->printer->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'printer' );
		$std->printer->popup       = self::$action;
		$std->printer->inside      =  __( 'Print', App::TEXTDOMAIN );
		$std->printer->has_counter = false;

		/**
		 * @var Object
		 * @see Telegram
		 */
		$std->telegram              = new stdClass();
		$std->telegram->name        = 'Telegram';
		$std->telegram->element     = 'telegram';
		$std->telegram->link        = 'tg://msg_url?url=' . self::$url . '&text=' . self::$title;
		$std->telegram->title       = __( 'Share on Telegram', App::TEXTDOMAIN );
		$std->telegram->class       = $prefix . '-telegram';
		$std->telegram->class_item  = self::$item;
		$std->telegram->class_link  = self::$class_button;
		$std->telegram->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'telegram' );
		$std->telegram->popup       = self::$action;
		$std->telegram->inside      = __( 'Share', App::TEXTDOMAIN );
		$std->telegram->has_counter = false;

		/**
		 * @var Object
		 * @see Skype
		 */
		$std->skype              = new stdClass();
		$std->skype->name        = 'Skype';
		$std->skype->element     = 'skype';
		$std->skype->link        = 'https://web.skype.com/share?url=' . self::$url . '&text=' . self::$title;
		$std->skype->title       = __( 'Share on Skype', App::TEXTDOMAIN );
		$std->skype->class       = $prefix . '-skype';
		$std->skype->class_item  = self::$item;
		$std->skype->class_link  = self::$class_button;
		$std->skype->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'skype' );
		$std->skype->popup       = self::$action;
		$std->skype->inside      = __( 'Share', App::TEXTDOMAIN );
		$std->skype->has_counter = false;

		/**
		 * @var Object
		 * @see Viber
		 */
		$std->viber              = new stdClass();
		$std->viber->name        = 'Viber';
		$std->viber->element     = 'viber';
		$std->viber->link        = 'viber://forward?text=' . self::$viber_text . self::$url;
		$std->viber->title       = __( 'Share on Viber', App::TEXTDOMAIN );
		$std->viber->class       = $prefix . '-viber';
		$std->viber->class_item  = self::$item;
		$std->viber->class_link  = self::$class_button;
		$std->viber->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'viber' );
		$std->viber->popup       = self::$action;
		$std->viber->inside      = __( 'Share', App::TEXTDOMAIN );
		$std->viber->has_counter = false;

		/**
		 * @var Object
		 * @see Like
		 */
		$std->like              = new stdClass();
		$std->like->name        = 'Like';
		$std->like->element     = 'like';
		$std->like->link        = 'http://victorfreitas.github.io/wpupper-share-buttons/?href=' . self::$url_like;
		$std->like->title       = __( 'Like on Facebook', App::TEXTDOMAIN );
		$std->like->class       = $prefix . '-like';
		$std->like->class_item  = self::$item;
		$std->like->class_link  = self::$class_button;
		$std->like->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'like' );
		$std->like->popup       = self::$action;
		$std->like->inside      = __( 'Like', App::TEXTDOMAIN );
		$std->like->has_counter = false;

		/**
		 * @var Object
		 * @see Modal Share
		 */
		$std->share              = new stdClass();
		$std->share->name        = 'Modal Share';
		$std->share->element     = 'share';
		$std->share->link        = 'javascript:void(0);';
		$std->share->title       = __( 'Open modal social networks', App::TEXTDOMAIN );
		$std->share->class       = $prefix . '-share';
		$std->share->class_item  = self::$item;
		$std->share->class_link  = self::$class_button;
		$std->share->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'share' );
		$std->share->popup       = 'data-action="open-modal-networks"';
		$std->share->inside      = __( 'More', App::TEXTDOMAIN );
		$std->share->has_counter = false;

		/**
		 * @var Object
		 * @see Reddit
		 */
		$std->reddit              = new stdClass();
		$std->reddit->name        = 'Reddit';
		$std->reddit->element     = 'reddit';
		$std->reddit->link        = 'https://www.reddit.com/submit?url=' . self::$url . '&title=' . self::$title;
		$std->reddit->title       = __( 'Share on Reddit', App::TEXTDOMAIN );
		$std->reddit->class       = $prefix . '-reddit';
		$std->reddit->class_item  = self::$item;
		$std->reddit->class_link  = self::$class_button;
		$std->reddit->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'reddit' );
		$std->reddit->popup       = self::$action;
		$std->reddit->inside      = __( 'Share', App::TEXTDOMAIN );
		$std->reddit->has_counter = false;

		/**
		 * @var Object
		 * @see Flipboard
		 */
		$std->flipboard              = new stdClass();
		$std->flipboard->name        = 'Flipboard';
		$std->flipboard->element     = 'flipboard';
		$std->flipboard->link        = 'https://share.flipboard.com/bookmarklet/popout?v=2&ext=' . rawurlencode( App::NAME ) . '&title=' . self::$title . '&url=' . self::$url;
		$std->flipboard->title       = __( 'Share on Flipboard', App::TEXTDOMAIN );
		$std->flipboard->class       = $prefix . '-flipboard';
		$std->flipboard->class_item  = self::$item;
		$std->flipboard->class_link  = self::$class_button;
		$std->flipboard->class_icon  = apply_filters( "{$prefix}_class_icon", $prefix_icons . 'flipboard' );
		$std->flipboard->popup       = self::$action;
		$std->flipboard->inside      = __( 'Share', App::TEXTDOMAIN );
		$std->flipboard->has_counter = false;

		return apply_filters( App::SLUG . '-elements-share', $std, self::$title, self::$url );
	}

	/**
	 * Sortable elements share
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param Array $elements
	 * @return Object
	 */
	private static function _ksort( $elements ) {
		$order  = Utils::option( 'order', false );
		$social = $elements;

		if ( $order ) {
			$social = new stdClass();
			$order  = json_decode( $order );

			foreach ( $order as $items ) {
				$social->{$items} = apply_filters( App::SLUG . "-{$items}-items", $elements->{$items} );
			}

			if ( is_admin() && count( (array) $elements ) > count( (array) $order ) ) {
				$social = (object) array_merge( (array) $social, (array) $elements );
			}
		}

		return apply_filters( App::SLUG . '-elements-args', $social );
	}

	/**
	 * Encode all items from data services
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param Null
	 * @return Object
	 */
	public static function get_elements() {
		$arguments = self::_get_arguments();
		$tracking  = Utils::get_tracking();

		self::_set_properts(
			$arguments['title'],
			$arguments['link'],
			$tracking,
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
	private static function _get_arguments() {
		$title     = Utils::get_title();
		$body_mail = Utils::body_mail();
		$arguments = array(
			'title'     => '_title_',
			'link'      => '_permalink_',
			'thumbnail' => Utils::get_image(),
			'body_mail' => "\n\n{$title}\n\n{$body_mail}\n",
		);

		return apply_filters( App::SLUG . '-arguments', $arguments );
	}

	/**
	 * Implements [] to facilitate replace shorturl bitly
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param string $url
	 * @return String
	 */
	private static function _url_facilitate_replace( $url ) {
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
	public static function social_media() {
		$elements          = self::get_elements();
		$elements_sortable = self::_ksort( $elements );

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
	private static function _set_properts( $title, $url, $tracking, $thumbnail, $body_mail ) {
		$post_id             = Utils::get_id();
		$prefix              = App::SLUG;
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
		self::$url           = $url;
		self::$item          = $prefix . '-item';
		self::$class_button  = $prefix . '-button';
		self::$viber_text    = apply_filters( App::SLUG . '-viber-text', "{$title}%20{$caracter}%20", $title );
		self::$whatsapp_text = apply_filters( App::SLUG . '-whatsapp-text', "{$title}%20{$caracter}%20", $title );

		self::_set_properts_twitter();
	}

	/**
	 * Set properts for Twitter
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param Null
	 * @return Void
	 */
	private static function _set_properts_twitter() {
		$tvia               = Utils::option( 'twitter_username' );
		$via                = preg_replace( '/[^a-zA-Z0-9_]+/', '', $tvia );
		$text_a             = apply_filters( App::SLUG . '-twitter-after', __( 'I just saw', App::TEXTDOMAIN ) );
		$text_b             = apply_filters( App::SLUG . '-twitter-before', __( 'Click to see also', App::TEXTDOMAIN ) );
		$text               = Utils::get_twitter_text( self::$title, $text_a, $text_b, self::$caracter );
		$option_text        = Utils::option( 'twitter_text' );
		self::$twitter_text = ( ! empty( $option_text ) ) ? str_replace( '{title}', self::$title, $option_text ) : $text;
		self::$twitter_via  = ( ! empty( $via ) ) ? "&via={$via}" : '';
	}
}
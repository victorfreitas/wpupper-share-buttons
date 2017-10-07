<?php
/**
 *
 * @package WPUpper Share Buttons
 * @subpackage Functions
 * @author  Victor Freitas
 * @since 3.7.0
 * @version 2.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
}

class WPUSB_Social_Elements {

	public static $action;

	public static $url_like;

	public static $url;

	public static $item;

	public static $class_button;

	public static $caracter;

	public static $twitter_text;

	public static $twitter_via;

	public static $twitter_hashtags;

	public static $viber_text;

	public static $whatsapp_text;

	public static $thumbnail;

	public static $title;

	public static $tracking;

	public static $body_mail;

	public static $social_networks = null;

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
		'reddit'    => 'reddit',
		'messenger' => 'messenger',
		'buffer'    => 'buffer',
		'vk'        => 'vk',
		'flipboard' => 'flipboard',
		'share'     => 'share',
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
		$items = apply_filters( WPUSB_Utils::add_prefix( '-items-available' ), self::$items_available );

		return isset( $items[ $item ] );
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
		$plugin_name  = rawurlencode( WPUSB_App::NAME );
		$prefix_icons = apply_filters( WPUSB_Utils::add_prefix( '_prefix_class_icons' ), WPUSB_Utils::add_prefix( '-icon-' ) );
		$tag_icon     = WPUSB_Utils::add_prefix( '_class_icon' );
		$std          = new stdClass();

		/**
		 * @var Object
		 * @see Facebook
		 */
		$std->facebook              = new stdClass();
		$std->facebook->name        = __( 'Facebook', 'wpupper-share-buttons' );
		$std->facebook->element     = 'facebook';
		$std->facebook->link        = 'https://www.facebook.com/sharer.php?u=' . self::$url;
		$std->facebook->title       = __( 'Share on Facebook', 'wpupper-share-buttons' );
		$std->facebook->class       = WPUSB_Utils::add_prefix( '-facebook' );
		$std->facebook->class_item  = self::$item;
		$std->facebook->class_link  = self::$class_button;
		$std->facebook->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'facebook' );
		$std->facebook->popup       = self::$action;
		$std->facebook->inside      = __( 'Share', 'wpupper-share-buttons' );
		$std->facebook->has_counter = true;
		$std->facebook->target      = '_blank';

		/**
		 * @var Object
		 * @see Twitter
		 */
		$std->twitter              = new stdClass();
		$std->twitter->name        = __( 'Twitter', 'wpupper-share-buttons' );
		$std->twitter->element     = 'twitter';
		$std->twitter->link        = 'https://twitter.com/share?url=' . self::$url . '&text=' . self::$twitter_text . self::$twitter_via . self::$twitter_hashtags;
		$std->twitter->title       = __( 'Tweet', 'wpupper-share-buttons' );
		$std->twitter->class       = WPUSB_Utils::add_prefix( '-twitter' );
		$std->twitter->class_item  = self::$item;
		$std->twitter->class_link  = self::$class_button;
		$std->twitter->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'twitter' );
		$std->twitter->popup       = self::$action;
		$std->twitter->inside      = __( 'Tweet', 'wpupper-share-buttons' );
		$std->twitter->has_counter = true;
		$std->twitter->target      = '_blank';

		/**
		 * @var Object
		 * @see Google Plus
		 */
		$std->google              = new stdClass();
		$std->google->name        = __( 'Google Plus', 'wpupper-share-buttons' );
		$std->google->element     = 'google-plus';
		$std->google->link        = 'https://plus.google.com/share?url=' . self::$url;
		$std->google->title       = __( 'Share on Google+', 'wpupper-share-buttons' );
		$std->google->class       = WPUSB_Utils::add_prefix( '-google-plus' );
		$std->google->class_item  = self::$item;
		$std->google->class_link  = self::$class_button;
		$std->google->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'google-plus' );
		$std->google->popup       = self::$action;
		$std->google->inside      = __( 'Share', 'wpupper-share-buttons' );
		$std->google->has_counter = true;
		$std->google->target      = '_blank';

		/**
		 * @var Object
		 * @see WhatsApp
		 */
		$std->whatsapp              = new stdClass();
		$std->whatsapp->name        = __( 'WhatsApp', 'wpupper-share-buttons' );
		$std->whatsapp->element     = 'whatsapp';
		$std->whatsapp->link        = 'whatsapp://send?text=' . self::$whatsapp_text . self::$url;
		$std->whatsapp->title       = __( 'Share on WhatsApp', 'wpupper-share-buttons' );
		$std->whatsapp->class       = WPUSB_Utils::add_prefix( '-whatsapp' );
		$std->whatsapp->class_item  = self::$item;
		$std->whatsapp->class_link  = self::$class_button;
		$std->whatsapp->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'whatsapp' );
		$std->whatsapp->popup       = 'data-whatsapp-wpusb="https://web.whatsapp.com/"';
		$std->whatsapp->inside      = __( 'Share', 'wpupper-share-buttons' );
		$std->whatsapp->has_counter = false;
		$std->whatsapp->target      = '_blank';

		/**
		 * @var Object
		 * @see Pinterest
		 */
		$std->pinterest              = new stdClass();
		$std->pinterest->name        = __( 'Pinterest', 'wpupper-share-buttons' );
		$std->pinterest->element     = 'pinterest';
		$std->pinterest->link        = 'https://pinterest.com/pin/create/bookmarklet/?' . self::_get_pinterest_param();
		$std->pinterest->title       = __( 'Share on Pinterest', 'wpupper-share-buttons' );
		$std->pinterest->class       = WPUSB_Utils::add_prefix( '-pinterest' );
		$std->pinterest->class_item  = self::$item;
		$std->pinterest->class_link  = self::$class_button;
		$std->pinterest->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'pinterest' );
		$std->pinterest->popup       = self::$action;
		$std->pinterest->inside      = __( 'Share', 'wpupper-share-buttons' );
		$std->pinterest->has_counter = true;
		$std->pinterest->target      = '_blank';

		/**
		 * @var Object
		 * @see Linkedin
		 */
		$std->linkedin              = new stdClass();
		$std->linkedin->name        = __( 'Linkedin', 'wpupper-share-buttons' );
		$std->linkedin->element     = 'linkedin';
		$std->linkedin->link        = 'https://www.linkedin.com/shareArticle?mini=true&url=' . self::$url . '&title=' . self::$title;
		$std->linkedin->title       = __( 'Share on Linkedin', 'wpupper-share-buttons' );
		$std->linkedin->class       = WPUSB_Utils::add_prefix( '-linkedin' );
		$std->linkedin->class_item  = self::$item;
		$std->linkedin->class_link  = self::$class_button;
		$std->linkedin->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'linkedin' );
		$std->linkedin->popup       = self::$action;
		$std->linkedin->inside      = __( 'Share', 'wpupper-share-buttons' );
		$std->linkedin->has_counter = true;
		$std->linkedin->target      = '_blank';

		/**
		 * @var Object
		 * @see Tumblr
		 */
		$std->tumblr              = new stdClass();
		$std->tumblr->name        = __( 'Tumblr', 'wpupper-share-buttons' );
		$std->tumblr->element     = 'tumblr';
		$std->tumblr->link        = 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . self::$url . '&title=' . self::$title;
		$std->tumblr->title       = __( 'Share on Tumblr', 'wpupper-share-buttons' );
		$std->tumblr->class       = WPUSB_Utils::add_prefix( '-tumblr' );
		$std->tumblr->class_item  = self::$item;
		$std->tumblr->class_link  = self::$class_button;
		$std->tumblr->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'tumblr' );
		$std->tumblr->popup       = self::$action;
		$std->tumblr->inside      = __( 'Share', 'wpupper-share-buttons' );
		$std->tumblr->has_counter = true;
		$std->tumblr->target      = '_blank';

		/**
		 * @var Object
		 * @see Email
		 */
		$std->email              = new stdClass();
		$std->email->name        = __( 'Email', 'wpupper-share-buttons' );
		$std->email->element     = 'email';
		$std->email->link        = 'mailto:?subject=' . self::$title . '&body=' . self::$url . "\n" . self::$body_mail;
		$std->email->title       = __( 'Send by email', 'wpupper-share-buttons' );
		$std->email->class       = WPUSB_Utils::add_prefix( '-email' );
		$std->email->class_item  = self::$item;
		$std->email->class_link  = self::$class_button;
		$std->email->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'email' );
		$std->email->popup       = '';
		$std->email->inside      = 'Email';
		$std->email->has_counter = false;
		$std->email->target      = '_self';

		/**
		 * @var Object
		 * @see Gmail
		 */
		$std->gmail              = new stdClass();
		$std->gmail->name        = __( 'Gmail', 'wpupper-share-buttons' );
		$std->gmail->element     = 'gmail';
		$std->gmail->link        = 'https://mail.google.com/mail/u/0/?view=cm&fs=1&su=' . self::$title . '&body=' . self::$url . "\n" . self::$body_mail . '&tf=1';
		$std->gmail->title       = __( 'Send by Gmail', 'wpupper-share-buttons' );
		$std->gmail->class       = WPUSB_Utils::add_prefix( '-gmail' );
		$std->gmail->class_item  = self::$item;
		$std->gmail->class_link  = self::$class_button;
		$std->gmail->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'gmail' );
		$std->gmail->popup       = self::$action;
		$std->gmail->inside      = 'Gmail';
		$std->gmail->has_counter = false;
		$std->gmail->target      = '_blank';

		/**
		 * @var Object
		 * @see PrintFriendly
		 */
		$std->printer              = new stdClass();
		$std->printer->name        = __( 'PrintFriendly', 'wpupper-share-buttons' );
		$std->printer->element     = 'printer';
		$std->printer->link        = 'https://www.printfriendly.com/print?url=' . self::$url;
		$std->printer->title       = __( 'Print via PrintFriendly', 'wpupper-share-buttons' );
		$std->printer->class       = WPUSB_Utils::add_prefix( '-printer' );
		$std->printer->class_item  = self::$item;
		$std->printer->class_link  = self::$class_button;
		$std->printer->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'printer' );
		$std->printer->popup       = self::$action;
		$std->printer->inside      = __( 'Print', 'wpupper-share-buttons' );
		$std->printer->has_counter = false;
		$std->printer->target      = '_blank';

		/**
		 * @var Object
		 * @see Telegram
		 */
		$std->telegram              = new stdClass();
		$std->telegram->name        = __( 'Telegram', 'wpupper-share-buttons' );
		$std->telegram->element     = 'telegram';
		$std->telegram->link        = 'https://telegram.me/share/url?url=' . self::$url . '&text=' . self::$title;
		$std->telegram->title       = __( 'Share on Telegram', 'wpupper-share-buttons' );
		$std->telegram->class       = WPUSB_Utils::add_prefix( '-telegram' );
		$std->telegram->class_item  = self::$item;
		$std->telegram->class_link  = self::$class_button;
		$std->telegram->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'telegram' );
		$std->telegram->popup       = self::$action;
		$std->telegram->inside      = __( 'Share', 'wpupper-share-buttons' );
		$std->telegram->has_counter = false;
		$std->telegram->target      = '_blank';

		/**
		 * @var Object
		 * @see Skype
		 */
		$std->skype              = new stdClass();
		$std->skype->name        = __( 'Skype', 'wpupper-share-buttons' );
		$std->skype->element     = 'skype';
		$std->skype->link        = 'https://web.skype.com/share?url=' . self::$url . '&text=' . self::$title;
		$std->skype->title       = __( 'Share on Skype', 'wpupper-share-buttons' );
		$std->skype->class       = WPUSB_Utils::add_prefix( '-skype' );
		$std->skype->class_item  = self::$item;
		$std->skype->class_link  = self::$class_button;
		$std->skype->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'skype' );
		$std->skype->popup       = self::$action;
		$std->skype->inside      = __( 'Share', 'wpupper-share-buttons' );
		$std->skype->has_counter = false;
		$std->skype->target      = '_blank';

		/**
		 * @var Object
		 * @see Viber
		 */
		$std->viber              = new stdClass();
		$std->viber->name        = __( 'Viber', 'wpupper-share-buttons' );
		$std->viber->element     = 'viber';
		$std->viber->link        = 'viber://forward?text=' . self::$viber_text . self::$url;
		$std->viber->title       = __( 'Share on Viber', 'wpupper-share-buttons' );
		$std->viber->class       = WPUSB_Utils::add_prefix( '-viber' );
		$std->viber->class_item  = self::$item;
		$std->viber->class_link  = self::$class_button;
		$std->viber->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'viber' );
		$std->viber->popup       = self::$action;
		$std->viber->inside      = __( 'Share', 'wpupper-share-buttons' );
		$std->viber->has_counter = false;
		$std->viber->target      = '_blank';

		/**
		 * @var Object
		 * @see Like
		 */
		$std->like              = new stdClass();
		$std->like->name        = __( 'Like', 'wpupper-share-buttons' );
		$std->like->element     = 'like';
		$std->like->link        = 'https://victorfreitas.github.io/wpupper-share-buttons/?href=' . self::$url_like;
		$std->like->title       = __( 'Like on Facebook', 'wpupper-share-buttons' );
		$std->like->class       = WPUSB_Utils::add_prefix( '-like' );
		$std->like->class_item  = self::$item;
		$std->like->class_link  = self::$class_button;
		$std->like->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'like' );
		$std->like->popup       = self::$action;
		$std->like->inside      = __( 'Like', 'wpupper-share-buttons' );
		$std->like->has_counter = false;
		$std->like->target      = '_blank';

		/**
		 * @var Object
		 * @see Reddit
		 */
		$std->reddit              = new stdClass();
		$std->reddit->name        = __( 'Reddit', 'wpupper-share-buttons' );
		$std->reddit->element     = 'reddit';
		$std->reddit->link        = 'https://www.reddit.com/submit?url=' . self::$url . '&title=' . self::$title;
		$std->reddit->title       = __( 'Share on Reddit', 'wpupper-share-buttons' );
		$std->reddit->class       = WPUSB_Utils::add_prefix( '-reddit' );
		$std->reddit->class_item  = self::$item;
		$std->reddit->class_link  = self::$class_button;
		$std->reddit->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'reddit' );
		$std->reddit->popup       = self::$action;
		$std->reddit->inside      = __( 'Share', 'wpupper-share-buttons' );
		$std->reddit->has_counter = false;
		$std->reddit->target      = '_blank';

		/**
		 * @var Object
		 * @see Facebook messenger
		 */
		$std->messenger              = new stdClass();
		$std->messenger->name        = __( 'Messenger', 'wpupper-share-buttons' );
		$std->messenger->element     = 'messenger';
		$std->messenger->link        = 'https://www.facebook.com/dialog/send?app_id=140586622674265&link=' . self::$url . '&redirect_uri=' . self::$url;
		$std->messenger->title       = __( 'Send on Facebook Messenger', 'wpupper-share-buttons' );
		$std->messenger->class       = WPUSB_Utils::add_prefix( '-messenger' );
		$std->messenger->class_item  = self::$item;
		$std->messenger->class_link  = self::$class_button;
		$std->messenger->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'messenger' );
		$std->messenger->popup       = 'data-messenger-wpusb="fb-messenger://share?link=' . self::$url . '"';
		$std->messenger->inside      = __( 'Messenger', 'wpupper-share-buttons' );
		$std->messenger->has_counter = false;
		$std->messenger->target      = '_blank';

		/**
		 * @var Object
		 * @see Buffer
		 */
		$std->buffer              = new stdClass();
		$std->buffer->name        = __( 'Buffer', 'wpupper-share-buttons' );
		$std->buffer->element     = 'buffer';
		$std->buffer->link        = 'https://bufferapp.com/add?' . self::_get_buffer_param();
		$std->buffer->title       = __( 'Share on Buffer', 'wpupper-share-buttons' );
		$std->buffer->class       = WPUSB_Utils::add_prefix( '-buffer' );
		$std->buffer->class_item  = self::$item;
		$std->buffer->class_link  = self::$class_button;
		$std->buffer->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'buffer' );
		$std->buffer->popup       = self::$action;
		$std->buffer->inside      = __( 'Share', 'wpupper-share-buttons' );
		$std->buffer->has_counter = true;
		$std->buffer->target      = '_blank';

		/**
		 * @var Object
		 * @see VK
		 */
		$std->vk              = new stdClass();
		$std->vk->name        = __( 'VK', 'wpupper-share-buttons' );
		$std->vk->element     = 'vk';
		$std->vk->link        = 'https://vk.com/share.php?url=' . self::$url . '&title=' . self::$title;
		$std->vk->title       = __( 'Share on VK', 'wpupper-share-buttons' );
		$std->vk->class       = WPUSB_Utils::add_prefix( '-vk' );
		$std->vk->class_item  = self::$item;
		$std->vk->class_link  = self::$class_button;
		$std->vk->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'vk' );
		$std->vk->popup       = self::$action;
		$std->vk->inside      = __( 'Share', 'wpupper-share-buttons' );
		$std->vk->has_counter = false;
		$std->vk->target      = '_blank';

		/**
		 * @var Object
		 * @see Flipboard
		 */
		$std->flipboard              = new stdClass();
		$std->flipboard->name        = __( 'Flipboard', 'wpupper-share-buttons' );
		$std->flipboard->element     = 'flipboard';
		$std->flipboard->link        = 'https://share.flipboard.com/bookmarklet/popout?v=2&ext=' . $plugin_name . '&title=' . self::$title . '&url=' . self::$url;
		$std->flipboard->title       = __( 'Share on Flipboard', 'wpupper-share-buttons' );
		$std->flipboard->class       = WPUSB_Utils::add_prefix( '-flipboard' );
		$std->flipboard->class_item  = self::$item;
		$std->flipboard->class_link  = self::$class_button;
		$std->flipboard->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'flipboard' );
		$std->flipboard->popup       = self::$action;
		$std->flipboard->inside      = __( 'Share', 'wpupper-share-buttons' );
		$std->flipboard->has_counter = false;
		$std->flipboard->target      = '_blank';

		/**
		 * @var Object
		 * @see Modal Share
		 */
		$std->share              = new stdClass();
		$std->share->name        = __( 'Modal Share', 'wpupper-share-buttons' );
		$std->share->element     = 'share';
		$std->share->link        = 'javascript:void(0);';
		$std->share->title       = __( 'Open modal social networks', 'wpupper-share-buttons' );
		$std->share->class       = WPUSB_Utils::add_prefix( '-share' );
		$std->share->class_item  = self::$item;
		$std->share->class_link  = self::$class_button;
		$std->share->class_icon  = apply_filters( $tag_icon, $prefix_icons . 'share' );
		$std->share->popup       = 'data-action="open-modal-networks"';
		$std->share->inside      = false;
		$std->share->has_counter = false;
		$std->share->target      = '_self';

		$args = array(
			'title'        => self::$title,
			'url'          => self::$url,
			'prefix'       => WPUSB_App::SLUG,
			'item'         => self::$item,
			'class_button' => self::$class_button,
			'attr_action'  => self::$action,
			'prefix_icons' => $prefix_icons,
		);

		return apply_filters( WPUSB_Utils::add_prefix( '-elements-share' ), $std, self::$title, self::$url, $args );
	}

	/**
	 * Sortable elements share
	 *
	 * @since 3.1.4
	 * @since 3.27
	 * @version 1.2
	 * @param Array $elements
	 * @return Object
	 */
	private static function _ksort( $elements ) {
		$tag = WPUSB_Utils::add_prefix( '-elements-args' );

		if ( ! is_null( self::$social_networks ) ) {
			return apply_filters( $tag, self::$social_networks );
		}

		$elements_order = WPUSB_Utils::get_networks_order( true );

		if ( ! $elements_order ) {
			return apply_filters( $tag, $elements );
		}

		$networks = new stdClass();

		foreach ( $elements_order as $element => $title ) :
			if ( ! isset( $elements->{$element} ) ) {
				continue;
			}

			$networks->{$element} = $elements->{$element};
		endforeach;

		self::$social_networks = $networks;

		return apply_filters( $tag, $networks );
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
		$tracking  = WPUSB_Utils::get_tracking();

		self::_set_properts(
			$arguments['title'],
			$arguments['link'],
			$tracking,
			rawurlencode( $arguments['thumbnail'] ),
			rawurlencode( $arguments['body_mail'] )
		);
		$elements  = self::_get_elements();

		return apply_filters( WPUSB_App::SLUG . 'elements-econded', $elements );
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
		$body_mail = WPUSB_Utils::body_mail();
		$arguments = array(
			'title'     => '_title_',
			'link'      => '_permalink_',
			'thumbnail' => WPUSB_Utils::get_image(),
			'body_mail' => "\n\n_title_\n\n{$body_mail}\n",
		);

		return apply_filters( WPUSB_App::SLUG . '-arguments', $arguments );
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
		$name = WPUSB_App::SLUG . '-url-share';
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

		return apply_filters( WPUSB_App::SLUG . '-elements-share-sortable', $elements_sortable );
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
		$post_id             = WPUSB_Utils::get_id();
		$title               = WPUSB_Utils::rm_tags( apply_filters( 'the_title', $title, WPUSB_Utils::get_id() ) );
		self::$title         = $title;
		$tracking            = apply_filters( WPUSB_Utils::add_prefix( '-tracking' ), $tracking, $post_id );
		self::$thumbnail     = apply_filters( WPUSB_Utils::add_prefix( '-thumbnail' ), $thumbnail, $post_id );
		self::$body_mail     = apply_filters( WPUSB_Utils::add_prefix( '-body-mail' ), $body_mail, $post_id );
		self::$tracking      = $tracking;
		self::$action        = 'data-action="open-popup"';
		$caracter            = apply_filters( WPUSB_Utils::add_prefix( '-caracter' ), html_entity_decode( '&#x261B;' ) );
		self::$caracter      = $caracter;
		self::$url_like      = rawurldecode( $url );
		self::$url           = $url;
		self::$item          = WPUSB_Utils::add_prefix( '-item' );
		self::$class_button  = WPUSB_Utils::add_prefix( '-button' );
		self::$viber_text    = apply_filters( WPUSB_Utils::add_prefix( '-viber-text' ), "{$title}%20{$caracter}%20", $title );
		self::$whatsapp_text = apply_filters( WPUSB_Utils::add_prefix( '-whatsapp-text' ), "{$title}%20{$caracter}%20", $title );

		self::_set_properts_twitter();
	}

	/**
	 * Set properts for Twitter
	 *
	 * @since 3.1.4
	 * @version 2.0
	 * @param Null
	 * @return Void
	 */
	private static function _set_properts_twitter() {
		self::_set_twitter_extra_params();

		$text = WPUSB_Utils::option( 'twitter_text', false );

		if ( ! empty( $text ) ) :
			if ( WPUSB_Utils::indexof( $text, '{' ) ) :
				$search             = array( '{title}', '{', '}' );
				$replace            = array( self::$title, '', '' );
				self::$twitter_text = str_replace( $search, $replace, $text );
				return;
			endif;

			self::$twitter_text = $text;
			return;
		endif;

		$before_text = apply_filters(
			WPUSB_Utils::add_prefix( '-twitter-before' ),
			__( 'Click to see also', 'wpupper-share-buttons' )
		);
		$after_text  = apply_filters(
			WPUSB_Utils::add_prefix( '-twitter-after' ),
			__( 'I just saw', 'wpupper-share-buttons' )
		);

		self::$twitter_text = WPUSB_Utils::get_twitter_text(
			self::$title,
			$after_text,
			$before_text,
			self::$caracter
		);
	}

	/**
	 * Set properts for twitter extra params
	 *
	 * @since 3.17
	 * @version 1.0
	 * @param Null
	 * @return Void
	 */
	public static function _set_twitter_extra_params() {
		$via      = WPUSB_Utils::option( 'twitter_username' );
		$hashtags = WPUSB_Utils::option( 'twitter_hashtags' );
		$hashtags = apply_filters( WPUSB_Utils::add_prefix( '-twitter-hashtags' ), WPUSB_Utils::rm_tags( $hashtags ) );
		$via      = WPUSB_Utils::sanitize_twitter_params( $via );

		self::$twitter_via      = ( ! empty( $via ) ) ? "&via={$via}" : '';
		self::$twitter_hashtags = ( ! empty( $hashtags ) ) ? "&hashtags={$hashtags}" : '';
	}

	/**
	 * Buffer Parameters
	 *
	 * @since 3.28
	 * @param Null
	 * @return String
	 */
	private static function _get_buffer_param() {
		$via     = WPUSB_Utils::option( 'twitter_username' );
		$mention = WPUSB_Utils::sanitize_twitter_params( $via );

		$args = array(
			'url'  => self::$url,
			'text' => self::$title,
		);

		if ( ! empty( self::$thumbnail ) ) {
			$args['picture'] = rawurldecode( self::$thumbnail );
		}

		if ( ! empty( $mention ) ) {
			$args['via'] = $mention;
		}

		return http_build_query( $args );
	}

	/**
	 * Pinterest Parameters
	 *
	 * @since 3.31
	 * @param Null
	 * @return String
	 */
	private static function _get_pinterest_param() {
		$alt = '';

		if ( 'yes' === WPUSB_Utils::option( 'pin_image_alt' ) ) {
			$alt = WPUSB_Utils::get_image_alt();
		}

		$title       = ( $alt ) ? $alt : self::$title;
		$description = apply_filters( WPUSB_Utils::add_prefix( '_pinterest_description' ), $title );

		return sprintf(
			'url=%s&media=%s&description=%s',
			self::$url,
			self::$thumbnail,
			rawurlencode( $description )
		);
	}
}

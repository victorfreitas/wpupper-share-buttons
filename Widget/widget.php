<?php
/**
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Widgets
 * @since 3.27
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit;
}

WPUSB_App::uses( 'widgets', 'View' );

class WPUpper_SB_Widget extends WP_Widget {

	protected $instance;

	public $follow_us_networks = array();

	public $widget_type = '';

	public function __construct( $id_base, $description, $name = '' ) {
		$this->set_networks_available();

		$options = apply_filters(
			WPUSB_App::SLUG . '_widget_options',
			array(
				'classname'                   => $id_base,
				'description'                 => $description,
				'customize_selective_refresh' => true,
			),
			$id_base
		);

		parent::__construct(
			$id_base,
			WPUSB_App::NAME . $name,
			$options
		);

		add_action( "update_option_{$this->option_name}", array( $this, 'rebuild_css' ), 10, 3 );
	}

	public function update( $new_instance, $old_instance ) {
		$instance               = $this->sanitize( $new_instance );
		$instance['icons_size'] = ( $new_instance['icons_size'] ) ? absint( $new_instance['icons_size'] ) : '';

		if ( isset( $new_instance['url'] ) ) {
			$instance['url'] = ( $new_instance['url'] ) ? esc_url( $new_instance['url'] ) : '';
		}

		if ( isset( $new_instance['custom_class'] ) ) {
			$instance['custom_class'] = WPUSB_Utils::esc_class( $new_instance['custom_class'] );
		}

		return $instance;
	}

	public function is_checked( $key ) {
		$items   = $this->get_property( 'items' );
		$current = WPUSB_Utils::isset_get( $items, $key );

		return checked( $key, $current, false );
	}

	public function get_property( $property, $default = '', $sanitize = false ) {
		$value = WPUSB_Utils::isset_get( $this->instance, $property, $default );

		if ( $sanitize && is_callable( $sanitize ) ) {
			return call_user_func( $sanitize, $value );
		}

		return $this->sanitize( $value );
	}

	public function sanitize( $value ) {
		return WPUSB_Utils::rm_tags( $value );
	}

	public function set_instance( $instance ) {
		$this->instance = $instance;
	}

	public function get_widget_title() {
		return apply_filters( 'widget_title', $this->get_property( 'title' ), $this->instance, $this->id_base );
	}

	public function get_layout( $key = null, $follow = false ) {
		$layouts = WPUSB_Utils::get_layouts();

		if ( $follow ) {
			unset( $layouts['buttons'] );
			unset( $layouts['square-plus'] );
		}

		return $key ? WPUSB_Utils::isset_get( $layouts, $key ) : $layouts;
	}

	public function get_network( $network, $field, $sanitize = false ) {
		$items = $this->get_property( $network, $sanitize );

		return WPUSB_Utils::isset_get( $items, $field );
	}

	public function get_networks_available() {
		switch ( $this->widget_type ) {
			case 'share':
				return WPUSB_Social_Elements::$items_available;

			case 'follow_us':
				return $this->follow_us_networks;

			default:
				return array();
		}
	}

	public function render_checkboxes( $items ) {
		if ( ! class_exists( 'WPUSB_Settings_View' ) ) {
			WPUSB_App::uses( 'settings', 'View' );
		}

		$prefix             = WPUSB_App::SLUG;
		$names              = array_keys( $items );
		$networks_available = $this->get_networks_available();

		foreach ( $names as $name ) :
			if ( ! isset( $networks_available[ $name ] ) ) {
				continue;
			}

			WPUSB_Settings_View::td(
				array(
					'type'        => 'checkbox',
					'id'          => esc_attr( $this->get_field_id( $name ) ),
					'name'        => esc_attr( $this->get_field_name( 'items' ) ) . "[{$name}]",
					'value'       => $name,
					'label-class' => "{$prefix}-icon {$prefix}-{$name}",
					'td-class'    => "{$prefix}-td",
					'td-id'       => $name,
					'td-title'    => ucfirst( $name ),
					'svg-link'    => "{$prefix}-{$name}",
					'span'        => false,
					'class'       => 'hide-input',
					'is_checked'  => $this->is_checked( $name ),
					'attr'        => array(
						'data-action' => 'networks',
					),
				)
			);
		endforeach;
	}

	public function set_networks_available() {
		$this->follow_us_networks = apply_filters( WPUSB_Utils::add_prefix( '_networks_available' ), array(
			'behance'    => 'behance',
			'email'      => 'email',
			'facebook'   => 'facebook',
			'flickr'     => 'flickr',
			'foursquare' => 'foursquare',
			'github'     => 'github',
			'instagram'  => 'instagram',
			'linkedin'   => 'linkedin',
			'pinterest'  => 'pinterest',
			'reddit'     => 'reddit',
			'rss'        => 'rss',
			'snapchat'   => 'snapchat',
			'tumblr'     => 'tumblr',
			'twitter'    => 'twitter',
			'vimeo'      => 'vimeo',
			'vk'         => 'vk',
			'whatsapp'   => 'whatsapp',
			'youtube'    => 'youtube',
		) );
	}

	public function get_follow_us_networks() {
		$std = new stdClass();

		/**
		 * @var object
		 * @see Facebook
		 */
		$std->facebook         = new stdClass();
		$std->facebook->name   = __( 'Facebook', 'wpupper-share-buttons' );
		$std->facebook->url    = 'https://www.facebook.com/your-id';
		$std->facebook->title  = __( 'Follow us on Facebook', 'wpupper-share-buttons' );
		$std->facebook->method = 'default';

		/**
		 * @var object
		 * @see Twitter
		 */
		$std->twitter         = new stdClass();
		$std->twitter->name   = __( 'Twitter', 'wpupper-share-buttons' );
		$std->twitter->url    = 'https://twitter.com/your-id';
		$std->twitter->title  = __( 'Follow us on Twitter', 'wpupper-share-buttons' );
		$std->twitter->method = 'default';

		/**
		 * @var object
		 * @see Linkedin
		 */
		$std->linkedin         = new stdClass();
		$std->linkedin->name   = __( 'Linkedin', 'wpupper-share-buttons' );
		$std->linkedin->url    = 'https://www.linkedin.com/in/your-id';
		$std->linkedin->title  = __( 'Find us on Linkedin', 'wpupper-share-buttons' );
		$std->linkedin->method = 'default';

		/**
		 * @var object
		 * @see Pinterest
		 */
		$std->pinterest         = new stdClass();
		$std->pinterest->name   = __( 'Pinterest', 'wpupper-share-buttons' );
		$std->pinterest->url    = 'https://www.pinterest.com/your-id/';
		$std->pinterest->title  = __( 'My Pinterest board', 'wpupper-share-buttons' );
		$std->pinterest->method = 'default';

		/**
		 * @var object
		 * @see Instagram
		 */
		$std->instagram         = new stdClass();
		$std->instagram->name   = __( 'Instagram', 'wpupper-share-buttons' );
		$std->instagram->url    = 'https://www.instagram.com/your-id/';
		$std->instagram->title  = __( 'Check out our Instagram', 'wpupper-share-buttons' );
		$std->instagram->method = 'default';

		/**
		 * @var object
		 * @see Reddit
		 */
		$std->reddit         = new stdClass();
		$std->reddit->name   = __( 'Reddit', 'wpupper-share-buttons' );
		$std->reddit->url    = 'https://www.reddit.com/user/your-id';
		$std->reddit->title  = __( 'Follow us Reddit', 'wpupper-share-buttons' );
		$std->reddit->method = 'default';

		/**
		 * @var object
		 * @see YouTube
		 */
		$std->youtube         = new stdClass();
		$std->youtube->name   = __( 'YouTube', 'wpupper-share-buttons' );
		$std->youtube->url    = 'https://www.youtube.com/channel/your-id';
		$std->youtube->title  = __( 'Subscribe to our YouTube', 'wpupper-share-buttons' );
		$std->youtube->method = 'default';

		/**
		 * @var object
		 * @see Vimeo
		 */
		$std->vimeo         = new stdClass();
		$std->vimeo->name   = __( 'Vimeo', 'wpupper-share-buttons' );
		$std->vimeo->url    = 'https://vimeo.com/your-id';
		$std->vimeo->title  = __( 'Find us on Vimeo', 'wpupper-share-buttons' );
		$std->vimeo->method = 'default';

		/**
		 * @var object
		 * @see RSS
		 */
		$std->rss         = new stdClass();
		$std->rss->name   = __( 'RSS Feed', 'wpupper-share-buttons' );
		$std->rss->url    = esc_url( get_feed_link() );
		$std->rss->title  = __( 'Subscribe to our RSS Feed', 'wpupper-share-buttons' );
		$std->rss->method = 'default';

		/**
		 * @var object
		 * @see Tumblr
		 */
		$std->tumblr         = new stdClass();
		$std->tumblr->name   = __( 'Tumblr', 'wpupper-share-buttons' );
		$std->tumblr->url    = 'https://your-id.tumblr.com/';
		$std->tumblr->title  = __( 'Find us on Tumblr', 'wpupper-share-buttons' );
		$std->tumblr->method = 'default';

		/**
		 * @var object
		 * @see Flickr
		 */
		$std->flickr         = new stdClass();
		$std->flickr->name   = __( 'Flickr', 'wpupper-share-buttons' );
		$std->flickr->url    = 'https://www.flickr.com/photos/your-id';
		$std->flickr->title  = __( 'Check out our Flickr', 'wpupper-share-buttons' );
		$std->flickr->method = 'default';

		/**
		 * @var object
		 * @see Foursquare
		 */
		$std->foursquare         = new stdClass();
		$std->foursquare->name   = __( 'Foursquare', 'wpupper-share-buttons' );
		$std->foursquare->url    = 'https://foursquare.com/your-id';
		$std->foursquare->title  = __( 'Check out our Foursquare', 'wpupper-share-buttons' );
		$std->foursquare->method = 'default';

		/**
		 * @var object
		 * @see GitHub
		 */
		$std->github         = new stdClass();
		$std->github->name   = __( 'GitHub', 'wpupper-share-buttons' );
		$std->github->url    = 'https://github.com/your-id';
		$std->github->title  = __( 'Check out our GitHub', 'wpupper-share-buttons' );
		$std->github->method = 'default';

		/**
		 * @var object
		 * @see E-mail
		 */
		$std->email          = new stdClass();
		$std->email->name    = __( 'E-mail', 'wpupper-share-buttons' );
		$std->email->subject = WPUSB_Utils::rm_tags( get_option( 'blogname' ) );
		$std->email->title   = __( 'Contact Us', 'wpupper-share-buttons' );
		$std->email->method  = 'email';
		$std->email->type    = 'email';
		$std->email->link    = 'mailto:%s?subject=%s';

		/**
		 * @var object
		 * @see Snapchat
		 */
		$std->snapchat         = new stdClass();
		$std->snapchat->name   = __( 'Snapchat', 'wpupper-share-buttons' );
		$std->snapchat->url    = 'https://www.snapchat.com/add/your-id';
		$std->snapchat->title  = __( 'Follow us on Snapchat', 'wpupper-share-buttons' );
		$std->snapchat->method = 'default';

		/**
		 * @var object
		 * @see Behance
		 */
		$std->behance         = new stdClass();
		$std->behance->name   = __( 'Behance', 'wpupper-share-buttons' );
		$std->behance->url    = 'https://www.behance.net/your-id';
		$std->behance->title  = __( 'Follow us on Behance', 'wpupper-share-buttons' );
		$std->behance->method = 'default';

		/**
		 * @var object
		 * @see Behance
		 */
		$std->vk         = new stdClass();
		$std->vk->name   = __( 'VK', 'wpupper-share-buttons' );
		$std->vk->url    = 'https://vk.com/your-id';
		$std->vk->title  = __( 'Follow us on VKontakte', 'wpupper-share-buttons' );
		$std->vk->method = 'default';

		/**
		 * @var object
		 * @see WhatsApp
		 */
		$std->whatsapp               = new stdClass();
		$std->whatsapp->name         = __( 'WhatsApp', 'wpupper-share-buttons' );
		$std->whatsapp->helper_phone = __( 'The complete phone number with country code.', 'wpupper-share-buttons' );
		$std->whatsapp->title        = __( 'Click to Chat', 'wpupper-share-buttons' );
		$std->whatsapp->helper_text  = __( 'Pre-filled message that will automatically appear in the text field.', 'wpupper-share-buttons' );
		$std->whatsapp->method       = 'whatsapp';
		$std->whatsapp->type         = 'phone';
		$std->whatsapp->attr         = sprintf( 'data-whatsapp-%s="whatsapp://"', WPUSB_App::SLUG );
		$std->whatsapp->link         = 'https://web.whatsapp.com/send?phone=%d&text=%s';

		return apply_filters( WPUSB_Utils::add_prefix( '_follow_us_networks' ), $std );
	}

	public function rebuild_css() {
		WPUSB_Utils::build_css( WPUSB_Utils::get_all_custom_css() );
	}
}

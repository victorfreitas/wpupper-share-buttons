<?php
/**
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Widget Follow US
 * @since 3.27
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
}

WPUSB_App::uses( 'widget-follow', 'View' );

class WPUSB_Widget_Follow_Controller extends WPUpper_SB_Widget {

	public $networks = array();

	public function __construct() {
		$this->_set_networks();

		$id_base     = WPUSB_Utils::get_widget_follow_id_base();
		$description = __( 'Insert the Follow Us of your social networks.', 'wpupper-share-buttons' );

		parent::__construct( $id_base, $description, ' - Follow Us' );
	}

	public function widget( $args, $instance ) {
		$this->set_instance( $instance );

		$title = $this->get_widget_title();
		$title = apply_filters( 'widget_title', $title, $this->id_base );

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		if ( WPUSB_Utils::is_disabled_css() ) {
			printf( '<h4>%s</h4>', __( 'CSS is disabled!', 'wpupper-share-buttons' ) );
		}

		$items = $this->get_property( 'items', array() );

		WPUSB_Widget_Follow_View::render_fields( $this, $items );

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$this->set_instance( $instance );

		$hash  = md5( uniqid( rand(), true ) );
		$order = $this->get_property( 'items', array() );
		$items = array_merge( $order, $this->networks );

		WPUSB_Widgets_View::set_instance( $this );

		printf( '<div data-widgets-hash="%s">', $hash );

		WPUSB_Widgets_View::field_input(
			__( 'Widget title', 'wpupper-share-buttons' ),
			'title'
		);

		WPUSB_Widgets_View::field_input(
			__( 'Custom class', 'wpupper-share-buttons' ),
			'custom_class'
		);

		WPUSB_Widgets_View::field_input(
			__( 'Icons size', 'wpupper-share-buttons' ),
			'icons_size',
			'number'
		);

		WPUSB_Widgets_View::field_input(
			__( 'Icons color', 'wpupper-share-buttons' ),
			'icons_color',
			'color'
		);

		WPUSB_Widgets_View::field_select(
			__( 'Layout', 'wpupper-share-buttons' ),
			'layout',
			$this->get_layout( false, true )
		);

		$networks = $this->get_networks();

		foreach ( $items as $item ) :
			if ( ! isset( $networks->{$item} ) ) {
				continue;
			}

			WPUSB_Widgets_View::follow_us_fields( $networks->{$item}, $item );
		endforeach;

		WPUSB_Widgets_View::follow_us_networks( $items );

		echo '</div>';

		WPUSB_Widgets_View::unset_instance();
	?>
		<script>
			jQuery(function($) {
				var context;

				if ( typeof WPUSB !== 'function' ) {
					return;
				}

				context = $( '[class*="sidebars-column"], [id*="section-sidebar-widgets"]' );

				WPUSB.Components.WidgetFollow.call(
					null,
					context.find( '[data-widgets-hash="<?php echo $hash; ?>"]' )
				);
			});
		</script>
	<?php
	}

	public function _set_networks() {
		$networks = array(
			'facebook'   => 'facebook',
			'twitter'    => 'twitter',
			'linkedin'   => 'linkedin',
			'google'     => 'google',
			'pinterest'  => 'pinterest',
			'instagram'  => 'instagram',
			'reddit'     => 'reddit',
			'youtube'    => 'youtube',
			'vimeo'      => 'vimeo',
			'rss'        => 'rss',
			'tumblr'     => 'tumblr',
			'flickr'     => 'flickr',
			'foursquare' => 'foursquare',
			'github'     => 'github',
			'email'      => 'email',
			'snapchat'   => 'snapchat',
			'behance'    => 'behance',
			'vk'         => 'vk',
		);

		$this->networks = apply_filters( WPUSB_Utils::add_prefix( '_networks_available' ), $networks );
	}

	public function get_networks() {
		$std = new stdClass();

		/**
		 * @var Object
		 * @see Facebook
		 */
		$std->facebook        = new stdClass();
		$std->facebook->name  = __( 'Facebook', 'wpupper-share-buttons' );
		$std->facebook->url   = 'https://www.facebook.com/your-id';
		$std->facebook->title = __( 'Follow us on Facebook', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see Twitter
		 */
		$std->twitter        = new stdClass();
		$std->twitter->name  = __( 'Twitter', 'wpupper-share-buttons' );
		$std->twitter->url   = 'https://twitter.com/your-id';
		$std->twitter->title = __( 'Follow us on Twitter', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see Linkedin
		 */
		$std->linkedin        = new stdClass();
		$std->linkedin->name  = __( 'Linkedin', 'wpupper-share-buttons' );
		$std->linkedin->url   = 'https://www.linkedin.com/in/your-id';
		$std->linkedin->title = __( 'Find us on Linkedin', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see Google Plus
		 */
		$std->google        = new stdClass();
		$std->google->name  = __( 'Google Plus', 'wpupper-share-buttons' );
		$std->google->url   = 'https://plus.google.com/+your-id';
		$std->google->title = __( 'Follow us on Google+', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see Pinterest
		 */
		$std->pinterest        = new stdClass();
		$std->pinterest->name  = __( 'Pinterest', 'wpupper-share-buttons' );
		$std->pinterest->url   = 'https://www.pinterest.com/your-id/';
		$std->pinterest->title = __( 'My Pinterest board', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see Instagram
		 */
		$std->instagram        = new stdClass();
		$std->instagram->name  = __( 'Instagram', 'wpupper-share-buttons' );
		$std->instagram->url   = 'https://www.instagram.com/your-id/';
		$std->instagram->title = __( 'Check out our Instagram', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see Reddit
		 */
		$std->reddit        = new stdClass();
		$std->reddit->name  = __( 'Reddit', 'wpupper-share-buttons' );
		$std->reddit->url   = 'https://www.reddit.com/user/your-id';
		$std->reddit->title = __( 'Follow us Reddit', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see YouTube
		 */
		$std->youtube        = new stdClass();
		$std->youtube->name  = __( 'YouTube', 'wpupper-share-buttons' );
		$std->youtube->url   = 'https://www.youtube.com/channel/your-id';
		$std->youtube->title = __( 'Subscribe to our YouTube', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see Vimeo
		 */
		$std->vimeo        = new stdClass();
		$std->vimeo->name  = __( 'Vimeo', 'wpupper-share-buttons' );
		$std->vimeo->url   = 'https://vimeo.com/your-id';
		$std->vimeo->title = __( 'Find us on Vimeo', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see RSS
		 */
		$std->rss        = new stdClass();
		$std->rss->name  = __( 'RSS Feed', 'wpupper-share-buttons' );
		$std->rss->url   = esc_url( get_feed_link() );
		$std->rss->title = __( 'Subscribe to our RSS Feed', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see Tumblr
		 */
		$std->tumblr        = new stdClass();
		$std->tumblr->name  = __( 'Tumblr', 'wpupper-share-buttons' );
		$std->tumblr->url   = 'https://your-id.tumblr.com/';
		$std->tumblr->title = __( 'Find us on Tumblr', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see Flickr
		 */
		$std->flickr        = new stdClass();
		$std->flickr->name  = __( 'Flickr', 'wpupper-share-buttons' );
		$std->flickr->url   = 'https://www.flickr.com/photos/your-id';
		$std->flickr->title = __( 'Check out our Flickr', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see Foursquare
		 */
		$std->foursquare        = new stdClass();
		$std->foursquare->name  = __( 'Foursquare', 'wpupper-share-buttons' );
		$std->foursquare->url   = 'https://foursquare.com/your-id';
		$std->foursquare->title = __( 'Check out our Foursquare', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see GitHub
		 */
		$std->github        = new stdClass();
		$std->github->name  = __( 'GitHub', 'wpupper-share-buttons' );
		$std->github->url   = 'https://github.com/your-id';
		$std->github->title = __( 'Check out our GitHub', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see E-mail
		 */
		$std->email          = new stdClass();
		$std->email->name    = __( 'E-mail', 'wpupper-share-buttons' );
		$std->email->subject = WPUSB_Utils::rm_tags( get_option( 'blogname' ) );
		$std->email->title   = __( 'Contact Us', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see Snapchat
		 */
		$std->snapchat        = new stdClass();
		$std->snapchat->name  = __( 'Snapchat', 'wpupper-share-buttons' );
		$std->snapchat->url   = 'https://www.snapchat.com/add/your-id';
		$std->snapchat->title = __( 'Follow us on Snapchat', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see Behance
		 */
		$std->behance        = new stdClass();
		$std->behance->name  = __( 'Behance', 'wpupper-share-buttons' );
		$std->behance->url   = 'https://www.behance.net/your-id';
		$std->behance->title = __( 'Follow us on Behance', 'wpupper-share-buttons' );

		/**
		 * @var Object
		 * @see Behance
		 */
		$std->vk        = new stdClass();
		$std->vk->name  = __( 'VK', 'wpupper-share-buttons' );
		$std->vk->url   = 'https://vk.com/your-id';
		$std->vk->title = __( 'Follow us on VKontakte', 'wpupper-share-buttons' );

		return apply_filters( WPUSB_Utils::add_prefix( '_follow_us_networks' ), $std );
	}
}

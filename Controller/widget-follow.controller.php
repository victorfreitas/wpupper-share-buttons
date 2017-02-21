<?php
/**
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Widget Follow US
 * @since 3.27
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

WPUSB_App::uses( 'widget-follow', 'View' );

class WPUSB_Widget_Follow_Controller extends WPUpper_SB_Widget {

	public $networks = array();

	public function __construct() {
		$this->_set_networks();

		$id_base     = WPUSB_Utils::get_widget_follow_id_base();
		$description = __( 'Insert the Follow Us of your social networks.', WPUSB_App::TEXTDOMAIN );

		parent::__construct( $id_base, $description, ' - Follow Us' );
	}

	public function widget( $args, $instance ) {
		$this->set_instance( $instance );

		$title = $this->get_widget_title();

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		if ( WPUSB_Utils::is_disabled_css() ) {
			printf( '<h4>%s</h4>', __( 'CSS is disabled!', WPUSB_App::TEXTDOMAIN ) );
		}

		$items = $this->get_property( 'items', array() );

		WPUSB_Widget_Follow_View::render_fields( $this, $items );

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$this->set_instance( $instance );

		$prefix = WPUSB_App::SLUG;
		$domain = WPUSB_App::TEXTDOMAIN;
		$hash   = md5( uniqid( rand(), true ) );
		$order  = $this->get_property( 'items', array() );
		$items  = array_merge( $order, $this->networks );

		WPUSB_Widgets_View::set_instance( $this );

		printf( '<div data-widgets-hash="%s">', $hash );

		WPUSB_Widgets_View::field_input(
			__( 'Widget title', $domain ),
			'title'
		);

		WPUSB_Widgets_View::field_input(
			__( 'Custom class', $domain ),
			'custom_class'
		);

		WPUSB_Widgets_View::field_input(
			__( 'Icons size', $domain ),
			'icons_size',
			'number'
		);

		WPUSB_Widgets_View::field_input(
			__( 'Icons color', $domain ),
			'icons_color',
			'color'
		);

		WPUSB_Widgets_View::field_select(
			__( 'Layout', $domain ),
			'layout',
			$this->get_layout( false, true )
		);

		$networks = $this->get_networks();

		foreach ( $items as $item ) :
			if ( ! isset( $networks->{$item} ) ) {
				continue;
			}

			$network = $networks->{$item};
			WPUSB_Widgets_View::follow_us_fields( $network, $item );
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
		);

		$this->networks = apply_filters( WPUSB_App::SLUG . '_networks_available', $networks );
	}

	public function get_networks() {
		$domain = WPUSB_App::TEXTDOMAIN;
		$std    = new stdClass();

		/**
		 * @var Object
		 * @see Facebook
		 */
		$std->facebook        = new stdClass();
		$std->facebook->name  = 'Facebook';
		$std->facebook->url   = 'https://www.facebook.com/your-id';
		$std->facebook->title = __( 'Follow us on Facebook', $domain );

		/**
		 * @var Object
		 * @see Twitter
		 */
		$std->twitter        = new stdClass();
		$std->twitter->name  = 'Twitter';
		$std->twitter->url   = 'https://twitter.com/your-id';
		$std->twitter->title = __( 'Follow us on Twitter', $domain );

		/**
		 * @var Object
		 * @see Linkedin
		 */
		$std->linkedin        = new stdClass();
		$std->linkedin->name  = 'Linkedin';
		$std->linkedin->url   = 'https://www.linkedin.com/in/your-id';
		$std->linkedin->title = __( 'Find us on Linkedin', $domain );

		/**
		 * @var Object
		 * @see Google Plus
		 */
		$std->google        = new stdClass();
		$std->google->name  = 'Google Plus';
		$std->google->url   = 'https://plus.google.com/+your-id';
		$std->google->title = __( 'Follow us on Google+', $domain );

		/**
		 * @var Object
		 * @see Pinterest
		 */
		$std->pinterest        = new stdClass();
		$std->pinterest->name  = 'Pinterest';
		$std->pinterest->url   = 'https://www.pinterest.com/your-id/';
		$std->pinterest->title = __( 'My Pinterest board', $domain );

		/**
		 * @var Object
		 * @see Instagram
		 */
		$std->instagram        = new stdClass();
		$std->instagram->name  = 'Instagram';
		$std->instagram->url   = 'https://www.instagram.com/your-id/';
		$std->instagram->title = __( 'Check out our Instagram', $domain );

		/**
		 * @var Object
		 * @see Reddit
		 */
		$std->reddit        = new stdClass();
		$std->reddit->name  = 'Reddit';
		$std->reddit->url   = 'https://www.reddit.com/user/your-id';
		$std->reddit->title = __( 'Follow us Reddit', $domain );

		/**
		 * @var Object
		 * @see YouTube
		 */
		$std->youtube        = new stdClass();
		$std->youtube->name  = 'YouTube';
		$std->youtube->url   = 'https://www.youtube.com/channel/your-id';
		$std->youtube->title = __( 'Subscribe to our YouTube', $domain );

		/**
		 * @var Object
		 * @see Vimeo
		 */
		$std->vimeo        = new stdClass();
		$std->vimeo->name  = 'Vimeo';
		$std->vimeo->url   = 'https://vimeo.com/your-id';
		$std->vimeo->title = __( 'Find us on Vimeo', $domain );

		/**
		 * @var Object
		 * @see RSS
		 */
		$std->rss        = new stdClass();
		$std->rss->name  = 'RSS Feed';
		$std->rss->url   = esc_url( get_feed_link() );
		$std->rss->title = __( 'Subscribe to our RSS Feed', $domain );

		/**
		 * @var Object
		 * @see Tumblr
		 */
		$std->tumblr        = new stdClass();
		$std->tumblr->name  = 'Tumblr';
		$std->tumblr->url   = 'https://your-id.tumblr.com/';
		$std->tumblr->title = __( 'Find us on Tumblr', $domain );

		/**
		 * @var Object
		 * @see Flickr
		 */
		$std->flickr        = new stdClass();
		$std->flickr->name  = 'Flickr';
		$std->flickr->url   = 'https://www.flickr.com/photos/your-id';
		$std->flickr->title = __( 'Check out our Flickr', $domain );

		/**
		 * @var Object
		 * @see Foursquare
		 */
		$std->foursquare        = new stdClass();
		$std->foursquare->name  = 'Foursquare';
		$std->foursquare->url   = 'https://foursquare.com/your-id';
		$std->foursquare->title = __( 'Check out our Foursquare', $domain );

		/**
		 * @var Object
		 * @see GitHub
		 */
		$std->github        = new stdClass();
		$std->github->name  = 'GitHub';
		$std->github->url   = 'https://github.com/your-id';
		$std->github->title = __( 'Check out our GitHub', $domain );

		/**
		 * @var Object
		 * @see E-mail
		 */
		$std->email          = new stdClass();
		$std->email->name    = 'E-mail';
		$std->email->subject = WPUSB_Utils::rm_tags( get_option( 'blogname' ) );
		$std->email->title   = __( 'Contact Us', $domain );

		/**
		 * @var Object
		 * @see Snapchat
		 */
		$std->snapchat        = new stdClass();
		$std->snapchat->name  = 'Snapchat';
		$std->snapchat->url   = 'https://www.snapchat.com/add/your-id';
		$std->snapchat->title = __( 'Follow us on Snapchat', $domain );

		return apply_filters( WPUSB_App::SLUG . '_follow_us_networks', $std );
	}
}
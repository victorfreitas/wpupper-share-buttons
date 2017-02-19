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

class WPUSB_Widget_Follow_Controller extends WPUpper_SB_Widget {

	public function __construct() {
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

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$this->set_instance( $instance );

		$prefix = WPUSB_App::SLUG;
		$domain = WPUSB_App::TEXTDOMAIN;
		$hash   = md5( uniqid( rand(), true ) );

		WPUSB_Widgets_View::set_instance( $this );

		printf( '<div data-widgets-hash="%s">', $hash );

		WPUSB_Widgets_View::field_input(
			__( 'Widget title', $domain ),
			'title'
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

		WPUSB_Widgets_View::social_items();

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
				WPUSB.Components.Widgets.call(
					null,
					context.find( '[data-widgets-hash="<?php echo $hash; ?>"]' )
				);
			});
		</script>
	<?php
	}

	private function get_networks() {
		$domain = WPUSB_App::TEXTDOMAIN;
		$std    = new stdClass();

		/**
		 * @var Object
		 * @see Facebook
		 */
		$std->facebook              = new stdClass();
		$std->facebook->name        = 'Facebook';
		$std->facebook->placeholder = 'https://www.facebook.com/myname';
		$std->facebook->title       = __( 'Follow us on Facebook', $domain );
		$std->facebook->default     = true;

		/**
		 * @var Object
		 * @see Twitter
		 */
		$std->twitter              = new stdClass();
		$std->twitter->name        = 'Twitter';
		$std->twitter->placeholder = 'https://twitter.com/myname';
		$std->twitter->title       = __( 'Follow us on Twitter', $domain );
		$std->twitter->default     = true;

		/**
		 * @var Object
		 * @see Linkedin
		 */
		$std->linkedin              = new stdClass();
		$std->linkedin->name        = 'Linkedin';
		$std->linkedin->placeholder = 'https://www.linkedin.com/in/myname';
		$std->linkedin->title       = __( 'Find us on Linkedin', $domain );
		$std->linkedin->default     = true;

		/**
		 * @var Object
		 * @see Google Plus
		 */
		$std->google              = new stdClass();
		$std->google->name        = 'Google Plus';
		$std->google->placeholder = 'https://plus.google.com/+myname';
		$std->google->title       = __( 'Follow us on Google+', $domain );
		$std->google->default     = false;

		/**
		 * @var Object
		 * @see Pinterest
		 */
		$std->pinterest              = new stdClass();
		$std->pinterest->name        = 'Pinterest';
		$std->pinterest->placeholder = 'https://www.pinterest.com/myname/';
		$std->pinterest->title       = __( 'My Pinterest board', $domain );
		$std->pinterest->default     = false;

		/**
		 * @var Object
		 * @see Instagram
		 */
		$std->instagram              = new stdClass();
		$std->instagram->name        = 'Instagram';
		$std->instagram->placeholder = 'https://www.instagram.com/myname/';
		$std->instagram->title       = __( 'Check out our Instagram', $domain );
		$std->instagram->default     = false;

		/**
		 * @var Object
		 * @see Reddit
		 */
		$std->reddit              = new stdClass();
		$std->reddit->name        = 'Reddit';
		$std->reddit->placeholder = 'https://www.reddit.com/user/myname';
		$std->reddit->title       = __( 'Follow us Reddit', $domain );
		$std->reddit->default     = true;

		/**
		 * @var Object
		 * @see YouTube
		 */
		$std->youtube              = new stdClass();
		$std->youtube->name        = 'YouTube';
		$std->youtube->placeholder = 'https://www.youtube.com/user/myname';
		$std->youtube->title       = __( 'Subscribe to our YouTube', $domain );
		$std->youtube->default     = false;

		/**
		 * @var Object
		 * @see Vimeo
		 */
		$std->vimeo              = new stdClass();
		$std->vimeo->name        = 'Vimeo';
		$std->vimeo->placeholder = 'https://vimeo.com/myname';
		$std->vimeo->title       = __( 'Find us on vimeo', $domain );
		$std->vimeo->default     = false;

		/**
		 * @var Object
		 * @see RSS
		 */
		$std->feed              = new stdClass();
		$std->feed->name        = 'RSS';
		$std->feed->placeholder = esc_url( get_feed_link() );
		$std->feed->title       = __( 'Subscribe to our RSS Feed', $domain );
		$std->feed->default     = false;

		/**
		 * @var Object
		 * @see Tumblr
		 */
		$std->tumblr              = new stdClass();
		$std->tumblr->name        = 'Tumblr';
		$std->tumblr->placeholder = 'https://myname.tumblr.com/';
		$std->tumblr->title       = __( 'Find us on Tumblr', $domain );
		$std->tumblr->default     = false;

		/**
		 * @var Object
		 * @see Flickr
		 */
		$std->flickr              = new stdClass();
		$std->flickr->name        = 'Flickr';
		$std->flickr->placeholder = 'https://www.flickr.com/photos/myname';
		$std->flickr->title       = __( 'Check out our Flickr', $domain );
		$std->flickr->default     = false;

		/**
		 * @var Object
		 * @see Foursquare
		 */
		$std->foursquare              = new stdClass();
		$std->foursquare->name        = 'Foursquare';
		$std->foursquare->placeholder = 'https://foursquare.com/myname';
		$std->foursquare->title       = __( 'Check out our Foursquare', $domain );
		$std->foursquare->default     = false;

		/**
		 * @var Object
		 * @see E-mail
		 */
		$std->email              = new stdClass();
		$std->email->name        = 'E-mail';
		$std->email->placeholder = 'Subject';
		$std->email->title       = __( 'Contact Us', $domain );
		$std->email->default     = false;

		return apply_filters( WPUSB_App::SLUG . '_follow_us_networks', $std );
	}
}
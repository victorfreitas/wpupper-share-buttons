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

	public $networks = array();

	public function __construct() {
		$this->_set_networks();

		$id_base     = WPUSB_Utils::get_widget_follow_id_base();
		$description = __( 'Insert the Follow Us of your social networks.', WPUSB_App::TEXTDOMAIN );

		parent::__construct( $id_base, $description, ' - Follow Us' );
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
			'email'      => 'email',
			'snapchat'   => 'snapchat',
		);

		$this->networks = apply_filters( WPUSB_App::SLUG . '_networks_available', $networks );
	}

	public function widget( $args, $instance ) {
		$this->set_instance( $instance );

		$title = $this->get_widget_title();

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		?>
			<div class="wpusb-follow-us">
				<div class="wpusb-item item-facebook">
					<a href="#" class="wpusb-btn" title="Follow us Facebook">
						<i class="wpusb-icon-facebook-rounded wpusb-follow-icon"></i>
					</a>
				</div>
				<div class="wpusb-item item-twitter">
					<a href="#" class="wpusb-btn" title="Follow us Twitter">
						<i class="wpusb-icon-twitter-rounded wpusb-follow-icon"></i>
					</a>
				</div>
				<div class="wpusb-item item-reddit">
					<a href="#" class="wpusb-btn" title="Follow us Reddit">
						<i class="wpusb-icon-reddit-rounded wpusb-follow-icon"></i>
					</a>
				</div>
			</div>
		<?php

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

		foreach ( $items as $id => $item ) :
			if ( ! isset( $networks->{$item} ) ) {
				continue;
			}

			$network = $networks->{$item};
			WPUSB_Widgets_View::follow_us_fields( $network, $id );
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

	private function get_networks() {
		$domain = WPUSB_App::TEXTDOMAIN;
		$std    = new stdClass();

		/**
		 * @var Object
		 * @see Facebook
		 */
		$std->facebook                    = new stdClass();
		$std->facebook->name              = 'Facebook';
		$std->facebook->placeholder_url   = 'https://www.facebook.com/your-username';
		$std->facebook->placeholder_title = __( 'Follow us on Facebook', $domain );

		/**
		 * @var Object
		 * @see Twitter
		 */
		$std->twitter                    = new stdClass();
		$std->twitter->name              = 'Twitter';
		$std->twitter->placeholder_url   = 'https://twitter.com/your-username';
		$std->twitter->placeholder_title = __( 'Follow us on Twitter', $domain );

		/**
		 * @var Object
		 * @see Linkedin
		 */
		$std->linkedin                    = new stdClass();
		$std->linkedin->name              = 'Linkedin';
		$std->linkedin->placeholder_url   = 'https://www.linkedin.com/in/your-username';
		$std->linkedin->placeholder_title = __( 'Find us on Linkedin', $domain );

		/**
		 * @var Object
		 * @see Google Plus
		 */
		$std->google                    = new stdClass();
		$std->google->name              = 'Google Plus';
		$std->google->placeholder_url   = 'https://plus.google.com/+your-username';
		$std->google->placeholder_title = __( 'Follow us on Google+', $domain );

		/**
		 * @var Object
		 * @see Pinterest
		 */
		$std->pinterest                    = new stdClass();
		$std->pinterest->name              = 'Pinterest';
		$std->pinterest->placeholder_url   = 'https://www.pinterest.com/your-username/';
		$std->pinterest->placeholder_title = __( 'My Pinterest board', $domain );

		/**
		 * @var Object
		 * @see Instagram
		 */
		$std->instagram                    = new stdClass();
		$std->instagram->name              = 'Instagram';
		$std->instagram->placeholder_url   = 'https://www.instagram.com/your-username/';
		$std->instagram->placeholder_title = __( 'Check out our Instagram', $domain );

		/**
		 * @var Object
		 * @see Reddit
		 */
		$std->reddit                    = new stdClass();
		$std->reddit->name              = 'Reddit';
		$std->reddit->placeholder_url   = 'https://www.reddit.com/user/your-username';
		$std->reddit->placeholder_title = __( 'Follow us Reddit', $domain );

		/**
		 * @var Object
		 * @see YouTube
		 */
		$std->youtube                    = new stdClass();
		$std->youtube->name              = 'YouTube';
		$std->youtube->placeholder_url   = 'https://www.youtube.com/channel/your-username';
		$std->youtube->placeholder_title = __( 'Subscribe to our YouTube', $domain );

		/**
		 * @var Object
		 * @see Vimeo
		 */
		$std->vimeo                    = new stdClass();
		$std->vimeo->name              = 'Vimeo';
		$std->vimeo->placeholder_url   = 'https://vimeo.com/your-username';
		$std->vimeo->placeholder_title = __( 'Find us on vimeo', $domain );

		/**
		 * @var Object
		 * @see RSS
		 */
		$std->rss                    = new stdClass();
		$std->rss->name              = 'RSS';
		$std->rss->placeholder_url   = esc_url( get_feed_link() );
		$std->rss->placeholder_title = __( 'Subscribe to our RSS Feed', $domain );

		/**
		 * @var Object
		 * @see Tumblr
		 */
		$std->tumblr                    = new stdClass();
		$std->tumblr->name              = 'Tumblr';
		$std->tumblr->placeholder_url   = 'https://your-username.tumblr.com/';
		$std->tumblr->placeholder_title = __( 'Find us on Tumblr', $domain );

		/**
		 * @var Object
		 * @see Flickr
		 */
		$std->flickr                    = new stdClass();
		$std->flickr->name              = 'Flickr';
		$std->flickr->placeholder_url   = 'https://www.flickr.com/photos/your-username';
		$std->flickr->placeholder_title = __( 'Check out our Flickr', $domain );

		/**
		 * @var Object
		 * @see Foursquare
		 */
		$std->foursquare                    = new stdClass();
		$std->foursquare->name              = 'Foursquare';
		$std->foursquare->placeholder_url   = 'https://foursquare.com/your-username';
		$std->foursquare->placeholder_title = __( 'Check out our Foursquare', $domain );

		/**
		 * @var Object
		 * @see E-mail
		 */
		$std->email                    = new stdClass();
		$std->email->name              = 'E-mail';
		$std->email->placeholder_url   = __( 'Your subject', $domain );
		$std->email->placeholder_title = __( 'Contact Us', $domain );

		/**
		 * @var Object
		 * @see Snapchat
		 */
		$std->snapchat                    = new stdClass();
		$std->snapchat->name              = 'Snapchat';
		$std->snapchat->placeholder_url   = 'https://www.snapchat.com/add/your-username';
		$std->snapchat->placeholder_title = __( 'Follow us on Snapchat', $domain );

		return apply_filters( WPUSB_App::SLUG . '_follow_us_networks', $std );
	}
}
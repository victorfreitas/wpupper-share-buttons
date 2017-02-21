<?php
/**
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Widgets Share
 * @since 3.25
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

class WPUSB_Widgets_Controller extends WPUpper_SB_Widget {

	public function __construct() {
		$id_base     = WPUSB_Utils::get_widget_id_base();
		$description = __( 'Insert share buttons of social networks.', WPUSB_App::TEXTDOMAIN );

		parent::__construct( $id_base, $description );
	}

	public function widget( $args, $instance ) {
		if ( WPUSB_Utils::is_disabled_by_meta() ) {
			return;
		}

		$this->set_instance( $instance );

		$title      = $this->get_widget_title();
		$prefix     = WPUSB_App::SLUG;
		$share_args = array(
			'layout'         => $this->get_property( 'layout', 'default' ),
			'items'          => $this->get_property( 'items' ),
			'title'          => $this->get_property( 'post_title' ),
			'header_title'   => false,
			'url'            => $this->get_property( 'url' ),
			'remove_inside'  => $this->get_property( 'inside', 0, 'intval' ),
			'remove_counter' => $this->get_property( 'counter', 0, 'intval' ),
			'is_widget'      => true,
		);

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$share_args    = apply_filters( "{$prefix}_buttons_share_args_widget", $share_args, $this->number );
		$buttons_share = WPUSB_Utils::buttons_share( $share_args );

		printf( '<div id="%s">', WPUSB_Utils::get_widget_attr_id( $this->number ) );

		do_action( "{$prefix}_before_buttons_widget", $instance, $this->number );

		echo apply_filters( "{$prefix}_buttons_share_widget", $buttons_share, $share_args, $this->number );

		do_action( "{$prefix}_after_buttons_widget", $instance, $this->number );

		echo '</div>';

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
			__( 'Post title', $domain ),
			'post_title'
		);

		WPUSB_Widgets_View::field_input(
			__( 'URL', $domain ),
			'url'
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

		WPUSB_Widgets_View::field_input(
			__( 'Buttons background color. <br>Layouts: Square plus and Button', $domain ),
			'icons_background',
			'color'
		);

		WPUSB_Widgets_View::field_input(
			__( 'Buttons title color', $domain ),
			'btn_inside_color',
			'color'
		);

		WPUSB_Widgets_View::field_input(
			__( 'Share count text color', $domain ),
			'counts_text_color',
			'color'
		);

		WPUSB_Widgets_View::field_input(
			__( 'Share count background color. <br>Layouts: Default, Button, Rounded and Square.', $domain ),
			'counts_bg_color',
			'color'
		);

		WPUSB_Widgets_View::field_select(
			__( 'Layout', $domain ),
			'layout',
			$this->get_layout()
		);

		WPUSB_Widgets_View::field_checkbox(
			__( 'Remove counter', $domain ),
			'counter'
		);

		WPUSB_Widgets_View::field_checkbox(
			__( 'Remove button title', $domain ),
			'inside'
		);

		do_action( "{$prefix}_widget_form", $instance, $prefix );

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
}
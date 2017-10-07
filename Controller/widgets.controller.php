<?php
/**
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Widgets Share
 * @since 3.25
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
}

class WPUSB_Widgets_Controller extends WPUpper_SB_Widget {

	public function __construct() {
		$id_base     = WPUSB_Utils::get_widget_id_base();
		$description = __( 'Insert share buttons of social networks.', 'wpupper-share-buttons' );

		parent::__construct( $id_base, $description );
	}

	public function widget( $args, $instance ) {
		if ( WPUSB_Utils::is_disabled_by_meta() ) {
			return;
		}

		$this->set_instance( $instance );

		$title      = $this->get_widget_title();
		$title      = apply_filters( 'widget_title', $title, $this->id_base );
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

		$share_args = apply_filters(
			WPUSB_Utils::add_prefix( '_buttons_share_args_widget' ),
			$share_args,
			$this->number
		);
		$buttons_share = WPUSB_Utils::buttons_share( $share_args );

		printf( '<div id="%s">', WPUSB_Utils::get_widget_attr_id( $this->number ) );

		do_action( WPUSB_Utils::add_prefix( '_before_buttons_widget' ), $instance, $this->number );

		echo apply_filters(
			WPUSB_Utils::add_prefix( '_buttons_share_widget' ),
			$buttons_share,
			$share_args,
			$this->number
		);

		do_action( WPUSB_Utils::add_prefix( '_after_buttons_widget' ), $instance, $this->number );

		echo '</div>';

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$this->set_instance( $instance );

		$hash = md5( uniqid( rand(), true ) );

		WPUSB_Widgets_View::set_instance( $this );

		printf( '<div data-widgets-hash="%s">', $hash );

		WPUSB_Widgets_View::field_input(
			__( 'Widget title', 'wpupper-share-buttons' ),
			'title'
		);

		WPUSB_Widgets_View::field_input(
			__( 'Post title', 'wpupper-share-buttons' ),
			'post_title'
		);

		WPUSB_Widgets_View::field_input(
			__( 'URL', 'wpupper-share-buttons' ),
			'url'
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

		WPUSB_Widgets_View::field_input(
			__( 'Buttons background color. <br>Layouts: Square plus and Button', 'wpupper-share-buttons' ),
			'icons_background',
			'color'
		);

		WPUSB_Widgets_View::field_input(
			__( 'Buttons title color', 'wpupper-share-buttons' ),
			'btn_inside_color',
			'color'
		);

		WPUSB_Widgets_View::field_input(
			__( 'Share count text color', 'wpupper-share-buttons' ),
			'counts_text_color',
			'color'
		);

		WPUSB_Widgets_View::field_input(
			__( 'Share count background color. <br>Layouts: Default, Button, Rounded and Square.', 'wpupper-share-buttons' ),
			'counts_bg_color',
			'color'
		);

		WPUSB_Widgets_View::field_select(
			__( 'Layout', 'wpupper-share-buttons' ),
			'layout',
			$this->get_layout()
		);

		WPUSB_Widgets_View::field_checkbox(
			__( 'Remove counter', 'wpupper-share-buttons' ),
			'counter'
		);

		WPUSB_Widgets_View::field_checkbox(
			__( 'Remove button title', 'wpupper-share-buttons' ),
			'inside'
		);

		do_action( WPUSB_Utils::add_prefix( '_widget_form' ), $instance, WPUSB_App::SLUG );

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

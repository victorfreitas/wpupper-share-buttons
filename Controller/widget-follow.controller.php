<?php
/**
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Widget Follow US
 * @since 3.27
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit;
}

WPUSB_App::uses( 'widget-follow', 'View' );

class WPUSB_Widget_Follow_Controller extends WPUpper_SB_Widget {

	public $widget_type = 'follow_us';

	public function __construct() {
		$id_base     = WPUSB_Utils::get_widget_follow_id_base();
		$description = __( 'Insert the Follow Us of your social networks.', 'wpupper-share-buttons' );

		parent::__construct( $id_base, $description, ' - Follow Us' );
	}

	public function widget( $args, $instance ) {
		$this->set_instance( $instance );

		$title = $this->get_widget_title();
		$title = apply_filters( 'widget_title', $title, $this->id_base );

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( WPUSB_Utils::is_disabled_css() ) {
			printf( '<h4>%s</h4>', esc_html__( 'CSS is disabled!', 'wpupper-share-buttons' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		$items = $this->get_property( 'items', array() );

		WPUSB_Widget_Follow_View::render_fields( $this, $items );

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$this->set_instance( $instance );

		$order = $this->get_property( 'items', array() );
		$items = array_merge( $order, $this->follow_us_networks );
		$id    = md5( uniqid( wp_rand(), true ) );

		WPUSB_Widgets_View::set_instance( $this );

		printf( '<div data-widget-id="%s">', esc_attr( $id ) );

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

		$networks = $this->get_follow_us_networks();

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
				if ( typeof window.WPUSB !== 'function' ) {
					return;
				}

				const context = $( '[class*="sidebars-column"], [id*="section-sidebar-widgets"]' );

				window.WPUSB.legacyWidgetsInlineScriptLoaded = true;
				window.WPUSB.Components.WidgetFollow.call(
					null,
					context.find( '[data-widget-id="<?php echo esc_attr( $id ); ?>"]' )
				);
			});
		</script>
	<?php
	}
}

<?php
/**
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Widgets Controller
 * @since 3.25
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

WPUSB_App::uses( 'widgets', 'View' );

class WPUSB_Widgets_Controller extends \WP_Widget {

	public $instance;

	public function __construct() {
		$id_base = WPUSB_Utils::get_widget_id_base();

		parent::__construct(
			$id_base,
			WPUSB_App::NAME,
			array(
				'classname'   => $id_base,
				'description' => __( 'Insert share buttons of social networks.', WPUSB_App::TEXTDOMAIN ),
			)
		);

		WPUSB_Widgets_View::set_instance( $this );

		add_action( "update_option_{$this->option_name}", array( $this, 'rebuild_css' ), 10, 3 );
	}

	public function widget( $args, $instance ) {
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

		do_action( "{$prefix}_before_buttons_widget", $instance, $this->number );

		echo apply_filters( "{$prefix}_buttons_share_widget", $buttons_share, $share_args, $this->number );

		do_action( "{$prefix}_after_buttons_widget", $instance, $this->number );

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance               = $this->sanitize( $new_instance );
		$instance['url']        = ( $new_instance['url'] ) ? esc_url( $new_instance['url'] ) : '';
		$instance['icons_size'] = ( $new_instance['icons_size'] ) ? absint( $new_instance['icons_size'] ) : '';

		return $instance;
	}

	public function form( $instance ) {
		$this->set_instance( $instance );

		$prefix = WPUSB_App::SLUG;
		$domain = WPUSB_App::TEXTDOMAIN;
		$hash   = md5( uniqid( rand(), true ) );

		WPUSB_Widgets_View::field_input( __( 'Widget title', $domain ), 'title' );
		WPUSB_Widgets_View::field_input( __( 'Custom post title', $domain ), 'post_title' );
		WPUSB_Widgets_View::field_input( __( 'Custom url', $domain ), 'url' );
		WPUSB_Widgets_View::field_input( __( 'Custom icons size', $domain ), 'icons_size', 'number' );
		WPUSB_Widgets_View::field_input( __( 'Custom icons color', $domain ), 'icons_color' );
		WPUSB_Widgets_View::field_input( __( 'Custom buttons background color', $domain ), 'icons_background' );
		WPUSB_Widgets_View::field_select( __( 'Layout', $domain ), 'layout', $this->get_layout() );
		WPUSB_Widgets_View::field_checkbox( __( 'Remove counter', $domain ), 'counter' );
		WPUSB_Widgets_View::field_checkbox( __( 'Remove button title', $domain ), 'inside' );

		do_action( "{$prefix}_widget_form", $instance, $prefix );

		WPUSB_Widgets_View::social_items( $hash );
	?>
		<script>
			jQuery(function($) {
				var context;

				if ( typeof WPUSB === 'undefined' ) {
					return;
				}

				context = $( '[class*="sidebars-column"], [id*="section-sidebar-widgets"]' );

				WPUSB.Sortable.create.call(
					WPUSB.Sortable,
					context.find( '[data-widget-hash="<?php echo $hash; ?>"]' )
				);

				if ( typeof $.prototype.wpColorPicker !== 'function' ) {
					return;
				}

				context.find( <?php echo "'.{$prefix}-widget-colorpicker'"; ?> ).wpColorPicker();
			});
		</script>
	<?php
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

	public function get_layout( $key = false ) {
		$layouts = WPUSB_Utils::get_layouts();

		return ( ! $key ) ? $layouts : WPUSB_Utils::isset_get( $layouts, $key );
	}

	public function rebuild_css( $old_value, $value, $option ) {
		$custom_css = WPUSB_Utils::get_all_custom_css();
		WPUSB_Utils::build_css( $custom_css );
	}
}
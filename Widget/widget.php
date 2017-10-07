<?php
/**
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Widgets
 * @since 3.27
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
}

WPUSB_App::uses( 'widgets', 'View' );

class WPUpper_SB_Widget extends WP_Widget {

	protected $instance;

	public function __construct( $id_base, $description, $name = '' ) {
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

	public function get_layout( $key = false, $follow = false ) {
		$layouts = WPUSB_Utils::get_layouts();

		if ( $follow ) {
			unset( $layouts['buttons'] );
			unset( $layouts['square-plus'] );
		}

		return ( ! $key ) ? $layouts : WPUSB_Utils::isset_get( $layouts, $key );
	}

	public function get_network( $network, $field, $sanitize = false ) {
		$items = $this->get_property( $network, $sanitize );

		return WPUSB_Utils::isset_get( $items, $field );
	}

	public function render_checkboxes( $items ) {
		$prefix = WPUSB_App::SLUG;

		foreach ( $items as $name => $item ) :
			$id = ( 'google' === $name ) ? "{$name}-plus" : $name;

			WPUSB_Settings_View::td(
				array(
					'type'        => 'checkbox',
					'id'          => esc_attr( $this->get_field_id( $id ) ),
					'name'        => esc_attr( $this->get_field_name( 'items' ) ) . "[{$name}]",
					'value'       => $name,
					'label-class' => "{$prefix}-icon {$prefix}-{$id}-icon",
					'td-class'    => "{$prefix}-td",
					'td-id'       => $name,
					'td-title'    => ucfirst( $name ),
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

	public function rebuild_css( $old_value, $value, $option ) {
		$custom_css = WPUSB_Utils::get_all_custom_css();
		WPUSB_Utils::build_css( $custom_css );
	}
}

<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @since 3.0.0
 * @subpackage Social Icons Display
 * @version 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

class WPUSB_Fixed_Left {

	protected static $layout;
	/**
	 * Open buttons container
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 */
	public static function init( \stdClass $atts ) {
		self::_set_layout();

		$args      = WPUSB_Utils::content_args( $atts );
		$classes   = self::get_classes_first( $atts );
		$counter   = self::add_count( $atts );
		$component = WPUSB_Utils::get_component_by_type();
		$content   = <<<EOD
		<div class="{$classes} {$args['prefix']}-fixed"
		     id="{$args['prefix']}-container-fixed"
		     data-element-url="{$args['permalink']}"
		     data-element-title="{$args['title']}"
		     data-attr-reference="{$args['post_id']}"
		     data-element="fixed"
		     data-attr-nonce="{$args['nonce']}"
		     {$component}>

			<div data-element="buttons" class="{$atts->position_fixed}-container">
			{$counter}
EOD;
		return apply_filters( WPUSB_App::SLUG . 'init-buttons-fixed', $content );
	}

	/**
	 * Items social buttons
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 */
	public static function items( $args = OBJECT ) {
		$classes    = self::get_classes_second( $args );
		$link_type  = WPUSB_Utils::link_type( $args->reference->link );
		$layout     = self::$layout;
		$btn_class  = ( 'buttons' == $layout ) ? 'button' : $layout;
		$ga_event   = ( $args->ga ) ? 'onClick="' . $args->ga . ';"' : '';
		$modal_data = WPUSB_Utils::get_modal_data_id( $args->reference->element, $args->number );
		$class_icon = apply_filters(
			"{$args->prefix}_item_class_icon",
			"{$args->reference->class_icon}-{$layout}",
			$args->reference
		);
		$content   = <<<EOD
			<div class="{$classes}">

				<a {$link_type}
				   {$args->reference->popup}
				   class="{$args->prefix}-{$btn_class} {$args->class_link}"
				   title="{$args->reference->title}"
				   {$ga_event}
				   {$modal_data}
				   rel="nofollow">

				   <i class="{$class_icon} {$args->class_icon}"></i>
				</a>
			</div>
EOD;
		return apply_filters( WPUSB_App::SLUG . '-btn-items', $content );
	}

	/**
	 * Get classes container
	 *
	 * @since 3.0.0
	 * @param Object $atts
	 * @return String
	 *
	 */
	public static function get_classes_second( $atts ) {
		$classes  = "{$atts->reference->class_item}";
		$classes .= " {$atts->reference->class}";
		$classes .= " {$atts->class_second}";

		return apply_filters( WPUSB_App::SLUG . '-classes-second-fixed-left', $classes );
	}

	/**
	 * Add total counter
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 */
	public static function add_count( $args ) {
		$prefix  = $args->prefix;
		$content = '';

		if ( ! WPUSB_Utils::is_inactive_couter( $args ) ) {
			$inside  = self::_get_inside_count();
			$content = <<<EOD
				<div class="{$prefix}-item {$prefix}-total-share">

					<div class="{$prefix}-counts">
						<span data-element="total-share"></span>
						{$inside}
					</div>

				</div>
EOD;
		}

		return apply_filters( WPUSB_App::SLUG . '-total-counter-fixed', $content );
	}

	/**
	 * Add inside for layout rounded
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return String
	 */
	private static function _get_inside_count() {
		$inside = '<span>' . __( 'Shares', WPUSB_App::TEXTDOMAIN ) . '</span>';

		return ( 'default' == self::$layout ) ? $inside : '';
	}

	/**
	 * Get classes for container
	 *
	 * @since 3.0.0
	 * @param Object $atts
	 * @return String
	 *
	 */
	public static function get_classes_first( $atts ) {
		$classes  = $atts->prefix;
		$layout   = self::$layout;
		$classes .= " {$atts->prefix}-{$layout}";
		$classes .= " {$atts->position_fixed}";
		$classes .= " {$atts->class_first} {$atts->custom_class}";

		return apply_filters( WPUSB_App::SLUG . '-classes-first-fixed-left', $classes );
	}

	/**
	 * Close buttons container
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 *
	 */
	public static function end( $args ) {
		$prefix  = WPUSB_App::SLUG;
		$content = <<<EOD
				</div>
				<span class="{$prefix}-toggle"
					  data-action="close-buttons"></span>
			</div>
EOD;
		return apply_filters( WPUSB_App::SLUG . '-close-buttons-fixed', $content );
	}

	/**
	 * Set property layout
	 *
	 * @since 3.5.0
	 * @param Null
	 * @return Void
	 *
	 */
	public static function _set_layout() {
		self::$layout = WPUSB_Utils::option( 'fixed_layout', 'buttons' );
	}
}
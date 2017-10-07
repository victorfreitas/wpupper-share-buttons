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
	exit( 0 );
}

class WPUSB_Fixed_Left {

	public static $layout;
	public static $current_layout;

	/**
	 * Open buttons container
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 */
	public static function init( \stdClass $atts ) {
		$layout = WPUSB_Utils::option( 'fixed_layout', 'buttons' );

		self::_set_layout( $layout );

		$args          = WPUSB_Utils::content_args( $atts );
		$prefix        = $args['prefix'];
		$classes       = self::get_classes_first( $atts );
		$counter       = self::add_count( $atts );
		$component     = WPUSB_Utils::get_component_by_type();
		$square2_class = ( $layout === 'square2' ) ? WPUSB_Utils::add_prefix( '-buttons' ) : '';
		$content       = <<<EOD
		<div class="{$classes} {$prefix}-fixed {$prefix}-layout-{$layout}-content {$prefix}-fixed-{$atts->layout}"
		     id="{$prefix}-container-fixed"
		     data-element-url="{$args['permalink']}"
		     data-element-title="{$args['title']}"
		     data-attr-reference="{$args['post_id']}"
		     data-is-term="{$args['is_term']}"
		     data-element="fixed"
		     data-attr-nonce="{$args['nonce']}"
		     {$component}>

			<div data-element="buttons" class="{$atts->position_fixed}-container {$square2_class}">
			{$counter}
EOD;
		return apply_filters( WPUSB_Utils::add_prefix( '-init-buttons-fixed' ), $content );
	}

	/**
	 * Items social buttons
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 */
	public static function items( $args = OBJECT ) {
		$classes        = self::get_classes_second( $args );
		$link_type      = WPUSB_Utils::link_type( $args->reference );
		$layout         = self::$layout;
		$current_layout = self::$current_layout;
		$btn_class      = ( 'buttons' === $layout ) ? 'button' : $layout;
		$ga_event       = ( $args->ga ) ? 'onClick="' . $args->ga . ';"' : '';
		$modal_data     = WPUSB_Utils::get_modal_data_id( $args->reference->element, $args->number );
		$class_btn      = WPUSB_Utils::get_class_btn();
		$class_icon     = apply_filters( WPUSB_Utils::add_prefix( '_item_class_icon' ), "{$args->reference->class_icon}-{$layout}", $args->reference );
		$content        = <<<EOD
			<div class="{$classes}">

				<a {$link_type}
				   {$args->reference->popup}
				   class="{$args->prefix}-layout-{$current_layout} {$args->prefix}-{$btn_class} {$class_btn} {$args->class_link}"
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
		$prefix     = $args->prefix;
		$content    = '';
		$class_hide = WPUSB_Utils::get_hide_count_class();

		if ( ! WPUSB_Utils::is_inactive_couter( $args ) ) {
			$inside  = self::_get_inside_count();
			$content = <<<EOD
				<div class="{$prefix}-item {$prefix}-total-share {$class_hide}">

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
		if ( 'default' !== self::$layout ) {
			return '';
		}

		return sprintf(
			'<span class="%s">%s</span>',
			WPUSB_Utils::get_class_btn_inside(),
			__( 'Shares', 'wpupper-share-buttons' )
		);
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
	 * @param String $layout
	 * @return Void
	 *
	 */
	public static function _set_layout( $layout ) {
		self::$layout         = ( $layout === 'square2' ) ? 'default' : $layout;
		self::$current_layout = $layout;
	}
}

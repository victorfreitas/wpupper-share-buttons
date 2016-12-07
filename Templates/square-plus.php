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

class WPUSB_Square_Plus {

	/**
	 * Open buttons container
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 */
	public static function init( \stdClass $atts ) {
		$args      = WPUSB_Utils::content_args( $atts );
		$classes   = WPUSB_Utils::get_classes_first( $atts );
		$counter   = self::add_count( $atts );
		$component = WPUSB_Utils::get_component_by_type();
		$content   = <<<EOD
		<div data-element-url="{$args['permalink']}"
		     data-element-title="{$args['title']}"
		     data-attr-reference="{$args['post_id']}"
		     data-attr-nonce="{$args['nonce']}"
		     class="{$classes}"
		     {$component}
		     {$args['fixed_top']}>

		     {$counter}
EOD;
		return apply_filters( WPUSB_App::SLUG . 'start-buttons-html', $content );
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
		$inside     = self::inside( $args );
		$referrer   = WPUSB_Utils::get_data_referrer( $args );
		$ga_event   = ( $args->ga ) ? 'onClick="' . $args->ga . ';"' : '';
		$content    = <<<EOD
			<div class="{$classes}" {$referrer}>

				<a {$link_type}
				   class="{$args->prefix}-link {$args->class_link}"
				   title="{$args->reference->title}"
				   rel="nofollow"
				   {$args->reference->popup}
				   {$ga_event}>

				   <i class="{$args->item_class_icon} {$args->class_icon}"></i>
				   {$inside}
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

		if ( WPUSB_Utils::is_first() && WPUSB_Utils::is_active_inside( $atts->elements ) ) {
			$classes .= " {$atts->prefix}-inside {$atts->prefix}-full";
		}

		return apply_filters( WPUSB_App::SLUG . '-classes-second-square-plus', $classes );
	}

	/**
	 * Add total counter
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 */
	public static function add_count( $args ) {
		$prefix      = $args->prefix;
		$shares_text = __( 'Shares', WPUSB_App::TEXTDOMAIN );
		$content     = '';

		if ( WPUSB_Utils::is_active_couter( $args ) ) {
			$content = <<<EOD
				<div class="{$prefix}-item {$prefix}-counter">
					<span class="{$prefix}-counter"
					      data-element="total-share">
					</span>
					<span class="{$prefix}-text" data-title="{$shares_text}"></span>

					<div class="{$prefix}-slash" data-slash="&#8260;"></div>
				</div>
EOD;
		}

		return apply_filters( WPUSB_App::SLUG . 'total-counter', $content );
	}

	/**
	 * Verifies is set sharing name
	 *
	 * @since 3.0.0
	 * @param Object $atts
	 * @return String
	 *
	 */
	public static function inside( $atts ) {
		$content = '';

		if ( ! $atts->reference->inside ) {
			return WPUSB_Utils::filter_inside( $atts );
		}

		if ( WPUSB_Utils::is_first() && WPUSB_Utils::is_active_inside( $atts->elements ) ) {
			$content = "<span data-title=\"{$atts->reference->name}\"></span>";
		}

		return WPUSB_Utils::filter_inside( $atts, $content );
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
		return apply_filters( WPUSB_App::SLUG . 'end-buttons-html', '</div>' );
	}
}
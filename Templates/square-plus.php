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

class WPUSB_Square_Plus {

	/**
	 * Open buttons container
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 */
	public static function init( \stdClass $atts ) {
		$args         = WPUSB_Utils::content_args( $atts );
		$classes      = WPUSB_Utils::get_classes_first( $atts );
		$counter      = self::add_count( $atts );
		$component    = WPUSB_Utils::get_component_by_type();
		$header_title = WPUSB_Shares_View::get_header_title( $atts );
		$content      = <<<EOD
		<div class="{$classes}"
			 id="{$args['prefix']}-container-square-plus"
			 data-element-url="{$args['permalink']}"
		     data-element-title="{$args['title']}"
		     data-attr-reference="{$args['post_id']}"
		     data-attr-nonce="{$args['nonce']}"
		     data-is-term="{$args['is_term']}"
		     {$component}
		     {$args['fixed_top']}>

			 {$header_title}
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
		$link_type  = WPUSB_Utils::link_type( $args->reference );
		$inside     = self::inside( $args );
		$referrer   = WPUSB_Utils::get_data_referrer( $args );
		$ga_event   = ( $args->ga ) ? 'onClick="' . $args->ga . ';"' : '';
		$modal_data = WPUSB_Utils::get_modal_data_id( $args->reference->element, $args->number );
		$class_btn  = WPUSB_Utils::get_class_btn();
		$content    = <<<EOD
			<div class="{$classes}" {$referrer}>

				<a {$link_type}
				   class="{$args->prefix}-link {$class_btn} {$args->class_link}"
				   title="{$args->reference->title}"
				   rel="nofollow"
				   {$args->reference->popup}
				   {$ga_event}
				   {$modal_data}>

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

		if ( WPUSB_Utils::is_first() && ! WPUSB_Utils::is_inactive_inside( $atts->elements ) ) {
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
		if ( WPUSB_Utils::is_inactive_couter( $args ) ) {
			return '';
		}

		$share_label = WPUSB_Utils::get_share_count_label();
		$class_hide  = WPUSB_Utils::get_hide_count_class();
		$content     = <<<EOD
			<div class="{$args->prefix}-item {$args->prefix}-total-share {$class_hide}">
				<div class="{$args->prefix}-shares-count" data-element="total-share"></div>
				<div class="{$args->prefix}-shares-text" data-title="{$share_label}"></div>
				<span class="{$args->prefix}-pipe" data-pipe="&#x0007C;"></span>
			</div>
EOD;
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

		if ( WPUSB_Utils::is_first() && ! WPUSB_Utils::is_inactive_inside( $atts->elements ) ) {
			$class_btn_inside = WPUSB_Utils::get_class_btn_inside();
			$content          = sprintf(
				'<span class="%s" data-title="%s"></span>',
				$class_btn_inside,
				$atts->reference->name
			);
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

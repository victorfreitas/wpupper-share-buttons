<?php
/**
 *
 * @author  Victor Freitas
 * @package WPUpper Share Buttons
 * @subpackage Social Icons Display
 * @since 3.0.0
 * @version 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
}

class WPUSB_Layouts_Primary {

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
		$component    = WPUSB_Utils::get_component_by_type();
		$header_title = WPUSB_Shares_View::get_header_title( $atts );
		$content      = <<<EOD
			<div class="{$classes}"
		     	 id="{$args['prefix']}-container-{$atts->layout}"
				 data-element-url="{$args['permalink']}"
		     	 data-element-title="{$args['title']}"
			     data-attr-reference="{$args['post_id']}"
			     data-attr-nonce="{$args['nonce']}"
		     	 data-is-term="{$args['is_term']}"
			     {$component}
			     {$args['fixed_top']}>

			 {$header_title}
EOD;
		return apply_filters( WPUSB_App::SLUG . '-start-buttons-html', $content, $atts );
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
		$counter    = self::add_count( $args );
		$referrer   = WPUSB_Utils::get_data_referrer( $args );
		$modal_data = WPUSB_Utils::get_modal_data_id( $args->reference->element, $args->number );
		$ga_event   = ( $args->ga ) ? 'onClick="' . $args->ga . ';"' : '';
		$class_btn  = WPUSB_Utils::get_class_btn();
		$content    = <<<EOD
			<div class="{$classes}" {$referrer}>

				<a {$link_type}
				   {$args->reference->popup}
				   class="{$args->reference->class_link} {$class_btn} {$args->class_link}"
				   title="{$args->reference->title}"
				   {$ga_event}
				   {$modal_data}
				   rel="nofollow">

				   <i class="{$args->item_class_icon} {$args->class_icon}"></i>
				   {$inside}
				</a>
				{$counter}
			</div>
EOD;
		return apply_filters( WPUSB_App::SLUG . '-btn-items', $content, $args );
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

		return apply_filters( WPUSB_App::SLUG . '-classes-second-layouts-primary', $classes, $atts );
	}

	/**
	 * Verifies is set sharing name
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 *
	 */
	public static function inside( $atts ) {
		$content = '';

		if ( ! $atts->reference->inside ) {
			return WPUSB_Utils::filter_inside( $atts );
		}

		if ( ! WPUSB_Utils::is_inactive_inside( $atts->elements ) ) {
			$class_btn_inside = WPUSB_Utils::get_class_btn_inside();
			$content          = sprintf(
				'<span class="%s" data-title="%s"></span>',
				$class_btn_inside,
				$atts->reference->inside
			);
		}

		return WPUSB_Utils::filter_inside( $atts, $content );
	}

	/**
	 * Adds counter from items
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 */
	public static function add_count( $args ) {
		$active_counter = WPUSB_Utils::is_inactive_couter( $args->elements );
		$content        = '';
		$class_hide     = WPUSB_Utils::get_hide_count_class();

		if ( $args->reference->has_counter && ! $active_counter ) {
			$content = sprintf(
				'<span data-element="%s" class="%s-count %s"></span>',
				$args->reference->element,
				$args->prefix,
				$class_hide
			);
		}

		return apply_filters( WPUSB_App::SLUG . '-total-counter', $content, $args );
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
		return apply_filters( WPUSB_App::SLUG . '-end-buttons-html', '</div>', $args );
	}

	/**
	 * Get button open modal all items
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return String
	 *
	 */
	public static function get_btn_plus( $class = '' ) {
		$prefix = WPUSB_App::SLUG;
		$title  = __( 'Open modal social networks', 'wpupper-share-buttons' );

		return <<<EOD
			<div class="{$prefix}-{$class} {$prefix}-popup-open-networks">
				<a href="#" data-action="open-modal-networks"
				   class="wpusb-btn-open" title="{$title}" rel="nofollow">
					<i class="{$prefix}-icon-share-rounded"></i>
				</a>
			</div>
EOD;
	}
}

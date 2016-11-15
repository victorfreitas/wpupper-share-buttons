<?php
/**
 *
 * @author  Victor Freitas
 * @package WPUpper Share Buttons
 * @subpackage Social Icons Display
 * @since 3.0.0
 * @version 1.0
 */

if ( ! function_exists( 'add_action' ) ) {
	exit(0);
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
		$args       = WPUSB_Utils::content_args( $atts );
		$classes    = WPUSB_Utils::get_classes_first( $atts );
		$data_token = WPUSB_Utils::get_data_token( $args['token'] );
		$component  = WPUSB_Utils::get_component_by_type();
		$content    = <<<EOD
			<div data-element-url="{$args['permalink']}"
		     	 data-element-title="{$args['title']}"
			     data-tracking="{$args['tracking']}"
			     data-attr-reference="{$args['post_id']}"
			     data-attr-nonce="{$args['nonce']}"
		     	 data-attr-nonce-gplus="{$args['nonce-gplus']}"
			     {$component}
			     class="{$classes}"
			     {$data_token}
			     {$args['fixed_top']}>
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
		$classes   = self::get_classes_second( $args );
		$link_type = WPUSB_Utils::link_type( $args->reference->link );
		$inside    = self::inside( $args );
		$counter   = self::add_count( $args );
		$referrer  = WPUSB_Utils::get_data_referrer( $args );
		$ga_event  = ( $args->ga ) ? 'onClick="' . $args->ga . ';"' : '';
		$content   = <<<EOD
			<div class="{$classes}" {$referrer}>

				<a {$link_type}
				   {$args->reference->popup}
				   class="{$args->reference->class_link} {$args->class_link}"
				   title="{$args->reference->title}"
				   {$ga_event}
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

		if ( WPUSB_Utils::is_active_inside( $atts->elements ) ) {
			$content = "<span data-title=\"{$atts->reference->inside}\"></span>";
		}

		return apply_filters( WPUSB_App::SLUG . '-inside-html', $content, $atts );
	}

	/**
	 * Adds counter from items
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 */
	public static function add_count( $args ) {
		$active_counter = WPUSB_Utils::is_active_couter( $args->elements );
		$content        = '';

		if ( $args->reference->has_counter && $active_counter ) {
			$content = "<span data-element=\"{$args->reference->element}\" class=\"{$args->prefix}-count\"></span>";
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
		$title  = __( 'Open modal social networks', WPUSB_App::TEXTDOMAIN );

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
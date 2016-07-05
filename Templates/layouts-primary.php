<?php
/**
 *
 * @author  Victor Freitas
 * @package WPUpper Share Buttons
 * @subpackage Social Icons Display
 * @since 3.0.0
 * @version 1.0
 */

if ( ! function_exists( 'add_action' ) )
	exit(0);

use WPUSB_Utils as Utils;
use WPUSB_App as App;

class WPUSB_Layouts_Primary
{
	/**
	 * Open buttons container
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 */
	public static function init( \stdClass $atts )
	{
		$args       = Utils::content_args();
		$classes    = Utils::get_classes_first( $atts );
		$data_token = Utils::get_data_token( $args['token'] );
		$content    = <<<EOD
			<div data-element-url="{$args['permalink']}"
			     data-tracking="{$args['tracking']}"
			     data-attr-reference="{$args['post_id']}"
			     data-attr-nonce="{$args['nonce']}"
			     data-component="counter-social-share"
			     class="{$classes}"
			     {$data_token}
			     {$args['fixed_top']}>
EOD;
		return apply_filters( App::SLUG . 'start-buttons-html', $content );
	}

	/**
	 * Items social buttons
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 */
	public static function items( $args = OBJECT )
	{
		$classes   = self::get_classes_second( $args );
		$link_type = Utils::link_type( $args->reference->link );
		$inside    = self::inside( $args );
		$counter   = self::add_count( $args );
		$referrer  = Utils::get_data_referrer( $args->reference->element );
		$content   = <<<EOD
			<div class="{$classes}" {$referrer}>

				<a {$link_type}
				   {$args->reference->popup}
				   class="{$args->reference->class_link} {$args->class_link}"
				   title="{$args->reference->title}"
				   rel="nofollow">

				   <i class="{$args->reference->class_icon}-{$args->layout} {$args->class_icon}"></i>
				   {$inside}
				</a>
				{$counter}
			</div>
EOD;
		return apply_filters( App::SLUG . '-btn-items', $content );
	}

	/**
	 * Get classes container
	 *
	 * @since 3.0.0
	 * @param Object $atts
	 * @return String
	 *
	 */
	public static function get_classes_second( $atts )
	{
		$classes  = "{$atts->reference->class_item}";
		$classes .= " {$atts->reference->class}";
		$classes .= " {$atts->class_second}";

		return apply_filters( App::SLUG . '-classes-second-layouts-primary', $classes );
	}

	/**
	 * Verifies is set sharing name
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 *
	 */
	public static function inside( $atts )
	{
		$content = '';

		if ( Utils::is_active_inside( $atts->elements ) )
			$content = "<span data-title=\"{$atts->reference->inside}\"></span>";

		return apply_filters( App::SLUG . 'inside-html', $content );
	}

	/**
	 * Adds counter from items
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 */
	public static function add_count( $args )
	{
		$active_counter = Utils::is_active_couter( $args->elements );
		$content        = '';

		if ( $args->reference->has_counter && $active_counter )
			$content = "<span data-element=\"{$args->reference->element}\" class=\"{$args->prefix}-count\"></span>";

		return apply_filters( App::SLUG . 'total-counter', $content );
	}

	/**
	 * Close buttons container
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 *
	 */
	public static function end( $args )
	{
		return '</div>';
	}

	/**
	 * Get button open modal all items
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return String
	 *
	 */
	public static function get_btn_plus( $class = '' )
	{
		$prefix = WPUSB_Setting::PREFIX;
		$title  = __( 'Open modal social networks', App::TEXTDOMAIN );

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
<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @since 3.0.0
 * @subpackage Social Icons Display
 * @version 1.0
 */

if ( ! function_exists( 'add_action' ) )
	exit(0);

use WPUSB_Utils as Utils;
use WPUSB_App as App;

class WPUSB_Fixed_Left
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
		$classes    = self::get_classes_first( $atts );
		$data_token = Utils::get_data_token( $args['token'] );
		$counter    = self::add_count( $atts );
		$content    = <<<EOD
		<div class="{$classes}"
		     data-element-url="{$args['permalink']}"
		     data-tracking="{$args['tracking']}"
		     data-attr-reference="{$args['post_id']}"
		     data-element="fixed"
		     data-attr-nonce="{$args['nonce']}"
		     data-component="counter-social-share"
		     {$data_token}>

			<div data-element="buttons" class="{$atts->position_fixed}-container">
			{$counter}
EOD;
		return apply_filters( App::SLUG . 'init-buttons-fixed', $content );
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
		$content   = <<<EOD
			<div class="{$classes}">

				<a {$link_type}
				   {$args->reference->popup}
				   class="{$args->prefix}-button {$args->class_link}"
				   title="{$args->reference->title}"
				   rel="nofollow">

				   <i class="{$args->reference->class_icon}-buttons {$args->class_icon}"></i>
				</a>
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

		return apply_filters( App::SLUG . '-classes-second-fixed-left', $classes );
	}

	/**
	 * Add total counter
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 */
	public static function add_count( $args )
	{
		$prefix  = $args->prefix;
		$content = '';

		if ( Utils::is_active_couter( $args ) ) :
			$content = <<<EOD
				<div class="{$prefix}-item {$prefix}-total-share">

					<div class="{$prefix}-counts">
						<span data-element="total-share"></span>
					</div>

				</div>
EOD;
		endif;

		return apply_filters( App::SLUG . '-total-counter-fixed', $content );
	}

	/**
	 * Get classes for container
	 *
	 * @since 3.0.0
	 * @param Object $atts
	 * @return String
	 *
	 */
	public static function get_classes_first( $atts )
	{
		$classes  = $atts->prefix;
		$classes .= " {$atts->prefix}-buttons";
		$classes .= " {$atts->position_fixed}";
		$classes .= " {$atts->class_first} {$atts->custom_class}";

		return apply_filters( App::SLUG . '-classes-first-fixed-left', $classes );
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
		$prefix  = WPUSB_Setting::PREFIX;
		$content = <<<EOD
				</div>
				<span class="{$prefix}-toggle"
					  data-action="close-buttons"></span>
			</div>
EOD;
		return apply_filters( App::SLUG . '-close-buttons-fixed', $content );
	}
}
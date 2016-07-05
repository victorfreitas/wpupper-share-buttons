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

class WPUSB_Square_Plus
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
		$counter    = self::add_count( $atts );
		$content    = <<<EOD
		<div data-element-url="{$args['permalink']}"
		     data-tracking="{$args['tracking']}"
		     data-attr-reference="{$args['post_id']}"
		     data-attr-nonce="{$args['nonce']}"
		     data-component="counter-social-share"
		     class="{$classes}"
		     {$data_token}
		     {$args['fixed_top']}>

		     {$counter}
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
		$referrer  = Utils::get_data_referrer( $args->reference->element );
		$content   = <<<EOD
			<div class="{$classes}" {$referrer}>

				<a {$link_type}
				   {$args->reference->popup}
				   class="{$args->prefix}-link {$args->class_link}"
				   title="{$args->reference->title}"
				   rel="nofollow">

				   <i class="{$args->reference->class_icon}-{$args->layout} {$args->class_icon}"></i>
				   {$inside}
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

		if ( Utils::is_first() && Utils::is_active_inside( $atts->elements ) )
			$classes .= " {$atts->prefix}-inside {$atts->prefix}-full";

		return apply_filters( App::SLUG . '-classes-second-square-plus', $classes );
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
		$prefix      = $args->prefix;
		$shares_text = __( 'Shares', App::TEXTDOMAIN );
		$content     = '';

		if ( Utils::is_first() && Utils::is_active_couter( $args ) ) :
			$content = <<<EOD
				<div class="{$prefix}-item {$prefix}-counter">
					<span class="{$prefix}-counter"
					      data-element="total-share">
					</span>
					<span class="{$prefix}-text" data-title="{$shares_text}"></span>

					<div class="{$prefix}-slash" data-slash="&#8260;"></div>
				</div>
EOD;
		endif;

		return apply_filters( App::SLUG . 'total-counter', $content );
	}

	/**
	 * Verifies is set sharing name
	 *
	 * @since 3.0.0
	 * @param Object $args
	 * @return String
	 *
	 */
	public static function inside( $args )
	{
		$content = '';

		if ( Utils::is_first() && Utils::is_active_inside( $args->elements ) )
			$content = "<span data-title=\"{$args->reference->name}\"></span>";

		return apply_filters( App::SLUG . 'inside-html', $content );
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
}
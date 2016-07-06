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

use WPUSB_Ajax_Controller as Ajax;
use WPUSB_Utils as Utils;
use WPUSB_Setting as Setting;
use WPUSB_Core as Core;
use WPUSB_App as App;

abstract class WPUSB_Utils_Share
{
	public static $count_elements = 0;
	public static $layout_fixed = 'position_fixed';

	/**
	 * Set buttons args
	 *
	 * @since 3.0.0
	 * @param object $social
	 * @param array $args
	 * @return String HTML
	 *
	 */
	public static function set_buttons_args( $social, $args )
	{
		$buttons = static::_set_buttons(
			array(
				'social'       => $social,
				'class_second' => $args['class_second'],
				'class_icon'   => $args['class_icon'],
				'class_link'   => $args['class_link'],
				'layout'       => $args['layout'],
				'elements'     => $args['elements'],
			)
		);

		return $buttons;
	}

	/**
	 * Set and verify buttons
	 *
	 * @since 3.0.0
	 * @param Array $args
	 * @return String HTML
	 *
	 */
	private static function _set_buttons( $args = array() )
	{
		$prefix  = Setting::PREFIX;
		$buttons = self::get_content_by_layout(
			(object) array(
				'reference'    => $args['social'],
				'prefix'       => $prefix,
				'class_second' => $args['class_second'],
				'class_icon'   => $args['class_icon'],
				'class_link'   => $args['class_link'],
				'layout'       => $args['layout'],
				'elements'     => $args['elements'],
				'share_full'   => '',
			),
			'items'
		);

		return apply_filters( App::SLUG . 'set-buttons-html', $buttons );
	}

	/**
	 * Get buttons
	 *
	 * @since 3.0.0
	 * @param array $args
	 * @return String
	 *
	 */
	public static function get_buttons( $args = array(), $fixed = false )
	{
		$model          = new Setting();
		$elements       = Core::social_media_objects();
		$args           = apply_filters( App::SLUG . 'buttons-args', $args );
		$args['layout'] = self::get_layout( $args, $model->layout, $fixed );
		$buttons        = self::get_buttons_open( $args, $model );

		foreach ( $elements as $key => $social ) :
			if ( ! in_array( $key, (array) $model->social_media ) )
				continue;

			self::$count_elements++;

			$buttons .= self::set_buttons_args( $social, $args );
		endforeach;

		$buttons .= self::get_content_by_layout( (object) $args, 'end' );

		return $buttons;
	}

	public static function get_layout( $args, $layout, $fixed )
	{
		if ( $fixed )
			return self::$layout_fixed;

		return ( ! empty( $args['layout'] ) ) ? $args['layout'] : $layout;
	}

	/**
	 * Get buttons open
	 *
	 * @since 3.0.0
	 * @param Array $args
	 * @param object $model
	 * @return String HTML
	 *
	 */
	public static function get_buttons_open( $args, $model )
	{
		$prefix  = Setting::PREFIX;
		$buttons = self::get_content_by_layout(
			(object) array(
				'class_first'    => $args['class_first'],
				'custom_class'   => $model->class,
				'layout'         => $args['layout'] ? $args['layout'] : 'default',
				'prefix'         => $prefix,
				'position_fixed' => ( $model->position_fixed ) ? "{$prefix}-{$model->position_fixed}" : '',
				'remove_counter' => $args['elements']['remove_counter'],
			),
			'init'
		);

		return $buttons;
	}

	/**
	 * Create nonce from ajax counter share
	 *
	 * @since 3.0.0
	 * @param empty
	 * @return String
	 *
	 */
	public static function nonce()
	{
		return wp_create_nonce(
			Ajax::AJAX_VERIFY_NONCE_COUNTER
		);
	}

	/**
	 * Arguments for content buttons start
	 *
	 * @since 3.0.0
	 * @param empty
	 * @return Array
	 *
	 */
	public static function content_args()
	{
		$prefix = Setting::PREFIX;

		return array(
			'nonce'     => self::nonce(),
			'token'     => Utils::option( 'bitly_token' ),
			'prefix'    => $prefix,
			'post_id'   => Utils::get_id(),
			'tracking'  => Utils::option( 'tracking' ),
			'permalink' => Utils::get_permalink(),
			'fixed_top' => self::data_fixed_top( $prefix ),
		);
	}

	/**
	 * Get data element fixed top
	 *
	 * @since 3.0.0
	 * @param String $prefix
	 * @return String
	 *
	 */
	public static function data_fixed_top( $prefix )
	{
		$element = '';

		if ( Utils::is_fixed_top() )
			$element = "data-element=\"{$prefix}-fixed-top\"";

		return $element;
	}

	/**
	 * Get data token short url
	 *
	 * @since 3.0.0
	 * @param String $token
	 * @return String
	 *
	 */
	public static function get_data_token( $token )
	{
		if ( empty( $token ) )
			return '';

		return "data-token=\"{$token}\"";
	}

	/**
	 * Verfy type and return links from icons
	 *
	 * @since 3.0.0
	 * @param String $url_share
	 * @return String
	 */
	public static function link_type( $url_share )
	{
		$attr_link = "href=\"{$url_share}\" target=\"_blank\"";

		return apply_filters( App::SLUG . 'attr-link', $attr_link );
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
		$classes .= " {$atts->prefix}-{$atts->layout}";
		$classes .= " {$atts->class_first} {$atts->custom_class}";

		return $classes;
	}

	/**
	 * Verify is active counters
	 *
	 * @since 3.0.0
	 * @param Array $atts
	 * @return Boolean
	 *
	 */
	public static function is_active_couter( $atts )
	{
		$atts         = (object) $atts;
		$atts_counter = (bool) $atts->remove_counter;
		$opt_counter  = Utils::option( 'remove_count', false, 'intval' );

		return ! ( $atts_counter ? $atts_counter : $opt_counter );
	}

	/**
	 * Verify is active title
	 *
	 * @since 3.0.0
	 * @param Array $atts
	 * @return Boolen
	 *
	 */
	public static function is_active_inside( $atts )
	{
		$atts_inside = (bool) $atts['remove_inside'];
		$opt_inside  = Utils::option( 'remove_inside', false, 'intval' );

		return ! ( $atts_inside ? $atts_inside : $opt_inside );
	}

	/**
	 * Get container button by layout
	 *
	 * @since 3.0.0
	 * @param Array $args
	 * @param String $method
	 * @return String
	 *
	 */
	public static function get_content_by_layout( $args, $method )
	{
		$layouts = self::get_layouts();

		switch( $args->layout ) :
			case $layouts['plus'] :
				$content = WPUSB_Square_Plus::$method( $args );
				break;

			case $layouts['default'] :
			case $layouts['buttons'] :
			case $layouts['rounded'] :
			case $layouts['square'] :
				$content = WPUSB_Layouts_Primary::$method( $args );
				break;

			case $layouts['fixed'] :
				$content = WPUSB_Fixed_Left::$method( $args );
				break;
		endswitch;

		return $content;
	}

	/**
	 * Set all layouts
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return Array
	 *
	 */
	public static function get_layouts()
	{
		return array(
			'default' => 'default',
			'buttons' => 'buttons',
			'rounded' => 'rounded',
			'square'  => 'square',
			'plus'    => 'square-plus',
			'fixed'   => self::$layout_fixed,
		);
	}

	/**
	 * Verifies is first item
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return Boolean
	 *
	 */
	public static function is_first()
	{
		if ( self::$count_elements > 1 )
			return false;

		return true;
	}

	/**
	 * Verifies is position fixed
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return Boolean
	 *
	 */
	public static function is_position_fixed()
	{
		return ( 'on' === Utils::option( 'fixed' ) );
	}

	/**
	 * Add data featured by referrer
	 *
	 * @since 3.0.0
	 * @param String $element
	 * @return String
	 *
	 */
	public static function get_data_referrer( $element )
	{
		$opt_referrer = Utils::option( 'referrer', false );

		if ( $opt_referrer === 'yes' )
			return "data-referrer=\"{$element}\"";
	}

	/**
	 * Create custom class from icons
	 *
	 * @since 1.0
	 * @param Array $atts
	 * @param Boolean $fixed
	 * @return String
	 */
	public static function buttons_share( $atts = array(), $fixed = false )
	{
		$atts = array_map( array( 'WPUSB_Utils', 'esc_class' ), $atts );
		$args = array(
			'class_first'  => Utils::isset_get( $atts, 'class_first' ),
			'class_second' => Utils::isset_get( $atts, 'class_second' ),
			'class_link'   => Utils::isset_get( $atts, 'class_link' ),
			'class_icon'   => Utils::isset_get( $atts, 'class_icon' ),
			'layout'       => Utils::isset_get( $atts, 'layout' ),
			'elements'     => array(
				'remove_inside'  => Utils::isset_get( $atts, 'remove_inside' ),
				'remove_counter' => Utils::isset_get( $atts, 'remove_counter' ),
			),
		);

		return self::get_buttons( $args, $fixed );
	}
}
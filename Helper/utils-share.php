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

abstract class WPUSB_Utils_Share {

	public static $count_elements = 0;
	public static $layout_fixed = 'position_fixed';
	public static $social_media = array();
	public static $number = 0;
	public static $instances = array();

	/**
	 * Set buttons args
	 *
	 * @since 3.0.0
	 * @param object $social
	 * @param array $args
	 * @return String HTML
	 *
	 */
	public static function set_buttons_args( $social, $args, $permalink, $title ) {
		$social  = self::replace_link( $social, $permalink, $title );
		$buttons = self::_set_buttons(
			array(
				'social'       => $social,
				'class_second' => $args['class_second'],
				'class_icon'   => $args['class_icon'],
				'class_link'   => $args['class_link'],
				'layout'       => $args['layout'],
				'permalink'    => $permalink,
				'elements'     => $args['elements'],
			)
		);

		return $buttons;
	}

	public static function replace_link( $social, $permalink, $title ) {
		$item         = (array) $social;
		$search       = array( '_permalink_', '_title_' );
		$replace      = array( $permalink, $title );
		$item['link'] = str_replace( $search, $replace, $social->link );

		return (object) $item;
	}

	/**
	 * Set and verify buttons
	 *
	 * @since 3.0.0
	 * @param Array $args
	 * @return String HTML
	 *
	 */
	private static function _set_buttons( $args = array() ) {
		$social       = $args['social'];
		$args_buttons = (object) array(
			'reference'       => $social,
			'prefix'          => WPUSB_App::SLUG,
			'class_second'    => $args['class_second'],
			'class_icon'      => $args['class_icon'],
			'class_link'      => $args['class_link'],
			'layout'          => $args['layout'],
			'elements'        => $args['elements'],
			'permalink'       => $args['permalink'],
			'share_full'      => '',
			'number'          => self::$number,
			'ga'              => apply_filters( WPUSB_App::SLUG . '-ga-event', false, $social ),
			'item_class_icon' => apply_filters(
				WPUSB_App::SLUG . '_item_class_icon',
				"{$social->class_icon}-{$args['layout']}",
				$social
			),
		);
		$item = $args_buttons->reference;

		if ( $item->element === 'messenger' ) {
			$args_buttons->reference->popup = str_replace( '_permalink_', $args_buttons->permalink, $item->popup );
		}

		$buttons = self::get_content_by_layout( $args_buttons, 'items' );

		return apply_filters( WPUSB_App::SLUG . '-set-buttons-html', $buttons, $args_buttons );
	}

	/**
	 * Get buttons
	 *
	 * @since 3.7.0
	 * @version 2.0.0
	 * @param array $args
	 * @return String
	 */
	public static function get_buttons( $args = array(), $fixed = false ) {
		$model             = WPUSB_Setting::get_instance();
		$args              = apply_filters( WPUSB_App::SLUG . 'buttons-args', $args );
		$args['layout']    = self::get_layout( $args, $model->layout, $fixed );
		$args['is_fixed']  = $fixed;
		$args['permalink'] = ( $args['url'] ) ? $args['url'] : WPUSB_Utils::get_real_permalink( $fixed, $args['is_widget'] );
		$args['title']     = ( $args['title'] ) ? $args['title'] : WPUSB_Utils::get_real_title( $fixed, $args['is_widget'] );
		$hash              = WPUSB_Utils::get_hash( $args );

		if ( $hash && isset( self::$instances[ $hash ] ) ) {
			return self::$instances[ $hash ];
		}

		$elements     = WPUSB_Social_Elements::social_media();
		$social_items = self::get_social_media( $model, $args['items'] );
		$buttons      = self::get_buttons_open( $args, $model );
		$share_modal  = false;

		foreach ( $social_items as $item ) :
			if ( ! isset( $elements->{$item} ) ) {
				continue;
			}

			self::$count_elements++;

			if ( 'share' === $item ) {
				self::$number += 1;
				$share_modal = true;
			}

			$buttons .= self::set_buttons_args( $elements->{$item}, $args, $args['permalink'], $args['title'] );
		endforeach;

		self::$count_elements = 0;

		$buttons         .= self::get_content_by_layout( (object) $args, 'end' );
		$buttons_section = WPUSB_Shares_View::get_buttons_section( $buttons, $share_modal, $args, self::$number );
		$html_buttons    = WPUSB_Utils::minify_html( $buttons_section );

		self::$instances[ $hash ] = $html_buttons;

		return apply_filters( WPUSB_App::SLUG . '_html_buttons', $html_buttons, $elements, $args );
	}

	/**
	 * Get social media items active
	 *
	 * @since 3.7.0
	 * @version 1.1.0
	 * @param Object Model | false $model
	 * @param Mixed Array|String $items
	 * @return Array
	 */
	public static function get_social_media( $model = false, $items = '' ) {
		if ( ! empty( $items ) ) {
			return self::get_selected_items( $items );
		}

		if ( ! $model ) {
			$model = WPUSB_Setting::get_instance();
		}

		$social_media = $model->social_media;

		if ( isset( $social_media['order'] ) ) {
			unset( $social_media['order'] );
		}

		return (array) $social_media;
	}

	/**
	 * Get social media items active by the user
	 *
	 * @since 3.7.0
	 * @version 1.0.0
	 * @param Mixed Array|String $items
	 * @return Array
	 */
	public static function get_selected_items( $items ) {
		if ( is_array( $items ) ) {
			return $items;
		}

		$items = preg_replace( '/[^a-z,]+/', '', strtolower( $items ) );

		return explode( ',', $items );
	}

	/**
	 * Set social media items active
	 *
	 * @since 3.2.2
	 * @version 1.0.0
	 * @param array $social_media
	 * @return Void
	 */
	private static function _set_social_media( $social_media ) {
		if ( isset( $social_media['order'] ) ) {
			unset( $social_media['order'] );
		}

		self::$social_media = (array) $social_media;
	}

	public static function get_layout( $args, $layout, $fixed ) {
		if ( $fixed ) {
			return self::$layout_fixed;
		}

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
	public static function get_buttons_open( $atts, $model ) {
		$args = array(
			'custom_class'   => $model->class,
			'layout'         => ( $atts['layout'] ) ? $atts['layout'] : 'default',
			'prefix'         => WPUSB_App::SLUG,
			'position_fixed' => ( $model->position_fixed ) ? WPUSB_App::SLUG . '-' . $model->position_fixed : '',
			'remove_counter' => $atts['elements']['remove_counter'],
			'remove_inside'  => $atts['elements']['remove_inside'],
			'permalink'      => $atts['permalink'],
			'title'          => $atts['title'],
			'header_title'   => ( '' !== $atts['header_title'] ) ? $atts['header_title'] : WPUSB_Utils::option( 'title' ),
		);

		unset( $atts['elements'] );

		$args    = (object) array_merge( $atts, $args );
		$buttons = self::get_content_by_layout( $args, 'init' );

		return apply_filters( WPUSB_App::SLUG . '-init-buttons-html', $buttons, $args );
	}

	/**
	 * Create nonce from ajax counter share
	 *
	 * @since 3.0.0
	 * @param String $action
	 * @return String
	 *
	 */
	public static function nonce( $action ) {
		$nonce = wp_create_nonce( $action );

		return WPUSB_Utils::rm_tags( $nonce );
	}

	/**
	 * Arguments for content buttons start
	 *
	 * @since 3.0.0
	 * @param empty
	 * @return Array
	 *
	 */
	public static function content_args( $atts ) {
		$args = array(
			'nonce'     => self::nonce( WPUSB_Setting::NONCE_SHARING_REPORT ),
			'prefix'    => WPUSB_App::SLUG,
			'post_id'   => WPUSB_Utils::get_reference_id(),
			'permalink' => $atts->permalink,
			'title'     => $atts->title,
			'fixed_top' => self::data_fixed_top( WPUSB_App::SLUG ),
			'is_term'   => ( WPUSB_Utils::is_archive_category() ) ? 1 : 0,
		);

		return apply_filters( WPUSB_Utils::add_prefix( '-content-args' ), $args, $atts );
	}

	/**
	 * Get data element fixed top
	 *
	 * @since 3.0.0
	 * @param String $prefix
	 * @return String
	 *
	 */
	public static function data_fixed_top( $prefix ) {
		if ( WPUSB_Utils::is_fixed_top() ) {
			return sprintf( 'data-element="%s-fixed-top"', $prefix );
		}

		return '';
	}

	/**
	 * Verfy type and return links from icons
	 *
	 * @since 3.0
	 * @since 3.31
	 * @param Object $network
	 * @return String
	 */
	public static function link_type( $network ) {
		$attr_link = sprintf( 'href="%s" target="%s"', $network->link, $network->target );

		return apply_filters( WPUSB_Utils::add_prefix( '-attr-link' ), $attr_link, $network->link, $network->element );
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
	 */
	public static function is_inactive_couter( $atts ) {
		$args           = (object) $atts;
		$remove_counter = $args->remove_counter;
		$disabled_count = WPUSB_Utils::option( 'disabled_count', false, 'intval' );

		return ( '' !== $remove_counter ) ? $remove_counter : $disabled_count;
	}

	/**
	 * Verify is active title
	 *
	 * @since 3.0.0
	 * @param Array $atts
	 * @return Boolen
	 *
	 */
	public static function is_inactive_inside( $atts ) {
		$remove_inside   = $atts['remove_inside'];
		$disabled_inside = WPUSB_Utils::option( 'disabled_inside', false, 'intval' );

		return ( '' !== $remove_inside ) ? $remove_inside : $disabled_inside;
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
	public static function get_content_by_layout( $args, $method ) {
		$content = '';

		switch ( $args->layout ) :
			case 'square-plus':
				$content = WPUSB_Square_Plus::$method( $args );
				break;

			case 'default':
			case 'buttons':
			case 'rounded':
			case 'square':
				$content = WPUSB_Layouts_Primary::$method( $args );
				break;

			case 'position_fixed':
				$content = WPUSB_Fixed_Left::$method( $args );
				break;
		endswitch;

		return apply_filters( WPUSB_Utils::add_prefix( "-content-buttons-{$args->layout}" ), $content, $args, $method );
	}

	/**
	 * Set all layouts
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return Array
	 *
	 */
	public static function get_layouts() {
		return array(
			'default'     => __( 'Default', 'wpupper-share-buttons' ),
			'buttons'     => __( 'Button', 'wpupper-share-buttons' ),
			'rounded'     => __( 'Rounded', 'wpupper-share-buttons' ),
			'square'      => __( 'Square', 'wpupper-share-buttons' ),
			'square-plus' => __( 'Square plus', 'wpupper-share-buttons' ),
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
	public static function is_first() {
		if ( self::$count_elements > 1 ) {
			return false;
		}

		return true;
	}

	/**
	 * Add data featured by referrer
	 *
	 * @since 3.0.0
	 * @param Object $atts
	 * @return String
	 *
	 */
	public static function get_data_referrer( $atts ) {
		$opt_referrer = WPUSB_Utils::option( 'referrer', false );

		if ( $opt_referrer === 'yes' ) {
			$attr  = "data-referrer=\"{$atts->reference->element}\"";
			$attr .= " data-ref-title=\"{$atts->reference->inside}\"";

			return $attr;
		}
	}

	/**
	 * Create custom class from icons
	 *
	 * @since 1.0
	 * @param Array $atts
	 * @param Boolean $fixed
	 * @return String
	 */
	public static function buttons_share( $atts = array(), $fixed = false ) {
		if ( WPUSB_Utils::is_disabled_by_meta() ) {
			return;
		}

		$args          = self::sanitize_atts( $atts );
		$buttons_share = self::get_buttons( $args, $fixed );

		return $buttons_share;
	}

	/**
	 * Sanitize atts values
	 *
	 * @since 1.0
	 * @since 3.25
	 * @param Array $atts
	 * @return Array
	 */
	public static function sanitize_atts( $atts = array() ) {
		$class_first    = WPUSB_Utils::isset_get( $atts, 'class_first' );
		$class_second   = WPUSB_Utils::isset_get( $atts, 'class_second' );
		$class_link     = WPUSB_Utils::isset_get( $atts, 'class_link' );
		$class_icon     = WPUSB_Utils::isset_get( $atts, 'class_icon' );
		$layout         = WPUSB_Utils::isset_get( $atts, 'layout' );
		$items          = WPUSB_Utils::isset_get( $atts, 'items' );
		$url            = WPUSB_Utils::isset_get( $atts, 'url' );
		$title          = WPUSB_Utils::isset_get( $atts, 'title' );
		$header_title   = WPUSB_Utils::isset_get( $atts, 'header_title' );
		$remove_inside  = WPUSB_Utils::isset_get( $atts, 'remove_inside' );
		$remove_counter = WPUSB_Utils::isset_get( $atts, 'remove_counter' );
		$is_widget      = WPUSB_Utils::isset_get( $atts, 'is_widget' );

		return array(
			'class_first'  => WPUSB_Utils::esc_class( $class_first ),
			'class_second' => WPUSB_Utils::esc_class( $class_second ),
			'class_link'   => WPUSB_Utils::esc_class( $class_link ),
			'class_icon'   => WPUSB_Utils::esc_class( $class_icon ),
			'layout'       => WPUSB_Utils::rm_tags( $layout ),
			'items'        => WPUSB_Utils::rm_tags( $items ),
			'url'          => rawurlencode( esc_url( $url ) ),
			'title'        => WPUSB_Utils::rm_tags( $title ),
			'header_title' => WPUSB_Utils::rm_tags( $header_title ),
			'is_widget'    => (bool) $is_widget,
			'elements'     => array(
				'remove_inside'  => WPUSB_Utils::rm_tags( $remove_inside ),
				'remove_counter' => WPUSB_Utils::rm_tags( $remove_counter ),
			),
		);
	}

	/**
	 * Add filter on inside html buttons
	 *
	 * @since 3.17
	 * @param Object $args
	 * @param String $content
	 * @return String
	 */
	public static function filter_inside( $args, $content = '' ) {
		return apply_filters( WPUSB_App::SLUG . '-inside-html', $content, $args );
	}

	public static function get_modal_data_id( $element, $number ) {
		return ( 'share' === $element ) ? "data-modal-id=\"{$number}\"" : '';
	}

	public static function render_modal( $args, $number ) {
		$modal_init = WPUSB_Modal::init( $args, $number );
		$modal      = WPUSB_Utils::minify_html( $modal_init );

		return apply_filters( WPUSB_Utils::add_prefix( '_rendered_modal' ), $modal, $args );
	}
}

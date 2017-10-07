<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @since 3.1.2
 * @subpackage Social Icons Display
 * @version 2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
}

class WPUSB_Shares_View {

	public static function buttons_share( $atts = array(), $fixed = false ) {
		return WPUSB_Utils::buttons_share( $atts, $fixed );
	}

	public static function render_meta_box( $post ) {
		$is_disabled = WPUSB_Utils::is_disabled_by_meta( $post->ID );

		printf(
			'<input type="checkbox"
			        value="yes"
			        id="%1$s"
			        name="%1$s" %3$s>
			<label for="%1$s">
				%2$s
			</label>',
			WPUSB_Setting::META_KEY,
			__( 'Disable on this post', 'wpupper-share-buttons' ),
			checked( $is_disabled, true, false )
		);
	}

	public static function get_buttons_section( $buttons, $share_modal, $args, $number ) {
		$prefix = WPUSB_App::SLUG;

		if ( ! $share_modal || ! apply_filters( "{$prefix}_show_modal", true ) ) {
			return $buttons;
		}

		$modal     = WPUSB_Utils::render_modal( $args, $number );
		$component = WPUSB_Utils::get_component( 'buttons-section' );

		return <<<EOD
			<div {$component}>
				{$buttons}
				{$modal}
			</div>
EOD;
	}

	public static function get_header_title( $atts ) {
		if ( empty( $atts->header_title ) ) {
			return '';
		}

		return <<<EOD
	    <div class="{$atts->prefix}-title">
	     	<span>{$atts->header_title}</span>
	     </div>
EOD;
	}

	public static function get_css_buttons_styles( $options, $widget_id = '' ) {
		$css        = '';
		$css       .= self::get_css_icons( $options, $widget_id );
		$css       .= self::get_css_btn_inside( $options, $widget_id );
		$css       .= self::get_css_counts_color( $options, $widget_id );
		$css       .= self::get_css_counts_bg_color( $options, $widget_id );
		$css       .= self::get_css_bg_color( $options, $widget_id );

		return $css;
	}

	public static function get_css_icons( $options, $widget_id = '' ) {
		$prefix      = WPUSB_App::SLUG;
		$color       = WPUSB_Utils::get_css_icons_color( $options );
		$size        = WPUSB_Utils::get_css_icons_size( $options );
		$color_hover = '';

		if ( empty( $color ) && empty( $size ) ) {
			return '';
		}

		$prefix_first = $prefix;

		if ( false !== strpos( $widget_id, 'follow' ) ) {
			$prefix_first = "{$prefix}-follow";
		}

		return <<<EOD
		{$widget_id} .{$prefix_first} .{$prefix}-item .{$prefix}-btn i {
			{$color}
			{$size}
		}
		{$widget_id} .{$prefix_first} .{$prefix}-item .{$prefix}-btn i:hover {
			{$color}
			{$size}
		}
EOD;
	}

	public static function get_css_btn_inside( $options, $widget_id = '' ) {
		$btn_inside = WPUSB_Utils::get_css_btn_inside( $options );
		$prefix     = WPUSB_App::SLUG;

		if ( empty( $btn_inside ) ) {
			return '';
		}

		return <<<EOD
		{$widget_id} .{$prefix} .{$prefix}-item .{$prefix}-btn-inside {
			color: {$btn_inside};
		}
EOD;
	}

	public static function get_css_counts_color( $options, $widget_id = '' ) {
		$counts_color = WPUSB_Utils::get_css_counts_color( $options );
		$prefix       = WPUSB_App::SLUG;

		if ( empty( $counts_color ) ) {
			return '';
		}

		return <<<EOD
		{$widget_id} .{$prefix} .{$prefix}-item .{$prefix}-counts,
		{$widget_id} .{$prefix} .{$prefix}-item .{$prefix}-count,
		{$widget_id} .{$prefix} .{$prefix}-total-share {
			color: {$counts_color};
		}
EOD;
	}

	public static function get_css_counts_bg_color( $options, $widget_id = '' ) {
		$bg_color = WPUSB_Utils::get_css_counts_bg_color( $options );
		$prefix   = WPUSB_App::SLUG;

		if ( empty( $bg_color ) ) {
			return '';
		}

		return <<<EOD
		{$widget_id} .{$prefix} .{$prefix}-item .{$prefix}-counter,
		{$widget_id} .{$prefix} .{$prefix}-item .{$prefix}-count {
			background-color: {$bg_color};
		}
		{$widget_id} .{$prefix} .{$prefix}-item .{$prefix}-counter:after,
		{$widget_id} .{$prefix} .{$prefix}-item .{$prefix}-count:after {
			border-color: transparent {$bg_color} transparent transparent;
		}
EOD;
	}

	public static function get_css_bg_color( $options, $widget_id = '' ) {
		$bg_color  = WPUSB_Utils::get_css_bg_color( $options );
		$btn_hover = self::get_css_btn_hover();
		$prefix    = WPUSB_App::SLUG;

		if ( empty( $bg_color ) ) {
			return '';
		}

		return <<<EOD
		{$widget_id} .{$prefix}-buttons .{$prefix}-item .{$prefix}-btn,
		{$widget_id} .{$prefix}-square-plus .{$prefix}-item .{$prefix}-btn,
		{$widget_id} .{$prefix}-fixed .{$prefix}-item .{$prefix}-btn {
		    background-color: {$bg_color};
		}

		{$widget_id} .{$prefix}-buttons .{$prefix}-item .{$prefix}-btn:hover,
		{$widget_id} .{$prefix}-square-plus .{$prefix}-item .{$prefix}-btn:hover,
		{$widget_id} .{$prefix}-fixed .{$prefix}-item .{$prefix}-btn:hover {
		    background-color: {$bg_color};
		}

		{$widget_id} #{$prefix}-container-buttons .{$prefix}-item .{$prefix}-btn,
		{$widget_id} #{$prefix}-container-square-plus .{$prefix}-item .{$prefix}-btn {
			-moz-box-shadow: 0 2px {$bg_color};
			-webkit-box-shadow: 0 2px {$bg_color};
			box-shadow: 0 2px {$bg_color};
		}

		{$widget_id} #{$prefix}-container-buttons .{$prefix}-item .{$prefix}-btn:active,
		{$widget_id} #{$prefix}-container-square-plus .{$prefix}-item .{$prefix}-btn:active {
			-moz-box-shadow: none;
			-webkit-box-shadow: none;
			box-shadow: none;
		}

		{$btn_hover}
EOD;
	}

	public static function get_css_btn_hover() {
		$prefix = WPUSB_App::SLUG;

		return <<<EOD
		.{$prefix} .{$prefix}-item .{$prefix}-btn:hover {
			filter: alpha(opacity=80);
			-moz-opacity: 0.8;
			opacity: 0.8;
			zoom: 1;
		}
EOD;
	}
}

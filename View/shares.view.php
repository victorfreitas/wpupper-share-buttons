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
	exit(0);
}

class WPUSB_Shares_View {

	public static function buttons_share( $atts = array(), $fixed = false ) {
		return WPUSB_Utils::buttons_share( $atts, $fixed );
	}

	public static function get_buttons_section( $buttons, $share_modal, $args, $number ) {
		$prefix = WPUSB_App::SLUG;

		if ( ! $share_modal || ! apply_filters( "{$prefix}_show_modal", true ) ) {
			return $buttons;
		}

		$modal = WPUSB_Utils::render_modal( $args, $number );

		return <<<EOD
			<div data-{$prefix}-component="buttons-section">
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

	public static function get_css_icons_size( $icons_size, $number = false, $layout = '' ) {
		$prefix = WPUSB_App::SLUG;
		$size   = absint( $icons_size );
		$id     = ".{$prefix}";

		if ( false !== $number ) {
			$id = "#widget-{$prefix}-{$number}";
		}

		return <<<EOD
			{$id} .{$prefix}-item a i {
			    font-size: {$size}px;
			}
EOD;
	}

	public static function get_css_icons_color( $option = array() ) {
		$background = WPUSB_Utils::get_custom_background_color_icons( $option );
		$color      = WPUSB_Utils::get_custom_color_icons( $option );
		$colors     = WPUSB_Utils::get_validate_color_icons( $color, $background );

		if ( empty( $color ) && empty( $background ) ) {
			return '';
		}

		return self::get_custom_css_buttons( $colors[0], $background, $colors[1] );
	}

	public static function get_widget_css_icons_color( $number, $color, $background ) {
		$prefix = WPUSB_App::SLUG;

		if ( empty( $color ) && empty( $background ) ) {
			return '';
		}

		$colors = WPUSB_Utils::get_validate_color_icons( $color, $background );
		$id     = "#widget-{$prefix}-{$number}";

		return self::get_custom_css_buttons( $colors[0], $background, $colors[1], $id );
	}

	public static function get_custom_css_buttons( $color, $background, $icon_color, $id_widget = '' ) {
		$prefix         = WPUSB_App::SLUG;
		$background_css = self::get_css_icons_background( $background, $id_widget );
		$btn_hover_css  = self::get_css_btn_hover();

		if ( empty( $color ) && empty( $background ) ) {
			return '';
		}

		return <<<EOD
			{$background_css}
			{$id_widget} .{$prefix} .{$prefix}-item i {
			  color: {$color};
			}

			#{$prefix}-container-buttons .{$prefix}-item a,
			#{$prefix}-container-square-plus .{$prefix}-item a {
				-moz-box-shadow: 0 2px #545454;
				-webkit-box-shadow: 0 2px #545454;
				box-shadow: 0 2px #545454;
			}

			#{$prefix}-container-buttons .{$prefix}-item a:active,
			#{$prefix}-container-square-plus .{$prefix}-item a:active {
				-moz-box-shadow: none;
				-webkit-box-shadow: none;
				box-shadow: none;
			}

			{$btn_hover_css}
EOD;
	}

	public static function get_css_icons_background( $background, $id_widget ) {
		$prefix = WPUSB_App::SLUG;

		if ( empty( $background ) ) {
			return '';
		}

		return <<<EOD
			{$id_widget} #{$prefix}-container-buttons .{$prefix}-item a,
			{$id_widget} #{$prefix}-container-square-plus .{$prefix}-item a,
			{$id_widget} #{$prefix}-container-fixed .{$prefix}-item a {
				background-color: {$background};
			}
EOD;
	}

	public static function get_css_btn_hover() {
		$prefix = WPUSB_App::SLUG;

		return <<<EOD
			.{$prefix} .{$prefix}-item a:hover {
				filter: alpha(opacity=80);
				opacity: 0.8;
				zoom: 1;
			}
EOD;
	}
}
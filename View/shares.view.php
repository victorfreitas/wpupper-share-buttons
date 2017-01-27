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
		$option_layout   = WPUSB_Utils::option( 'layout' );
		$layout_id       = ( 'buttons' === $option_layout ) ? "-{$option_layout}" : '';
		$prefix          = WPUSB_App::SLUG;
		$size            = absint( $icons_size );
		$id              = "{$prefix}-container{$layout_id}";
		$id_fixed        = ",#{$prefix}-container-fixed .{$prefix}-item a:not(.{$prefix}-default) i";

		if ( false !== $number ) {
			$id       = "widget-{$prefix}-{$number}";
			$id_fixed = '';
		}

		$size_icon_share = self::get_css_icon_share_square( $id, $prefix, $size );

		if ( ! empty( $layout ) && $layout === 'square-plus' || empty( $layout ) && $option_layout === 'square-plus' ) {
			return <<<EOD
				#{$id} .{$prefix}-item a i {
				    font-size: {$size}px;
				}
				{$size_icon_share}
EOD;
		}

		$print_size = ( $size - 5 );
		$smal_size  = ( $size + 6 );

		return <<<EOD
			#{$id} .{$prefix}-item a:not(.{$prefix}-default) i{$id_fixed} {
			    font-size: {$size}px;
			    height: {$size}px;
			    line-height: initial;
			    width: {$size}px;
			}

			#{$id} .{$prefix}-item a:not(.{$prefix}-default) .{$prefix}-icon-email-square {
				font-size: {$smal_size}px;
			}

			#{$id} .{$prefix}-printer a:not(.{$prefix}-default) i {
				font-size: {$print_size}px;
				line-height: {$size}px;
			}

			#{$id} .{$prefix}-item a:not(.{$prefix}-default) .{$prefix}-icon-reddit-square {
				font-size: {$smal_size}px;
			}

			#{$id} .{$prefix}-item a:not(.{$prefix}-default) .{$prefix}-icon-share-square {
				font-size: {$smal_size}px;
			}

			{$size_icon_share}
EOD;
	}

	public static function get_css_icon_share_square( $id, $prefix, $size ) {
		$size = ( $size + 5 );

		return <<<EOD
			#{$id} .{$prefix}-item a .{$prefix}-icon-share-square {
				font-size: {$size}px;
			}
EOD;
	}

	public static function get_css_icons_color( $option = array() ) {
		$prefix = WPUSB_App::SLUG;
		$color  = '';

		if ( isset( $option['icons_color'] ) ) {
			$color = WPUSB_Utils::rm_tags( $option['icons_color'] );
		}

		if ( empty( $option ) ) {
			$color = WPUSB_Utils::option( 'icons_color' );
		}

		if ( empty( $color ) ) {
			return '';
		}

		return <<<EOD
			#{$prefix}-container i {
			  color: {$color};
			}

			#{$prefix}-container-buttons .{$prefix}-item a,
			#{$prefix}-container-square-plus .{$prefix}-item a,
			#{$prefix}-container-fixed .{$prefix}-item a {
				background-color: {$color};
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

			#{$prefix}-container-square-plus .{$prefix}-item i,
			#{$prefix}-container-buttons .{$prefix}-item i,
			#{$prefix}-container-fixed .{$prefix}-item i {
				color: #fff;
			}

			#{$prefix}-container-fixed .{$prefix}-counts {
				border-bottom: 1px dotted #ebebeb;
			}

			#{$prefix}-container .{$prefix}-printer i:not(.{$prefix}-icon-printer-default),
			#{$prefix}-container .{$prefix}-icon-like-square,
			#{$prefix}-container .{$prefix}-icon-like-rounded,
			#{$prefix}-container .{$prefix}-icon-viber-rounded {
				background: {$color};
				color: #fff;
			}

			#{$prefix}-container .{$prefix}-icon-whatsapp-square {
				box-shadow: 0px 0px 0px 5px #303030 inset;
			}

			.{$prefix} .{$prefix}-item a:hover {
				filter: alpha(opacity=80);
				opacity: 0.8;
				zoom: 1;
			}
EOD;
	}

	public static function get_widget_css_icons_color( $number, $color ) {
		$prefix = WPUSB_App::SLUG;

		if ( empty( $color ) ) {
			return '';
		}

		$id = "widget-{$prefix}-{$number}";

		return <<<EOD
			#{$id} .{$prefix}-item i {
			  color: {$color};
			}

			#{$id} .{$prefix}-buttons .{$prefix}-item a,
			#{$id} .{$prefix}-square-plus .{$prefix}-item a {
				background-color: {$color};
				-moz-box-shadow: 0 2px #545454;
				-webkit-box-shadow: 0 2px #545454;
				box-shadow: 0 2px #545454;
			}

			#{$id} .{$prefix}-buttons .{$prefix}-item a:active,
			#{$id} .{$prefix}-square-plus .{$prefix}-item a:active {
				-moz-box-shadow: none;
				-webkit-box-shadow: none;
				box-shadow: none;
			}

			#{$id} .{$prefix}-square-plus .{$prefix}-item i,
			#{$id} .{$prefix}-buttons .{$prefix}-item i {
			  color: #fff;
			}

			#{$id} .{$prefix}-rounded .{$prefix}-printer i,
			#{$id} .{$prefix}-square .{$prefix}-printer i,
			#{$id} .{$prefix}-item .{$prefix}-icon-like-square,
			#{$id} .{$prefix}-item .{$prefix}-icon-like-rounded,
			#{$id} .{$prefix}-item .{$prefix}-icon-viber-rounded  {
				background: {$color};
				color: #fff;
			}

			#{$id} #{$prefix}-container .{$prefix}-icon-whatsapp-square {
				box-shadow: 0px 0px 0px 5px #303030 inset;
			}

			.{$prefix} .{$prefix}-item a:hover {
				filter: alpha(opacity=80);
				opacity: 0.8;
				zoom: 1;
			}
EOD;
	}
}
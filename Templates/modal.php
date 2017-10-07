<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @since 3.0.0
 * @subpackage Social Icons Display
 * @version 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
}

class WPUSB_Modal {

	/**
	 * The buttons container popup
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return Void
	 */
	public static function init( $atts = array(), $number = 0 ) {
		if ( ! intval( $number ) ) {
			return;
		}

		$prefix = WPUSB_App::SLUG;
		$items  = self::items( $prefix, $atts );
		$end    = self::end();

		return <<<EOD
			<div class="{$prefix}-modal-mask"
				 data-element="{$prefix}-modal-{$number}"
			     style="display:none;">

				<a class="{$prefix}-btn-close" data-action="close-popup">
					<i class="{$prefix}-icon-close"></i>
				</a>
			</div>
			<div class="{$prefix}-modal-networks"
			     data-element="{$prefix}-modal-container-{$number}">
			{$items}
			{$end}
EOD;
	}

	/**
	 * The items social popup
	 *
	 * @since 3.0.0
	 * @param String $prefix
	 * @return Void
	 */
	public static function items( $prefix, $atts ) {
		$elements  = WPUSB_Social_Elements::social_media();
		$permalink = apply_filters( "{$prefix}-modal-permalink", WPUSB_Utils::isset_get( $atts, 'permalink' ) );
		$title     = apply_filters( "{$prefix}-modal-title", WPUSB_Utils::isset_get( $atts, 'title' ) );
		$class_btn = WPUSB_Utils::get_class_btn();
		$items     = '';

		foreach ( $elements as $key => $social ) {
			if ( $key === 'share' ) {
				continue;
			}

			$ga        = apply_filters( "{$prefix}-ga-event", false, $social );
			$ga_event  = ( $ga ) ? 'onClick="' . $ga . ';"' : '';

			if ( $permalink || $title ) {
				$social = WPUSB_Utils::replace_link( $social, $permalink, $title );
			}

			$link_attr = WPUSB_Utils::link_type( $social );

			if ( $social->element === 'messenger' ) {
				$social->popup = str_replace( '_permalink_', $permalink, $social->popup );
			}

			$items .= <<<EOD
				<div class="{$prefix}-element-popup {$prefix}-item-{$social->element}">
					<a {$link_attr}
					   class="{$social->class_link}-popup {$class_btn} {$social->class}-popup"
					   rel="nofollow"
					   title="{$social->title}"
					   {$ga_event}
					   {$social->popup}>

						<i class="{$social->class_icon} {$prefix}-icon-popup"></i>
						<span class="{$prefix}-name-popup" data-name="{$social->name}"></span>
					</a>
				</div>
EOD;
		}

		return $items;
	}

	/**
	 * Close buttons container popup
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return Void
	 */
	public static function end() {
		return '</div>';
	}
}

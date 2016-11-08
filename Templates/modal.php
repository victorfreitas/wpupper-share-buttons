<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @since 3.0.0
 * @subpackage Social Icons Display
 * @version 1.0
 */
if ( ! function_exists( 'add_action' ) ) {
	exit(0);
}

use WPUSB_Utils as Utils;
use WPUSB_App as App;
use WPUSB_Setting as Setting;
use WPUSB_Social_Elements as Elements;
use WPUSB_Core as Core;

class WPUSB_Modal {

	/**
	 * The buttons container popup
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return Void
	 */
	public static function init() {
		$prefix    = App::SLUG;
		$component = Utils::get_component_by_type( 'modal' );

		do_action( App::SLUG . '-before-modal' );

		echo <<< EOD
			<div class="{$prefix}-modal-mask"
			     {$component}
			     style="display:none;">

				<a class="{$prefix}-btn-close" data-action="close-popup">
					<i class="{$prefix}-icon-close"></i>
				</a>
			</div>
			<div class="{$prefix}-modal-networks">
EOD;
		self::items( $prefix );
		self::end();

		do_action( App::SLUG . '-after-modal' );
	}

	/**
	 * The items social popup
	 *
	 * @since 3.0.0
	 * @param String $prefix
	 * @return Void
	 */
	public static function items( $prefix ) {
		$elements    = Elements::social_media();
		$r_permalink = ( Utils::is_home() ) ? '' : Utils::get_real_permalink();
		$r_title     = ( $r_permalink ) ? Utils::get_real_title() : '';
		$permalink   = apply_filters( App::SLUG . '-modal-permalink', $r_permalink );
		$title       = apply_filters( App::SLUG . '-modal-title', $r_title );

		foreach ( $elements as $key => $social ) {
			if ( $key === 'share' ) {
				continue;
			}

			$ga        = apply_filters( App::SLUG . '-ga-event', false, $social );
			$ga_event  = ( $ga ) ? 'onClick="' . $ga . ';"' : '';

			if ( $permalink || $title ) {
				$social = Utils::replace_link( $social, $permalink, $title );
			}

			$link_attr = Utils::link_type( $social->link );

			echo <<<EOD
				<div class="{$prefix}-element-popup">
					<a {$link_attr}
					   class="{$social->class_link}-popup {$social->class}-popup"
					   target="_blank"
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
	}

	/**
	 * Close buttons container popup
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return Void
	 */
	public static function end() {
		echo '</div>';
	}
}
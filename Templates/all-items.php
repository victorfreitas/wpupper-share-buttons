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

class WPUSB_All_Items
{
	/**
	 * The buttons container popup
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return Void
	 */
	public static function init()
	{
		$social = Utils::get_social_media();

		if ( ! isset( $social['share'] ) ) {
			return;
		}

		$permalink = Utils::get_permalink();
		$prefix    = Setting::PREFIX;

		echo <<< EOD
			<div class="{$prefix}-popup-content"
			     data-element-url="{$permalink}"
			     data-display="{$prefix}-none"
			     data-component="social-popup">
				<div class="{$prefix}-networks">
					<a class="{$prefix}-btn-close" data-action="close-popup">
						<i class="{$prefix}-icon-close"></i>
					</a>
EOD;
		self::items( $prefix );
		self::end();
	}

	/**
	 * The items social popup
	 *
	 * @since 3.0.0
	 * @param String $prefix
	 * @return Void
	 */
	public static function items( $prefix )
	{
		$elements  = Elements::social_media();
		$permalink = Utils::get_real_permalink();
		$title     = Utils::get_real_title();

		foreach ( $elements as $key => $social ) {
			if ( $key === 'share' ) {
				continue;
			}

			$social = Utils::replace_link( $social, $permalink, $title );

			echo <<< EOD
				<div class="{$prefix}-element-popup">
					<a href="{$social->link}"
					   class="{$social->class_link}-popup {$social->class}-popup"
					   rel="nofollow"
					   data-action="open-popup">
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
	public static function end()
	{
		echo "</div></div>";
	}
}
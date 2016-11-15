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

class WPUSB_Modal {

	/**
	 * The buttons container popup
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return Void
	 */
	public static function init() {
		$prefix    = WPUSB_App::SLUG;
		$component = WPUSB_Utils::get_component_by_type( 'modal' );

		do_action( WPUSB_App::SLUG . '-before-modal' );

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

		do_action( WPUSB_App::SLUG . '-after-modal' );
	}

	/**
	 * The items social popup
	 *
	 * @since 3.0.0
	 * @param String $prefix
	 * @return Void
	 */
	public static function items( $prefix ) {
		$elements    = WPUSB_Social_Elements::social_media();
		$r_permalink = ( WPUSB_Utils::is_home() ) ? '' : WPUSB_Utils::get_real_permalink();
		$r_title     = ( $r_permalink ) ? WPUSB_Utils::get_real_title() : '';
		$permalink   = apply_filters( WPUSB_App::SLUG . '-modal-permalink', $r_permalink );
		$title       = apply_filters( WPUSB_App::SLUG . '-modal-title', $r_title );

		foreach ( $elements as $key => $social ) {
			if ( $key === 'share' ) {
				continue;
			}

			$ga        = apply_filters( WPUSB_App::SLUG . '-ga-event', false, $social );
			$ga_event  = ( $ga ) ? 'onClick="' . $ga . ';"' : '';

			if ( $permalink || $title ) {
				$social = WPUSB_Utils::replace_link( $social, $permalink, $title );
			}

			$link_attr = WPUSB_Utils::link_type( $social->link );

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
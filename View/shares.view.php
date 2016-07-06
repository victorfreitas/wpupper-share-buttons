<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @since 3.1.2
 * @subpackage Social Icons Display
 * @version 1.0
 */

if ( ! function_exists( 'add_action' ) )
	exit(0);

class WPUSB_Shares_View
{
	/**
	 * Create custom buttons
	 *
	 * @since 3.1.2
	 * @param Array $atts
	 * @return String
	 */
	public static function buttons_share( $atts = array() )
	{
		return WPUSB_Utils::buttons_share( $atts );
	}
}
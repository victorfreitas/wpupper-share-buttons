<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @since 3.1.2
 * @subpackage Social Icons Display
 * @version 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

class WPUSB_Shares_View {

	/**
	 * Create custom buttons
	 *
	 * @since 3.1.2
	 * @param Array $atts
	 * @return String
	 */
	public static function buttons_share( $atts = array() ) {
		return WPUSB_Utils::buttons_share( $atts );
	}

	/**
	 * The title above share buttons
	 *
	 * @since 3.23
	 * @version 1.0
	 * @param Object $atts
	 * @return String
	 *
	 */
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
}
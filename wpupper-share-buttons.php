<?php
/**
 * @package WPUpper Share Buttons
 * @author Victor Freitas
 *
 * Plugin Name: WPUpper Share Buttons
 * Plugin URI:  https://github.com/victorfreitas/wpupper-share-buttons
 * Version:     3.26
 * Author:      Victor Freitas
 * Author URI:  https://github.com/victorfreitas
 * License:     GPL2
 * Text Domain: wpupper-share-buttons
 * Domain Path: /languages
 * Description: Insert share buttons of social networks. The buttons are inserted automatically or can be called via shortcode or php method.
 *
 #═════════════════════════════════════════════════════════════════════════════════════#
 ║ This program is free software; you can redistribute it and/or                       ║
 ║ modify it under the terms of the GNU General Public License                         ║
 ║ as published by the Free Software Foundation; either version 2                      ║
 ║ of the License, or (at your option) any later version.                              ║
 ║                                                                                     ║
 ║ This program is distributed in the hope that it will be useful,                     ║
 ║ but WITHOUT ANY WARRANTY; without even the implied warranty of                      ║
 ║ MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                       ║
 ║ GNU General Public License for more details.                                        ║
 ║                                                                                     ║
 ║ You should have received a copy of the GNU General Public License                   ║
 ║ along with this program; if not, write to the Free Software                         ║
 ║ Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.     ║
 ║                                                                                     ║
 ║    By Victor Freitas (victorfreitasdev@gmail.com)                                   ║
 ║                                                                                     ║
 ║ Copyright 2015-2016 WPUpper Share Buttons                                           ║
 #═════════════════════════════════════════════════════════════════════════════════════#
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

class WPUSB_App {

    /**
     * The short slug
     *
     * @var String
     */
	const SLUG = 'wpusb';

    /**
     * Text domain real dir name
     *
     * @var String
     */
	const TEXTDOMAIN = 'wpupper-share-buttons';

    /**
     * Plugin name
     *
     * @var String
     */
	const NAME = 'WPUpper Share Buttons';

    /**
     * Initial file path
     *
     * @var String
     */
	const FILE = __FILE__;

    /**
     * Version
     *
     * @var String
     */
	const VERSION = '3.26';

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 2.0
	 * @return Void
	 */
	public static function uses( $class, $location ) {
		$extension = 'php';
		$sep       = DIRECTORY_SEPARATOR;
		$root      = dirname( __FILE__ );

		if ( $location === 'View' ||  $location === 'Controller' ) {
			$extension = strtolower( $location ) . ".{$extension}";
		}

		require_once( "{$root}{$sep}{$location}{$sep}{$class}.{$extension}" );
	}

	/**
	 * Set is admin property true
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return Void
	 */
	public static function is_admin() {
		return is_admin();
	}
}

WPUSB_App::uses( 'core', 'Config' );
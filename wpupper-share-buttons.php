<?php
/**
 * @package WPUpper Share Buttons
 * @author Victor Freitas
 *
 * Plugin Name: WPUpper Share Buttons
 * Plugin URI:  https://github.com/victorfreitas/wpupper-share-buttons
 * Version:     3.14
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
if ( ! function_exists( 'add_action' ) ) {
	exit(0);
}

define( 'WPUSB_TEXTDOMAIN', 'wpupper-share-buttons' );

function wpusb_load_textdomain() {
	load_plugin_textdomain( WPUSB_TEXTDOMAIN, false, basename( dirname(__FILE__) ) . '/languages' );
}
add_action( 'init', 'wpusb_load_textdomain' );

if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) {
	function wpusb_admin_notices() {
		printf(
			'<div class="notice notice-error">
				<p>%s</p>
			</div>',
			__( 'Could not complete installation of <strong>WPUpper Share Buttons</strong> because your PHP version is less than 5.3.0, please upgrade your PHP version to use the plugin.', WPUSB_TEXTDOMAIN )
		);
	}
	add_action( 'admin_notices', 'wpusb_admin_notices' );

	return;
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
	const VERSION = '3.14';

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 2.0
	 * @return Void
	 */
	public static function uses( $class, $location ) {
		$extension = 'php';
		$sep       = DIRECTORY_SEPARATOR;
		$dirname   = dirname( __FILE__ );

		if ( $location == 'View' ||  $location == 'Controller' ) {
			$extension = strtolower( $location ) . ".{$extension}";
		}

		require_once( "{$dirname}{$sep}{$location}{$sep}{$class}.{$extension}" );
	}

	/**
	 * Automatic list files in
	 * Helpers, Controllers and Templates.
	 *
	 * @since 3.0
	 * @version 2.0
	 * @param Null
	 * @return Array
	 */
	public static function get_files() {
		$root = dirname( __FILE__ );

		if ( defined( 'GLOB_BRACE' ) ) {
			$pattern = "{$root}{/Helper/,/Templates/}*.php";
			return glob( $pattern, GLOB_BRACE );
		}

		$helpers   = glob( "{$root}/Helper/*.php" );
		$templates = glob( "{$root}/Templates/*.php" );

		return array_merge( $helpers, $templates );
	}

	/**
	 * Automatic include files in
	 * Helpers, Controllers and Templates.
	 *
	 * @since 3.0.0
	 * @param Null
	 * @return Void
	 */
	public static function require_files() {
		$files = self::get_files();

		foreach( $files as $key => $file ) {
			require_once( $file );
		}
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

new WPUSB_Core();
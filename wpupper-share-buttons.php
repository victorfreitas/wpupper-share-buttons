<?php
/**
 * @package WPUpper Share Buttons
 * @author Victor Freitas
 *
 * Plugin Name: WPUpper Share Buttons
 * Plugin URI:  https://github.com/victorfreitas/wpupper-share-buttons
 * Version:     3.36.3
 * Author:      Victor Freitas
 * Author URI:  https://github.com/victorfreitas
 * License:     GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: wpupper-share-buttons
 * Domain Path: /languages/
 * Description: Insert share buttons of social networks. The buttons are inserted automatically or can be called via shortcode or php method.
 *
 #═════════════════════════════════════════════════════════════════════════════════════#
 ║ This program is free software; you can redistribute it and/or                       ║
 ║ modify it under the terms of the GNU General Public License                         ║
 ║ as published by the Free Software Foundation; either version 3                      ║
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
 ║ Copyright 2015-2017 WPUpper Share Buttons                                           ║
 #═════════════════════════════════════════════════════════════════════════════════════#
 */
if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit( 0 );
}

class WPUSB_App {

	/**
	 * The short slug
	 *
	 * @var String
	 */
	const SLUG = 'wpusb';

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
	const VERSION = '3.36.3';

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 2.0
	 * @since 3.32
	 * @return Void
	 */
	public static function uses( $class, $location ) {
		$locations = array(
			'View'       => 1,
			'Controller' => 1,
		);

		$extension = isset( $locations[ $location ] ) ? strtolower( $location ) . '.php' : 'php';
		$path      = "/{$class}.{$extension}";
		$file      = dirname( __FILE__ ) . '/' . $location . $path;

		if ( $location === 'Templates' ) {
			$file = WPUSB_Utils::get_template_located( $file, $path, $class );
		}

		require_once $file;
	}
}

// If supported PHP version init core or admin notice if not supported
if ( version_compare( PHP_VERSION, '5.2.4', '>=' ) ) {
	WPUSB_App::uses( 'core', 'Config' );
} else {
	function wpusb_not_supported_php_version() {
	?>
		<div class="error notice is-dismissible">
			<p>
				<strong>
					<?php echo WPUSB_App::NAME; ?>
				</strong>
				<?php
					_e( 'It does not support your PHP version. Please, install a version greater than or equal to 5.2.4.', 'wpupper-share-buttons' );
				?>
			</p>
		</div>
	<?php
	}
	add_action( 'admin_notices', 'wpusb_not_supported_php_version' );
}

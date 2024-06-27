<?php
/**
 * Plugin Name: WPUpper Share Buttons
 * Plugin URI:  https://github.com/victorfreitas/wpupper-share-buttons
 * Description: The social share buttons. The buttons are inserted automatically, beautifully.
 * Author:      Victor Freitas
 * Author URI:  https://www.linkedin.com/in/viktorfreitas/
 * Version:     3.43
 * License:     GPLv3
 * Text Domain: wpupper-share-buttons
 * Domain Path: /languages
 *
 * WPUpper Share Buttons is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * WPUpper Share Buttons is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WPUpper Share Buttons. If not, see <https://www.gnu.org/licenses/>.
 *
 * @package WPUpper_Share_Buttons
 * @author Victor Freitas
 */
if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

if ( ! defined( 'WPUSB_PLUGIN_FILE' ) ) {
	define( 'WPUSB_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'WPUSB_PLUGIN_VERSION' ) ) {
	define( 'WPUSB_PLUGIN_VERSION', '3.43' );
}

// Class WPUSB_App to include classes.
require_once dirname( __FILE__ ) . '/Config/app.php';

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

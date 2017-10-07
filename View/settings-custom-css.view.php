<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Custom CSS
 * @version 1.0
 * @since 3.24
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
}

class WPUSB_Settings_Custom_CSS_View {

	/**
	 * Page display
	 *
	 * @since 3.24
	 * @version 1.0
	 * @param Null
	 * @return Void
	 */
	public static function render() {
	?>
		<div class="wrap <?php echo WPUSB_App::SLUG . '-custom-css-wrap'; ?>">
			<h2>
				<?php _e( 'WPUpper Share Buttons', 'wpupper-share-buttons' ); ?>
			</h2>

			<p class="description">
				<?php _e( 'Add the Share Buttons automatically.', 'wpupper-share-buttons' ); ?>
			</p>

			<?php WPUSB_Utils_View::page_notice(); ?>

			<span class="<?php echo WPUSB_App::SLUG . '-title-wrap'; ?>">
				<?php _e( 'Custom CSS', 'wpupper-share-buttons' ); ?>
			</span>

			<?php WPUSB_Utils_View::menu_top(); ?>

			<?php WPUSB_Utils_View::update_notice(); ?>

			<div class="<?php echo WPUSB_App::SLUG . '-wrap'; ?>"
					<?php echo WPUSB_Utils::get_component( 'custom-css' ); ?>>

				<table class="form-table">
					<tbody>
						<tr>
							<td>
								<textarea
									cols="100"
									rows="30"
									data-element="css-field"
									placeholder="<?php esc_attr_e( 'Enter your custom CSS ...', 'wpupper-share-buttons' ); ?>"
									name="custom-css"><?php echo WPUSB_Utils::get_custom_css(); ?></textarea>
							</td>
						</tr>
					</tbody>
				</table>

				<p class="submit <?php echo WPUSB_App::SLUG; ?>-custom-css-btn-content">
					<button type="submit"
							class="button button-primary"
							data-action="save-custom-css"
							data-element="btn-save">
						<?php _e( 'Save Changes' ); ?>
					</button>
					<span class="ajax-spinner" data-element="spinner"></span>
					<span data-element="error"></span>
				</p>
			</div>
		</div>
	<?php
	}
}

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
	exit(0);
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
		$prefix = WPUSB_App::SLUG;
	?>
		<div class="wrap <?php echo "{$prefix}-custom-css-wrap"; ?>">
			<h2><?php _e( 'WPUpper Share Buttons', WPUSB_App::TEXTDOMAIN ); ?></h2>

			<span class="<?php echo "{$prefix}-title-wrap"; ?>">
				<?php _e( 'Custom CSS', WPUSB_App::TEXTDOMAIN ); ?>
			</span>

			<?php WPUSB_Settings_View::menu_top(); ?>

			<?php WPUSB_Settings_View::update_notice_message(); ?>

			<div class="<?php echo "{$prefix}-wrap"; ?>"
				 <?php echo "data-{$prefix}-component=\"custom-css\""; ?>>

				<table class="form-table">
					<tbody>
						<tr>
							<td>
								<textarea
									cols="100"
									rows="30"
									data-element="css-field"
									name="custom-css"
									placeholder="<?php echo __( 'Enter your custom CSS ...', WPUSB_App::TEXTDOMAIN ); ?>"><?php
									echo WPUSB_Utils::get_custom_css();
								?></textarea>
							</td>
						</tr>
					</tbody>
				</table>

				<p class="submit <?php echo $prefix; ?>-custom-css-btn-content">
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
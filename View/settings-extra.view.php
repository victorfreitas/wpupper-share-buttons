<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage View Admin Page
 * @version 1.4.0
 */

if ( ! function_exists( 'add_action' ) )
	exit(0);

use WPUSB_Settings_View as View;

class WPUSB_Settings_Extra_View
{
	/**
	 * Display page setting
	 *
	 * @since 1.2
	 * @param Null
	 * @return Void, Display page
	 */
	public static function render_settings_extra()
	{
		$model         = new WPUSB_Setting();
		$prefix        = WPUSB_Setting::PREFIX;
		$extra_setting = "{$prefix}_extra_settings";
	?>
		<div class="wrap">
			<h2><?php _e( 'WPUpper Share Buttons', WPUSB_App::TEXTDOMAIN ); ?></h2>

			<?php
				if ( WPUSB_Utils::get_update( 'settings-updated' ) )
					WPUSB_Settings_View::update_notice_message();
			?>

			<p class="description"><?php _e( 'Add the Share Buttons automatically.', WPUSB_App::TEXTDOMAIN ); ?></p>
			<span class="<?php echo "{$prefix}-title-wrap"; ?>"><?php _e( 'Extra Settings', WPUSB_App::TEXTDOMAIN ); ?></span>

			<?php WPUSB_Settings_View::menu_top(); ?>

			<div class="<?php echo "{$prefix}-wrap extra-settings-wrap"; ?>">
				<form action="options.php" method="post">
					<table class="form-table table-extras" data-table="extras">
						<tbody>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-cache-time">
										<?php _e( 'Cache time', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-cache-time" step="1" min="1" max="60" type="number"
									       name="<?php echo "{$extra_setting}[report_cache_time]"; ?>"
										   value="<?php echo $model->report_cache_time; ?>">
									<?php _e( 'Minute', WPUSB_App::TEXTDOMAIN ); ?>(s)
									<p class="description">
										<?php _e( 'Set the time in minutes that will be cached in the Sharing report page', WPUSB_App::TEXTDOMAIN ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-twitter-username">
										<?php _e( 'Twitter username', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-twitter-username"
									       class="large-text"
										   placeholder="<?php _e( 'Twitter username', WPUSB_App::TEXTDOMAIN ); ?>"
									       name="<?php echo "{$extra_setting}[twitter_username]"; ?>"
										   value="<?php echo $model->twitter_username; ?>">
									<p class="description"><?php _e( 'Your twitter username', WPUSB_App::TEXTDOMAIN ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-twitter-text">
										<?php _e( 'Twitter text', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-twitter-text"
									       class="large-text"
										   placeholder="<?php _e( 'Twitter text', WPUSB_App::TEXTDOMAIN ); ?>"
									       name="<?php echo "{$extra_setting}[twitter_text]"; ?>"
										   value="<?php echo $model->twitter_text; ?>">

										<div class="<?php echo $prefix; ?>-blockquote">
											<?php _e( 'Use {title} to add the post title', WPUSB_App::TEXTDOMAIN ); ?>
											<p class="description">
											<strong><?php _e( 'Example: ', WPUSB_App::TEXTDOMAIN ); ?></strong>
												<?php _e( 'I just saw', WPUSB_App::TEXTDOMAIN ); ?> {title}
											</p>
										</div>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-tracking-analytics">
										<?php _e( 'UTM tracking', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-tracking-analytics"
									       class="large-text"
										   placeholder="<?php _e( 'Add UTM tracking (Analytics)', WPUSB_App::TEXTDOMAIN ); ?>"
									       name="<?php echo "{$extra_setting}[tracking]"; ?>"
										   value="<?php echo $model->tracking; ?>">

									<div class="<?php echo $prefix; ?>-blockquote">
										<p class="description">
											<strong><?php _e( 'Example: ', WPUSB_App::TEXTDOMAIN ); ?></strong>
											?utm_source=share_buttons&utm_medium=social_media&utm_campaign=social_share
											<br>
											<?php _e( 'Use <code>?</code> and', WPUSB_App::TEXTDOMAIN ); ?>
											<?php _e( 'adding parameters to use <code>&</code> in the tracking.', WPUSB_App::TEXTDOMAIN ); ?>
										</p>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-short-url">
										<?php _e( 'Bitly access token', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
									<input name="<?php echo "{$extra_setting}[bitly_token]"; ?>"
									       value="<?php echo $model->bitly_token; ?>"
									       placeholder="<?php _e( 'Insert your access token Bitly', WPUSB_App::TEXTDOMAIN ); ?>"
									       id="<?php echo $prefix; ?>-short-url"
									       class="large-text">
									<p class="description">
										<?php _e( 'Shorten urls using bitly, generate token in ', WPUSB_App::TEXTDOMAIN ); ?>
										<a href="https://bitly.com/a/oauth_apps" target="_blank">Bitly</a>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-remove-count">
										<?php _e( 'Remove counter', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
								<?php
									View::add_checkbox(array(
										'name'    => "{$extra_setting}[remove_count]",
										'id'      => 'remove-count',
										'checked' => checked( 1, $model->remove_count, false ),
										'value'   => 1,
									));
								?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-remove-inside">
										<?php _e( 'Remove button title', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
								<?php
									View::add_checkbox(array(
										'name'    => "{$extra_setting}[remove_inside]",
										'id'      => 'remove-inside',
										'checked' => checked( 1, $model->remove_inside, false ),
										'value'   => 1,
									));
								?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-disable-css">
										<?php _e( 'Disable CSS', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
								<?php
									View::add_checkbox(array(
										'name'    => "{$extra_setting}[disable_css]",
										'id'      => 'disable-css',
										'checked' => checked( 'on', $model->disable_css, false ),
										'value'   => 'on',
									));
								?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-disable-script">
										<?php _e( 'Disable JS', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
								<?php
									View::add_checkbox(array(
										'name'    => "{$extra_setting}[disable_js]",
										'id'      => 'disable-script',
										'checked' => checked( 'on', $model->disable_js, false ),
										'value'   => 'on',
									));
								?>
								</td>
							</tr>
						</tbody>
					</table>
					<?php
						settings_fields( "{$extra_setting}_group" );
						submit_button( __( 'Save Changes', WPUSB_App::TEXTDOMAIN ) );
					?>
				</form>
			</div>
		</div>
	<?php
	}
}
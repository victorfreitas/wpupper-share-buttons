<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage View Admin Page
 * @version 1.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

class WPUSB_Settings_Extra_View {

	/**
	 * Display page setting
	 *
	 * @since 1.2
	 * @param Null
	 * @return Void, Display page
	 */
	public static function render_settings_extra() {
		$model         = WPUSB_Setting::get_instance();
		$prefix        = WPUSB_App::SLUG;
		$extra_setting = "{$prefix}_extra_settings";
	?>
		<div class="wrap" <?php printf( 'data-%s-component="extra-settings"', $prefix ); ?>>
			<h2><?php _e( 'WPUpper Share Buttons', WPUSB_App::TEXTDOMAIN ); ?></h2>

			<?php
				if ( WPUSB_Utils::get_update( 'settings-updated' ) ) {
					WPUSB_Settings_View::update_notice_message();
				}
			?>

			<p class="description"><?php _e( 'Add the Share Buttons automatically.', WPUSB_App::TEXTDOMAIN ); ?></p>

			<?php WPUSB_Settings_View::home_page_notice(); ?>

			<span class="<?php echo "{$prefix}-title-wrap"; ?>"><?php _e( 'Extra Settings', WPUSB_App::TEXTDOMAIN ); ?></span>

			<?php WPUSB_Settings_View::menu_top(); ?>

			<div class="<?php echo "{$prefix}-wrap extra-settings-wrap"; ?>">
				<form action="options.php"
					  method="post"
					  data-action="form"
					  data-element="form">

					<table class="form-table table-extras" data-table="extras">
						<tbody>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-cache-time">
										<?php _e( 'Cache time', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
									<input type="number"
										   id="<?php echo $prefix; ?>-cache-time"
										   step="1"
										   min="1"
										   max="60"
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
									<input type="text"
										   id="<?php echo $prefix; ?>-twitter-username"
									       class="large-text"
										   placeholder="<?php _e( 'Twitter username', WPUSB_App::TEXTDOMAIN ); ?>"
									       name="<?php echo "{$extra_setting}[twitter_username]"; ?>"
										   value="<?php echo $model->twitter_username; ?>">
									<p class="description"><?php _e( 'Your twitter username', WPUSB_App::TEXTDOMAIN ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-twitter-hashtags">
										<?php _e( 'Twitter hashtags', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
									<input type="text"
										   id="<?php echo $prefix; ?>-twitter-hashtags"
									       class="large-text"
										   placeholder="<?php _e( 'Twitter hashtags', WPUSB_App::TEXTDOMAIN ); ?>"
									       name="<?php echo "{$extra_setting}[twitter_hashtags]"; ?>"
										   value="<?php echo $model->twitter_hashtags; ?>">

										<div class="<?php echo $prefix; ?>-blockquote">
											<div class="description">
												<?php _e( 'Optional Hashtags appended onto the tweet (comma separated. don\'t include "#")', WPUSB_App::TEXTDOMAIN ); ?>
											</div>
											<p class="description">
												<strong><?php _e( 'Example: ', WPUSB_App::TEXTDOMAIN ); ?></strong>
												social, share, like
											</p>
										</div>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-twitter-text">
										<?php _e( 'Twitter text', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
									<input type="text"
										   id="<?php echo $prefix; ?>-twitter-text"
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
									<input type="text"
										   id="<?php echo $prefix; ?>-tracking-analytics"
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
									<input type="text"
										   name="<?php echo "{$extra_setting}[bitly_token]"; ?>"
									       value="<?php echo $model->bitly_token; ?>"
									       data-element="bitly-token"
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
									<label for="<?php echo $prefix; ?>-bitly-domain">
										<?php _e( 'Select Bitly domain', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
									<select id="<?php echo $prefix; ?>-bitly-domain"
									        name="<?php echo "{$extra_setting}[bitly_domain]"; ?>"
									        class="regular-text">
										<option value="default" selected="selected">
											<?php _e( 'Default', WPUSB_App::TEXTDOMAIN ); ?>
										</option>
										<?php
											$domains = WPUSB_Utils::get_bitly_domains();

											foreach ( $domains as $key => $domain ) :
												printf(
													'<option value="%s" %s>%s</option>',
													$key,
													selected( $model->bitly_domain, $key, false ),
													$domain
												);
											endforeach;
										?>
									</select>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-minify-html">
										<?php _e( 'Minify html buttons share', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
								<?php
									WPUSB_Settings_View::add_checkbox(array(
										'name'    => "{$extra_setting}[minify_html]",
										'id'      => 'minify-html',
										'checked' => checked( 'on', $model->minify_html, false ),
										'value'   => 'on',
									));
								?>
									<p class="description">
										<?php _e( 'Minify the HTML helps site performance.', WPUSB_App::TEXTDOMAIN ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-sharing-report-disable">
										<?php _e( 'Deactivate sharing report', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
								<?php
									WPUSB_Settings_View::add_checkbox(array(
										'name'    => "{$extra_setting}[sharing_report_disabled]",
										'id'      => 'sharing-report-disable',
										'checked' => checked( 'on', $model->sharing_report_disabled, false ),
										'value'   => 'on',
									));
								?>
									<p class="description">
										<?php _e( 'This allows you to disable counting of the shares report. You will not lose the report you have already computed.', WPUSB_App::TEXTDOMAIN ); ?>
									</p>
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
									WPUSB_Settings_View::add_checkbox(array(
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
									WPUSB_Settings_View::add_checkbox(array(
										'name'    => "{$extra_setting}[disable_js]",
										'id'      => 'disable-script',
										'checked' => checked( 'on', $model->disable_js, false ),
										'value'   => 'on',
									));
								?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-css-footer">
										<?php _e( 'CSS file in footer', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
								<?php
									WPUSB_Settings_View::add_checkbox(array(
										'name'    => "{$extra_setting}[css_footer]",
										'id'      => 'css-footer',
										'checked' => checked( 'on', $model->css_footer, false ),
										'value'   => 'on',
									));
								?>
								<p class="description">
									<?php _e( 'Keep the CSS style in the footer is recommended to improve the performance of your website.', WPUSB_App::TEXTDOMAIN ); ?>
								</p>
								</td>
							</tr>
						</tbody>
					</table>
					<?php
						settings_fields( "{$extra_setting}_group" );
						submit_button();
					?>
					<div class="<?php echo $prefix; ?>-info-error"
						 data-element="bitly-message"></div>
				</form>
			</div>
		</div>
	<?php
	}
}
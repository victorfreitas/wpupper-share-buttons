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

class WPUSB_Settings_View
{
	/**
	 * Display page setting
	 *
	 * @since 1.2
	 * @param Null
	 * @return Void Display page
	 */
	public static function render_settings_page()
	{
		$model               = new WPUSB_Setting();
		$prefix              = WPUSB_Setting::PREFIX;
		$option_name         = "{$prefix}_settings";
		$option_social_media = "{$prefix}_social_media";
?>
		<div class="wrap">
			<h2><?php _e( 'WPUpper Share Buttons', WPUSB_App::TEXTDOMAIN ); ?></h2>

			<?php
				if ( WPUSB_Utils::get_update( 'settings-updated' ) )
					self::update_notice_message();
			?>

			<p class="description"><?php _e( 'Add the Share Buttons automatically.', WPUSB_App::TEXTDOMAIN ); ?></p>
			<span class="<?php echo "{$prefix}-title-wrap"; ?>"><?php _e( 'Settings', WPUSB_App::TEXTDOMAIN ); ?></span>

			<?php self::menu_top(); ?>

			<div class="<?php echo "{$prefix}-wrap"; ?>" data-component="share-settings">

			<div data-component="share-preview">
				<span class="ajax-spinner">loading...</span>
				<div data-element="<?php echo $prefix; ?>"></div>
			</div>

				<form action="options.php" method="post">
					<table class="form-table <?php echo "{$prefix}-table"; ?>" data-table="configurations">
						<tbody>
							<tr class="<?php echo $prefix; ?>-items-available">
								<th scope="row">
									<label><?php _e( 'Places available', WPUSB_App::TEXTDOMAIN ); ?></label>
								</th>
								<td>
					                <input id="<?php echo $prefix; ?>-single"
					                       type="checkbox"
					                	   value="on" name="<?php echo "{$option_name}[single]"; ?>"
					                	   <?php checked( 'on', $model->single ); ?>>
					                <label for="<?php echo $prefix; ?>-single">
					                	<span><?php _e( 'Single', WPUSB_App::TEXTDOMAIN ); ?></span>
					                </label>
					            </td>
								<td>
				                	<input id="<?php echo $prefix; ?>-pages"
				                	       type="checkbox"
				                	       value="on" name="<?php echo "{$option_name}[pages]"; ?>"
				                		   <?php checked( 'on', $model->pages ); ?>>
					                <label for="<?php echo $prefix; ?>-pages">
					                	<span><?php _e( 'Pages', WPUSB_App::TEXTDOMAIN ); ?></span>
					                </label>
					            </td>
								<td>
				                	<input id="<?php echo $prefix; ?>-home"
				                	       type="checkbox"
				                	       value="on" name="<?php echo "{$option_name}[home]"; ?>"
				                		   <?php checked( 'on', $model->home ); ?>>
					                <label for="<?php echo $prefix; ?>-home">
					                	<span><?php _e( 'Page home', WPUSB_App::TEXTDOMAIN ); ?></span>
					                </label>
				                </td>
								<td>
				                	<input id="<?php echo $prefix; ?>-before"
				                	       type="checkbox"
				                	       value="on" name="<?php echo "{$option_name}[before]"; ?>"
				                	       <?php checked( 'on', $model->before ); ?>>
					                <label for="<?php echo $prefix; ?>-before">
					                	<span><?php _e( 'Before content', WPUSB_App::TEXTDOMAIN ); ?></span>
					                </label>
				                </td>
								<td>
				                	<input id="<?php echo $prefix; ?>-after"
				                	       type="checkbox"
				                	       value="on" name="<?php echo "{$option_name}[after]"; ?>"
				                	       <?php checked( 'on', $model->after ); ?>>
					                <label for="<?php echo $prefix; ?>-after">
					                	<span><?php _e( 'After content', WPUSB_App::TEXTDOMAIN ); ?></span>
					                </label>
				                </td>
								<td>
				                	<input id="<?php echo $prefix; ?>-fixed"
				                		   data-element="fixed"
				                	       type="checkbox"
				                	       class="wpusb-fixed"
				                	       value="on" name="<?php echo "{$option_name}[fixed]"; ?>"
				                	       <?php checked( 'on', $model->fixed ); ?>>
					                <label for="<?php echo $prefix; ?>-fixed">
					                	<span><?php _e( 'Fixed', WPUSB_App::TEXTDOMAIN ); ?></span>
					                </label>
				                </td>
							</tr>
							<tr class="<?php echo $prefix; ?>-social-networks" data-element="sortable">
								<th scope="row">
									<label for="social-media"><?php _e( 'Social networks available', WPUSB_App::TEXTDOMAIN ); ?></label>
								</th>
									<?php
									foreach ( WPUSB_Core::get_all_elements() as $key => $social ) :
										$content  = "<td id=\"{$key}\" class=\"{$prefix}-select-item\" title=\"{$social->name}\">";
										$content .= sprintf( "<input id=\"%s\" type=\"checkbox\" name=\"{$option_social_media}[%s]\" value=\"%2\$s\" %s>",
											$social->class,
											$key,
											checked( $key, WPUSB_Utils::option( $key ), false )
										);
										$content .= sprintf( '<label for="%s" class="%s"></label>', $social->class, "{$prefix}-icon {$social->class}-icon" );
										$content .= '</td>';

										echo $content;
									endforeach;
									?>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-class">
										<?php _e( 'Custom class', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-class" class="large-text" type="text"
										   placeholder="<?php _e( 'Custom class for primary div', WPUSB_App::TEXTDOMAIN ); ?>"
									       name="<?php echo "{$option_name}[class]"; ?>"
										   value="<?php echo $model->class; ?>">
								</td>
							</tr>
							<tr class="<?php echo $prefix; ?>-layout-options">
								<th scope="row">
									<?php _e( 'Layout options', WPUSB_App::TEXTDOMAIN ); ?>
									<p class="description">
										<?php _e( 'All layout supports responsive', WPUSB_App::TEXTDOMAIN ); ?>
									</p>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-default"
										   type="radio"
										   class="layout-preview"
										   name="<?php echo "{$option_name}[layout]"; ?>"
										   value="default"
										   <?php checked( 'default', $model->layout ); ?>>
									<label for="<?php echo $prefix; ?>-default">
										<span><?php _e( 'Default', WPUSB_App::TEXTDOMAIN ); ?></span>
									</label>
								</td>
								<td>
									<input id="<?php echo $prefix; ?>-buttons"
										   type="radio"
										   class="layout-preview"
										   name="<?php echo "{$option_name}[layout]"; ?>"
										   value="buttons"
										   <?php checked( 'buttons', $model->layout ); ?>>
									<label for="<?php echo $prefix; ?>-buttons">
										<span><?php _e( 'Button', WPUSB_App::TEXTDOMAIN ); ?></span>
									</label>
								</td>
								<td>
									<input id="<?php echo $prefix; ?>-rounded"
										   type="radio"
										   class="layout-preview"
										   name="<?php echo "{$option_name}[layout]"; ?>"
										   value="rounded"
										   <?php checked( 'rounded', $model->layout ); ?>>
									<label for="<?php echo $prefix; ?>-rounded">
										<span><?php _e( 'Rounded', WPUSB_App::TEXTDOMAIN ); ?></span>
									</label>
								</td>
								<td>
									<input id="<?php echo $prefix; ?>-square"
										   type="radio"
										   class="layout-preview"
										   name="<?php echo "{$option_name}[layout]"; ?>"
										   value="square"
										   <?php checked( 'square', $model->layout ); ?>>
									<label for="<?php echo $prefix; ?>-square">
										<span><?php _e( 'Square', WPUSB_App::TEXTDOMAIN ); ?></span>
									</label>
								</td>
								<td>
									<input id="<?php echo $prefix; ?>-square-plus"
										   type="radio"
									       class="layout-preview"
									       name="<?php echo "{$option_name}[layout]"; ?>"
									       value="square-plus"
									       <?php checked( 'square-plus', $model->layout ); ?>>
									<label for="<?php echo $prefix; ?>-square-plus">
										<span><?php _e( 'Square plus', WPUSB_App::TEXTDOMAIN ); ?></span>
									</label>
								</td>
							</tr>
							<tr class="<?php echo $prefix; ?>-position-fixed">
								<th scope="row">
									<?php _e( 'Position fixed', WPUSB_App::TEXTDOMAIN ); ?>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-fixed-left"
										   data-element="fixed-left"
									       type="checkbox"
									       class="layout-preview layout-fixed"
										   name="<?php echo "{$option_name}[position_fixed]"; ?>"
										   value="fixed-left"
										   <?php checked( 'fixed-left', $model->position_fixed ); ?>>
									<label for="<?php echo $prefix; ?>-fixed-left">
										<span><?php _e( 'Fixed left', WPUSB_App::TEXTDOMAIN ); ?></span>
									</label>
								</td>
							</tr>
							<tr class="<?php echo $prefix; ?>-position-fixed-top">
								<th scope="row">
									<?php _e( 'Fixed Items in top', WPUSB_App::TEXTDOMAIN ); ?>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-fixed-top"
									       type="checkbox"
										   name="<?php echo "{$option_name}[fixed_top]"; ?>"
										   value="fixed-top"
										   <?php checked( 'fixed-top', $model->fixed_top ); ?>>
									<label for="<?php echo $prefix; ?>-fixed-top">
										<span><?php _e( 'Fixed top', WPUSB_App::TEXTDOMAIN ); ?></span>
									</label>

									<p class="<?php echo $prefix; ?>-description">
										<?php _e( 'It is activated when scrolling the page on the buttons position.', WPUSB_App::TEXTDOMAIN ); ?>
									</p>
								</td>
							</tr>
							<tr class="<?php echo $prefix; ?>-referrer">
								<th scope="row">
									<?php _e( 'Enable highlighted by reference?', WPUSB_App::TEXTDOMAIN ); ?>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-referrer"
									       type="checkbox"
										   name="<?php echo "{$option_name}[referrer]"; ?>"
										   value="yes"
										   <?php checked( 'yes', $model->referrer ); ?>>
									<label for="<?php echo $prefix; ?>-referrer">
										<span><?php _e( 'Referrer', WPUSB_App::TEXTDOMAIN ); ?></span>
									</label>

									<p class="<?php echo $prefix; ?>-description">
										<?php _e( 'This allows highlight the social network where the user Came from.', WPUSB_App::TEXTDOMAIN ); ?>
									</p>
								</td>
							</tr>

							<tr class="<?php echo $prefix; ?>-info-twitter">
								<th scope="row">
									Twiiter share counter
								</th>
								<td>
									<p class="description">
									<?php
										_e( 'The share count Twitter is powered by <a href="http://newsharecounts.com" target="_blank">newsharecounts.com</a>, you have to sign up with your Twitter account to get free service and twitter count. Just visit the website, fill in the domain of your site and click Sign in with Twitter. That, and nothing else!', WPUSB_App::TEXTDOMAIN );
									?>
									</p>
								</td>
							</tr>
						</tbody>
					</table>
					<input type="hidden"
					       name="<?php echo $option_social_media; ?>[order]"
					       data-element="order"
					       value='<?php echo WPUSB_Utils::option( 'order' ); ?>'>
					<?php
						settings_fields( "{$option_name}_group" );
						submit_button( __( 'Save Changes', WPUSB_App::TEXTDOMAIN ) );
					?>
				</form>
			</div>
		</div>
<?php
	}

	/**
	 * Display update notice
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function update_notice_message()
	{
	?>
		<div class="updated notice is-dismissible">
			<p><strong><?php _e( 'Settings saved.', WPUSB_App::TEXTDOMAIN ); ?></strong></p>
			<button class="notice-dismiss"></button>
		</div>
	<?php
	}

	public static function menu_top()
	{
		$general    = WPUSB_Setting::HOME_SETTINGS;
		$extra      = WPUSB_Setting::EXTRA_SETTINGS;
		$use_option = WPUSB_Setting::USE_OPTIONS;
		$report     = WPUSB_Setting::SHARING_REPORT;
	?>
		<div class="<?php echo WPUSB_Setting::PREFIX; ?>-menu">
			<ul>
				<li<?php echo WPUSB_Utils::selected_menu( $general ); ?>>
					<a href="<?php menu_page_url( $general ); ?>">
						<?php _e( 'General', WPUSB_App::TEXTDOMAIN ); ?>
					</a>
				</li>
				<li<?php echo WPUSB_Utils::selected_menu( $extra ); ?>>
					<a href="<?php menu_page_url( $extra ); ?>">
						<?php _e( 'Extra Settings', WPUSB_App::TEXTDOMAIN ); ?>
					</a>
				</li>
				<li<?php echo WPUSB_Utils::selected_menu( $use_option ); ?>>
					<a href="<?php menu_page_url( $use_option ); ?>">
						<?php _e( 'Use options', WPUSB_App::TEXTDOMAIN ); ?>
					</a>
				</li>
				<li<?php echo WPUSB_Utils::selected_menu( $report ); ?>>
					<a href="<?php menu_page_url( $report ); ?>">
						<?php _e( 'Sharing Report', WPUSB_App::TEXTDOMAIN ); ?>
					</a>
				</li>
			</ul>
		</div>
	<?php
	}
}
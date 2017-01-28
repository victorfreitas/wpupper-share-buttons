<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage View Admin Page
 * @version 2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

class WPUSB_Settings_View {

	/**
	 * Display page setting
	 *
	 * @since 3.1.0
	 * @version 2.0.0
	 * @param Null
	 * @return Void Display page
	 */
	public static function render_settings_page() {
		$model               = WPUSB_Setting::get_instance();
		$prefix              = WPUSB_App::SLUG;
		$option_name         = "{$prefix}_settings";
		$option_social_media = "{$prefix}_social_media";
?>
		<div class="wrap">
			<h2><?php _e( 'WPUpper Share Buttons', WPUSB_App::TEXTDOMAIN ); ?></h2>

			<?php
				if ( WPUSB_Utils::get_update( 'settings-updated' ) ) {
					self::update_notice_message();
				}
			?>

			<p class="description"><?php _e( 'Add the Share Buttons automatically.', WPUSB_App::TEXTDOMAIN ); ?></p>

			<?php self::home_page_notice(); ?>

			<span class="<?php echo "{$prefix}-title-wrap"; ?>"><?php _e( 'Settings', WPUSB_App::TEXTDOMAIN ); ?></span>

			<?php self::menu_top(); ?>

			<div class="<?php echo "{$prefix}-wrap"; ?>" data-<?php echo $prefix; ?>-component="share-settings">

			<div data-<?php echo $prefix; ?>-component="share-preview">
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
								<?php
									self::td(array(
										'type'       => 'checkbox',
										'id'         => 'home',
										'name'       => "{$option_name}[home]",
										'value'      => 'on',
										'is_checked' => checked( 'on', $model->home, false ),
										'title'      => __( 'Page home', WPUSB_App::TEXTDOMAIN ),
										'class'      => 'hide-input',
									));
									self::td(array(
										'type'       => 'checkbox',
										'id'         => 'archive_category',
										'name'       => "{$option_name}[archive_category]",
										'value'      => 'on',
										'is_checked' => checked( 'on', $model->archive_category, false ),
										'title'      => __( 'Archive/Category', WPUSB_App::TEXTDOMAIN ),
										'class'      => 'hide-input',
									));
									self::td(array(
										'type'       => 'checkbox',
										'id'         => 'pages',
										'name'       => "{$option_name}[pages]",
										'value'      => 'on',
										'is_checked' => checked( 'on', $model->pages, false ),
										'title'      => __( 'Pages', WPUSB_App::TEXTDOMAIN ),
										'class'      => 'hide-input',
									));
									self::td(array(
										'type'       => 'checkbox',
										'id'         => 'single',
										'name'       => "{$option_name}[single]",
										'value'      => 'on',
										'is_checked' => checked( 'on', $model->single, false ),
										'title'      => __( 'Single', WPUSB_App::TEXTDOMAIN ),
										'class'      => 'hide-input',
									));

									if ( class_exists( 'WooCommerce' ) ) :
										self::td(array(
											'type'       => 'checkbox',
											'id'         => 'woocommerce',
											'name'       => "{$option_name}[woocommerce]",
											'value'      => 'on',
											'is_checked' => checked( 'on', $model->woocommerce, false ),
											'title'      => __( 'WooCommerce share', WPUSB_App::TEXTDOMAIN ),
											'class'      => 'hide-input',
										));
									endif;

									self::td(array(
										'type'       => 'checkbox',
										'id'         => 'before',
										'name'       => "{$option_name}[before]",
										'value'      => 'on',
										'is_checked' => checked( 'on', $model->before, false ),
										'title'      => __( 'Before content', WPUSB_App::TEXTDOMAIN ),
										'class'      => 'hide-input',
									));
									self::td(array(
										'type'       => 'checkbox',
										'id'         => 'after',
										'name'       => "{$option_name}[after]",
										'value'      => 'on',
										'is_checked' => checked( 'on', $model->after, false ),
										'title'      => __( 'After content', WPUSB_App::TEXTDOMAIN ),
										'class'      => 'hide-input',
									));
								?>
							</tr>
							<tr class="<?php echo $prefix; ?>-social-networks" data-element="sortable">
								<th scope="row">
									<label for="social-media"><?php _e( 'Social networks available', WPUSB_App::TEXTDOMAIN ); ?></label>
								</th>
									<?php
										$social_elements = WPUSB_Social_Elements::social_media();

										foreach ( $social_elements as $key => $social ) {
											$option_value = WPUSB_Utils::option( $key );
											$id           = ( 'google' == $key ) ? "{$key}-plus" : $key;
											self::td(array(
												'type'        => 'checkbox',
												'id'          => $id,
												'name'        => "{$option_social_media}[{$key}]",
												'value'       => $key,
												'is_checked'  => checked( $key, $option_value, false ),
												'label-class' => "{$prefix}-icon {$social->class}-icon",
												'td-class'    => "{$prefix}-select-item",
												'td-id'       => $key,
												'td-title'    => $social->name,
												'span'        => false,
												'class'       => 'hide-input',
											));
										}
									?>
							</tr>
							<tr class="<?php echo $prefix; ?>-layout-options">
								<th scope="row">
									<?php _e( 'Layout options', WPUSB_App::TEXTDOMAIN ); ?>
									<p class="description">
										<?php _e( 'All layout supports responsive', WPUSB_App::TEXTDOMAIN ); ?>
									</p>
								</th>
								<?php
									self::td(array(
										'type'       => 'radio',
										'id'         => 'default',
										'class'      => 'hide-input layout-preview',
										'name'       => "{$option_name}[layout]",
										'value'      => 'default',
										'is_checked' => checked( 'default', $model->layout, false ),
										'title'      => __( 'Default', WPUSB_App::TEXTDOMAIN ),
									));
									self::td(array(
										'type'       => 'radio',
										'id'         => 'buttons',
										'class'      => 'hide-input layout-preview',
										'name'       => "{$option_name}[layout]",
										'value'      => 'buttons',
										'is_checked' => checked( 'buttons', $model->layout, false ),
										'title'      => __( 'Button', WPUSB_App::TEXTDOMAIN ),
									));
									self::td(array(
										'type'       => 'radio',
										'id'         => 'rounded',
										'class'      => 'hide-input layout-preview',
										'name'       => "{$option_name}[layout]",
										'value'      => 'rounded',
										'is_checked' => checked( 'rounded', $model->layout, false ),
										'title'      => __( 'Rounded', WPUSB_App::TEXTDOMAIN ),
									));
									self::td(array(
										'type'       => 'radio',
										'id'         => 'square',
										'class'      => 'hide-input layout-preview',
										'name'       => "{$option_name}[layout]",
										'value'      => 'square',
										'is_checked' => checked( 'square', $model->layout, false ),
										'title'      => __( 'Square', WPUSB_App::TEXTDOMAIN ),
									));
									self::td(array(
										'type'       => 'radio',
										'id'         => 'square-plus',
										'class'      => 'hide-input layout-preview',
										'name'       => "{$option_name}[layout]",
										'value'      => 'square-plus',
										'is_checked' => checked( 'square-plus', $model->layout, false ),
										'title'      => __( 'Square plus', WPUSB_App::TEXTDOMAIN ),
									));
								?>
							</tr>
							<tr class="<?php echo $prefix; ?>-position-fixed">
								<th scope="row">
									<?php _e( 'Position fixed', WPUSB_App::TEXTDOMAIN ); ?>
								</th>
								<?php
									self::td(array(
										'type'       => 'radio',
										'id'         => 'fixed-left',
										'class'      => 'hide-input layout-preview layout-fixed',
										'name'       => "{$option_name}[position_fixed]",
										'value'      => 'fixed-left',
										'is_checked' => checked( 'fixed-left', $model->position_fixed, false ),
										'title'      => __( 'Fixed left', WPUSB_App::TEXTDOMAIN ),
										'data-attr'  => 'data-element="position-fixed"',
									));
									self::td(array(
										'type'       => 'radio',
										'id'         => 'fixed-right',
										'class'      => 'hide-input layout-preview layout-fixed',
										'name'       => "{$option_name}[position_fixed]",
										'value'      => 'fixed-right',
										'is_checked' => checked( 'fixed-right', $model->position_fixed, false ),
										'title'      => __( 'Fixed right', WPUSB_App::TEXTDOMAIN ),
										'data-attr'  => 'data-element="position-fixed"',
									));
								?>
								<td class="<?php echo "{$prefix}-fixed-clear"; ?>">
									<input type="button"
									       data-action="fixed-disabled"
									       value="<?php _e( 'Clear', WPUSB_App::TEXTDOMAIN ); ?>">
									<span><?php _e( 'Click to clear the positions.', WPUSB_App::TEXTDOMAIN ); ?></span>
								</td>
							</tr>
							<tr class="<?php echo $prefix; ?>-position-fixed">
								<th scope="row">
									<?php _e( 'Position fixed layout', WPUSB_App::TEXTDOMAIN ); ?>
								</th>
									<?php
										$fixed_layout   = WPUSB_Utils::option( 'fixed_layout', false );
										$checked_layout = checked( 'buttons', $model->fixed_layout, false );

										self::td(array(
											'type'       => 'radio',
											'id'         => 'fixed-square',
											'class'      => 'hide-input layout-preview fixed-layout',
											'name'       => "{$option_name}[fixed_layout]",
											'value'      => 'buttons',
											'is_checked' => ( $fixed_layout ) ? $checked_layout : 'checked="checked"',
											'title'      => __( 'Square', WPUSB_App::TEXTDOMAIN ),
										));

										self::td(array(
											'type'       => 'radio',
											'id'         => 'fixed-rounded',
											'class'      => 'hide-input layout-preview fixed-layout',
											'name'       => "{$option_name}[fixed_layout]",
											'value'      => 'default',
											'is_checked' => checked( 'default', $model->fixed_layout, false ),
											'title'      => __( 'Rounded', WPUSB_App::TEXTDOMAIN ),
										));
									?>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-icons-size">
										<?php _e( 'Custom icons size', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<?php
									self::td(array(
										'type'  => 'number',
										'id'    => 'icons-size',
										'class' => 'small-text',
										'name'  => "{$option_name}[icons_size]",
										'value' => $model->icons_size,
										'span'  => true,
										'title' => 'px',
									));
								?>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-icons-color">
										<?php _e( 'Custom icons color', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<?php
									self::td(array(
										'type'  => 'text',
										'id'    => 'icons-color',
										'class' => "{$prefix}-colorpicker",
										'name'  => "{$option_name}[icons_color]",
										'value' => $model->icons_color,
									));
								?>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-icons-background-color">
										<?php _e( 'Custom buttons background color', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<?php
									self::td(array(
										'type'        => 'text',
										'id'          => 'buttons-background',
										'class'       => "{$prefix}-colorpicker",
										'name'        => "{$option_name}[buttons_background_color]",
										'value'       => $model->buttons_background_color,
										'description' => sprintf(
											__( 'By layouts: %s, %s, and %s.', WPUSB_App::TEXTDOMAIN ),
											__( 'Button', WPUSB_App::TEXTDOMAIN ),
											__( 'Square plus', WPUSB_App::TEXTDOMAIN ),
											__( 'Position fixed', WPUSB_App::TEXTDOMAIN )
										),
									));
								?>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-class">
										<?php _e( 'Custom class', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<?php
									self::td(array(
										'id'          => 'class',
										'class'       => 'large-text',
										'name'        => "{$option_name}[class]",
										'value'       => $model->class,
										'placeholder' => __( 'Custom class for primary div', WPUSB_App::TEXTDOMAIN ),
									));
								?>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-share-count-label">
										<?php _e( 'Share count label', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<?php
									self::td(array(
										'id'          => 'share-count-label',
										'class'       => 'large-text',
										'name'        => "{$option_name}[share_count_label]",
										'value'       => $model->share_count_label,
										'placeholder' => __( 'Change text of the share count title. Default SHARES', WPUSB_App::TEXTDOMAIN ),
										'description' => sprintf( __( 'Used in %s layout.', WPUSB_App::TEXTDOMAIN ), __( 'Square plus', WPUSB_App::TEXTDOMAIN ) ),
									));
								?>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-title">
										<?php _e( 'Title', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<?php
									self::td(array(
										'id'          => 'title',
										'class'       => 'large-text',
										'name'        => "{$option_name}[title]",
										'value'       => $model->title,
										'placeholder' => __( 'Insert the title here.', WPUSB_App::TEXTDOMAIN ),
										'description' => __( 'Text to display above the sharing buttons.', WPUSB_App::TEXTDOMAIN ),
									));
								?>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-context">
										<?php _e( 'HTML id attribute', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<?php
									self::td(array(
										'id'          => 'fixed-context',
										'class'       => 'large-text',
										'name'        => "{$option_name}[fixed_context]",
										'value'       => $model->fixed_context,
										'placeholder' => __( 'Enter name to context of search. ID of content tag', WPUSB_App::TEXTDOMAIN ),
										'description' => __( 'This is to set the fixed layout to the left of the post content. <strong>Example:</strong> <code>wrap</code> use {id} for post id.', WPUSB_App::TEXTDOMAIN ),
										'span'        => false,
									));
								?>
							</tr>
							<tr>
								<th scope="row">
									<?php _e( 'Fixed Items in top', WPUSB_App::TEXTDOMAIN ); ?>
								</th>
								<td>
								<?php
									self::add_checkbox(array(
										'name'    => "{$option_name}[fixed_top]",
										'id'      => 'fixed-top',
										'checked' => checked( 'fixed-top', $model->fixed_top, false ),
										'value'   => 'fixed-top',
									));
								?>
									<p class="description">
										<?php _e( 'It is activated when scrolling the page on the buttons position.', WPUSB_App::TEXTDOMAIN ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<?php _e( 'Highlighted by reference', WPUSB_App::TEXTDOMAIN ); ?>
								</th>
								<td>
								<?php
									self::add_checkbox(array(
										'name'    => "{$option_name}[referrer]",
										'id'      => 'referrer',
										'checked' => checked( 'yes', $model->referrer, false ),
										'value'   => 'yes',
									));
								?>
									<p class="description">
										<?php _e( 'This allows highlight the social network where the user Came from.', WPUSB_App::TEXTDOMAIN ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<?php _e( 'Remove button title', WPUSB_App::TEXTDOMAIN ); ?>
								</th>
								<td>
								<?php
									self::add_checkbox(array(
										'name'    => "{$option_name}[disabled_inside]",
										'id'      => 'remove-inside',
										'checked' => checked( 1, $model->disabled_inside, false ),
										'value'   => 1,
									));
								?>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<?php _e( 'Remove counter', WPUSB_App::TEXTDOMAIN ); ?>
								</th>
								<td>
								<?php
									self::add_checkbox(array(
										'name'    => "{$option_name}[disabled_count]",
										'id'      => 'remove-count',
										'checked' => checked( 1, $model->disabled_count, false ),
										'value'   => 1,
									));
								?>
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

                	<input type="hidden"
		                   data-element="fixed"
		                   name="<?php echo "{$option_name}[fixed]"; ?>"
		                   value="<?php echo WPUSB_Utils::option( 'fixed' ); ?>">
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
	public static function update_notice_message() {
	?>
		<div class="updated notice is-dismissible" id="updated-notice">
			<p><strong><?php _e( 'Settings saved.', WPUSB_App::TEXTDOMAIN ); ?></strong></p>
			<button class="notice-dismiss"></button>
		</div>
	<?php
	}

	public static function menu_top() {
		$general    = WPUSB_Setting::HOME_SETTINGS;
		$extra      = WPUSB_Setting::EXTRA_SETTINGS;
		$custom_css = WPUSB_Setting::CUSTOM_CSS;
		$use_option = WPUSB_Setting::USE_OPTIONS;
		$report     = WPUSB_Setting::SHARING_REPORT;
	?>
		<div class="<?php echo WPUSB_App::SLUG; ?>-menu">
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
				<li<?php echo WPUSB_Utils::selected_menu( $custom_css ); ?>>
					<a href="<?php menu_page_url( $custom_css ); ?>">
						<?php _e( 'Custom CSS', WPUSB_App::TEXTDOMAIN ); ?>
					</a>
				</li>
				<li<?php echo WPUSB_Utils::selected_menu( $use_option ); ?>>
					<a href="<?php menu_page_url( $use_option ); ?>">
						<?php _e( 'Use options', WPUSB_App::TEXTDOMAIN ); ?>
					</a>
				</li>

				<?php if ( ! WPUSB_Utils::is_sharing_report_disabled() ) : ?>

				<li<?php echo WPUSB_Utils::selected_menu( $report ); ?>>
					<a href="<?php menu_page_url( $report ); ?>">
						<?php _e( 'Sharing Report', WPUSB_App::TEXTDOMAIN ); ?>
					</a>
				</li>

				<?php endif; ?>

			</ul>
		</div>
	<?php
	}

	public static function td( $args = array() ) {
		$prefix = WPUSB_App::SLUG;
		$span   = '';
		$args   = self::_get_td_args( $args );
		$label  = self::_get_label( $prefix, $args );

		echo <<<EOD
			<{$args['tag']} id="{$args['td-id']}"
			    class="{$args['td-class']}"
			    title="{$args['td-title']}">

	            <input type="{$args['type']}" {$args['data-attr']}
	                   id="{$prefix}-{$args['id']}"
	                   class="{$args['class']}"
	            	   name="{$args['name']}"
	            	   value="{$args['value']}"
	            	   placeholder="{$args['placeholder']}"
	            	   {$args['is_checked']}>
	           	{$label}
	           	<p class="description">{$args['description']}</p>
	        </{$args['tag']}>
EOD;
	}

	private static function _get_label( $prefix, $args ) {
		$span = '';

		if ( $args['span'] ) {
			$span = "<span>{$args['title']}</span>";
		}

       $label = <<<EOD
	       	<label for="{$prefix}-{$args['id']}"
	               class="{$args['label-class']}">
	               {$span}
	        </label>
EOD;
		return $label;
	}

	public static function add_checkbox( $args = array() ) {
		$prefix   = WPUSB_App::SLUG;
		$defaults = array(
			'name'        => '',
			'id'          => '',
			'checked'     => '',
			'value'       => '',
			'description' => '',
		);
		$args = array_merge( $defaults, $args );

		echo <<<EOD
			<div class="{$prefix}-custom-switch">

			    <input type="checkbox"
			    	   id="{$prefix}-{$args['id']}"
			    	   class="{$prefix}-check"
			    	   name="{$args['name']}"
			    	   value="{$args['value']}"
			    	   {$args['checked']}>

			    <label for="{$prefix}-{$args['id']}">
			        <span class="{$prefix}-inner"></span>
			        <span class="{$prefix}-switch"></span>
			    </label>

			</div>
EOD;
	}

	private static function _get_td_args( $args ) {
		$defaults = array(
			'type'        => 'text',
			'description' => '',
			'placeholder' => '',
			'id'          => '',
			'class'       => '',
			'name'        => '',
			'value'       => '',
			'is_checked'  => '',
			'title'       => '',
			'td-id'       => '',
			'td-class'    => '',
			'label-class' => '',
			'td-title'    => '',
			'data-attr'   => '',
			'span'        => true,
			'tag'         => 'td',
		);

		return array_merge( $defaults, $args );
	}

	public static function home_page_notice() {
		if ( apply_filters( WPUSB_App::SLUG . '-admin-message', false ) )
			return;
	?>

	<div class="updated inline">
		<p>
			<?php
				$message = sprintf(
					__( 'Help keep the free %s, you can make a donation or vote with %s at WordPress.org. Thank you very much!', WPUSB_App::TEXTDOMAIN ),
					__( WPUSB_App::NAME, WPUSB_App::TEXTDOMAIN ),
					'★★★★★'
				);

				echo WPUSB_Utils::rm_tags( $message );
			?>
		</p>
		<p>
			<a href="<?php echo WPUSB_Utils::get_url_donate(); ?>"
			   target="_blank"
			   class="button button-primary">

				<?php _e( 'Make a donation', WPUSB_App::TEXTDOMAIN ); ?>

			</a>

			<a href="https://wordpress.org/support/plugin/wpupper-share-buttons/reviews/?filter=5#postform"
			   target="_blank"
			   class="button button-secondary">

		   		<?php _e( 'Make a review', WPUSB_App::TEXTDOMAIN ); ?>

		   </a>
		</p>
	</div>

	<?php
	}
}
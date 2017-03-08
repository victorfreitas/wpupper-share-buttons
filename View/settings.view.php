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
		$current_layout      = WPUSB_Utils::option( 'layout' );
		$option_name         = "{$prefix}_settings";
		$option_social_media = "{$prefix}_social_media";
		$hide_class          = 'hide-input';
		$tr_class_hide       = "{$prefix}-tr-hide";
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

			<style data-element-style></style>
			<div data-<?php echo $prefix; ?>-component="share-preview">
				<div data-element="preview"></div>
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
										'class'      => $hide_class,
									));
									self::td(array(
										'type'       => 'checkbox',
										'id'         => 'archive_category',
										'name'       => "{$option_name}[archive_category]",
										'value'      => 'on',
										'is_checked' => checked( 'on', $model->archive_category, false ),
										'title'      => __( 'Archive/Category', WPUSB_App::TEXTDOMAIN ),
										'class'      => $hide_class,
									));
									self::td(array(
										'type'       => 'checkbox',
										'id'         => 'pages',
										'name'       => "{$option_name}[pages]",
										'value'      => 'on',
										'is_checked' => checked( 'on', $model->pages, false ),
										'title'      => __( 'Pages', WPUSB_App::TEXTDOMAIN ),
										'class'      => $hide_class,
									));
									self::td(array(
										'type'       => 'checkbox',
										'id'         => 'single',
										'name'       => "{$option_name}[single]",
										'value'      => 'on',
										'is_checked' => checked( 'on', $model->single, false ),
										'title'      => __( 'Single', WPUSB_App::TEXTDOMAIN ),
										'class'      => $hide_class,
									));

									if ( class_exists( 'WooCommerce' ) ) :
										self::td(array(
											'type'       => 'checkbox',
											'id'         => 'woocommerce',
											'name'       => "{$option_name}[woocommerce]",
											'value'      => 'on',
											'is_checked' => checked( 'on', $model->woocommerce, false ),
											'title'      => __( 'WooCommerce share', WPUSB_App::TEXTDOMAIN ),
											'class'      => $hide_class,
										));
									endif;

									self::td(array(
										'type'       => 'checkbox',
										'id'         => 'before',
										'name'       => "{$option_name}[before]",
										'value'      => 'on',
										'is_checked' => checked( 'on', $model->before, false ),
										'title'      => __( 'Before content', WPUSB_App::TEXTDOMAIN ),
										'class'      => $hide_class,
									));
									self::td(array(
										'type'       => 'checkbox',
										'id'         => 'after',
										'name'       => "{$option_name}[after]",
										'value'      => 'on',
										'is_checked' => checked( 'on', $model->after, false ),
										'title'      => __( 'After content', WPUSB_App::TEXTDOMAIN ),
										'class'      => $hide_class,
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
												'class'       => $hide_class,
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
										'class'      => "{$hide_class} layout-preview",
										'name'       => "{$option_name}[layout]",
										'value'      => 'default',
										'is_checked' => checked( 'default', $model->layout, false ),
										'title'      => __( 'Default', WPUSB_App::TEXTDOMAIN ),
										'attr'       => array(
											'data-action' => 'primary-layout',
										),
									));
									self::td(array(
										'type'       => 'radio',
										'id'         => 'buttons',
										'class'      => "{$hide_class} layout-preview",
										'name'       => "{$option_name}[layout]",
										'value'      => 'buttons',
										'is_checked' => checked( 'buttons', $model->layout, false ),
										'title'      => __( 'Button', WPUSB_App::TEXTDOMAIN ),
										'attr'       => array(
											'data-action' => 'primary-layout',
										),
									));
									self::td(array(
										'type'       => 'radio',
										'id'         => 'rounded',
										'class'      => "{$hide_class} layout-preview",
										'name'       => "{$option_name}[layout]",
										'value'      => 'rounded',
										'is_checked' => checked( 'rounded', $model->layout, false ),
										'title'      => __( 'Rounded', WPUSB_App::TEXTDOMAIN ),
										'attr'       => array(
											'data-action' => 'primary-layout',
										),
									));
									self::td(array(
										'type'       => 'radio',
										'id'         => 'square',
										'class'      => "{$hide_class} layout-preview",
										'name'       => "{$option_name}[layout]",
										'value'      => 'square',
										'is_checked' => checked( 'square', $model->layout, false ),
										'title'      => __( 'Square', WPUSB_App::TEXTDOMAIN ),
										'attr'       => array(
											'data-action' => 'primary-layout',
										),
									));
									self::td(array(
										'type'       => 'radio',
										'id'         => 'square-plus',
										'class'      => "{$hide_class} layout-preview",
										'name'       => "{$option_name}[layout]",
										'value'      => 'square-plus',
										'is_checked' => checked( 'square-plus', $model->layout, false ),
										'title'      => __( 'Square plus', WPUSB_App::TEXTDOMAIN ),
										'attr'       => array(
											'data-action' => 'primary-layout',
										),
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
										'class'      => "{$hide_class} layout-preview layout-fixed",
										'name'       => "{$option_name}[position_fixed]",
										'value'      => 'fixed-left',
										'is_checked' => checked( 'fixed-left', $model->position_fixed, false ),
										'title'      => __( 'Fixed left', WPUSB_App::TEXTDOMAIN ),
										'attr'       => array(
											'data-element' => 'position-fixed',
											'data-action'  => 'position-fixed',
										),
									));
									self::td(array(
										'type'       => 'radio',
										'id'         => 'fixed-right',
										'class'      => "{$hide_class} layout-preview layout-fixed",
										'name'       => "{$option_name}[position_fixed]",
										'value'      => 'fixed-right',
										'is_checked' => checked( 'fixed-right', $model->position_fixed, false ),
										'title'      => __( 'Fixed right', WPUSB_App::TEXTDOMAIN ),
										'attr'       => array(
											'data-element' => 'position-fixed',
											'data-action'  => 'position-fixed',
										),
									));
								?>
								<td class="<?php echo "{$prefix}-fixed-clear"; ?>">
									<input type="button"
									       data-action="fixed-disabled"
									       value="<?php _e( 'Clear', WPUSB_App::TEXTDOMAIN ); ?>">
									<span><?php _e( 'Click to clear the positions.', WPUSB_App::TEXTDOMAIN ); ?></span>
								</td>
							</tr>

							<?php
								$class_tr_hide = $tr_class_hide;

								if ( WPUSB_Utils::option( 'position_fixed', false ) ) {
									$class_tr_hide = '';
								}
							?>

							<tr class="<?php echo $prefix; ?>-position-fixed <?php echo $class_tr_hide; ?>"
								data-element="tr-fixed-layout">
								<th scope="row">
									<?php _e( 'Position fixed layout', WPUSB_App::TEXTDOMAIN ); ?>
								</th>
									<?php
										$fixed_layout   = WPUSB_Utils::option( 'fixed_layout', false );
										$checked_layout = checked( 'buttons', $model->fixed_layout, false );

										self::td(array(
											'type'       => 'radio',
											'id'         => 'fixed-square',
											'class'      => "{$hide_class} layout-preview fixed-layout",
											'name'       => "{$option_name}[fixed_layout]",
											'value'      => 'buttons',
											'is_checked' => ( $fixed_layout ) ? $checked_layout : 'checked="checked"',
											'title'      => __( 'Square', WPUSB_App::TEXTDOMAIN ),
											'attr'       => array(
												'data-action' => 'fixed-layout',
											),
										));

										self::td(array(
											'type'       => 'radio',
											'id'         => 'fixed-rounded',
											'class'      => "{$hide_class} layout-preview fixed-layout",
											'name'       => "{$option_name}[fixed_layout]",
											'value'      => 'default',
											'is_checked' => checked( 'default', $model->fixed_layout, false ),
											'title'      => __( 'Rounded', WPUSB_App::TEXTDOMAIN ),
											'attr'       => array(
												'data-action' => 'fixed-layout',
											),
										));
									?>
							</tr>

							<?php
								$class_tr_hide = $tr_class_hide;

								if ( WPUSB_Utils::option( 'fixed_layout' ) === 'default' ) {
									$class_tr_hide = '';
								}
							?>

							<tr class="<?php echo $class_tr_hide; ?>"
								data-element="tr-fixed-label">
								<th scope="row">
									<label for="<?php echo $prefix; ?>-fixed-default-label">
										<?php _e( 'Text below sharing count', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<?php
									self::td(array(
										'id'          => 'fixed-default-label',
										'class'       => 'large-text',
										'name'        => "{$option_name}[text_label_fixed_default]",
										'value'       => $model->text_label_fixed_default,
										'attr'        => array(
											'data-action' => 'fixed-label',
										),
										'placeholder' => __(
											'Change text below sharing count. Default SHARES',
											WPUSB_App::TEXTDOMAIN
										),
										'description' => sprintf(
											__( 'Used in %s %s.', WPUSB_App::TEXTDOMAIN ),
											strtolower(__( 'Position fixed layout', WPUSB_App::TEXTDOMAIN )),
											strtolower(__( 'Rounded', WPUSB_App::TEXTDOMAIN ))
										),
									));
								?>
							</tr>


							<?php
								$plus_share_label_class = $tr_class_hide;

								if ( WPUSB_Utils::option( 'layout' ) === 'square-plus' ) {
									$plus_share_label_class = '';
								}
							?>

							<tr class="<?php echo $plus_share_label_class; ?>"
								data-element="tr-share-plus-label">

								<th scope="row">
									<label for="<?php echo $prefix; ?>-share-count-label">
										<?php
											printf(
												__( '%s: Text below sharing count', WPUSB_App::TEXTDOMAIN ),
												__( 'Square plus', WPUSB_App::TEXTDOMAIN )
											);
										?>
									</label>
								</th>
								<?php
									self::td(array(
										'id'          => 'share-count-label',
										'class'       => 'large-text',
										'name'        => "{$option_name}[share_count_label]",
										'value'       => $model->share_count_label,
										'placeholder' => __( 'Change text below sharing count. Default SHARES', WPUSB_App::TEXTDOMAIN ),
										'description' => sprintf( __( 'Used in %s layout.', WPUSB_App::TEXTDOMAIN ), __( 'Square plus', WPUSB_App::TEXTDOMAIN ) ),
										'attr'        => array(
											'data-action' => 'plus-share-label',
										),
									));
								?>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-icons-size">
										<?php _e( 'Icons size', WPUSB_App::TEXTDOMAIN ); ?>
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
										'attr'  => array(
											'data-action' => 'icons-size',
										),
									));
								?>
							</tr>

							<?php
								$class_tr_hide = $tr_class_hide;
								$layouts       = array(
									'default' => 1,
									'buttons' => 1,
									'rounded' => 1,
									'square'  => 1,
								);

								if ( isset( $layouts[ $current_layout ] ) ) {
									$class_tr_hide = '';
								}
							?>

							<tr class="<?php echo $class_tr_hide; ?>"
							    data-element="tr-share-count-bg-color">
								<th scope="row">
									<label for="<?php echo $prefix; ?>-share-count-bg">
										<?php _e( 'Share count background color', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<?php
									self::td(array(
										'type'  => 'text',
										'id'    => 'counts-bg',
										'class' => "{$prefix}-colorpicker",
										'name'  => "{$option_name}[counts_bg_color]",
										'value' => $model->counts_bg_color,
										'attr'  => array(
											'data-element' => 'text',
											'data-style'   => 'background-color',
										),
										'description' => sprintf(
											__( 'Layouts: %s, %s, %s and %s.', WPUSB_App::TEXTDOMAIN ),
											__( 'Default', WPUSB_App::TEXTDOMAIN ),
											__( 'Button', WPUSB_App::TEXTDOMAIN ),
											__( 'Rounded', WPUSB_App::TEXTDOMAIN ),
											__( 'Square', WPUSB_App::TEXTDOMAIN )
										),
									));
								?>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-count-text-color">
										<?php _e( 'Share count text color', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<?php
									self::td(array(
										'type'  => 'text',
										'id'    => 'count-text-color',
										'class' => "{$prefix}-colorpicker",
										'name'  => "{$option_name}[counts_text_color]",
										'value' => $model->counts_text_color,
										'attr'        => array(
											'data-element' => 'text',
											'data-style'   => 'color',
										),
									));
								?>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-icons-color">
										<?php _e( 'Icons color', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<?php
									self::td(array(
										'type'  => 'text',
										'id'    => 'icons-color',
										'class' => "{$prefix}-colorpicker",
										'name'  => "{$option_name}[icons_color]",
										'value' => $model->icons_color,
										'attr'  => array(
											'data-element' => 'icons-color',
											'data-style'   => 'color',
										),
									));
								?>
							</tr>

							<?php
								$class_tr_hide = $tr_class_hide;
								$layouts       = array(
									'buttons'     => 1,
									'square-plus' => 1,
								);

								if ( isset( $layouts[ $current_layout ] ) || WPUSB_Utils::option( 'position_fixed', false ) ) {
									$class_tr_hide = '';
								}
							?>

							<tr class="<?php echo $class_tr_hide; ?>"
							    data-element="tr-button-bg-color">
								<th scope="row">
									<label for="<?php echo $prefix; ?>-button-bg-color">
										<?php _e( 'Buttons background color', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<?php
									self::td(array(
										'type'        => 'text',
										'id'          => 'button-bg-color',
										'class'       => "{$prefix}-colorpicker",
										'name'        => "{$option_name}[button_bg_color]",
										'value'       => $model->button_bg_color,
										'attr'        => array(
											'data-element' => 'bg-color',
											'data-style'   => 'background-color',
										),
										'description' => sprintf(
											__( 'Layouts: %s, %s, and %s.', WPUSB_App::TEXTDOMAIN ),
											__( 'Button', WPUSB_App::TEXTDOMAIN ),
											__( 'Square plus', WPUSB_App::TEXTDOMAIN ),
											__( 'Position fixed', WPUSB_App::TEXTDOMAIN )
										),
									));
								?>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-title-color">
										<?php _e( 'Buttons title color', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<?php
									self::td(array(
										'type'  => 'text',
										'id'    => 'title-color',
										'class' => "{$prefix}-colorpicker",
										'name'  => "{$option_name}[btn_inside_color]",
										'value' => $model->btn_inside_color,
										'attr'  => array(
											'data-element' => 'inside',
											'data-style'   => 'color',
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

							<tr>
								<th scope="row">
									<?php _e( 'Pinterest description', WPUSB_App::TEXTDOMAIN ); ?>
								</th>
								<td>
									<?php
										self::add_checkbox(array(
											'name'    => "{$option_name}[pin_image_alt]",
											'id'      => 'pin-image-alt',
											'checked' => checked( 'yes', $model->pin_image_alt, false ),
											'value'   => 'yes',
										));
									?>
									<p class="description">
										<?php _e( 'Use in description of Pinterest the alt text of highlighted image in place of title of post.', WPUSB_App::TEXTDOMAIN ); ?>
									</p>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-min-count-display">
										<?php _e( 'Min count to display', WPUSB_App::TEXTDOMAIN ); ?>
									</label>
								</th>
								<?php
									self::td(array(
										'type'        => 'number',
										'id'          => 'min-count-display',
										'class'       => 'small-text',
										'name'        => "{$option_name}[min_count_display]",
										'value'       => $model->min_count_display,
										'default'     => 0,
										'description' => __( 'When you enter the value, share counts are only displayed when the total counts of each item than equal to or greater than the informed value.', WPUSB_App::TEXTDOMAIN ),
									));
								?>
							</tr>
							<tr class="<?php echo $prefix; ?>-info-twitter">
								<th scope="row">
									<?php _e( 'Twitter share counter', WPUSB_App::TEXTDOMAIN ); ?>
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
			'attr'        => '',
			'span'        => true,
			'tag'         => 'td',
			'label'       => true,
			'default'     => '',
		);

		return array_merge( $defaults, $args );
	}

	public static function td( $args = array() ) {
		$prefix = WPUSB_App::SLUG;
		$args   = self::_get_td_args( $args );
		$label  = self::_get_label( $prefix, $args );
	?>
		<?php printf( '<%s', $args['tag'] ); ?>
		    id="<?php echo $args['td-id']; ?>"
		    class="<?php echo $args['td-class']; ?>"
		    title="<?php echo $args['td-title']; ?>">

            <input type="<?php echo $args['type']; ?>"
                   id="<?php printf( '%s-%s', $prefix, $args['id'] ); ?>"
                   class="<?php echo $args['class'] ; ?>"
            	   name="<?php echo $args['name'] ; ?>"
            	   value="<?php echo empty( $args['value'] ) ? $args['default'] : $args['value']; ?>"
            	   placeholder="<?php echo $args['placeholder'] ; ?>"
                   <?php echo self::get_attrs( $args ); ?>
            	   <?php echo $args['is_checked']; ?>>
    <?php
			echo $label;

       		if ( ! empty( $args['description'] ) ) :
       			printf( '<p class="description">%s</p>', $args['description'] );
       		endif;

        printf( '</%s>', $args['tag'] );
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
		$args      = array_merge( $defaults, $args );
		$on_title  = __( 'YES', WPUSB_App::SLUG );
		$off_title = __( 'NO', WPUSB_App::SLUG );

		echo <<<EOD
			<div class="{$prefix}-custom-switch">

			    <input type="checkbox"
			    	   id="{$prefix}-{$args['id']}"
			    	   class="{$prefix}-check"
			    	   name="{$args['name']}"
			    	   value="{$args['value']}"
			    	   {$args['checked']}>

			    <label for="{$prefix}-{$args['id']}">
			        <span class="{$prefix}-inner"
			        	  data-title-on="{$on_title}"
			        	  data-title-off="{$off_title}"></span>
			        <span class="{$prefix}-switch"></span>
			    </label>

			</div>
EOD;
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

	public static function get_attrs( $args ) {
		if ( ! is_array( $args['attr'] ) ) {
			return $args['attr'];
		}

		$attributes = '';

		foreach ( $args['attr'] as $attr => $value ) :
			$attributes .= sprintf( ' %s="%s"', $attr, $value );
		endforeach;

		return $attributes;
	}
}
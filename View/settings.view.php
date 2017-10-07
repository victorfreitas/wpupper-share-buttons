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
	exit( 0 );
}

class WPUSB_Settings_View extends WPUSB_Utils_View {

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
		$settings_option     = WPUSB_Utils::add_prefix( '_settings' );
		$option_social_media = WPUSB_Utils::add_prefix( '_social_media' );
		$tr_class_hide       = WPUSB_Utils::add_prefix( '-tr-hide' );
		$hide_class          = 'hide-input';

		parent::set_options( $model->get_options() );
		parent::set_prefix( $settings_option );
	?>
		<div class="wrap">
			<h2><?php _e( 'WPUpper Share Buttons', 'wpupper-share-buttons' ); ?></h2>

			<?php
			if ( WPUSB_Utils::get_update( 'settings-updated' ) ) {
				parent::update_notice();
			}
			?>

			<p class="description"><?php _e( 'Add the Share Buttons automatically.', 'wpupper-share-buttons' ); ?></p>

			<?php parent::page_notice(); ?>

			<span class="<?php echo WPUSB_App::SLUG . '-title-wrap'; ?>">
				<?php _e( 'Settings', 'wpupper-share-buttons' ); ?>
			</span>

			<?php parent::menu_top(); ?>

			<div class="<?php echo WPUSB_App::SLUG . '-wrap'; ?>"
					<?php echo WPUSB_Utils::get_component( 'share-settings' ); ?>>

				<style data-element-style></style>
				<div <?php echo WPUSB_Utils::get_component( 'share-preview' ); ?>>
					<div data-element="preview"></div>
				</div>

				<form action="options.php" method="post">
					<table class="form-table <?php echo WPUSB_App::SLUG . '-table'; ?>" data-table="configurations">
						<tbody>
							<tr class="<?php echo WPUSB_App::SLUG; ?>-items-available">
								<th scope="row">
									<label>
										<?php _e( 'Places available', 'wpupper-share-buttons' ); ?>
									</label>
								</th>
								<?php
									self::td(
										array(
											'type'       => 'checkbox',
											'id'         => 'home',
											'name'       => "{$settings_option}[home]",
											'value'      => 'on',
											'is_checked' => checked( 'on', $model->home, false ),
											'title'      => __( 'Page home', 'wpupper-share-buttons' ),
											'class'      => $hide_class,
										)
									);
									self::td(
										array(
											'type'       => 'checkbox',
											'id'         => 'archive_category',
											'name'       => "{$settings_option}[archive_category]",
											'value'      => 'on',
											'is_checked' => checked( 'on', $model->archive_category, false ),
											'title'      => __( 'Archive/Category', 'wpupper-share-buttons' ),
											'class'      => $hide_class,
										)
									);
									self::td(
										array(
											'type'       => 'checkbox',
											'id'         => 'pages',
											'name'       => "{$settings_option}[pages]",
											'value'      => 'on',
											'is_checked' => checked( 'on', $model->pages, false ),
											'title'      => __( 'Pages', 'wpupper-share-buttons' ),
											'class'      => $hide_class,
										)
									);
									self::td(
										array(
											'type'       => 'checkbox',
											'id'         => 'single',
											'name'       => "{$settings_option}[single]",
											'value'      => 'on',
											'is_checked' => checked( 'on', $model->single, false ),
											'title'      => __( 'Single', 'wpupper-share-buttons' ),
											'class'      => $hide_class,
										)
									);

								if ( class_exists( 'WooCommerce' ) ) :
									self::td(
										array(
											'type'       => 'checkbox',
											'id'         => 'woocommerce',
											'name'       => "{$settings_option}[woocommerce]",
											'value'      => 'on',
											'is_checked' => checked( 'on', $model->woocommerce, false ),
											'title'      => __( 'WooCommerce share', 'wpupper-share-buttons' ),
											'class'      => $hide_class,
										)
									);
									endif;

									self::td(
										array(
											'type'       => 'checkbox',
											'id'         => 'before',
											'name'       => "{$settings_option}[before]",
											'value'      => 'on',
											'is_checked' => checked( 'on', $model->before, false ),
											'title'      => __( 'Before content', 'wpupper-share-buttons' ),
											'class'      => $hide_class,
										)
									);
									self::td(
										array(
											'type'       => 'checkbox',
											'id'         => 'after',
											'name'       => "{$settings_option}[after]",
											'value'      => 'on',
											'is_checked' => checked( 'on', $model->after, false ),
											'title'      => __( 'After content', 'wpupper-share-buttons' ),
											'class'      => $hide_class,
										)
									);
								?>
							</tr>
							<tr class="<?php echo WPUSB_App::SLUG; ?>-social-networks" data-element="sortable">
								<th scope="row">
									<label for="social-media">
										<?php _e( 'Social networks available', 'wpupper-share-buttons' ); ?>
									</label>
								</th>
									<?php
										$networks = WPUSB_Utils::get_networks_order();

									foreach ( $networks as $element => $title ) {
										$option_value = WPUSB_Utils::option( $element );
										$id           = ( 'google' === $element ) ? "{$element}-plus" : $element;
										self::td(
											array(
												'type'        => 'checkbox',
												'id'          => $id,
												'name'        => "{$option_social_media}[{$element}]",
												'value'       => $element,
												'is_checked'  => checked( $element, $option_value, false ),
												'label-class' => sprintf( '%1$s-icon %1$s-%2$s-icon', WPUSB_App::SLUG, $id ),
												'td-class'    => WPUSB_App::SLUG . '-select-item',
												'td-id'       => $element,
												'td-title'    => $title,
												'span'        => false,
												'class'       => $hide_class,
											)
										);
									}
									?>
							</tr>
							<tr class="<?php echo WPUSB_App::SLUG; ?>-layout-options">
								<th scope="row">

									<?php _e( 'Layout options', 'wpupper-share-buttons' ); ?>

									<p class="description">
										<?php _e( 'All layout supports responsive', 'wpupper-share-buttons' ); ?>
									</p>
								</th>
								<?php
									self::td(
										array(
											'type'       => 'radio',
											'id'         => 'default',
											'class'      => "{$hide_class} layout-preview",
											'name'       => "{$settings_option}[layout]",
											'value'      => 'default',
											'is_checked' => checked( 'default', $model->layout, false ),
											'title'      => __( 'Default', 'wpupper-share-buttons' ),
											'attr'       => array(
												'data-action' => 'primary-layout',
											),
										)
									);
									self::td(
										array(
											'type'       => 'radio',
											'id'         => 'buttons',
											'class'      => "{$hide_class} layout-preview",
											'name'       => "{$settings_option}[layout]",
											'value'      => 'buttons',
											'is_checked' => checked( 'buttons', $model->layout, false ),
											'title'      => __( 'Button', 'wpupper-share-buttons' ),
											'attr'       => array(
												'data-action' => 'primary-layout',
											),
										)
									);
									self::td(
										array(
											'type'       => 'radio',
											'id'         => 'rounded',
											'class'      => "{$hide_class} layout-preview",
											'name'       => "{$settings_option}[layout]",
											'value'      => 'rounded',
											'is_checked' => checked( 'rounded', $model->layout, false ),
											'title'      => __( 'Rounded', 'wpupper-share-buttons' ),
											'attr'       => array(
												'data-action' => 'primary-layout',
											),
										)
									);
									self::td(
										array(
											'type'       => 'radio',
											'id'         => 'square',
											'class'      => "{$hide_class} layout-preview",
											'name'       => "{$settings_option}[layout]",
											'value'      => 'square',
											'is_checked' => checked( 'square', $model->layout, false ),
											'title'      => __( 'Square', 'wpupper-share-buttons' ),
											'attr'       => array(
												'data-action' => 'primary-layout',
											),
										)
									);
									self::td(
										array(
											'type'       => 'radio',
											'id'         => 'square-plus',
											'class'      => "{$hide_class} layout-preview",
											'name'       => "{$settings_option}[layout]",
											'value'      => 'square-plus',
											'is_checked' => checked( 'square-plus', $model->layout, false ),
											'title'      => __( 'Square plus', 'wpupper-share-buttons' ),
											'attr'       => array(
												'data-action' => 'primary-layout',
											),
										)
									);
								?>
							</tr>
							<tr class="<?php echo WPUSB_App::SLUG; ?>-position-fixed">
								<th scope="row">
									<?php _e( 'Position fixed', 'wpupper-share-buttons' ); ?>
								</th>
								<?php
									self::td(
										array(
											'type'       => 'radio',
											'id'         => 'fixed-left',
											'class'      => "{$hide_class} layout-preview layout-fixed",
											'name'       => "{$settings_option}[position_fixed]",
											'value'      => 'fixed-left',
											'is_checked' => checked( 'fixed-left', $model->position_fixed, false ),
											'title'      => __( 'Fixed left', 'wpupper-share-buttons' ),
											'attr'       => array(
												'data-element' => 'position-fixed',
												'data-action'  => 'position-fixed',
											),
										)
									);
									self::td(
										array(
											'type'       => 'radio',
											'id'         => 'fixed-right',
											'class'      => "{$hide_class} layout-preview layout-fixed",
											'name'       => "{$settings_option}[position_fixed]",
											'value'      => 'fixed-right',
											'is_checked' => checked( 'fixed-right', $model->position_fixed, false ),
											'title'      => __( 'Fixed right', 'wpupper-share-buttons' ),
											'attr'       => array(
												'data-element' => 'position-fixed',
												'data-action'  => 'position-fixed',
											),
										)
									);
								?>
								<td class="<?php echo WPUSB_App::SLUG . '-fixed-clear'; ?>">
									<input type="button"
										   data-action="fixed-disabled"
										   value="<?php esc_attr_e( 'Clear', 'wpupper-share-buttons' ); ?>">
									<span><?php _e( 'Click to clear the positions.', 'wpupper-share-buttons' ); ?></span>
								</td>
							</tr>

							<?php
								$class_tr_hide = $tr_class_hide;

							if ( WPUSB_Utils::option( 'position_fixed', false ) ) {
								$class_tr_hide = '';
							}
							?>

							<tr class="<?php echo WPUSB_App::SLUG; ?>-position-fixed <?php echo $class_tr_hide; ?>"
								data-element="tr-fixed-layout">
								<th scope="row">
									<?php _e( 'Position fixed layout', 'wpupper-share-buttons' ); ?>
								</th>
									<?php
										$fixed_layout   = WPUSB_Utils::option( 'fixed_layout', false );
										$checked_layout = checked( 'buttons', $model->fixed_layout, false );

										self::td(
											array(
												'type'       => 'radio',
												'id'         => 'fixed-square',
												'class'      => "{$hide_class} layout-preview fixed-layout",
												'name'       => "{$settings_option}[fixed_layout]",
												'value'      => 'buttons',
												'is_checked' => ( $fixed_layout ) ? $checked_layout : 'checked="checked"',
												'title'      => __( 'Square', 'wpupper-share-buttons' ),
												'attr'       => array(
													'data-action' => 'fixed-layout',
												),
											)
										);

										self::td(
											array(
												'type'       => 'radio',
												'id'         => 'fixed-sqaure-space',
												'class'      => "{$hide_class} layout-preview fixed-layout",
												'name'       => "{$settings_option}[fixed_layout]",
												'value'      => 'square2',
												'is_checked' => checked( 'square2', $model->fixed_layout, false ),
												'title'      => __( 'Square', 'wpupper-share-buttons' ) . ' 2',
												'attr'       => array(
													'data-action' => 'fixed-layout',
												),
											)
										);

										self::td(
											array(
												'type'       => 'radio',
												'id'         => 'fixed-rounded',
												'class'      => "{$hide_class} layout-preview fixed-layout",
												'name'       => "{$settings_option}[fixed_layout]",
												'value'      => 'default',
												'is_checked' => checked( 'default', $model->fixed_layout, false ),
												'title'      => __( 'Rounded', 'wpupper-share-buttons' ),
												'attr'       => array(
													'data-action' => 'fixed-layout',
												),
											)
										);
									?>
							</tr>

							<?php
								$class_tr_hide = $tr_class_hide;

							if ( WPUSB_Utils::option( 'fixed_layout' ) === 'default' ) {
								$class_tr_hide = '';
							}

								parent::tr(
									array(
										'key'         => 'text-label-fixed-default',
										'label'       => __( 'Text below sharing count', 'wpupper-share-buttons' ),
										'tr_class'    => $class_tr_hide,
										'tr_attr'     => array(
											'data-element' => 'tr-fixed-label',
										),
										'attr'        => array(
											'data-action' => 'fixed-label',
										),
										'placeholder' => __( 'Change text below sharing count. Default SHARES', 'wpupper-share-buttons' ),
										'text'        => sprintf(
											__( 'Used in %1$s %2$s.', 'wpupper-share-buttons' ),
											strtolower( __( 'Position fixed layout', 'wpupper-share-buttons' ) ),
											strtolower( __( 'Rounded', 'wpupper-share-buttons' ) )
										),
									)
								);

								$plus_share_label_class = $tr_class_hide;

							if ( WPUSB_Utils::option( 'layout' ) === 'square-plus' ) {
								$plus_share_label_class = '';
							}

								parent::tr(
									array(
										'key'         => 'share-count-label',
										'label'       => sprintf( __( '%s: Text below sharing count', 'wpupper-share-buttons' ), __( 'Square plus', 'wpupper-share-buttons' ) ),
										'tr_class'    => $plus_share_label_class,
										'tr_attr'     => array(
											'data-element' => 'tr-share-plus-label',
										),
										'attr'        => array(
											'data-action' => 'plus-share-label',
										),
										'placeholder' => __( 'Change text below sharing count. Default SHARES', 'wpupper-share-buttons' ),
										'text'        => sprintf( __( 'Used in %s layout.', 'wpupper-share-buttons' ), __( 'Square plus', 'wpupper-share-buttons' ) ),
									)
								);

								parent::tr(
									array(
										'type'  => 'number',
										'key'   => 'icons-size',
										'class' => 'small-text',
										'label' => __( 'Icons size', 'wpupper-share-buttons' ),
										'span'  => 'px',
										'attr'  => array(
											'data-action' => 'icons-size',
										),
									)
								);

								$class_tr_hide = $tr_class_hide;
								$layouts       = array(
									'default' => 1,
									'buttons' => 1,
									'rounded' => 1,
									'square'  => 1,
								);

							if ( isset( $layouts[ $model->layout ] ) ) {
								$class_tr_hide = '';
							}

								parent::tr(
									array(
										'key'      => 'counts-bg-color',
										'label'    => __( 'Share count background color', 'wpupper-share-buttons' ),
										'tr_class' => $class_tr_hide,
										'tr_attr'  => array(
											'data-element' => 'tr-share-count-bg-color',
										),
										'attr'     => array(
											'data-element'     => 'text',
											'data-style'       => 'background-color',
											'data-colorpicker' => 'true',
										),
										'text' => sprintf(
											__( 'Layouts: %1$s, %2$s, %3$s and %4$s.', 'wpupper-share-buttons' ),
											__( 'Default', 'wpupper-share-buttons' ),
											__( 'Button', 'wpupper-share-buttons' ),
											__( 'Rounded', 'wpupper-share-buttons' ),
											__( 'Square', 'wpupper-share-buttons' )
										),
									)
								);

								parent::tr(
									array(
										'key' => 'counts-text-color',
										'label' => __( 'Share count text color', 'wpupper-share-buttons' ),
										'attr'     => array(
											'data-element'     => 'text',
											'data-style'       => 'color',
											'data-colorpicker' => 'true',
										),
									)
								);

								parent::tr(
									array(
										'key'   => 'icons-color',
										'label' => __( 'Icons color', 'wpupper-share-buttons' ),
										'attr'  => array(
											'data-element'     => 'icons-color',
											'data-style'       => 'color',
											'data-colorpicker' => 'true',
										),
									)
								);

								$class_tr_hide = $tr_class_hide;
								$layouts       = array(
									'buttons'     => 1,
									'square-plus' => 1,
								);

							if ( isset( $layouts[ $model->layout ] ) || WPUSB_Utils::option( 'position_fixed', false ) ) {
								$class_tr_hide = '';
							}

								parent::tr(
									array(
										'key'      => 'button-bg-color',
										'label'    => __( 'Buttons background color', 'wpupper-share-buttons' ),
										'tr_class' => $class_tr_hide,
										'tr_attr'  => array(
											'data-element' => 'tr-button-bg-color',
										),
										'attr'     => array(
											'data-element'     => 'bg-color',
											'data-style'       => 'background-color',
											'data-colorpicker' => 'true',
										),
										'text' => sprintf(
											__( 'Layouts: %1$s, %2$s, and %3$s.', 'wpupper-share-buttons' ),
											__( 'Button', 'wpupper-share-buttons' ),
											__( 'Square plus', 'wpupper-share-buttons' ),
											__( 'Position fixed', 'wpupper-share-buttons' )
										),
									)
								);

								parent::tr(
									array(
										'key'   => 'btn-inside-color',
										'label' => __( 'Buttons title color', 'wpupper-share-buttons' ),
										'attr'  => array(
											'data-element'     => 'inside',
											'data-style'       => 'color',
											'data-colorpicker' => 'true',
										),
									)
								);

								parent::tr(
									array(
										'key'         => 'class',
										'label'       => __( 'Custom class', 'wpupper-share-buttons' ),
										'placeholder' => __( 'Custom class for primary div', 'wpupper-share-buttons' ),
									)
								);

								parent::tr(
									array(
										'key'         => 'title',
										'label'       => __( 'Title', 'wpupper-share-buttons' ),
										'placeholder' => __( 'Insert the title here.', 'wpupper-share-buttons' ),
										'text'        => __( 'Text to display above the sharing buttons.', 'wpupper-share-buttons' ),
									)
								);

								parent::tr(
									array(
										'key'         => 'fixed-context',
										'label'       => __( 'HTML id attribute', 'wpupper-share-buttons' ),
										'placeholder' => __( 'Enter name to context of search. ID of content tag', 'wpupper-share-buttons' ),
										'text'        => __( 'This is to set the fixed layout to the left of the post content. <strong>Example:</strong> <code>wrap</code> use {id} for post id.', 'wpupper-share-buttons' ),
									)
								);

								parent::tr(
									array(
										'type'    => 'checkbox',
										'key'     => 'fixed-top',
										'label'   => __( 'Fixed Items in top', 'wpupper-share-buttons' ),
										'checked' => 'fixed-top',
										'text'    => __( 'It is activated when scrolling the page on the buttons position.', 'wpupper-share-buttons' ),
									)
								);

								parent::tr(
									array(
										'type'    => 'checkbox',
										'key'     => 'referrer',
										'label'   => __( 'Highlighted by reference', 'wpupper-share-buttons' ),
										'checked' => 'yes',
										'text'    => __( 'This allows highlight the social network where the user Came from.', 'wpupper-share-buttons' ),
									)
								);

								parent::tr(
									array(
										'type'    => 'checkbox',
										'key'     => 'disabled-inside',
										'label'   => __( 'Remove button title', 'wpupper-share-buttons' ),
										'checked' => 1,
									)
								);

								parent::tr(
									array(
										'type'    => 'checkbox',
										'key'     => 'disabled-count',
										'label'   => __( 'Remove counter', 'wpupper-share-buttons' ),
										'checked' => 1,
									)
								);

								parent::tr(
									array(
										'type'    => 'checkbox',
										'key'     => 'pin-image-alt',
										'label'   => __( 'Pinterest alt text', 'wpupper-share-buttons' ),
										'checked' => 'yes',
										'text'    => __( 'Use in description of Pinterest the alt text of highlighted image in place of title of post.', 'wpupper-share-buttons' ),
									)
								);

								parent::tr(
									array(
										'type'    => 'number',
										'key'     => 'min-count-display',
										'label'   => __( 'Min count to display', 'wpupper-share-buttons' ),
										'class'   => 'small-text',
										'default' => 0,
										'text'    => __( 'When you enter the value, share counts are only displayed when the total counts of each item than equal to or greater than the informed value.', 'wpupper-share-buttons' ),
									)
								);
							?>
						</tbody>
					</table>

					<h3>
						<?php _e( 'Twitter share count', 'wpupper-share-buttons' ); ?>
					</h3>
					<p class="description">
					<?php
						_e( 'The share count Twitter is powered by <a href="http://newsharecounts.com" target="_blank">newsharecounts.com</a>, you have to sign up with your Twitter account to get free service and twitter count. Just visit the website, fill in the domain of your site and click Sign in with Twitter. That, and nothing else!', 'wpupper-share-buttons' );
					?>
					</p>

					<input type="hidden"
						   name="<?php echo $option_social_media; ?>[order]"
						   data-element="order"
						   value='<?php echo WPUSB_Utils::option( 'order' ); ?>'>

					<input type="hidden"
						   data-element="fixed"
						   name="<?php echo "{$settings_option}[fixed]"; ?>"
						   value="<?php echo WPUSB_Utils::option( 'fixed' ); ?>">
					<?php
						settings_fields( "{$settings_option}_group" );
						submit_button( __( 'Save Changes', 'wpupper-share-buttons' ) );
					?>
				</form>
			</div>
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
		$args   = self::_get_td_args( $args );
		$label  = self::_get_label( WPUSB_App::SLUG, $args );
	?>
		<?php printf( '<%s', $args['tag'] ); ?>
			id="<?php echo $args['td-id']; ?>"
			class="<?php echo $args['td-class']; ?>"
			title="<?php echo $args['td-title']; ?>">

			<input type="<?php echo $args['type']; ?>"
				   id="<?php printf( '%s-%s', WPUSB_App::SLUG, $args['id'] ); ?>"
				   class="<?php echo $args['class'] ; ?>"
				   name="<?php echo $args['name'] ; ?>"
				   value="<?php echo empty( $args['value'] ) ? $args['default'] : $args['value']; ?>"
				   placeholder="<?php echo $args['placeholder'] ; ?>"
					<?php echo self::_get_attributes( $args ); ?>
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

	public static function _get_attributes( $args ) {
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

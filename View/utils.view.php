<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Utils View
 * @version 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit;
}

abstract class WPUSB_Utils_View {

	protected static $options = array();

	protected static $prefix = null;

	protected static $args;

	protected static function set_args( $args ) {
		self::$args = (object) $args;
	}

	protected static function reset_args( $defaults ) {
		self::$args = (object) $defaults;
	}

	protected static function set_options( $options = array() ) {
		if ( empty( $options ) || ! is_array( $options ) ) {
			$model   = WPUSB_Setting::get_instance();
			$options = $model->get_options();
		}

		self::$options = $options;
	}

	protected static function unset_options() {
		self::$options = array();
	}

	protected static function set_prefix( $prefix ) {
		self::$prefix = $prefix;
	}

	protected static function unset_prefix( $prefix ) {
		self::$prefix = null;
	}

	public static function section( $title, $id ) {
	?>
		</table>
		<table class="form-table" id="<?php echo esc_attr( self::get_field_id( $id ) ); ?>">
			<tbody>
				<tr>
					<th class="no-padding">
						<h2 class="size-section">
							<?php echo esc_html( $title ); ?>
						</h2>
					</th>
				</tr>
			</tbody>
		</table>
		<table class="form-table">
	<?php
	}

	public static function get_default_args() {
		return array(
			'label'        => '',
			'type'         => 'text',
			'class'        => 'large-text',
			'tr_class'     => '',
			'key'          => '',
			'text'         => '',
			'link'         => '',
			'tag_text'     => 'p',
			'span'         => '',
			'tr_attr'      => '',
			'attr'         => '',
			'placeholder'  => '',
			'value'        => '',
			'block_strong' => '',
			'block_text'   => '',
			'options'      => array(),
			'prefix'       => WPUSB_App::SLUG,
			'multiple'     => false,
			'cols'         => 100,
			'rows'         => 5,
			'default'      => '',
			'checked'      => '1',
			'min'          => '',
			'max'          => '',
			'step'         => 1,
		);
	}

	public static function tr( $args = array() ) {
		$defaults = self::get_default_args();

		self::set_args( array_merge( $defaults, $args ) );

		switch ( self::$args->type ) :
			case 'select':
				self::_tr_select();
				break;

			case 'textarea':
				self::_tr_textarea();
				break;

			case 'checkbox':
				self::_tr_checkbox();
				break;

			default:
				self::_tr_input();
		endswitch;

		self::reset_args( $defaults );
	}

	private static function _tr_input() {
		$args     = self::$args;
		$value    = $args->type === 'checkbox' ? $args->checked : self::get_value();
		$field_id = self::get_field_id( $args->key );
	?>
		<tr class="<?php echo esc_attr( self::get_class( true ) ); ?>"
			<?php echo self::get_attrs( true ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>

			<th scope="row">
				<label for="<?php echo esc_attr( $field_id ); ?>">
					<?php echo esc_html( $args->label ); ?>
				</label>
			</th>
			<td>
				<?php
				if ( $args->type === 'checkbox' && $args->default !== '' ) {
					printf(
						'<input type="hidden" name="%s" value="%s">',
						esc_attr( self::get_field_name() ),
						esc_attr( $args->default )
					);
				}

				if ( ! empty( $args->left_text ) ) {
					printf(
						'<span class="%s">%s</span>',
						esc_attr( $args->left_text_class ),
						esc_attr( $args->left_text )
					);
				}
				?>
				<input
					   type="<?php echo esc_attr( $args->type ); ?>"
					   id="<?php echo esc_attr( $field_id ); ?>"
					   class="<?php echo esc_attr( self::get_class() ); ?>"
					   name="<?php echo esc_attr( self::get_field_name() ); ?>"
					   value="<?php echo esc_attr( $value ); ?>"
						<?php if ( $args->type === 'number' && $args->min ) : ?>
						   step="<?php echo esc_attr( $args->step ); ?>"
						   min="<?php echo esc_attr( $args->min ); ?>"
						   max="<?php echo esc_attr( $args->max ); ?>"
						<?php endif; ?>
						<?php
							   echo self::checked(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							   echo self::get_placeholder(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							   echo self::get_attrs(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						>
				<?php
				if ( ! empty( $args->span ) ) {
					printf(
						'<span class="description text-span">%s</span>',
						esc_html( $args->span )
					);
				}

				if ( ! empty( $args->text ) && empty( $args->block_text ) ) {
					echo self::get_text(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}

				if ( ! empty( $args->block_text ) ) {
					?>
					<div class="<?php echo esc_attr( self::get_field_id( 'blockquote' ) ); ?>">

						<?php echo self::get_text(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>

						<div class="description">
							<?php
								printf(
									'<strong>%s</strong> %s', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									$args->block_strong, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									$args->block_text // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								);
							?>
							</div>
						</div>
					<?php
				}
				?>
			</td>
		</tr>
	<?php
	}

	private static function _tr_select() {
		$args     = self::$args;
		$field_id = self::get_field_id( $args->key );
	?>
		<tr class="<?php echo esc_attr( self::get_class( true ) ); ?>"
			<?php echo self::get_attrs( true ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>

			<th scope="row">
				<label for="<?php echo esc_attr( $field_id ); ?>">
					<?php echo esc_html( $args->label ); ?>
				</label>
			</th>
			<td>
				<select
					class="<?php echo esc_attr( self::get_class() ); ?>"
					name="<?php echo esc_attr( self::get_field_name() ); ?>"
					id="<?php echo esc_attr( $field_id ); ?>"
					<?php
						echo WPUSB_Utils::get_component( 'select2' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo self::get_placeholder( 'data-' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo self::get_attrs(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo ( $args->multiple ) ? ' multiple="multiple"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				>
					<?php
					$value = self::get_value();

					if ( isset( $args->reverse ) && is_array( $value ) ) {
						$value = array_flip( $value );
					}

					foreach ( $args->options as $key => $option ) :
						printf(
							'<option value="%s" %s>%s</option>',
							esc_attr( $key ),
							WPUSB_Utils::selected( $key, $value ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							esc_html( $option )
						);
						endforeach;
					?>
				</select>
				<?php
				if ( ! empty( $args->text ) ) {
					printf( '<p class="description">%s</p>', esc_html( $args->text ) );
				}
				?>
			</td>
		</tr>
	<?php
	}

	private static function _tr_textarea() {
		$args     = self::$args;
		$field_id = self::get_field_id( $args->key );
	?>
		<tr class="<?php echo esc_attr( self::get_class( true ) ); ?>"
			<?php echo self::get_attrs( true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

			<th scope="row">
				<label for="<?php echo esc_attr( $field_id ); ?>">
					<?php echo esc_html( $args->label ); ?>
				</label>
			</th>
			<td>
				<textarea
					name="<?php echo esc_attr( self::get_field_name() ); ?>"
					class="<?php echo esc_attr( self::get_class() ); ?>"
					id="<?php echo esc_attr( $field_id ); ?>"
					rows="<?php echo esc_attr( $args->rows ); ?>"
					cols="<?php echo esc_attr( $args->cols ); ?>"
					<?php echo $args->attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				>
					<?php echo self::get_value(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</textarea>
				<?php
				if ( ! empty( $args->text ) ) {
					printf( '<p class="description">%s</p>', esc_html( $args->text ) );
				}
				?>
			</td>
		</tr>
	<?php
	}

	private static function _tr_checkbox() {
		$args     = self::$args;
		$value    = self::get_value();
		$prefix   = str_replace( '_', '-', $args->prefix );
		$field_id = self::get_field_id( $args->key );
	?>
		<tr <?php echo self::get_attrs( true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<th scope="row">
				<label for="<?php echo esc_attr( $field_id ); ?>">
					<?php echo esc_html( $args->label ); ?>
				</label>
			</th>
			<td>
				<div class="<?php echo esc_attr( $prefix ); ?>-custom-switch">
					<input type="checkbox"
						   id="<?php echo esc_attr( $field_id ); ?>"
						   class="<?php echo esc_attr( $prefix ); ?>-check"
						   name="<?php echo esc_attr( self::get_field_name() ); ?>"
						   value="<?php echo esc_attr( $args->checked ); ?>"
							<?php checked( $args->checked, $value ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php echo self::get_attrs(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

					<label for="<?php echo esc_attr( $field_id ); ?>">
						<span class="<?php echo esc_attr( $prefix ); ?>-inner"
							  data-title-on="<?php esc_html_e( 'YES', 'wpupper-share-buttons' ); ?>"
							  data-title-off="<?php esc_html_e( 'NO', 'wpupper-share-buttons' ); ?>"></span>
						<span class="<?php echo esc_attr( $prefix ); ?>-switch"></span>
					</label>
				</div>

				<?php
				if ( ! empty( $args->text ) ) {
					printf( '<p class="description">%s</p>', esc_html( $args->text ) );
				}
				?>
			</td>
		</tr>
	<?php
	}

	public static function get_text() {
		$args = self::$args;

		return sprintf(
			'<%1$s class="description" %3$s>%2$s %4$s</%1$s>',
			$args->tag_text,
			$args->text,
			( $args->tag_text === 'label' ) ? "for=\"{$args->key}\"" : '',
			self::get_link( $args->link )
		);
	}

	public static function get_link( $link ) {
		if ( empty( $link ) ) {
			return '';
		}

		return sprintf( '<a href="%1$s" target="_blank">%1$s</a>', esc_url( $link ) );
	}

	public static function get_key_name( $key ) {
		return str_replace( '-', '_', $key );
	}

	public static function get_field_name() {
		$args = self::$args;

		if ( ! is_null( self::$prefix ) ) {
			$args->prefix = self::$prefix;
		}

		$key = self::get_key_name( $args->key );

		return WPUSB_Utils::get_field_name( $key, $args->prefix, $args->multiple );
	}

	public static function get_class( $tr = false ) {
		$args  = self::$args;
		$class = str_replace( '_', '-', $args->key );

		if ( $tr ) {
			return esc_attr( sprintf( 'tr-%s %s', $class, $args->tr_class ) );
		}

		if ( ! empty( $args->class ) ) {
			return esc_attr( sprintf( '%s %s', $args->class, $class ) );
		}

		return esc_attr( $class );
	}

	public static function get_value() {
		$args = self::$args;
		$key  = self::get_key_name( $args->key );

		if ( '' === $args->value && ! empty( self::$options ) ) {
			return WPUSB_Utils::get_value_by( self::$options, $key, $args->default );
		}

		if ( empty( $args->value ) ) {
			return $args->default;
		}

		return $args->value;
	}

	public static function get_attrs( $tr = false ) {
		$args  = self::$args;
		$attrs = ( $tr ) ? $args->tr_attr : $args->attr;

		if ( empty( $attrs ) || ! is_array( $attrs ) ) {
			return $attrs;
		}

		$attributes = '';

		foreach ( $attrs as $attr => $name ) :
			$attributes .= sprintf( " %s='%s'", $attr, $name );
		endforeach;

		return $attributes;
	}

	public static function get_placeholder( $data = '' ) {
		$args = self::$args;

		if ( empty( $args->placeholder ) ) {
			return '';
		}

		return sprintf( ' %splaceholder="%s" ', $data, $args->placeholder );
	}

	public static function checked() {
		$args = self::$args;

		if ( $args->type !== 'checkbox' ) {
			return;
		}

		return WPUSB_Utils::checked( $args->checked, self::get_value() );
	}

	public static function get_field_id( $id ) {
		return WPUSB_Utils::add_prefix( "-{$id}" );
	}

	public static function page_notice() {
		if ( apply_filters( WPUSB_Utils::add_prefix( '-admin-message' ), false ) ) {
			return;
		}
	?>
		<div class="updated inline">
			<p>
				<?php
					$message = sprintf(
						// translators: %1$s is the plugin name, %2$s are the stars.
						esc_html__( 'Help keep the free %1$s, you can make a donation or vote with %2$s at WordPress.org. Thank you very much!', 'wpupper-share-buttons' ),
						esc_html( WPUSB_App::NAME ),
						'★★★★★'
					);
					echo WPUSB_Utils::rm_tags( $message ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</p>
			<p>
				<a href="<?php echo esc_url( WPUSB_Utils::get_url_donate() ); ?>"
				   target="_blank"
				   class="button button-primary">

					<?php esc_html_e( 'Make a donation', 'wpupper-share-buttons' ); ?>
				</a>

				<a href="https://wordpress.org/support/plugin/wpupper-share-buttons/reviews/?filter=5#postform"
				   target="_blank"
				   class="button button-secondary">

						<?php esc_html_e( 'Make a review', 'wpupper-share-buttons' ); ?>
			   </a>
			</p>
		</div>
	<?php
	}

	public static function update_notice() {
	?>
		<div class="updated notice is-dismissible" id="updated-notice">
			<p><strong><?php esc_html_e( 'Settings saved.', 'wpupper-share-buttons' ); ?></strong></p>
			<button class="notice-dismiss"></button>
		</div>
	<?php
	}

	public static function menu_top() {
	?>
		<div class="<?php echo esc_attr( WPUSB_App::SLUG ); ?>-menu">
			<ul>
				<li class="<?php echo esc_attr( WPUSB_Utils::selected_menu( WPUSB_Setting::HOME_SETTINGS ) ); ?>">
					<a href="<?php echo esc_url( WPUSB_Utils::get_page_url( WPUSB_Setting::HOME_SETTINGS ) ); ?>">
						<?php esc_html_e( 'General', 'wpupper-share-buttons' ); ?>
					</a>
				</li>

				<li class="<?php echo esc_attr( WPUSB_Utils::selected_menu( WPUSB_Setting::EXTRA_SETTINGS ) ); ?>">
					<a href="<?php echo esc_url( WPUSB_Utils::get_page_url( WPUSB_Setting::EXTRA_SETTINGS ) ); ?>">
						<?php esc_html_e( 'Extra Settings', 'wpupper-share-buttons' ); ?>
					</a>
				</li>

				<li class="<?php echo esc_attr( WPUSB_Utils::selected_menu( WPUSB_Setting::CUSTOM_CSS ) ); ?>">
					<a href="<?php echo esc_url( WPUSB_Utils::get_page_url( WPUSB_Setting::CUSTOM_CSS ) ); ?>">
						<?php esc_html_e( 'Custom CSS', 'wpupper-share-buttons' ); ?>
					</a>
				</li>

				<li class="<?php echo esc_attr( WPUSB_Utils::selected_menu( WPUSB_Setting::USE_OPTIONS ) ); ?>">
					<a href="<?php echo esc_url( WPUSB_Utils::get_page_url( WPUSB_Setting::USE_OPTIONS ) ); ?>">
						<?php esc_html_e( 'Use options', 'wpupper-share-buttons' ); ?>
					</a>
				</li>

				<?php if ( ! WPUSB_Utils::is_sharing_report_disabled() ) : ?>

				<li class="<?php echo esc_attr( WPUSB_Utils::selected_menu( WPUSB_Setting::SHARING_REPORT ) ); ?>">
					<a href="<?php echo esc_url( WPUSB_Utils::get_page_url( WPUSB_Setting::SHARING_REPORT ) ); ?>">
						<?php esc_html_e( 'Sharing Report', 'wpupper-share-buttons' ); ?>
					</a>
				</li>

				<?php endif; ?>

			</ul>
		</div>
	<?php
	}
}

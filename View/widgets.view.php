<?php
/**
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Widgets
 * @since 3.25
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

class WPUSB_Widgets_View {

	public static $instance = null;

	public static function set_instance( WPUpper_SB_Widget $instance ) {
		self::$instance = $instance;
	}

	public static function unset_instance() {
		self::$instance = null;
	}

	public static function field_input( $text, $id, $type = 'text' ) {
		$instance     = self::$instance;
		$prefix       = WPUSB_App::SLUG;
		$value        = $instance->get_property( $id );
		$class        = ( $type === 'number' ) ? 'small-text' : 'large-text';
		$after_label  = false;
		$class_label  = '';
		$attr         = '';
		$placeholders = array(
			'post_title'   => __( 'Override post title', WPUSB_App::TEXTDOMAIN ),
			'url'          => __( 'Override permalinks', WPUSB_App::TEXTDOMAIN ),
			'custom_class' => __( 'Class name for CSS customization' ),
		);
		$placeholder = isset( $placeholders[ $id ] ) ? $placeholders[ $id ] : '';

		if ( $type === 'color' ) {
			$class       = '';
			$after_label = true;
			$class_label = "{$prefix}-label-color";
			$type        = 'text';
			$attr        = 'data-element="color-picker"';
		}

		$label = self::get_label( $instance, $id, $text, $class_label );
	?>
		<p>
			<?php
				if ( ! $after_label ) {
					echo $label;
				}
			?>
			<input type="<?php echo $type; ?>"
				   id="<?php echo esc_attr( $instance->get_field_id( $id ) ); ?>"
			       name="<?php echo esc_attr( $instance->get_field_name( $id ) ); ?>"
			       class="<?php echo $class; ?>"
			       value="<?php echo $value; ?>"
			       placeholder="<?php echo $placeholder; ?>"
			       <?php echo $attr; ?>>

			<?php echo ( $type === 'number' ) ? 'px' : ''; ?>

			<?php
				if ( $after_label ) {
					echo $label;
				}
			?>
		</p>
	<?php
	}

	public static function get_label( $instance, $id, $text, $class_label ) {
		$prefix   = WPUSB_App::SLUG;
		$field_id = esc_attr( $instance->get_field_id( $id ) );
		$class    = "{$class_label} {$prefix}-{$id}";

		return sprintf( '<label for="%s" class="%s-label">%s</label>', $field_id, $class, $text );
	}

	public static function field_select( $text, $id, $options ) {
		$instance = self::$instance;
		$current  = $instance->get_property( $id );
	?>
		<p class="<?php echo WPUSB_App::SLUG . '-widget-select-content'; ?>">
			<label for="<?php echo esc_attr( $instance->get_field_id( $id ) ); ?>">
				<?php echo $text; ?>
			</label>

			<select name="<?php echo esc_attr( $instance->get_field_name( $id ) ); ?>"
				    id="<?php echo esc_attr( $instance->get_field_id( $id ) ); ?>">
			<?php
				foreach ( $options as $key => $option ) :
					printf(
						'<option value="%s"%s>%s</option>',
						$key,
						selected( $key, $current, false ),
						$option
					);
				endforeach;
			?>
			</select>
		</p>
	<?php
	}

	public static function field_checkbox( $text, $id ) {
		$instance = self::$instance;
		$prefix   = WPUSB_App::SLUG;
		$value    = $instance->get_property( $id );
	?>
		<div class="<?php echo $prefix; ?>-widget-checkbox-content">
			<div class="<?php echo $prefix; ?>-widget-text">
				<?php echo $text; ?>
			</div>
	<?php
		WPUSB_Settings_View::add_checkbox(array(
			'name'    => esc_attr( $instance->get_field_name( $id ) ),
			'id'      => esc_attr( $instance->get_field_id( $id ) ),
			'checked' => checked( 1, $value, false ),
			'value'   => true,
		));
	?>
		</div>
	<?php
	}

	public static function social_items() {
		$instance = self::$instance;
		$prefix   = WPUSB_App::SLUG;
	?>
		<table id="<?php echo $prefix; ?>-widget-table">
			<tbody>
				<tr class="<?php echo $prefix; ?>-social-networks"
					data-element="social-items">

					<th class="strong">
						<?php _e( 'Drag & Drop to order and click to select', WPUSB_App::TEXTDOMAIN ); ?>
					</th>
					<?php
						$order = $instance->get_property( 'items', array() );
						$items = array_merge( $order, WPUSB_Social_Elements::$items_available );

						$instance->render_checkboxes( $items );
					?>
				</tr>
			</tbody>
		</table>
	<?php
	}

	public static function follow_us_networks( $networks ) {
		$instance = self::$instance;
		$prefix   = WPUSB_App::SLUG;
	?>
		<table id="<?php echo $prefix; ?>-widget-table">
			<tbody>
				<tr class="<?php echo $prefix; ?>-social-networks"
					data-element="social-items">

					<th>
						<span class="strong">
							<?php _e( 'Drag & Drop to order and click to select', WPUSB_App::TEXTDOMAIN ); ?>
						</span>
						<span class="<?php echo $prefix; ?>-info-error <?php echo $prefix; ?>-hide"
						      data-message="<?php _e( 'The [item] URL field is empty.', WPUSB_App::TEXTDOMAIN ); ?>"
						      data-element="info-message"></span>
					</th>
					<?php
						$items = $instance->get_property( 'items', array() );
						$instance->render_checkboxes( $networks );
					?>
				</tr>
			</tbody>
		</table>
	<?php
	}

	public static function follow_us_fields( $network, $id ) {
		$instance   = self::$instance;
		$prefix     = WPUSB_App::SLUG;
		$field_id   = esc_attr( $instance->get_field_id( $id ) );
		$field_name = esc_attr( $instance->get_field_name( $id ) );
		$is_email   = ( $id === 'email' );
	?>
		<p id="<?php printf( '%s-follow-us-item', $prefix ); ?>">

			<a class="<?php printf( '%s-title', $prefix ); ?>"
			      data-action="title"
			      data-item="<?php echo $id; ?>">

				<?php echo $network->name; ?>

				<span class="<?php printf( '%s-arrow', $prefix ); ?>"
				      data-element="arrow">
					&#9662;
				</span>
			</a>

			<span class="<?php printf( '%s-fields-content', $prefix ); ?>"
			      data-field="content"
			      data-element="<?php echo $id; ?>">

			    <?php if ( ! $is_email ) : ?>

				<label for="<?php echo $field_id; ?>-url">
					<?php _e( 'Enter the network URL here:', WPUSB_App::TEXTDOMAIN ); ?>
				</label>
				<input type="text"
					   id="<?php echo $field_id; ?>-url"
					   class="large-text"
					   data-action="field-url"
					   data-element="<?php echo $id; ?>-url"
				       name="<?php printf( '%s[url]', $field_name ); ?>"
				       value="<?php echo esc_url( $instance->get_network( $id, 'url' ) ); ?>">

				<span class="description">
					<?php
						printf(
							'<span class="bold">%s</span> %s',
							__( 'Example:', WPUSB_App::TEXTDOMAIN ),
							$network->url
						);
					?>
				</span>

				<?php endif; ?>

				<?php
					if ( $is_email ) :
						$value       = esc_attr( $instance->get_network( $id, 'email' ) );
						$admin_email = WPUSB_Utils::rm_tags( get_option( 'admin_email' ) );
						$subject     = esc_attr( $instance->get_network( $id, 'subject' ) );
				?>

				<label for="<?php echo $field_id; ?>-email">
					<?php _e( 'Your email:', WPUSB_App::TEXTDOMAIN ); ?>
				</label>
				<input type="text"
					   id="<?php echo $field_id; ?>-email"
					   class="large-text"
				       name="<?php printf( '%s[email]', $field_name ); ?>"
				       value="<?php echo empty( $value ) ? $admin_email : $value; ?>">

				<label for="<?php echo $field_id; ?>-subject">
					<?php _e( 'Subject:', WPUSB_App::TEXTDOMAIN ); ?>
				</label>
				<input type="text"
					   id="<?php echo $field_id; ?>-subject"
					   class="large-text"
				       name="<?php printf( '%s[subject]', $field_name ); ?>"
				       value="<?php echo empty( $subject ) ? $network->subject : $subject; ?>">

				<?php endif; ?>

				<label for="<?php echo $field_id; ?>-title">
					<?php _e( 'Give the title:', WPUSB_App::TEXTDOMAIN ); ?>
				</label>
				<input type="text"
					   id="<?php echo $field_id; ?>-title"
					   class="large-text"
				       name="<?php printf( '%s[title]', $field_name ); ?>"
				       value="<?php echo esc_attr( $instance->get_network( $id, 'title' ) ); ?>"
				       placeholder="<?php echo $network->title; ?>">
			</span>
		</p>
	<?php
	}
}
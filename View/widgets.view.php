<?php
/**
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Widgets
 * @since 3.25
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit;
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
		$value        = $instance->get_property( $id );
		$class        = ( $type === 'number' ) ? 'small-text' : 'large-text';
		$after_label  = false;
		$class_label  = '';
		$attr         = '';
		$placeholders = array(
			'post_title'   => __( 'Override post title', 'wpupper-share-buttons' ),
			'url'          => __( 'Override permalinks', 'wpupper-share-buttons' ),
			'custom_class' => __( 'Class name for CSS customization' ),
		);
		$placeholder = isset( $placeholders[ $id ] ) ? $placeholders[ $id ] : '';

		if ( $type === 'color' ) {
			$class       = '';
			$after_label = true;
			$class_label = WPUSB_App::SLUG . '-label-color';
			$type        = 'text';
			$attr        = 'data-element="color-picker"';
		}

		$label = self::get_label( $instance, $id, $text, $class_label );
	?>
		<p>
			<?php
			if ( ! $after_label ) {
				echo $label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
			<input type="<?php echo esc_attr( $type ); ?>"
				   id="<?php echo esc_attr( $instance->get_field_id( $id ) ); ?>"
				   name="<?php echo esc_attr( $instance->get_field_name( $id ) ); ?>"
				   class="<?php echo esc_attr( $class ); ?>"
				   value="<?php echo esc_attr( $value ); ?>"
				   placeholder="<?php echo esc_attr( $placeholder ); ?>"
					<?php echo $attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

			<?php echo ( $type === 'number' ) ? 'px' : ''; ?>

			<?php
			if ( $after_label ) {
				echo $label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</p>
	<?php
	}

	public static function get_label( $instance, $id, $text, $class_label ) {
		$field_id = esc_attr( $instance->get_field_id( $id ) );
		$class    = WPUSB_App::SLUG . '-' . $id;

		return sprintf( '<label for="%s" class="%s %s-label">%s</label>', $field_id, $class_label, $class, $text );
	}

	public static function field_select( $text, $id, $options ) {
		$instance = self::$instance;
		$current  = $instance->get_property( $id );
	?>
		<p class="<?php echo esc_attr( sprintf( '%1$s-%2$s %1$s-%3$s-widget', WPUSB_App::SLUG, 'widget-select-content', $id ) ); ?>">
			<label for="<?php echo esc_attr( $instance->get_field_id( $id ) ); ?>">
				<?php echo esc_html( $text ); ?>
			</label>

			<select name="<?php echo esc_attr( $instance->get_field_name( $id ) ); ?>"
					id="<?php echo esc_attr( $instance->get_field_id( $id ) ); ?>">
			<?php
			foreach ( $options as $key => $option ) :
				printf(
					'<option value="%s"%s>%s</option>',
					esc_attr( $key ),
					selected( $key, $current, false ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					esc_html( $option )
				);
				endforeach;
			?>
			</select>
		</p>
	<?php
	}

	public static function field_checkbox( $text, $id ) {
		$instance = self::$instance;
		$value    = $instance->get_property( $id );
	?>
		<div class="<?php echo esc_attr( WPUSB_App::SLUG ); ?>-widget-checkbox-content">
			<div class="<?php echo esc_attr( WPUSB_App::SLUG ); ?>-widget-text">
				<?php echo esc_html( $text ); ?>
			</div>
	<?php
		self::add_checkbox(
			array(
				'name'    => esc_attr( $instance->get_field_name( $id ) ),
				'id'      => esc_attr( $instance->get_field_id( $id ) ),
				'checked' => checked( 1, $value, false ),
				'value'   => true,
			)
		);
	?>
		</div>
	<?php
	}

	public static function social_items() {
		$instance = self::$instance;
	?>
		<table id="<?php echo esc_attr( WPUSB_App::SLUG ); ?>-widget-table">
			<tbody>
				<tr class="<?php echo esc_attr( WPUSB_App::SLUG ); ?>-social-networks"
					data-element="social-items">

					<th class="strong">
						<?php esc_html_e( 'Drag & Drop to order and click to select', 'wpupper-share-buttons' ); ?>
					</th>
					<?php
					$instance->render_checkboxes( array_merge(
						$instance->get_property( 'items', array() ),
						WPUSB_Social_Elements::$items_available
					) );
					?>
				</tr>
			</tbody>
		</table>
	<?php
	}

	public static function follow_us_networks( $networks ) {
		$instance = self::$instance;
	?>
		<table id="<?php echo esc_attr( WPUSB_App::SLUG ); ?>-widget-table">
			<tbody>
				<tr class="<?php echo esc_attr( WPUSB_App::SLUG ); ?>-social-networks"
					data-element="social-items">

					<th>
						<span class="strong">
							<?php esc_html_e( 'Drag & Drop to order and click to select', 'wpupper-share-buttons' ); ?>
						</span>
						<span class="<?php echo esc_attr( WPUSB_App::SLUG ); ?>-info-error <?php echo esc_attr( WPUSB_App::SLUG ); ?>-hide"
							  data-message="<?php esc_html_e( 'The [item] URL field is empty.', 'wpupper-share-buttons' ); ?>"
							  data-element="info-message"></span>
					</th>
					<?php $instance->render_checkboxes( $networks ); ?>
				</tr>
			</tbody>
		</table>
	<?php
	}

	public static function follow_us_fields( $network, $id ) {
		$instance   = self::$instance;
		$field_id   = esc_attr( $instance->get_field_id( $id ) );
		$field_name = esc_attr( $instance->get_field_name( $id ) );
	?>
		<p class="<?php printf( '%s-follow-us-item', esc_attr( WPUSB_App::SLUG ) ); ?>">

			<a class="<?php printf( '%s-title', esc_attr( WPUSB_App::SLUG ) ); ?>"
			   onclick="! window.WPUSB?.legacyWidgetsInlineScriptLoaded && jQuery(this).closest('p').find('[data-field=content]').toggle(100);"
			   data-action="title"
			   data-item="<?php echo esc_attr( $id ); ?>">

				<?php echo esc_html( $network->name ); ?>

				<span class="<?php printf( '%s-arrow', esc_attr( WPUSB_App::SLUG ) ); ?>"
					  data-element="arrow">
					&#9662;
				</span>
			</a>

			<span class="<?php printf( '%s-fields-content', esc_attr( WPUSB_App::SLUG ) ); ?>"
				  data-field="content"
				  data-element="<?php echo esc_attr( $id ); ?>">

				<?php
				if ( method_exists( __CLASS__, "render_{$network->method}" ) ) {
					call_user_func_array(
						array( __CLASS__, "render_{$network->method}" ),
						array( $instance, $id, $field_id, $field_name, $network )
					);
				}
				?>
				<label for="<?php echo esc_attr( $field_id ); ?>-title">
					<?php esc_html_e( 'Give the title:', 'wpupper-share-buttons' ); ?>
				</label>
				<input type="text"
					   id="<?php echo esc_attr( $field_id ); ?>-title"
					   class="large-text"
					   name="<?php printf( '%s[title]', esc_attr( $field_name ) ); ?>"
					   value="<?php echo esc_attr( $instance->get_network( $id, 'title' ) ); ?>"
					   placeholder="<?php echo esc_attr( $network->title ); ?>">
			</span>
		</p>
	<?php
	}

	public static function render_default( $instance, $id, $field_id, $field_name, $network ) {
	?>
		<label for="<?php echo esc_attr( $field_id ); ?>-url">
			<?php esc_html_e( 'Enter the network URL here:', 'wpupper-share-buttons' ); ?>
		</label>
		<input type="text"
				id="<?php echo esc_attr( $field_id ); ?>-url"
				class="large-text"
				data-action="field-url"
				data-element="<?php echo esc_attr( $id ); ?>-url"
				name="<?php printf( '%s[url]', esc_attr( $field_name ) ); ?>"
				value="<?php echo esc_url( $instance->get_network( $id, 'url' ) ); ?>">

		<span class="description">
			<?php
				printf(
					'<span class="bold">%s</span> %s',
					esc_html__( 'Example:', 'wpupper-share-buttons' ),
					esc_url( $network->url )
				);
			?>
		</span>
	<?php
	}

	public static function render_email( $instance, $id, $field_id, $field_name, $network ) {
		$value       = esc_attr( $instance->get_network( $id, 'email' ) );
		$admin_email = WPUSB_Utils::rm_tags( get_option( 'admin_email' ) );
		$subject     = esc_attr( $instance->get_network( $id, 'subject' ) );
	?>
		<label for="<?php echo esc_attr( $field_id ); ?>-email">
		<?php esc_html_e( 'Your email:', 'wpupper-share-buttons' ); ?>
		</label>
		<input type="text"
			id="<?php echo esc_attr( $field_id ); ?>-email"
			class="large-text"
			name="<?php printf( '%s[email]', esc_attr( $field_name ) ); ?>"
			value="<?php echo esc_attr( empty( $value ) ? $admin_email : $value ); ?>">

		<label for="<?php echo esc_attr( $field_id ); ?>-subject">
		<?php esc_html_e( 'Subject:', 'wpupper-share-buttons' ); ?>
		</label>
		<input type="text"
			id="<?php echo esc_attr( $field_id ); ?>-subject"
			class="large-text"
			name="<?php printf( '%s[subject]', esc_attr( $field_name ) ); ?>"
			value="<?php echo esc_attr( empty( $subject ) ? $network->subject : $subject ); ?>">
	<?php
	}

	public static function render_whatsapp( $instance, $id, $field_id, $field_name, $network ) {
		$value   = esc_attr( $instance->get_network( $id, 'phone' ) );
		$message = esc_attr( $instance->get_network( $id, 'message' ) );
	?>
		<label for="<?php echo esc_attr( $field_id ); ?>-whatsapp">
			<?php esc_html_e( 'WhatsApp number:', 'wpupper-share-buttons' ); ?>
		</label>

		<input
			type="number"
			id="<?php echo esc_attr( $field_id ); ?>-whatsapp"
			class="large-text"
			name="<?php printf( '%s[phone]', esc_attr( $field_name ) ); ?>"
			value="<?php echo esc_attr( $value ); ?>"
		>

		<span class="description">
			<?php echo esc_html( $network->helper_phone ); ?>
		</span>

		<label for="<?php echo esc_attr( $field_id ); ?>-message">
			<?php esc_html_e( 'Message:', 'wpupper-share-buttons' ); ?>
		</label>

		<textarea
			id="<?php echo esc_attr( $field_id ); ?>-message"
			class="large-text"
			name="<?php printf( '%s[message]', esc_attr( $field_name ) ); ?>"
			rows="4"
		><?php echo esc_html( $message ); ?></textarea>

		<span class="description">
			<?php echo esc_html( $network->helper_text ); ?>
		</span>
	<?php
	}

	public static function add_checkbox( $args = array() ) {
		$prefix   = esc_attr( WPUSB_App::SLUG );
		$defaults = array(
			'name'        => '',
			'id'          => '',
			'checked'     => '',
			'value'       => '',
			'description' => '',
		);
		$args      = array_merge( $defaults, $args );
		$on_title  = esc_attr__( 'YES', 'wpupper-share-buttons' );
		$off_title = esc_attr__( 'NO', 'wpupper-share-buttons' );

		// phpcs:disable WordPress.Security.EscapeOutput.HeredocOutputNotEscaped
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
// phpcs:enable WordPress.Security.EscapeOutput.HeredocOutputNotEscaped
	}
}

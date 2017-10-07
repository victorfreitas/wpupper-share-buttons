<?php
/**
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Widgets
 * @since 3.25
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
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
		$field_id = esc_attr( $instance->get_field_id( $id ) );
		$class    = WPUSB_App::SLUG . '-' . $id;

		return sprintf( '<label for="%s" class="%s %s-label">%s</label>', $field_id, $class_label, $class, $text );
	}

	public static function field_select( $text, $id, $options ) {
		$instance = self::$instance;
		$current  = $instance->get_property( $id );
	?>
		<p class="<?php printf( '%1$s-%2$s %1$s-%3$s-widget', WPUSB_App::SLUG, 'widget-select-content', $id ); ?>">
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
		$value    = $instance->get_property( $id );
	?>
		<div class="<?php echo WPUSB_App::SLUG; ?>-widget-checkbox-content">
			<div class="<?php echo WPUSB_App::SLUG; ?>-widget-text">
				<?php echo $text; ?>
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
		<table id="<?php echo WPUSB_App::SLUG; ?>-widget-table">
			<tbody>
				<tr class="<?php echo WPUSB_App::SLUG; ?>-social-networks"
					data-element="social-items">

					<th class="strong">
						<?php _e( 'Drag & Drop to order and click to select', 'wpupper-share-buttons' ); ?>
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
	?>
		<table id="<?php echo WPUSB_App::SLUG; ?>-widget-table">
			<tbody>
				<tr class="<?php echo WPUSB_App::SLUG; ?>-social-networks"
					data-element="social-items">

					<th>
						<span class="strong">
							<?php _e( 'Drag & Drop to order and click to select', 'wpupper-share-buttons' ); ?>
						</span>
						<span class="<?php echo WPUSB_App::SLUG; ?>-info-error <?php echo WPUSB_App::SLUG; ?>-hide"
							  data-message="<?php _e( 'The [item] URL field is empty.', 'wpupper-share-buttons' ); ?>"
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
		$field_id   = esc_attr( $instance->get_field_id( $id ) );
		$field_name = esc_attr( $instance->get_field_name( $id ) );
		$is_email   = ( $id === 'email' );
	?>
		<p id="<?php printf( '%s-follow-us-item', WPUSB_App::SLUG ); ?>">

			<a class="<?php printf( '%s-title', WPUSB_App::SLUG ); ?>"
				  data-action="title"
				  data-item="<?php echo $id; ?>">

				<?php echo $network->name; ?>

				<span class="<?php printf( '%s-arrow', WPUSB_App::SLUG ); ?>"
					  data-element="arrow">
					&#9662;
				</span>
			</a>

			<span class="<?php printf( '%s-fields-content', WPUSB_App::SLUG ); ?>"
				  data-field="content"
				  data-element="<?php echo $id; ?>">

				<?php if ( ! $is_email ) : ?>

				<label for="<?php echo $field_id; ?>-url">
					<?php _e( 'Enter the network URL here:', 'wpupper-share-buttons' ); ?>
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
							esc_html__( 'Example:', 'wpupper-share-buttons' ),
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
				<?php _e( 'Your email:', 'wpupper-share-buttons' ); ?>
				</label>
				<input type="text"
				   id="<?php echo $field_id; ?>-email"
				   class="large-text"
				   name="<?php printf( '%s[email]', $field_name ); ?>"
				   value="<?php echo empty( $value ) ? $admin_email : $value; ?>">

				<label for="<?php echo $field_id; ?>-subject">
				<?php _e( 'Subject:', 'wpupper-share-buttons' ); ?>
				</label>
				<input type="text"
				   id="<?php echo $field_id; ?>-subject"
				   class="large-text"
				   name="<?php printf( '%s[subject]', $field_name ); ?>"
				   value="<?php echo empty( $subject ) ? $network->subject : $subject; ?>">

				<?php endif; ?>

				<label for="<?php echo $field_id; ?>-title">
					<?php _e( 'Give the title:', 'wpupper-share-buttons' ); ?>
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
		$on_title  = __( 'YES', 'wpupper-share-buttons' );
		$off_title = __( 'NO', 'wpupper-share-buttons' );

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
}

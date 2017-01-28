<?php
/**
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Widgets Controller
 * @since 3.25
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

class WPUSB_Widgets_View {

	public static $instance = null;

	public static function set_instance( WPUSB_Widgets_Controller $instance ) {
		self::$instance = $instance;
	}

	public static function field_input( $text, $id, $type = 'text' ) {
		$instance     = self::$instance;
		$prefix       = WPUSB_App::SLUG;
		$value        = $instance->get_property( $id );
		$class        = ( $type === 'number' ) ? 'small-text' : 'large-text';
		$placeholders = array(
			'post_title' => __( 'Override post title', WPUSB_App::TEXTDOMAIN ),
			'url'        => __( 'Override permalinks', WPUSB_App::TEXTDOMAIN ),
		);
		$placeholder = isset( $placeholders[ $id ] ) ? $placeholders[ $id ] : '';

		if ( $id === 'icons_color' || $id === 'icons_background' ) {
			$class = "{$prefix}-widget-colorpicker";
		}
	?>
		<p>
			<label for="<?php echo $instance->sanitize( $instance->get_field_id( $id ) ); ?>"
			 	   class="<?php echo "{$prefix}-{$id}"; ?>-label">
				<?php echo $text; ?>
			</label>

			<input type="<?php echo $type; ?>"
				   id="<?php echo $instance->sanitize( $instance->get_field_id( $id ) ); ?>"
			       name="<?php echo $instance->sanitize( $instance->get_field_name( $id ) ); ?>"
			       class="<?php echo $class; ?>"
			       value="<?php echo $value; ?>"
			       placeholder="<?php echo $placeholder; ?>">

			<?php echo ( $type === 'number' ) ? 'px' : ''; ?>
		</p>
	<?php
	}

	public static function field_select( $text, $id, $options ) {
		$instance = self::$instance;
		$current  = $instance->get_property( $id );
	?>
		<p class="<?php echo WPUSB_App::SLUG . '-widget-select-content'; ?>">
			<label for="<?php echo $instance->sanitize( $instance->get_field_id( $id ) ); ?>">
				<?php echo $text; ?>
			</label>

			<select name="<?php echo $instance->sanitize( $instance->get_field_name( $id ) ); ?>"
				    id="<?php echo $instance->sanitize( $instance->get_field_id( $id ) ); ?>">
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
			'name'    => $instance->sanitize( $instance->get_field_name( $id ) ),
			'id'      => $instance->sanitize( $instance->get_field_id( $id ) ),
			'checked' => checked( 1, $value, false ),
			'value'   => true,
		));
	?>
		</div>
	<?php
	}

	public static function social_items( $hash ) {
		$instance = self::$instance;
		$prefix   = WPUSB_App::SLUG;
	?>
		<table id="<?php echo $prefix; ?>-widget-table">
			<tbody>
				<tr class="<?php echo $prefix; ?>-social-networks"
					data-widget-hash="<?php echo $hash; ?>">
	<?php
		$elements = WPUSB_Social_Elements::social_media();
		$order    = $instance->get_property( 'items', array() );
		$items    = array_merge( $order, WPUSB_Social_Elements::$items_available );

		foreach ( $items as $key => $item ) :
			$element = $elements->{$item};
			$id 	 = ( 'google' == $key ) ? "{$key}-plus" : $key;

			WPUSB_Settings_View::td(array(
				'type'        => 'checkbox',
				'id'          => $instance->sanitize( $instance->get_field_id( $id ) ),
				'name'        => $instance->sanitize( $instance->get_field_name( 'items' ) ) . "[{$key}]",
				'value'       => $key,
				'label-class' => "{$prefix}-icon {$element->class}-icon",
				'td-class'    => "{$prefix}-td",
				'td-id'       => $key,
				'td-title'    => $element->name,
				'span'        => false,
				'class'       => 'hide-input',
				'is_checked'  => $instance->is_checked( $key ),
			));
		endforeach;
	?>
				</tr>
			</tbody>
		</table>
	<?php
	}
}
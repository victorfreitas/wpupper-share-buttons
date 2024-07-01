<?php
/**
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Widget Follow
 * @since 3.25
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit;
}

class WPUSB_Widget_Follow_View {

	public static function render_fields( $instance, $items ) {
		if ( empty( $items ) ) {
			esc_html_e( 'No social networks were enabled in the Widget.', 'wpupper-share-buttons' );
			return;
		}

		$custom_class = WPUSB_Utils::esc_class( $instance->get_property( 'custom_class', false ) );
		$layout       = $instance->get_property( 'layout' );
	?>
		  <div id="<?php echo esc_attr( WPUSB_Utils::get_widget_follow_attr_id( $instance->number ) ); ?>">
			<div id="<?php echo esc_attr( WPUSB_App::SLUG ); ?>-container-follow"
				 class="<?php echo esc_attr( sprintf( '%1$s-follow %1$s-follow-%2$s %3$s', WPUSB_App::SLUG, $layout, $custom_class ) ); ?>">

			<?php
				$networks = $instance->get_follow_us_networks();

			foreach ( $items as $item ) :
				if ( ! isset( $networks->{$item} ) ) {
					continue;
				}

				$network       = $networks->{$item};
				$type          = isset( $network->type ) ? $network->type : 'url';
				$link          = $instance->get_network( $item, $type );
				$current_title = $instance->get_network( $item, 'title' );
				$title         = empty( $current_title ) ? $network->title : $current_title;

				if ( $item === 'email' ) {
					$subject = sanitize_text_field( $instance->get_network( $item, 'subject' ) );
					$subject = empty( $subject ) ? $network->subject : $subject;
					$link    = sprintf( $network->link, $link, rawurlencode( $subject ) );
				}

				if ( $item === 'whatsapp' ) {
					$phone   = (int) $instance->get_network( $item, 'phone' );
					$message = sanitize_text_field( $instance->get_network( $item, 'message' ) );
					$link    = sprintf( $network->link, $phone, rawurlencode( $message ) );
				}

				$prefix   = WPUSB_App::SLUG;
				$svg_icon = WPUSB_Shares_View::get_svg_icon( "{$prefix}-{$item}-{$layout}", "{$prefix}-follow-icon" );
			?>
			<div class="<?php echo esc_attr( sprintf( '%1$s-item %1$s-%2$s', WPUSB_App::SLUG, $item ) ); ?>">
				<a href="<?php echo esc_url( $link ); ?>"
				   target="_blank"
				   class="<?php echo esc_attr( WPUSB_App::SLUG ); ?>-btn"
				   title="<?php echo esc_attr( $title ); ?>"
				   <?php echo isset( $network->attr ) ? $network->attr : ''; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
				>
					<?php echo $svg_icon; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
				</a>
			</div>

			<?php endforeach; ?>
			</div>
		</div>
	<?php
	}
}

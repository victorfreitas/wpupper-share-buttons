<?php
/**
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Widget Follow
 * @since 3.25
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

class WPUSB_Widget_Follow_View {

	public static function render_fields( $instance, $items ) {
		$prefix = WPUSB_App::SLUG;

		if ( empty( $items ) ) {
			_e( 'No social networks were enabled in the Widget.', WPUSB_App::TEXTDOMAIN );
			return;
		}

		$custom_class = WPUSB_Utils::esc_class( $instance->get_property( 'custom_class', false ) );
		$layout       = $instance->get_property( 'layout' );
	?>
	  	<div id="<?php echo WPUSB_Utils::get_widget_follow_attr_id( $instance->number ); ?>">
			<div id="<?php echo $prefix; ?>-container-follow"
				 class="<?php printf( '%1$s-follow %1$s-follow-%2$s %3$s', $prefix, $layout, $custom_class ); ?>">

			<?php
				$networks = $instance->get_networks();

				foreach ( $items as $item ) :
					$is_email = ( $item === 'email' );
					$type     = $is_email ? 'email' : 'url';
					$link     = $instance->get_network( $item, $type );
					$element  = ( 'google' === $item ) ? "{$item}-plus" : $item;

					if ( ! isset( $networks->{$item} ) || empty( $link ) ) {
						continue;
					}

					$network       = $networks->{$item};
					$current_title = $instance->get_network( $item, 'title' );
					$title         = ( empty( $current_title ) ) ? $network->title : $current_title;

					if ( $is_email ) {
						$subject = $instance->get_network( $item, 'subject' );
						$subject = empty( $subject ) ? $network->subject : $subject;
						$link    = sprintf( 'mailto:%s?subject=%s', $link, rawurlencode( $subject ) );
					}
			?>
				<div class="<?php printf( '%1$s-item %1$s-%2$s', $prefix, $element ); ?>">
					<a href="<?php echo $is_email ? WPUSB_Utils::rm_tags( $link ) : esc_url( $link ); ?>"
					   <?php echo ( $is_email ) ? '' : 'target="_blank"'; ?>
					   class="<?php echo $prefix; ?>-btn"
					   title="<?php echo $title; ?>">

						<i class="<?php printf( '%1$s-icon-%2$s-%3$s %1$s-follow-icon', $prefix, $element, $layout ); ?>"></i>
					</a>
				</div>

			<?php endforeach; ?>
			</div>
		</div>
	<?php
	}
}
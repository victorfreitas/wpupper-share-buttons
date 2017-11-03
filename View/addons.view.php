<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Extensions
 * @since 3.36
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
}

class WPUSB_Addons {

	/**
	 * Page display
	 *
	 * @since 3.36
	 * @param Null
	 * @return Void
	 */
	public static function render() {
		$addons = WPUSB_Setting::get_instance()->get_addons();
	?>
		<div class="wrap <?php echo WPUSB_App::SLUG . '-addons'; ?>">
			<h2>
				<?php _e( 'WPUpper Share Buttons', 'wpupper-share-buttons' ); ?>
			</h2>

			<p class="description">
				<?php _e( 'Add the Share Buttons automatically.', 'wpupper-share-buttons' ); ?>
			</p>

			<?php WPUSB_Utils_View::page_notice(); ?>

			<span class="<?php echo WPUSB_App::SLUG . '-title-wrap'; ?>">
				<?php _e( 'Extensions', 'wpupper-share-buttons' ); ?>
			</span>

			<?php WPUSB_Utils_View::menu_top(); ?>

			<div class="<?php echo WPUSB_App::SLUG . '-addons-wrap'; ?>">
				<div class="addon-items">

					<?php
					if ( $addons ) :
						foreach ( $addons as $addon ) :
					?>

					<div class="addon-item">
						<figure class="addon-thumb">
							<img src="<?php echo esc_url( $addon->image_src ); ?>">
						</figure>

						<div class="addon-content">
							<h3>
								<?php echo esc_html( $addon->title ); ?>
							</h3>
							<p>
								<?php echo esc_html( $addon->description ); ?>
							</p>
							<a href="<?php echo esc_url( $addon->href ); ?>" class="addon-btn btn-buy">
								<i class="dashicons-before dashicons-cart"></i> From: <?php echo esc_html( $addon->price ); ?>
							</a>

							<?php if ( isset( $addon->video ) ) : ?>

							<a href="<?php echo esc_url( $addon->video ); ?>" target="_blank" class="addon-btn btn-video">
								<i class="dashicons-before dashicons-controls-play"></i> <?php _e( 'View video', 'wpupper-share-buttons' ); ?>
							</a>

							<?php endif; ?>
						</div>
					</div>

					<?php
						endforeach;
					endif;
					?>

				</div>
			</div>
		</div>
	<?php
	}
}

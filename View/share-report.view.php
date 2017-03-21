<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Views Sharing Report
 * @version 2.3.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

class WPUSB_Sharing_Report_View {

	/**
	 * Display page sharing report
	 *
	 * @since 1.3
	 * @param Object $list_table
	 * @return void
	 */
	public static function render_sharing_report( $list_table ) {
		$domain = WPUSB_App::TEXTDOMAIN;
		$prefix = WPUSB_App::SLUG;

		$list_table->prepare_items();
	?>
		<div class="wrap">
			<h2><?php _e( 'WPUpper Share Buttons', $domain ); ?></h2>

			<p class="description">
				<?php _e( 'Add the Share Buttons automatically.', $domain ); ?>
			</p>

			<?php WPUSB_Utils_View::page_notice(); ?>

			<?php WPUSB_Utils_View::menu_top(); ?>

			<div class="<?php echo $prefix; ?>-settings-wrap">

				<?php do_action( WPUSB_Utils::add_prefix( 'sr_render' ), $list_table ); ?>

				<form class="share-report-form">

					<input type="hidden"
					       name="page"
					       value="<?php echo WPUSB_App::SLUG . '-sharing-report'; ?>">

					<?php
						$list_table->search_box( __( 'Search', $domain ), $prefix );
						$list_table->display();
					?>
				</form>

			</div>
		</div>
	<?php
	}

	/**
	 * Insert link in column title in wp list table
	 *
	 * @since 1.0
	 * @param Object $list
	 * @return String
	 */
	public static function get_permalink_title( $list ) {
		$permalink = esc_url( get_permalink( $list->post_id ) );
		$title     = get_the_title( $list->post_id );

		if ( empty( $title ) ) {
			$title = $list->post_title;
		}

		return sprintf(
			'<a href="%s" class="row-title" target="_blank">%s</a>',
			$permalink,
			WPUSB_Utils::rm_tags( $title )
		);
	}

	public static function render_date_range_filter() {
		$component   = sprintf( 'data-%s-component="datepicker"', WPUSB_App::SLUG );
		$date_format = _x( 'YYYY-MM-DD', 'placeholder', WPUSB_App::TEXTDOMAIN );
	?>
		<label class="<?php echo WPUSB_Utils::add_prefix( '-label' ); ?>">
			<?php _e( 'Start date:', WPUSB_App::TEXTDOMAIN ); ?>

			<input type="text" <?php echo $component; ?>
				   placeholder="<?php echo $date_format; ?>"
				   class="<?php echo WPUSB_Utils::add_prefix( '-datepicker' ); ?>"
				   data-to="1"
				   name="start_date"
				   maxlength="10"
				   value="<?php echo WPUSB_Utils::get( 'start_date' ); ?>">
		</label>

		<label class="<?php echo WPUSB_Utils::add_prefix( '-label' ); ?>">
			<?php _e( 'End date:', WPUSB_App::TEXTDOMAIN ); ?>

			<input type="text" <?php echo $component; ?>
				   placeholder="<?php echo $date_format; ?>"
				   class="<?php echo WPUSB_Utils::add_prefix( '-datepicker' ); ?>"
				   name="end_date"
				   maxlength="10"
				   value="<?php echo WPUSB_Utils::get( 'end_date' ); ?>">
		</label>
	<?php
	}
}
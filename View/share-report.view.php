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
		$time_cache  = WPUSB_Utils::option( 'report_cache_time', 10, 'intval' );
		$domain      = WPUSB_App::TEXTDOMAIN;
		$prefix      = WPUSB_App::SLUG;
		$description = __( 'This report has a cache of ', $domain );
		$minutes     = __( 'minutes', $domain );
		$time        = sprintf( _n( '%d minute', "%d {$minutes}", $time_cache, $domain ), $time_cache );

		$list_table->prepare_items();
	?>
		<div class="wrap">
			<h2><?php _e( 'WPUpper Share Buttons', $domain ); ?></h2>
			<p class="description"><?php _e( 'Add the Share Buttons automatically.', $domain ); ?></p>

			<?php WPUSB_Utils_View::page_notice(); ?>

			<span class="<?php echo $prefix; ?>-settings-title">
				<span class="description information-cache">
					<?php echo "{$description}{$time}."; ?>
				</span>
			</span>

			<?php WPUSB_Utils_View::menu_top(); ?>

			<div class="<?php echo $prefix; ?>-settings-wrap">

				<?php do_action( WPUSB_Utils::add_prefix( '_render_sharing_report' ), $list_table ); ?>

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

	public static function render_months_dropdown( $options, $selected )
	{
		$start_date = WPUSB_Utils::get( 'wpusb_start_date' );
		$end_date   = WPUSB_Utils::get( 'wpusb_start_date' );
		$disabled   = ( $start_date || $end_date ) ? 'disabled ="disabled"' : '';

		?>
		<label for="filter-by-date" class="screen-reader-text">
			<?php _e( 'Filter by date' ); ?>
		</label>

		<select name="m" <?php echo $disabled; ?> id="filter-by-date">
			<option value="0" <?php echo WPUSB_Utils::selected( $selected, 0 ); ?>>
				<?php _e( 'All dates' ); ?>
			</option>

			<?php echo $options; ?>
		</select>
		<?php
	}

	public static function render_date_range_filter()
	{
		$prefix    = WPUSB_App::SLUG;
		$component = "data-{$prefix}-component=\"datepicker\"";

		?>
		<label class="wpusb-label">
			<?php _e( 'Start date:', WPUSB_App::TEXTDOMAIN ); ?>
			<input type="text" <?php echo $component; ?>
				placeholder="dd/mm/yyyy"
				class="wpusb-datepicker"
				name="wpusb_start_date"
				value="<?php echo WPUSB_Utils::get( 'wpusb_start_date' ); ?>"/>
		</label>

		<label class="wpusb-label">
			<?php _e( 'End date:', WPUSB_App::TEXTDOMAIN ); ?>
			<input type="text" <?php echo $component; ?>
				placeholder="dd/mm/yyyy"
				class="wpusb-datepicker"
				name="wpusb_end_date"
				value="<?php echo WPUSB_Utils::get( 'wpusb_end_date' ); ?>"/>
		</label>
		<?php
	}
}
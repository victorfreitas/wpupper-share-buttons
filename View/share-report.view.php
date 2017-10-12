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
	exit( 0 );
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
		$list_table->prepare_items();
	?>
		<div class="wrap"
		     data-cookie-name="<?php echo WPUSB_Share_Report::OPTION_CSN_CLOSED; ?>"
			 <?php echo WPUSB_Utils::get_component( 'report' ); ?>>
			<h2><?php _e( 'WPUpper Share Buttons', 'wpupper-share-buttons' ); ?></h2>

			<p class="description">
				<?php _e( 'Add the Share Buttons automatically.', 'wpupper-share-buttons' ); ?>
			</p>

			<?php WPUSB_Utils_View::page_notice(); ?>

			<?php WPUSB_Utils_View::menu_top(); ?>

			<div class="<?php echo WPUSB_App::SLUG; ?>-settings-wrap">

				<?php do_action( WPUSB_Utils::add_prefix( 'sr_render' ), $list_table ); ?>

				<?php self::render_classification_by_provider(); ?>

				<form class="share-report-form">

					<input type="hidden"
						   name="page"
						   value="<?php echo WPUSB_App::SLUG . '-sharing-report'; ?>">

					<?php
						$list_table->search_box( __( 'Search', 'wpupper-share-buttons' ), WPUSB_App::SLUG );
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

	/**
	 * Render date range filter
	 *
	 * @since 3.32
	 * @param Null
	 * @return Void
	 */
	public static function render_date_range_filter() {
		$date_format = _x( 'YYYY-MM-DD', 'placeholder', 'wpupper-share-buttons' );
	?>
		<div class="<?php echo WPUSB_Utils::add_prefix( '-inline' ); ?>"
				<?php echo WPUSB_Utils::get_component( 'datepicker' ); ?>>

			<label class="<?php echo WPUSB_Utils::add_prefix( '-label' ); ?>">
				<?php _e( 'Start date:', 'wpupper-share-buttons' ); ?>

				<input type="text"
					   name="start_date"
					   data-element="start-date"
					   class="<?php echo WPUSB_Utils::add_prefix( '-datepicker' ); ?>"
					   placeholder="<?php echo $date_format; ?>"
					   maxlength="10"
					   value="<?php echo WPUSB_Utils::get( 'start_date' ); ?>">
			</label>

			<label class="<?php echo WPUSB_Utils::add_prefix( '-label' ); ?>">
				<?php _e( 'End date:', 'wpupper-share-buttons' ); ?>

				<input type="text"
					   name="end_date"
					   data-element="end-date"
					   class="<?php echo WPUSB_Utils::add_prefix( '-datepicker' ); ?>"
					   placeholder="<?php echo $date_format; ?>"
					   maxlength="10"
					   value="<?php echo WPUSB_Utils::get( 'end_date' ); ?>">
			</label>

		</div>
	<?php
	}

	/**
	 * Render btn export csv
	 *
	 * @since 3.32
	 * @param Null
	 * @return Void
	 */
	public static function export_csv_btn() {
	?>
		<button class="button button-primary" name="export" value="true">
			<?php _e( 'Export CSV', 'wpupper-share-buttons' ); ?>
		</button>
	<?php
	}

	/**
	 * Render table classification sharing counter by social network
	 *
	 * @since 3.35
	 * @param null
	 * @return Void
	 */
	public static function render_classification_by_provider() {
		$model         = new WPUSB_Share_Report();
		$top_providers = $model->get_total_share_by_provider();

		if ( ! $top_providers ) {
			return;
		}

		$active = WPUSB_Utils::cookie( WPUSB_Share_Report::OPTION_CSN_CLOSED, false, 'intval' ) ? '' : 'active';
	?>
		<div id="top-providers">
			<table>
				<caption data-action="toggle">
					<?php _e( 'Classification by social network', 'wpupper-share-buttons' ); ?>
					<i class="<?php echo $active ? '' : 'active'; ?>"></i>
				</caption>
			</table>
			<div class="providers-content <?php echo $active; ?>" data-element="toggle">
				<table>
				    <thead>
				        <tr>
				            <th>#</th>
				            <th><?php _e( 'Name', 'wpupper-share-buttons' ); ?></th>
				            <th><?php _e( 'Count', 'wpupper-share-buttons' ); ?></th>
				        </tr>
				    </thead>
				    <tbody>
						<?php
						$rank = 1;

						foreach ( $top_providers as $name => $counts ) :
							$provider = ( $name === 'google' ) ? 'google-plus' : $name;

							printf(
								'<tr class="%s-%s">
									<td>%d</td>
									<td>%s</td>
									<td>%s</td>
								 </tr>
								',
								WPUSB_App::SLUG,
								$provider,
								$rank,
								ucfirst( $name ),
								WPUSB_Utils::format_number( $counts )
							);

							$rank++;
						endforeach;
						?>
				    </tbody>
					<tfoot>
						<tr>
							<th colspan="2">
								<?php _e( 'Total', 'wpupper-share-buttons' ); ?>
							</th>
							<th>
								<?php echo WPUSB_Utils::format_number( array_sum( $top_providers ) ); ?>
							</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	<?php
	}
}

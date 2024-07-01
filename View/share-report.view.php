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
	exit;
}

class WPUSB_Sharing_Report_View {

	/**
	 * Display page sharing report
	 *
	 * @since 1.3
	 * @param object $list_table
	 * @return void
	 */
	public static function render_sharing_report( $list_table ) {
		$list_table->prepare_items();
	?>
		<div class="wrap"
		     data-cookie-name="<?php echo esc_attr( WPUSB_Share_Report::OPTION_CSN_CLOSED ); ?>"
			 <?php echo WPUSB_Utils::get_component( 'report' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<h2><?php esc_html_e( 'WPUpper Share Buttons', 'wpupper-share-buttons' ); ?></h2>

			<p class="description">
				<?php esc_html_e( 'Add the Share Buttons automatically.', 'wpupper-share-buttons' ); ?>
			</p>

			<?php WPUSB_Utils_View::page_notice(); ?>

			<?php WPUSB_Utils_View::menu_top(); ?>

			<div class="<?php echo esc_attr( WPUSB_App::SLUG ); ?>-settings-wrap">

				<?php do_action( WPUSB_Utils::add_prefix( 'sr_render' ), $list_table ); ?>

				<?php self::render_classification_by_provider(); ?>

				<form class="share-report-form">

					<input type="hidden"
						   name="page"
						   value="<?php echo esc_attr( WPUSB_App::SLUG ) . '-sharing-report'; ?>">

					<?php
						$list_table->search_box( __( 'Search', 'wpupper-share-buttons' ), esc_attr( WPUSB_App::SLUG ) );
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
	 * @param object $list
	 * @return string
	 */
	public static function get_permalink_title( $list ) {
		$title = get_the_title( $list->post_id ) ?: $list->post_title;

		return sprintf(
			'<a href="%s" class="row-title" target="_blank">%s</a>',
			esc_url( get_permalink( $list->post_id ) ),
			esc_html( $title )
		);
	}

	/**
	 * Render date range filter
	 *
	 * @since 3.32
	 * @return void
	 */
	public static function render_date_range_filter() {
		$date_format = _x( 'YYYY-MM-DD', 'placeholder', 'wpupper-share-buttons' );
	?>
		<div class="<?php echo esc_attr( WPUSB_Utils::add_prefix( '-inline' ) ); ?>"
				<?php echo WPUSB_Utils::get_component( 'datepicker' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

			<label class="<?php echo esc_attr( WPUSB_Utils::add_prefix( '-label' ) ); ?>">
				<?php esc_html_e( 'Start date:', 'wpupper-share-buttons' ); ?>

				<input type="text"
					   name="start_date"
					   data-element="start-date"
					   class="<?php echo esc_attr( WPUSB_Utils::add_prefix( '-datepicker' ) ); ?>"
					   placeholder="<?php echo esc_attr( $date_format ); ?>"
					   maxlength="10"
					   value="<?php echo esc_attr( WPUSB_Utils::get( 'start_date' ) ); ?>">
			</label>

			<label class="<?php echo esc_attr( WPUSB_Utils::add_prefix( '-label' ) ); ?>">
				<?php esc_html_e( 'End date:', 'wpupper-share-buttons' ); ?>

				<input type="text"
					   name="end_date"
					   data-element="end-date"
					   class="<?php echo esc_attr( WPUSB_Utils::add_prefix( '-datepicker' ) ); ?>"
					   placeholder="<?php echo esc_attr( $date_format ); ?>"
					   maxlength="10"
					   value="<?php echo esc_attr( WPUSB_Utils::get( 'end_date' ) ); ?>">
			</label>

		</div>
	<?php
	}

	/**
	 * Render btn export csv
	 *
	 * @since 3.32
	 * @return void
	 */
	public static function export_csv_btn() {
	?>
		<button class="button button-primary" name="export" value="true">
			<?php esc_html_e( 'Export CSV', 'wpupper-share-buttons' ); ?>
		</button>
	<?php
	}

	/**
	 * Render table classification sharing counter by social network
	 *
	 * @since 3.35
	 * @return void
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
					<?php esc_html_e( 'Classification by social network', 'wpupper-share-buttons' ); ?>
					<i class="<?php echo $active ? '' : 'active'; ?>"></i>
				</caption>
			</table>
			<div class="providers-content <?php echo esc_attr( $active ); ?>" data-element="toggle">
				<table>
				    <thead>
				        <tr>
				            <th>#</th>
				            <th><?php esc_html_e( 'Name', 'wpupper-share-buttons' ); ?></th>
				            <th><?php esc_html_e( 'Count', 'wpupper-share-buttons' ); ?></th>
				        </tr>
				    </thead>
				    <tbody>
						<?php
						$rank = 1;

						foreach ( $top_providers as $provider => $counts ) :
							printf(
								'<tr class="%s-%s">
									<td>%d</td>
									<td>%s</td>
									<td>%s</td>
								 </tr>
								',
								esc_attr( WPUSB_App::SLUG ),
								esc_attr( $provider ),
								$rank, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								esc_html( ucfirst( $provider ) ),
								esc_html( WPUSB_Utils::format_number( $counts ) )
							);

							$rank++;
						endforeach;
						?>
				    </tbody>
					<tfoot>
						<tr>
							<th colspan="2">
								<?php esc_html_e( 'Total', 'wpupper-share-buttons' ); ?>
							</th>
							<th>
								<?php echo esc_html( WPUSB_Utils::format_number( array_sum( $top_providers ) ) ); ?>
							</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	<?php
	}
}

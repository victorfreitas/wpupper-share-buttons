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
		$text_domain = WPUSB_App::TEXTDOMAIN;
		$prefix      = WPUSB_App::SLUG;
		$text_button = __( 'Search', $text_domain );
		$description = __( 'This report has a cache of ', $text_domain );
		$minutes     = __( 'minutes', $text_domain );
		$time        = sprintf( _n( '%d minute', "%d {$minutes}", $time_cache, $text_domain ), $time_cache );

		$list_table->prepare_items();
	?>
		<div class="wrap">
			<h2><?php _e( 'WPUpper Share Buttons', $text_domain ); ?></h2>
			<p class="description"><?php _e( 'Add the Share Buttons automatically.', $text_domain ); ?></p>

			<?php WPUSB_Settings_View::home_page_notice(); ?>

			<span class="<?php echo $prefix; ?>-settings-title">
				<span class="description information-cache">
					<?php echo "{$description}{$time}."; ?>
				</span>
			</span>

			<div class="<?php echo $prefix; ?>-settings-wrap">

				<form action="<?php echo esc_url( get_admin_url( null, 'admin.php' ) ); ?>"
				      class="share-report-form">
					<input type="hidden"
					       name="page"
					       value="<?php echo WPUSB_App::SLUG . '-sharing-report'; ?>">

					<?php $list_table->search_box( $text_button, $prefix ); ?>
				</form>

				<?php WPUSB_Settings_View::menu_top(); ?>

				<?php $list_table->display(); ?>

			</div>
		</div>
	<?php
	}

	/**
	 * Insert link in column title in wp list table
	 *
	 * @since 1.0
	 * @param Integer $id
	 * @param String $post_title
	 * @return String
	 */
	public static function get_permalink_title( $id, $post_title ) {
		$permalink = get_permalink( $id );
		$html      = "<a class=\"row-title\" href=\"{$permalink}\">{$post_title}</a>";

		return $html;
	}
}
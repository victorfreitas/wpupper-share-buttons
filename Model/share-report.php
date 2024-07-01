<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Share report
 * @since 3.35
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit;
}

class WPUSB_Share_Report {

	const OPTION_CSN_CLOSED = 'wpusb-classificaton-providers-closed';

	public function __construct() {

	}

	/**
	 * Get classication total sharing counter by provider
	 *
	 * @since 3.35
	 * @return array
	 */
	public function get_total_share_by_provider() {
		global $wpdb;

		$table   = WPUSB_Utils::get_table_name();
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$results = $wpdb->get_row(
			"SELECT
				SUM(`facebook`) AS facebook,
				SUM(`twitter`) AS twitter,
				SUM(`linkedin`) AS linkedin,
				SUM(`pinterest`) AS pinterest,
				SUM(`tumblr`) AS tumblr,
				SUM(`buffer`) AS buffer
			 FROM `{$table}`", // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			ARRAY_A
		);

		$results = array_filter( $results );

		if ( empty( $results ) ) {
			return false;
		}

		arsort( $results );

		return $results;
	}
}

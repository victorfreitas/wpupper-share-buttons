<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Ajax sharing reports
 * @version 3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit;
}

class WPUSB_Ajax_Sharing_Reports_Controller {

	private $table;

	private $reference;

	private $post_title;

	private $post_date;

	private $facebook;

	private $tumblr;

	private $linkedin;

	private $pinterest;

	private $buffer;

	private $total = 0;

	/**
	* Initialize the plugin by ajax requests
	*
	* @since 3.30
	*/
	public function __construct() {
		$this->init( WPUSB_App::SLUG );
	}

	/**
	 * Init actions
	 *
	 * @since 3.30
	 * @param string $prefix
	 * @return void
	 */
	public function init( $prefix ) {
		if ( WPUSB_Utils::is_sharing_report_disabled() ) {
			return;
		}

		$action = WPUSB_Utils::add_prefix( '_share_count_reports' );

		add_action( "wp_ajax_{$action}", array( $this, 'request_init' ) );
		add_action( "wp_ajax_nopriv_{$action}", array( $this, 'request_init' ) );
	}

	/**
	 * Check is valid request and init proccess
	 *
	 * @since 3.30
	 * @return void
	 */
	public function request_init() {
		$this->_validate();
		$this->_set_fields();
		$this->_insert_init();
	}

	/**
	 * Check is valid request and set reference
	 *
	 * @since 3.30
	 * @return void
	 */
	private function _validate() {
		if ( ! WPUSB_Utils::is_request_ajax() ) {
			exit;
		}

		$nonce     = WPUSB_Utils::post( 'nonce', false );
		$reference = WPUSB_Utils::post( 'reference', false, 'intval' );

		if ( ! $reference || ! $nonce ) {
			$this->_send_json( __( 'Not valid reference', 'wpupper-share-buttons' ) );
		}

		$this->reference = $reference;
	}

	/**
	 * Set properties
	 *
	 * @since 3.30
	 * @return void
	 */
	private function _set_fields() {
		$this->table      = WPUSB_Utils::get_table_name();
		$this->post_date  = WPUSB_Utils::get_post_date( $this->reference );
		$this->post_title = WPUSB_Utils::rm_tags( get_the_title( $this->reference ), true );

		$items = array(
			'facebook',
			'tumblr',
			'linkedin',
			'pinterest',
			'buffer',
		);

		foreach ( $items as $item ) :
			$this->{$item} = WPUSB_Utils::post( "count_{$item}", 0, 'intval' );
			$this->total   += $this->{$item};
		endforeach;
	}

	/**
	 * Retrieve the requests
	 *
	 * @since 3.30
	 * @global $wpdb
	 * @return void
	 */
	private function _insert_init() {
		global $wpdb;

		if ( $this->total > 0 ) {
			$id = $wpdb->get_var( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				$wpdb->prepare(
					// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
					"SELECT `id` FROM `{$this->table}` WHERE `post_id` = %d",
					$this->reference
				)
			);
			$this->_add_counts( intval( $id ) );
		}

		$this->_send_json( __( 'Empty counts', 'wpupper-share-buttons' ) );
	}

	/**
	 * Select the table and check for records
	 *
	 * @since 3.30
	 * @global $wpdb
	 * @param int $id
	 * @return void
	 */
	private function _add_counts( $id ) {
		global $wpdb;

		if ( $id ) {
			$this->_update();
		}

		$this->_insert();
	}

	/**
	 * Update records in the table
	 *
	 * @since 1.0
	 * @since 3.30
	 * @since 3.37
	 * @global $wpdb
	 * @return void
	 */
	private function _update() {
		global $wpdb;

		$updated = $wpdb->query( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
			$wpdb->prepare(
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				"UPDATE `{$this->table}`
				 SET `post_title` = %s,
				     `post_date` = %s,
				     `facebook` = %d,
					 `linkedin` = %d,
					 `pinterest` = %d,
					 `tumblr` = %d,
					 `buffer` = %d,
					 `total`= (`facebook` + `twitter` + `linkedin` + `pinterest` + `tumblr` + `buffer`)
				 WHERE `post_id` = %d
				",
				$this->post_title,
				$this->post_date,
				$this->facebook,
				$this->linkedin,
				$this->pinterest,
				$this->tumblr,
				$this->buffer,
				$this->reference
			)
		);

		$this->_send_json( '', $updated );
	}

	/**
	 * Insert records in the table
	 *
	 * @since 1.0
	 * @since 3.30
	 * @global $wpdb
	 * @return void
	 */
	private function _insert() {
		global $wpdb;

		$inserted = $wpdb->insert( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
			$this->table,
			array(
				'post_id'    => $this->reference,
				'post_title' => $this->post_title,
				'post_date'  => $this->post_date,
				'facebook'   => $this->facebook,
				'linkedin'   => $this->linkedin,
				'pinterest'  => $this->pinterest,
				'tumblr'     => $this->tumblr,
				'buffer'     => $this->buffer,
				'total'      => $this->total,
			)
		);

		$this->_send_json( '', $inserted );
	}

	/**
	 * Send json request error
	 *
	 * @since 3.30
	 * @param string $message
	 * @param boolean $success
	 * @return void
	 */
	private function _send_json( $message, $success = false ) {
		wp_send_json(
			array(
				'success' => (bool) $success,
				'message' => $message,
			)
		);
	}
}

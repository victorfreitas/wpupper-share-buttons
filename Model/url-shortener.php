<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage URL Shortener
 * @version 3.27
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit;
}

class WPUSB_URL_Shortener {

	private $permalink;

	private $token;

	const TABLE_NAME = 'wpusb_url_shortener';
	const API = 'https://api-ssl.bitly.com/v4/shorten';

	public function __construct( $permalink, $token ) {
		$this->_set_permalink( $permalink );
		$this->_set_token( $token );
	}

	private function _set_permalink( $permalink ) {
		$this->permalink = $permalink;
	}

	private function _set_token( $token ) {
		$this->token = $token;
	}

	/**
	 * Get url short cache
	 *
	 * @since 3.27
	 * @global $wpdb
	 * @param string $hash
	 * @return string
	 */
	public static function get_cache( $hash ) {
		global $wpdb;

		$table        = $wpdb->prefix . self::TABLE_NAME;
		$current_time = current_time( 'timestamp' );

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$value = $wpdb->get_var(
			$wpdb->prepare(
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				"SELECT `short_url` FROM `{$table}` USE INDEX(`hash`) WHERE `hash` = %s AND `expires` > %d",
				$hash,
				$current_time
			)
		);

		if ( empty( $value ) ) {
			return '';
		}

		return rawurlencode( esc_url( $value ) );
	}

	/**
	 * Set url short cache
	 *
	 * @since 3.27
	 * @global $wpdb
	 * @param string $hash
	 * @param int $post_id
	 * @param string $short_url
	 * @param int $expiration
	 * @return int
	 */
	public static function set_cache( $hash, $post_id, $short_url, $expiration = 0 ) {
		global $wpdb;

		$expiration_time = ( current_time( 'timestamp' ) + intval( $expiration ) );

		if ( self::_is_exists( $hash ) ) {
			return self::_update( $short_url, $expiration_time, $hash );
		}

		return self::_insert( $post_id, $hash, $short_url, $expiration_time );
	}

	/**
	 * Check hash exists
	 *
	 * @since 3.27
	 * @global $wpdb
	 * @param string $hash
	 * @return int
	 */
	private static function _is_exists( $hash ) {
		global $wpdb;

		$table = $wpdb->prefix . self::TABLE_NAME;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		return (int) $wpdb->get_var(
			$wpdb->prepare(
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				"SELECT `post_id` FROM `{$table}` USE INDEX(`hash`) WHERE `hash` = %s",
				$hash
			)
		);
	}

	/**
	 * Update records in the table
	 *
	 * @since 3.27
	 * @global $wpdb
	 * @param string $short_url
	 * @param int $expiration_time
	 * @param string $hash
	 * @return int
	 */
	private static function _update( $short_url, $expiration_time, $hash ) {
		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		return $wpdb->update(
			$wpdb->prefix . self::TABLE_NAME,
			array(
				'short_url' => $short_url,
				'expires'   => $expiration_time,
			),
			array(
				'hash' => $hash,
			),
			array( '%s', '%d' ),
			array( '%s' )
		);
	}

	/**
	 * Insert records in the table
	 *
	 * @since 3.27
	 * @global $wpdb
	 * @param int $post_id
	 * @param string $hash
	 * @param string $short_url
	 * @param int $expiration_time
	 * @return int
	 */
	private static function _insert( $post_id, $hash, $short_url, $expiration_time ) {
		global $wpdb;

		$table = $wpdb->prefix . self::TABLE_NAME;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->delete(
			$table, array(
				'post_id' => $post_id,
			)
		);

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		return $wpdb->insert(
			$table,
			array(
				'post_id'   => $post_id,
				'hash'      => $hash,
				'short_url' => $short_url,
				'expires'   => $expiration_time,
			),
			array( '%d', '%s', '%s', '%d' )
		);
	}

	/**
	 * Generate URL short with curl from request API
	 *
	 * @since 3.27
	 * @global $wpdb
	 * @return mixed False|String
	 */
	public function get_short() {
		if ( ! WPUSB_Utils::has_curl() || ! WPUSB_Utils::has_json() ) {
			return false;
		}

		$value  = WPUSB_Utils::option( 'bitly_domain' );
		$args   = array(
			'body' => json_encode(
				array(
					'long_url' => rawurldecode( $this->permalink ),
					'domain'   => WPUSB_Utils::get_bitly_domain( $value ),
				)
			),
			'headers'  => array(
				'Authorization' => 'Bearer ' . $this->token,
				'Content-Type'  => 'application/json',
			),
		);

		$response = wp_remote_post( esc_url( self::API ), $args );
		$code     = wp_remote_retrieve_response_code( $response );

		error_log( print_r( $response, true ) );

		if ( empty( $code ) || ! in_array( $code, array( 200, 201 ), true ) ) {
			return false;
		}

		$data = WPUSB_Utils::json_decode( wp_remote_retrieve_body( $response ) );

		if ( $data && ! empty( $data->link ) ) {
			return $data->link;
		}

		return false;
	}
}

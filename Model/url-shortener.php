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
	exit(0);
}

class WPUSB_URL_Shortener {

	private static $data = array();

	const TABLE_NAME = 'wpusb_url_shortener';

	/**
	 * Get url short cache
	 *
	 * @since 1.0
	 * @global $wpdb
	 * @param String $hash
	 * @param Integer $post_id
	 * @param String $short_url
	 * @param Integer $expiration
	 * @return Integer
	 */
	public static function get_cache( $hash ) {
		global $wpdb;

		$table        = $wpdb->prefix . self::TABLE_NAME;
		$current_time = current_time( 'timestamp' );
		$query        = $wpdb->prepare(
			"SELECT
				`short_url`
			 FROM
			 	`{$table}`
			 USE INDEX(`hash`)
			 WHERE
			 	`hash` = %s
			 	AND `expires` > %d
			",
			$hash,
			$current_time
		);
		$value = $wpdb->get_var( $query );

		if ( empty( $value ) ) {
			return '';
		}

		return rawurlencode( esc_url( $value ) );
	}

	/**
	 * Set url short cache
	 *
	 * @since 1.0
	 * @global $wpdb
	 * @param String $hash
	 * @param Integer $post_id
	 * @param String $short_url
	 * @param Integer $expiration
	 * @return Integer
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
	 * @since 1.0
	 * @global $wpdb
	 * @param String $hash
	 * @return Integer
	 */
	private static function _is_exists( $hash ) {
		global $wpdb;

		$table = $wpdb->prefix . self::TABLE_NAME;
		$query = $wpdb->prepare(
			"SELECT
				`post_id`
			 FROM
			 	`{$table}`
			 	USE INDEX(`hash`)
			 WHERE
			 	`hash` = %s
			",
			$hash
		);

		return (int)$wpdb->get_var( $query );
	}

	/**
	 * Update records in the table
	 *
	 * @since 1.0
	 * @global $wpdb
	 * @param String $short_url
	 * @param Integer $expiration_time
	 * @param String $hash
	 * @return Void
	 */
	private static function _update( $short_url, $expiration_time, $hash ) {
		global $wpdb;

		$wpdb->update(
			$wpdb->prefix . self::TABLE_NAME,
			array(
				'short_url' => $short_url,
				'expires'   => $expiration_time,
			),
			array( 'hash' => $hash ),
			array( '%s', '%d' ),
			array( '%s', )
		);
	}

	/**
	 * Insert records in the table
	 *
	 * @since 1.0
	 * @global $wpdb
	 * @param Integer $post_id
	 * @param String $hash
	 * @param String $short_url
	 * @param Integer $expiration_time
	 * @return Void
	 */
	private static function _insert( $post_id, $hash, $short_url, $expiration_time ) {
		global $wpdb;

		$table = $wpdb->prefix . self::TABLE_NAME;

		$wpdb->delete( $table, array( 'post_id' => $post_id ) );

		$wpdb->insert(
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
}
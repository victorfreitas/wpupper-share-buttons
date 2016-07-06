<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Ajax Controller
 * @version 2.0.0
 */

if ( ! function_exists( 'add_action' ) )
	exit(0);

use WPUSB_Setting as Setting;
use WPUSB_Utils as Utils;
use WPUSB_Core as Core;

class WPUSB_Ajax_Controller
{
	/**
	* Initialize the plugin by ajax requests
	*
	* @since 1.2
	*/
	public function __construct()
	{
		add_action( 'wp_ajax_nopriv_share_google_plus', array( __CLASS__, 'google_plus' ) );
		add_action( 'wp_ajax_share_google_plus', array( __CLASS__, 'google_plus' ) );
		add_action( 'wp_ajax_nopriv_counts_social_share', array( __CLASS__, 'counts_social_share' ) );
		add_action( 'wp_ajax_counts_social_share', array( __CLASS__, 'counts_social_share' ) );
		add_action( 'wp_ajax_share_preview', array( __CLASS__, 'share_preview' ) );
	}
	/**
	* Nonce
	*
	* @since 1.0
	* @var string
	*/
	const AJAX_VERIFY_NONCE_COUNTER = 'wpusb-counter-social-share';

	/**
	 * Quantity shares google plus
	 *
	 * @since 1.1
	 * @param null
	 * @return void
	 */
	public static function google_plus()
	{
		header( 'Content-Type: application/javascript; charset=utf-8' );

		//Cache 10 minutes
		$cache = get_transient( Setting::TRANSIENT_GOOGLE_PLUS );
		$url   = Utils::get( 'url', false, 'esc_url' );

		if ( isset( $cache[$url] ) ) :
			echo Utils::get( 'callback' ) . '(' . $cache[$url] . ')';
			exit(1);
		endif;

		Utils::ajax_verify_request( $url, 500, 'url_is_empty' );
		static::_send_request_google( static::_get_google_args( $url ), $url );
	}

	/**
	 * Get google arguments post
	 *
	 * @since 1.0
	 * @param string $url
	 * @return array
	 */
	private static function _get_google_args( $url = '' )
	{
	    return array(
			'method'  => 'POST',
			'headers' => array(
		        'Content-Type' => 'application/json'
		    ),
		    'body' => json_encode(
		    	array(
					'method'     => 'pos.plusones.get',
					'id'         => 'p',
					'method'     => 'pos.plusones.get',
					'jsonrpc'    => '2.0',
					'key'        => 'p',
					'apiVersion' => 'v1',
			        'params' => array(
						'nolog'   => true,
						'id'      =>  $url,
						'source'  => 'widget',
						'userId'  => '@viewer',
						'groupId' => '@self',
		        	)
		     	)
		    ),
		    'sslverify' => false
		);
	}

	/**
	 * Send request google plus counter
	 *
	 * @since 1.0
	 * @param Array $args
	 * @return void
	 */
	private static function _send_request_google( $args = array(), $url )
	{
	    $response = wp_remote_post( 'https://clients6.google.com/rpc', $args );

	    if ( is_wp_error( $response ) )
	    	static::_error_request_google();

	    $plusones     = json_decode( $response['body'], true );
		$count_google = static::_get_global_counts_google( $plusones, $response, $url );
		$results      = json_encode( $count_google );

		echo Utils::get( 'callback' ) . "({$results})";
		exit(1);
	}

	/**
	 * Quantity shares google plus
	 *
	 * @since 1.0
	 * @param Array $results
	 * @return Array
	 */
	private static function _get_global_counts_google( $results, $response, $url )
	{
		$results      = ( isset( $results['result'] ) ? $results['result'] : false );
		$global_count = ( $results ) ? $results['metadata']['globalCounts'] : '';
		$cache        = array();

		if ( empty( $global_count ) || is_null( $global_count ) )
			$global_count = array( 'count' => 0 );

		$cache[$url] = json_encode( $global_count );

		set_transient(
			Setting::TRANSIENT_GOOGLE_PLUS,
			$cache,
			apply_filters( Setting::TRANSIENT_GOOGLE_PLUS, 10 * MINUTE_IN_SECONDS )
		);

		return $global_count;
	}

	/**
	 * Return count 0 if exist error
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _error_request_google()
	{
		$results = json_encode( array( 'count' => 0 ) );
		echo Utils::get( 'callback' ) . "({$results})";
		exit(0);
	}

	/**
	 * Retrieve the requests
	 *
	 * @since 1.2
	 * @global $wpdb
	 * @param Null
	 * @return Void
	 */
	public static function counts_social_share()
	{
		global $wpdb;

		$post_id         = Utils::post( 'reference', false, 'intval' );
		$post_title      = Utils::rip_tags( get_the_title( $post_id ) );
		$count_facebook  = Utils::post( 'count_facebook', 0, 'intval' );
		$count_twitter   = Utils::post( 'count_twitter', 0, 'intval' );
		$count_google    = Utils::post( 'count_google', 0, 'intval' );
		$count_linkedin  = Utils::post( 'count_linkedin', 0, 'intval' );
		$count_pinterest = Utils::post( 'count_pinterest', 0, 'intval' );
		$total           = ( $count_facebook + $count_twitter + $count_google + $count_linkedin + $count_pinterest );
		$nonce           = Utils::post( 'nonce', false );
		$table           = $wpdb->prefix . Setting::TABLE_NAME;

		if ( ! $post_id )
			static::_error_request( 'reference_is_empty' );

		if ( ! wp_verify_nonce( $nonce, self::AJAX_VERIFY_NONCE_COUNTER ) )
			static::_error_request( 'nonce_is_invalid' );

		if ( $total > 0 )
			static::_select(
				$table,
				array(
					'post_id'         => $post_id,
					'post_title'      => $post_title,
					'count_facebook'  => $count_facebook,
					'count_twitter'   => $count_twitter,
					'count_google'    => $count_google,
					'count_linkedin'  => $count_linkedin,
					'count_pinterest' => $count_pinterest,
					'total'           => $total,
				)
			);
		exit(1);
	}

	/**
	 * Select the table and check for records
	 *
	 * @since 1.0
	 * @global $wpdb
	 * @param String $table
	 * @param Array $data
	 * @return Void
	 */
	private static function _select( $table, $data = array() )
	{
		global $wpdb;

		$query     = $wpdb->prepare( "SELECT COUNT(*) FROM {$table} WHERE `post_id` = %d", $data['post_id'] );
		$row_count = $wpdb->get_var( $query );
		$row_count = intval( $row_count );

		if ( 1 === $row_count )
			static::_update( $table, $data );

		if ( 0 === $row_count )
			static::_insert( $table, $data );

		exit(1);
	}

	/**
	 * Update records in the table
	 *
	 * @since 1.0
	 * @global $wpdb
	 * @param String $table
	 * @param Array $data
	 * @return Void
	 */
	private static function _update( $table, $data = array() )
	{
		global $wpdb;

		$wpdb->update(
			$table,
			array(
				'post_title' => $data['post_title'],
				'facebook'   => $data['count_facebook'],
				'twitter'    => $data['count_twitter'],
				'google'     => $data['count_google'],
				'linkedin'   => $data['count_linkedin'],
				'pinterest'  => $data['count_pinterest'],
				'total'      => $data['total'],
			),
			array( 'post_id' => $data['post_id'], ),
			array( '%s', '%d', '%d', '%d', '%d', '%d', '%d', ),
			array( '%d', )
		);

		exit(1);
	}

	/**
	 * Insert records in the table
	 *
	 * @since 1.0
	 * @global $wpdb
	 * @param String $table
	 * @param Array $data
	 * @return Void
	 */
	private static function _insert( $table, $data = array() )
	{
		global $wpdb;

		$wpdb->insert(
			$table,
			array(
				'post_id'    => $data['post_id'],
				'post_title' => $data['post_title'],
				'facebook'   => $data['count_facebook'],
				'twitter'    => $data['count_twitter'],
				'google'     => $data['count_google'],
				'linkedin'   => $data['count_linkedin'],
				'pinterest'  => $data['count_pinterest'],
				'total'      => $data['total'],
			)
		);

		exit(1);
	}

	/**
	 * Share preview in settings page
	 *
	 * @since 1.0
	 * @param null
	 * @return Void
	 */
	public static function share_preview()
	{
		if ( ! Utils::is_request_ajax() )
			exit(0);

		$layout  = Utils::post( 'layout', false );
		$items   = Utils::post( 'items', false );
		$checked = Utils::post( 'checked', false );

		if ( ! ( $layout || $items || $checked ) )
			exit(0);

		$items   = static::_json_decode_quoted( $items );
		$checked = static::_json_decode_quoted( $checked );
		static::_share_preview_list( $layout, $items, $checked );
	}

	/**
	 * Render share preview list
	 *
	 * @since 1.0
	 * @param null
	 * @return Void
	 */
	private static function _share_preview_list( $layout, $items, $checked )
	{
		global $wp_version;

		$list       = array();
		$share_args = Core::get_all_elements();
		$count      = 0;

		if ( ! is_array( $items ) )
			exit(0);

		foreach ( $items as $key => $element ) :
			if ( ! in_array( $element, $checked ) )
				continue;

			$item   = $share_args->$element;
			$list[] = array(
				'prefix'      => Setting::PREFIX,
				'slash'       => '&#8260;',
				'counter'     => str_replace( '.', '', $wp_version ),
				'item_class'  => $item->element,
				'item_name'   => $item->name,
				'inside'      => true,
				'first'       => ( 0 === $count ) ? true : false,
				'layout'      => $layout,
				'item_title'  => $item->title,
				'has_counter' => $item->has_counter,
				'item_inside' => $item->inside,
			);
			$count++;
		endforeach;

		echo wp_send_json( $list );
		exit(1);
	}

	/**
	 * Error json requests
	 *
	 * @since 1.0
	 * @param String $message
	 * @return Void
	 */
	private static function _error_request( $message = '' )
	{
		http_response_code( 500 );
		Utils::error_server_json( $message );
		exit(0);
	}

	/**
	 * Decoded json quoted
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _json_decode_quoted( $txt )
	{
		$text = htmlspecialchars_decode( $txt );
		$text = Utils::rip_tags( $text );

		return json_decode( $text, true );
	}
}
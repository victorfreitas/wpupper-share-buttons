<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Ajax Google Plus Controller
 * @version 3.6.0
 */
if ( ! function_exists( 'add_action' ) ) {
	exit(0);
}

use WPUSB_Setting as Setting;
use WPUSB_Utils as Utils;
use WPUSB_Core as Core;
use WPUSB_Social_Elements as Elements;

class WPUSB_Ajax_Gplus_Controller
{
	/**
	* Initialize the plugin by ajax requests
	*
	* @since 3.6.0
	*/
	public function __construct()
	{
		add_action( 'wp_ajax_wpusb_gplus_counts', array( &$this, 'gplus_counts_verify_request' ) );
		add_action( 'wp_ajax_nopriv_wpusb_gplus_counts', array( &$this, 'gplus_counts_verify_request' ) );
	}

	/**
	 * Verify is valid request google plus counts
	 *
	 * @since 3.6.0
	 * @param null
	 * @return void
	 */
	public function gplus_counts_verify_request()
	{
		if ( ! Utils::is_request_ajax() ) {
			exit(0);
		}

		$nonce = Utils::get( 'nonce', false );
		$url   = Utils::get( 'url', false, 'esc_url' );

		Utils::ajax_verify_request( $url, 'url_is_empty' );

		if ( ! wp_verify_nonce( $nonce, Setting::AJAX_VERIFY_GPLUS_COUNTS ) ) {
			$this->_error_request( 'nonce_is_invalid' );
		}

		$this->_init_request( $url );
	}

	/**
	 * Quantity shares google plus
	 *
	 * @since 3.6.0
	 * @param String $url
	 * @return void
	 */
	private function _init_request( $url )
	{
		//Cache 10 minutes
		$cache = get_transient( Setting::TRANSIENT_GOOGLE_PLUS );

		if ( false !== $cache && isset( $cache[$url] ) ) {
			$this->_send_total_counts( $cache[$url] );
		}

		$args = $this->_get_gplus_args( $url );
		$this->_send_request( $args, $url );
	}

	/**
	 * Get google arguments post
	 *
	 * @since 3.6.0
	 * @param string $url
	 * @return array
	 */
	private function _get_gplus_args( $url = '' )
	{
	    return array(
			'sslverify' => false,
			'headers'   => array(
		        'Content-Type' => 'application/json'
		    ),
		    'body'      => json_encode(
		    	array(
					'method'     => 'pos.plusones.get',
					'id'         => 'p',
					'method'     => 'pos.plusones.get',
					'jsonrpc'    => '2.0',
					'key'        => 'p',
					'apiVersion' => 'v1',
			        'params'     => array(
						'nolog'   => true,
						'id'      =>  $url,
						'source'  => 'widget',
						'userId'  => '@viewer',
						'groupId' => '@self',
		        	),
		     	)
		    ),
		);
	}

	/**
	 * Send request google plus counter
	 *
	 * @since 3.6.0
	 * @param Array $args
	 * @param String $url
	 * @return void
	 */
	private function _send_request( $args, $url )
	{
		$response      = wp_remote_post( 'https://clients6.google.com/rpc', $args );
		$plusones      = Utils::retrieve_body_json( $response );
		$global_counts = $this->_get_global_counts( $plusones );
		$counts        = $this->_get_global_counts_google( $global_counts, $url );

		$this->_send_total_counts( $counts );
	}

	/**
	 * Check result
	 *
	 * @since 3.6.0
	 * @param Array $response
	 * @return Mixed Array|Void
	 */
	private function _get_global_counts( $response )
	{
		if ( ! isset( $response->result->metadata->globalCounts ) ) {
			$this->_send_default_count();
		}

		return $response->result->metadata->globalCounts;
	}

	/**
	 * Quantity shares google plus
	 *
	 * @since 3.6.0
	 * @param Array $results
	 * @return Array
	 */
	private function _get_global_counts_google( $global_counts, $url )
	{
		$cache       = array();
		$cache[$url] = $global_counts;

		$this->_set_transient( $cache );

		return $global_counts;
	}

	/**
	 * Sent total counts response
	 *
	 * @since 3.6.0
	 * @param Object $total_counts
	 * @return Void
	 */
	private function _send_total_counts( $total_counts )
	{
		$counts = json_encode( $total_counts );

		echo Utils::get( 'callback' ) . "({$counts})";
		exit(1);
	}

	/**
	 * Set transient Google Plus counts
	 *
	 * @since 3.6.0
	 * @param Mixed $value
	 * @return Void
	 */
	private function _set_transient( $value )
	{
		set_transient(
			Setting::TRANSIENT_GOOGLE_PLUS,
			$value,
			apply_filters( Setting::TRANSIENT_GOOGLE_PLUS, 10 * MINUTE_IN_SECONDS )
		);
	}

	/**
	 * Error json requests
	 *
	 * @since 3.6.0
	 * @param String $message
	 * @return Void
	 */
	private function _error_request( $message = '' )
	{
		http_response_code( 500 );
		Utils::error_server_json( $message );
		exit(0);
	}

	/**
	 * Seend default google count
	 *
	 * @since 3.6.0
	 * @param Null
	 * @return Void
	 */
	private function _send_default_count()
	{
		$counts = (object) array( 'count' => 0 );

		$this->_send_total_counts( $counts );
	}
}
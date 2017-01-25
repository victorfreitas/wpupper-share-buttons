<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Ajax Google Plus Controller
 * @version 3.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

class WPUSB_Ajax_Gplus_Controller {

	private $transient;
	private $index;
	private $cache;

	/**
	* Initialize the plugin by ajax requests
	*
	* @since 3.6.0
	*/
	public function __construct() {
		$prefix = WPUSB_App::SLUG;

		$this->_set_transient_name();

		add_action( "wp_ajax_{$prefix}_gplus_counts", array( $this, 'gplus_counts_verify_request' ) );
		add_action( "wp_ajax_nopriv_{$prefix}_gplus_counts", array( $this, 'gplus_counts_verify_request' ) );
	}

	/**
	 * Set transient name for counts
	 *
	 * @since 3.6.0
	 * @param null
	 * @return void
	 */
	private function _set_transient_name() {
		$this->transient = WPUSB_Setting::TRANSIENT_GOOGLE_PLUS;
	}

	/**
	 * Set hash name from url
	 *
	 * @since 3.6.0
	 * @param null
	 * @return void
	 */
	private function _set_index_url( $url ) {
		$this->index = preg_replace( '/[^A-Za-z0-9]+/', '', $url );
	}

	/**
	 * Set cache value
	 *
	 * @since 3.6.0
	 * @param Mixed Object|Bool $cache
	 * @return void
	 */
	private function _set_cache_value( $cache ) {
		$this->cache = $cache;
	}

	/**
	 * Verify is valid request google plus counts
	 *
	 * @since 3.6.0
	 * @param null
	 * @return void
	 */
	public function gplus_counts_verify_request() {
		if ( ! WPUSB_Utils::is_request_ajax() ) {
			exit(0);
		}

		$nonce     = WPUSB_Utils::get( 'nonce', false );
		$url       = WPUSB_Utils::get( 'url', false, 'esc_url' );
		$permalink = html_entity_decode( $url );

		WPUSB_Utils::ajax_verify_request( $permalink, 'url_is_empty' );

		if ( ! wp_verify_nonce( $nonce, WPUSB_Setting::AJAX_VERIFY_GPLUS_COUNTS ) ) {
			$this->_error_request( 'nonce_is_invalid' );
		}

		$this->_set_index_url( $permalink );
		$this->_init_request( $permalink );
	}

	/**
	 * Quantity shares google plus
	 *
	 * @since 3.6.0
	 * @param String $url
	 * @return void
	 */
	private function _init_request( $url ) {
		//Cache 10 minutes
		$cache = get_transient( $this->transient );

		if ( isset( $cache[ $this->index ] ) ) {
			$this->_send_total_counts( $cache[ $this->index ] );
		}

		$args = $this->_get_gplus_args( $url );
		$this->_set_cache_value( $cache );
		$this->_send_request( $args, $url );
	}

	/**
	 * Get google arguments post
	 *
	 * @since 3.6.0
	 * @param string $url
	 * @return array
	 */
	private function _get_gplus_args( $url = '' ) {
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
	private function _send_request( $args, $url ) {
		$response      = wp_remote_post( 'https://clients6.google.com/rpc', $args );
		$plusones      = WPUSB_Utils::retrieve_body_json( $response );
		$global_counts = $this->_get_global_counts( $plusones, $url );

		$this->_send_total_counts( $global_counts );
	}

	/**
	 * Check result
	 *
	 * @since 3.6.0
	 * @param Object $plusones
	 * @param String $url
	 * @return Mixed Array|Void
	 */
	private function _get_global_counts( $plusones, $url ) {
		if ( ! isset( $plusones->result->metadata->globalCounts ) ) {
			$this->_send_default_counts();
		}

		$global_counts = $plusones->result->metadata->globalCounts;
		$this->_set_cache_counts( $global_counts, $url );

		return $global_counts;
	}

	/**
	 * Quantity shares google plus
	 *
	 * @since 3.6.0
	 * @param Object $global_counts
	 * @param String $url
	 * @return Void
	 */
	private function _set_cache_counts( $global_counts, $url ) {
		$counts                 = $this->cache;
		$counts[ $this->index ] = $global_counts;
		$time                   = ( 10 * MINUTE_IN_SECONDS );
		$expiration             = apply_filters( $this->transient, $time );

		set_transient( $this->transient, $counts, $expiration );
	}

	/**
	 * Sent total counts response
	 *
	 * @since 3.6.0
	 * @param Object $total_counts
	 * @return Void
	 */
	private function _send_total_counts( $total_counts ) {
		$counts = json_encode( $total_counts );

		echo WPUSB_Utils::get( 'callback' ) . "({$counts})";
		exit(1);
	}

	/**
	 * Error json requests
	 *
	 * @since 3.6.0
	 * @param String $message
	 * @return Void
	 */
	private function _error_request( $message = '' ) {
		http_response_code( 500 );
		WPUSB_Utils::error_server_json( 500, $message );
		exit(0);
	}

	/**
	 * Seend default google count
	 *
	 * @since 3.6.0
	 * @param Null
	 * @return Void
	 */
	private function _send_default_counts() {
		$counts = (object) array( 'count' => 0 );

		$this->_send_total_counts( $counts );
	}
}
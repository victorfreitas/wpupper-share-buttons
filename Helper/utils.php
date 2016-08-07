<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Utils Helper
 * @version 2.3.0
 */
if ( ! function_exists( 'add_action' ) ) {
	exit(0);
}

use WPUSB_App as App;
use WPUSB_Setting as Setting;

class WPUSB_Utils extends WPUSB_Utils_Share
{
	/**
	 * Escape string for atribute class
	 *
	 * @since 1.0
	 * @param String $string
	 * @return String
	 */
	public static function esc_class( $class )
	{
		if ( empty( $class ) || is_array( $class ) ) {
			return '';
		}

		$class = self::rip_tags( $class, true );

        return preg_replace( '/[^a-zA-Z0-9-_]+/', '', $class );
	}

	/**
	 * Sanitize value from custom method
	 *
	 * @since 3.4.1
	 * @version 1.0.0
	 * @param String $key
	 * @param Mixed String|Array|Integer $default
	 * @param String $sanitize Relative function
	 * @return Mixed String|Array|Integer
	*/
	public static function request_by_type( $type, $key, $default, $sanitize = 'rip_tags' )
	{
		$request = filter_input_array( $type, FILTER_SANITIZE_STRING );

		if ( ! isset( $request[$key] ) || empty( $request[$key] ) ) {
			return $default;
		}

		if ( is_array( $request[$key] ) ) {
			return self::filter_array( $request[$key], $sanitize );
		}

		return self::sanitize( $request[$key], $sanitize );
	}

	/**
	 * Sanitize value from methods post
	 *
	 * @since 3.4.1
	 * @version 1.0.0
	 * @param String $key
	 * @param Mixed String|Array|Integer $default
	 * @param String $sanitize Relative function
	 * @return Mixed String|Array|Integer
	*/
	public static function post( $key, $default = '', $sanitize = 'rip_tags' )
	{
		return self::request_by_type( INPUT_POST, $key, $default, $sanitize );
	}

	/**
	 * Sanitize value from methods get
	 *
	 * @since 3.4.1
	 * @version 1.0.0
	 * @param String $key
	 * @param Mixed String|Array|Integer $default
	 * @param String $sanitize Relative function
	 * @return Mixed String|Array|Integer
	*/
	public static function get( $key, $default = '', $sanitize = 'rip_tags' )
	{
		return self::request_by_type( INPUT_GET, $key, $default, $sanitize );
	}

	/**
	 * Sanitize value from cookie
	 *
	 * @since 3.4.1
	 * @version 1.0.0
	 * @param String $key
	 * @param Mixed String|Array|Integer $default
	 * @param String $sanitize Relative function
	 * @return Mixed String|Array|Integer
	*/
	public static function cookie( $key, $default = '', $sanitize = 'rip_tags' )
	{
		return self::request_by_type( INPUT_COOKIE, $key, $default, $sanitize );
	}

	/**
	 * Sanitize requests
	 *
	 * @since 3.4.1
	 * @version 1.0.0
	 * @param String $value Relative sanitize
	 * @param String $function_name Relative function to use
	 * @return String
	*/
	public static function sanitize( $value, $function_name )
	{
		if ( ! is_callable( $function_name ) ) {
			return self::rip_tags( $value );
		}

		return call_user_func( $function_name, $value );
	}

	/**
	 * Properly sanitize array values
	 *
	 * @since 3.4.1
	 * @version 1.0.0
	 * @param Array $value
	 * @param String $sanitize
	 * @return Array
	 */
	public static function filter_array( $value, $sanitize )
	{
		if ( ! is_callable( $sanitize )  ) {
	    	return self::rip_tags( $value );
		}

	    return array_map( $sanitize, $value );
	}

	/**
	 * Properly strip all HTML tags including script and style
	 *
	 * @since 3.4.1
	 * @version 1.0.0
	 * @param Mixed String|Array $value
	 * @param Boolean $remove_breaks
	 * @return Mixed String|Array
	 */
	public static function rip_tags( $value, $remove_breaks = false )
	{
		if ( is_array( $value ) ) {
			return array_map( __METHOD__, $value );
		}

	    return wp_strip_all_tags( $value, $remove_breaks );
	}

	/**
	 * Verify request wp ajax
	 *
	 * @since 1.0
	 * @param null
	 * @return Boolean
	*/
	public static function is_request_ajax()
	{
		if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
			$request_ajax = $_SERVER['HTTP_X_REQUESTED_WITH'];
		}

		return ( ! empty( $request_ajax ) && strtolower( $request_ajax ) == 'xmlhttprequest' );
	}

	/**
	 * Post title
	 *
	 * @since 1.0
	 * @param null
	 * @return String
	 */
	public static function get_title()
	{
		$post_id = self::get_id();

		if ( $post_id ) {
			$post_title = get_the_title( $post_id );
			return self::html_decode( $post_title );
		}

		return self::site_name();
	}

	/**
	 * Site name
	 *
	 * @since 3.6.4
	 * @param null
	 * @return String
	 */
	public static function site_name()
	{
		$site_name = get_option( 'blogname' );

		return self::rip_tags( $site_name );
	}

	/**
	 * Post ID
	 *
	 * @since 1.0
	 * @param null
	 * @return Integer
	 */
	public static function get_id()
	{
		global $post;

		if ( isset( $post->ID ) ) {
			return intval( $post->ID );
		}

		return 0;
	}

	/**
	 * Site home url
	 *
	 * @since 3.6.4
	 * @param null
	 * @return String
	 */
	public static function site_url( $path = '' )
	{
		$site_url = get_site_url( null, "/{$path}" );

		return esc_url( $site_url );
	}

	/**
	 * Permalinks post
	 *
	 * @since 1.0
	 * @param null
	 * @return String
	 */
	public static function get_permalink()
	{
		$post_id = self::get_id();

		if ( $post_id ) {
			return esc_url( get_permalink( $post_id ) );
		}

		return self::site_url();
	}

	/**
	 * Permalinks post | archive | category
	 *
	 * @since 1.0
	 * @param null
	 * @return String
	 */
	public static function get_real_permalink( $is_fixed = false )
	{
		if ( $is_fixed && self::is_home() ) {
			$pagename = self::rip_tags( get_query_var( 'pagename' ) );
			return self::site_url( "{$pagename}/" );
		}

		if ( ! ( $is_fixed && self::is_archive_category() ) ) {
			return self::generate_short_url();
		}

		return self::get_term_link();
	}


	/**
	 * Get term link
	 *
	 * @since 3.6.4
	 * @param null
	 * @return String
	 */
	public static function get_term_link()
	{
		$term      = self::get_queried_object();
		$term_link = get_term_link( $term );

		if ( is_wp_error( $term_link ) ) {
			return self::site_url();
		}

		return self::generate_short_url( $term_link );
	}

	/**
	 * Generate short url by bitly
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param Null
	 * @return String
	 */
	public static function generate_short_url( $url = false )
	{
		$bitly_token = self::option( 'bitly_token', false );
		$permalink   = ( $url ) ? $url : self::get_permalink();
		$tracking    = self::get_tracking();
		$permalink   = rawurlencode( "{$permalink}{$tracking}" );

		if ( ! $bitly_token ) {
			return self::url_clean( $permalink );
		}

		return self::bitly_short_url_cache( $bitly_token, $permalink );
	}

	/**
	 * Return clean url and add implements filter
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param string $url
	 * @return String
	 */
	public static function url_clean( $url )
	{
		$name = App::SLUG . '-url-share';
		return apply_filters( $name, $url );
	}

	/**
	 * Return tracking UTM
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param Null
	 * @return String
	 */
	public static function get_tracking()
	{
		$tracking = self::option( 'tracking' );

		return self::html_decode( $tracking );
	}

	/**
	 * Title for post | archive | category
	 *
	 * @since 1.0
	 * @param null
	 * @return String
	 */
	public static function get_real_title( $is_fixed = false )
	{
		if ( $is_fixed && self::is_home() ) {
			return rawurlencode( self::site_name() );
		}

		if ( ! $is_fixed ) {
			return rawurlencode( self::get_title() );
		}

		$term = self::get_queried_object();

		if ( ! $term ) {
			return rawurlencode( self::get_title() );
		}

		return rawurlencode( $term->name );
	}

	/**
	 * Queried object
	 *
	 * @since 1.0
	 * @param Null
	 * @return Boolean | Object
	 */
	public static function get_queried_object()
	{
		$term = get_queried_object();

		if ( isset( $term->term_id ) ) {
			return $term;
		}

		return false;
	}

	/**
	 * Thumbnail posts
	 *
	 * @since 1.0
	 * @param null
	 * @return String thumbnail
	 */
	public static function get_image()
	{
		global $post;

		$thumbnail   = '';
		$filter_name = App::SLUG . 'thumbnail-url';

		if ( isset( $post->ID ) && has_post_thumbnail() ) {
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
		}

		if ( ! $thumbnail ) {
			return apply_filters( $filter_name, '' );
		}

		return apply_filters( $filter_name, $thumbnail[0] );
	}

	/**
	 * Get content posts
	 *
	 * @since 1.0
	 * @param null
	 * @return String content post
	 */
	public static function body_mail()
	{
		global $post;

		$content = '';

		if ( isset( $post->post_content ) ) {
			$content = $post->post_content;
		}

		$content = self::rip_tags( $content );
		$content = preg_replace( '/\[.*\]/', null, $content );

		return apply_filters( App::SLUG . 'body-email', $content );
	}

	/**
	 * Plugin base name
	 *
	 * @since 1.0
	 * @param null
	 * @return String link base file
	 */
	public static function base_name()
	{
		return plugin_basename( plugin_dir_path( __DIR__ ) . basename( App::FILE ) );
	}

	/**
	 * Descode html entityes UTF-8
	 *
	 * @since 1.0
	 * @param String $string
	 * @return String
	 */
	public static function html_decode( $string )
	{
		return html_entity_decode( $string, ENT_NOQUOTES, 'UTF-8' );
	}

	/**
	 * Plugin file url in assets directory
	 *
	 * @since 1.0
	 * @param String $file
	 * @param String $path
	 * @return String
	 */
	public static function plugin_url( $file, $path = 'assets/' )
	{
		return plugins_url( "{$path}{$file}", __DIR__ );
	}

	/**
	 * Plugin file path in assets directory
	 *
	 * @since 1.0
	 * @param String $file
	 * @return String
	 */
	public static function file_path( $file = '', $path = 'assets/' )
	{
		return plugin_dir_path( dirname( __FILE__ ) ) . "{$path}{$file}";
	}

	/**
	 * Generate file time style and scripts
	 *
	 * @since 1.0
	 * @param Int $path
	 * @return Integer
	 */
	public static function filetime( $path )
	{
		return date( 'dmYHi', filemtime( $path ) );
	}

	/**
	 * Get option unique and sanitize
	 *
	 * @since 1.0
	 * @param String $name Relative option name
	 * @param String $sanitize Relative function
	 * @return String
	 */
	public static function option( $name, $default = '', $sanitize = 'rip_tags' )
	{
		$model   = new Setting();
		$options = $model->get_options();

		if ( ! isset( $options[$name] ) || empty( $options[$name] ) ) {
			return $default;
		}

		$option = self::sanitize( $options[$name], $sanitize );

		return apply_filters( App::SLUG . "-option-{$name}-value", $option );
	}

	/**
	 * response error server json
	 *
	 * @since 1.0
	 * @param Int $code
	 * @param String $message
	 * @param Boolean $echo
	 * @return json
	 */
	public static function error_server_json( $code, $message = 'Message Error', $echo = true )
	{
		$response = json_encode(array(
			'status'  => 'error',
			'code'    => $code,
			'message' => $message,
		));

		if ( $echo ) {
			echo $response;
			exit(0);
		}

		return $response;
	}

	/**
	 * Request not found
	 *
	 * @since 1.0
	 * @param Array/String/Bool/Int $request
	 * @param Int $code
	 * @param String $message
	 * @return Void
	 */
	public static function ajax_verify_request( $request, $message = 'server_error', $code = 500 )
	{
		if ( ! $request ) {
			http_response_code( $code );
			self::error_server_json( $code, $message );
			exit(0);
		}
	}

	/**
	 * Verify option exists and update option
	 *
	 * @since 1.0.0
	 * @since 3.6.2 Modified
	 * @param String $option_name
	 * @param String $option_value
	 * @return String
	 */
	public static function add_update_option( $option_name, $option_value )
	{
		if ( $option_value ) {
			update_site_option( $option_name, Setting::DB_VERSION );
			return;
		}

		add_site_option( $option_name, Setting::DB_VERSION );
	}

	/**
	 * Format number
	 *
	 * @since 1.0
	 * @param Integer $number
	 * @return String
	 */
	public static function number_format( $number )
	{
		$number = (double) $number;

		if ( ! $number ) {
			return $number;
		}

		return number_format( $number, 0, '.', '.' );
	}

	/**
	 * Verify index in array and set
	 *
	 * @since 1.0
	 * @param Array $args
	 * @param String|int $index
	 * @return String
	 */
	public static function isset_get( $args = array(), $index = '', $default = '' )
	{
		if ( isset( $args[$index] ) ) {
			return $args[$index];
		}

		if ( isset( $args['elements'] ) ) {
			return self::isset_get( $args['elements'], $index );
		}

		return $default;
	}

	/**
	 * Check WP version and include file screen correctly
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function include_file_screen()
	{
		global $wp_version;

		require_once( ABSPATH . 'wp-admin/includes/screen.php' );

		if ( version_compare( $wp_version, '4.4', '>=' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/class-wp-screen.php' );
		}
	}

	/**
	 * Verify GET update settings
	 *
	 * @since 1.0
	 * @param String $key
	 * @return Boolean
	 */
	public static function get_update( $key )
	{
		if ( ! isset( $_GET[$key] ) ) {
			return false;
		}

		if ( 'true' == $_GET[$key] ) {
			return true;
		}
	}

	/**
	 * Get short url in cache
	 *
	 * @since 1.0
	 * @param String $token
	 * @param String $url
	 * @return String
	 */
	public static function bitly_short_url_cache( $token, $url )
	{
		$cache_url = get_transient( $url );

		if ( false !== $cache_url ) {
			return $cache_url;
		}

		return self::bitly_short_url( $token, $url );
	}

	/**
	 * Remote request bitly API
	 *
	 * @since 1.0
	 * @param String $token
	 * @param String $url
	 * @return String
	 */
	public static function bitly_short_url( $token, $url )
	{
		$api_url  = 'https://api-ssl.bitly.com/v3/shorten/';
		$api_url .= "?access_token={$token}&longUrl={$url}";
		$args     = array(
			'httpversion' => '1.1',
			'headers'     => array(
				'Content-Type' => 'application/json'
			),
	    );

	    $response = wp_remote_get( $api_url, $args );

	    if ( is_wp_error( $response ) ) {
	    	return $url;
	    }

	    return self::_bitly_response( $response, $url );
	}

	/**
	 * Generate shorturl by bitly
	 *
	 * @since 1.0
	 * @param Array $response
	 * @return String
	 */
	private static function _bitly_response( $response, $url )
	{
		$response   = json_decode( $response['body'] );
		$transient  = App::SLUG . '-shorturl-cache-expire';
		$cache_time = apply_filters( $transient, ( WEEK_IN_SECONDS * 1 ) );

		if ( 200 !== $response->status_code ) {
			return $url;
		}

		set_transient( $url, $response->data->url, $cache_time );

		return $response->data->url;
	}

	/**
	 * Add options social media default
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function add_options_defaults()
	{
		self::_add_options_settings();
		self::_add_options_social_media();
		self::_add_options_extra_settings();
	}

	/**
	 * Add options settings default
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _add_options_settings()
	{
		$option = self::get_option_group_name( 'settings' );
		$value  = array(
			'home'             => 'off',
			'pages'            => 'off',
			'archive_category' => 'on',
			'single'           => 'on',
			'before'           => 'on',
			'after'            => 'off',
			'layout'           => 'default',
		);
		$value  = apply_filters( App::SLUG . '-options-settings', $value );

		add_option( $option['name'], $value );
	}

	/**
	 * Add options social media default
	 *
	 * @since 2.9.3
	 * @param Null
	 * @return Void
	 */
	private static function _add_options_social_media()
	{
		$option = self::get_option_group_name( 'social_media' );
		$value  = array(
			'facebook' => 'facebook',
			'twitter'  => 'twitter',
			'google'   => 'google',
			'whatsapp' => 'whatsapp',
			'share'    => 'share',
		);
		$value  = apply_filters( App::SLUG . '-options-social-media', $value );

		add_option( $option['name'], $value );
	}

	/**
	 * Add options extra settings default
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _add_options_extra_settings()
	{
		$option = self::get_option_group_name( 'extra_settings' );
		$value  = array(
			'disable_css'       => 'off',
			'disable_js'        => 'off',
			'report_cache_time' => 10,
		);
		$value = apply_filters( App::SLUG . '-options-extra-settings', $value );

		add_option( $option['name'], $value );
	}

	/**
	 * Get option name and group to register settings
	 *
	 * @since 1.0
	 * @param String $name
	 * @param String $group
	 * @return Array
	 */
	public static function get_option_group_name( $name, $group = 'group' )
	{
		$prefix       = Setting::PREFIX;
		$option_name  = "{$prefix}_{$name}";
		$group_name   = ( 'group' !== $group ) ? $prefix : $option_name;
		$option_group = "{$group_name}_{$group}";

		return array( 'name' => $option_name, 'group' => $option_group );
	}

	/**
	 * Twitter text share
	 *
	 * @since 1.0
	 * @param String $title
	 * @param String $twitter_text_a
	 * @param String $twitter_text_b
	 * @param String $caracter
	 * @return String
	 */
	public static function get_twitter_text( $title, $twitter_text_a, $twitter_text_b, $caracter )
	{
		$text = "{$twitter_text_a}%20{$title}%20-%20{$twitter_text_b}%20{$caracter}%20";

		return apply_filters( App::SLUG . '-twitter-text', $text, $title );
	}

	/**
	 * Add class active current page in top menu
	 *
	 * @since 1.0
	 * @param String $current
	 * @return String|NULL
	 */
	public static function selected_menu( $current )
	{
		$page = self::get( 'page' );

		if ( $page === $current ) {
			return ' class="active"';
		}

		return null;
	}

	/**
	 * Ferify is button fixed in top
	 *
	 * @since 1.0
	 * @param Null
	 * @return String
	 */
	public static function is_fixed_top()
	{
		return self::option( 'fixed_top', false );
	}

	/**
	 * Make sure is activated the Share Buttons in singles
	 *
	 * @since 3.1.0
	 * @param Null
	 * @return Boolean
	 */
	public static function is_single()
	{
		if ( is_single() && self::option( 'single' ) === 'on' ) {
			return true;
		}

		return false;
	}

	/**
	 * Make sure is activated the Share Buttons in pages
	 *
	 * @since 3.1.0
	 * @param Null
	 * @return Boolean
	 */
	public static function is_page()
	{
		if ( ( is_page() || is_page_template() ) && self::option( 'pages' ) === 'on' ) {
			return true;
		}

		return false;
	}

	/**
	 * make sure is activated the Share Buttons in home
	 *
	 * @since 3.1.0
	 * @param Null
	 * @return Boolean
	 */
	public static function is_home()
	{
		if ( ( is_home() || is_front_page() ) && self::option( 'home' ) === 'on' ) {
			return true;
		}

		return false;
	}

	/**
	 * make sure is activated the Share Buttons in archive and category page
	 *
	 * @since 3.2.2
	 * @param Null
	 * @return Boolean
	 */
	public static function is_archive_category()
	{
		if ( ( is_archive() || is_category() ) && self::option( 'archive_category' ) === 'on' ) {
			return true;
		}

		return false;
	}

	/**
	 * Verify is active page option
	 *
	 * @since 3.1.0
	 * @param Null
	 * @return Boolean
	 */
	public static function is_active()
	{
		if ( self::is_home() || self::is_archive_category() ) {
			return true;
		}

		if ( self::is_page() || self::is_single() ) {
			return true;
		}

		return false;
	}

	/**
	 * Send a JSON response back to an Ajax request.
	 *
	 * @since 3.6.0
	 * @param mixed $response
	 * @return Void
	 */
	public static function send_json( $response )
	{
		$charset = self::rip_tags( get_option( 'blog_charset' ) );

		@header( 'Content-Type: application/json; charset=' . $charset );
		echo wp_json_encode( $response );
		exit(1);
	}

	/**
	 * Retrieve only the body from the raw response and decode json.
	 *
	 * @since 3.6.0
	 * @param mixed $response
	 * @return Array
	 */
	public static function retrieve_body_json( $response )
	{
		$results = wp_remote_retrieve_body( $response );

		return json_decode( $results );
	}

	/**
	 * Plugin page url
	 *
	 * @since 3.6.0
	 * @param Null
	 * @return String
	 */
	public static function get_page_url()
	{
		$page_url = get_admin_url( null,  'admin.php?page=' . App::SLUG );

		return esc_url( $page_url );
	}
}
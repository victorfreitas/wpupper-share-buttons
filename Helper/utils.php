<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Utils Helper
 * @version 2.3.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

class WPUSB_Utils extends WPUSB_Utils_Share {
	/**
	 * Escape string for atribute class
	 *
	 * @since 1.0
	 * @param String $string
	 * @return String
	 */
	public static function esc_class( $class ) {
		if ( empty( $class ) || is_array( $class ) ) {
			return '';
		}

        return apply_filters( WPUSB_App::SLUG . '_esc_class', sanitize_html_class( $class ) );
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
	public static function request_by_type( $type, $key, $default, $sanitize = 'rm_tags' ) {
		$request = filter_input_array( $type, FILTER_SANITIZE_STRING );

		if ( ! isset( $request[ $key ] ) || empty( $request[ $key ] ) ) {
			return $default;
		}

		if ( is_array( $request[ $key ] ) ) {
			return self::filter_array( $request[ $key ], $sanitize );
		}

		return self::sanitize( $request[ $key ], $sanitize );
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
	public static function post( $key, $default = '', $sanitize = 'rm_tags' ) {
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
	public static function get( $key, $default = '', $sanitize = 'rm_tags' ) {
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
	public static function cookie( $key, $default = '', $sanitize = 'rm_tags' ) {
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
	public static function sanitize( $value, $function_name ) {
		if ( ! is_callable( $function_name ) ) {
			return self::rm_tags( $value );
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
	public static function filter_array( $value, $sanitize ) {
		if ( ! is_callable( $sanitize )  ) {
	    	return self::rm_tags( $value );
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
	public static function rm_tags( $value, $remove_breaks = false ) {
		if ( empty( $value ) ) {
			return $value;
		}

		if ( is_array( $value ) ) {
			$values = self::filter_values_sanitize_option( $value, current_filter() );
			return array_map( __METHOD__, $values );
		}

	    return wp_strip_all_tags( $value, $remove_breaks );
	}

	/**
	 * Remove empty values is sanitize option
	 *
	 * @since 3.24
	 * @version 1.0
	 * @param Array $values
	 * @param String $filter
	 * @return Array
	*/
	public static function filter_values_sanitize_option( $values, $filter ) {
		if ( self::is_sanitize_option_filter( $filter ) ) {
			return array_filter( $values );
		}

		return $values;
	}

	/**
	 * Verify is sanitize option filter
	 *
	 * @since 3.24
	 * @version 1.0
	 * @param String $filter
	 * @return Boolean
	*/
	public static function is_sanitize_option_filter( $filter ) {
		return ( is_admin() && self::indexof( $filter, 'sanitize_option_' ) );
	}

	/**
	 * Find the position of the first occurrence of a substring in a string
	 *
	 * @since 3.24
	 * @version 1.0
	 * @param String $value
	 * @param String $search
	 * @return Boolean
	*/
	public static function indexof( $value, $search ) {
		return ( false !== strpos( $value, $search ) );
	}

	/**
	 * Verify request wp ajax
	 *
	 * @since 1.0
	 * @param null
	 * @return Boolean
	*/
	public static function is_request_ajax() {
		if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
			$request_ajax = $_SERVER['HTTP_X_REQUESTED_WITH'];
		}

		return ( ! empty( $request_ajax ) && strtolower( $request_ajax ) === 'xmlhttprequest' );
	}

	/**
	 * Post title
	 *
	 * @since 1.0
	 * @param null
	 * @return String
	 */
	public static function get_title() {
		$post_id = self::get_id();

		if ( $post_id ) {
			$post_title = self::rm_tags( get_the_title( $post_id ) );
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
	public static function site_name() {
		$site_name = self::get_option( 'blogname' );

		return self::rm_tags( $site_name );
	}

	/**
	 * Site description
	 *
	 * @since 3.6.4
	 * @param null
	 * @return String
	 */
	public static function get_site_description() {
		$description = self::get_option( 'blogdescription' );

		return self::rm_tags( $description );
	}

	/**
	 * Post ID
	 *
	 * @since 1.0
	 * @param null
	 * @return Integer
	 */
	public static function get_id() {
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
	public static function site_url( $path = '' ) {
		$site_url = get_home_url( null, "/{$path}" );

		return self::parse_url_params( $site_url );
	}

	/**
	 * Permalinks post
	 *
	 * @since 1.0
	 * @param null
	 * @return String
	 */
	public static function get_permalink() {
		$post_id = self::get_id();

		if ( $post_id ) {
			return self::parse_url_params( get_permalink( $post_id ) );
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
	public static function get_real_permalink( $is_fixed = false, $is_widget = false ) {
		$url = apply_filters( WPUSB_App::SLUG . '-real-permalink', false, $is_fixed );

		if ( $url ) {
			return self::html_decode( esc_url( $url ) );
		}

		if ( ( $is_fixed || $is_widget ) && self::is_home() || self::is_home() && is_page( self::get_id() ) ) {
			return self::site_url();
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
	public static function get_term_link() {
		$term      = self::get_queried_object();
		$term_link = get_term_link( $term );

		if ( is_wp_error( $term_link ) ) {
			return self::site_url();
		}

		$term_link = self::parse_url_params( $term_link );

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
	public static function generate_short_url( $url = false ) {
		$bitly_token = self::option( 'bitly_token', false );
		$permalink   = ( $url ) ? $url : self::get_permalink();

		if ( ! $bitly_token ) {
			return self::url_clean( $permalink );
		}

		return self::bitly_short_url_cache( $bitly_token, $permalink );
	}

	/**
	 * Parse url query args
	 *
	 * @since 3.15
	 * @version 1.0.0
	 * @param String $url
	 * @return String
	 */
	public static function parse_url_params( $url ) {
		$tracking     = self::get_tracking();
		$query_string = self::get_query_string();

		if ( empty( $tracking ) && empty( $query_string ) ) {
			$post_url = self::html_decode( esc_url( $url ) );
			return rawurlencode( $post_url );
		}

		$has_param = strpos( $url, '?' );

		if ( ! empty( $tracking ) && empty( $query_string ) && false === $has_param ) {
			$post_url = self::html_decode( esc_url( $url . $tracking ) );
			return rawurlencode( $post_url );
		}

		if ( empty( $tracking ) && ! empty( $query_string ) && false === $has_param ) {
			$post_url = self::html_decode( esc_url( $url . '?' . $query_string ) );
			return rawurlencode( $post_url );
		}

		$args = add_query_arg( $tracking, '', $query_string );

		parse_str( str_replace( '?', '', $args ), $params );

		$url_params = http_build_query( $params );

		if ( false !== $has_param ) {
			$url = remove_query_arg( array_keys( $params ), $url );
			$post_url = self::html_decode( esc_url( add_query_arg( $url_params, '', $url ) ) );
			return rawurlencode( $post_url );
		}

		$post_url = self::html_decode( esc_url( $url . '?' . $url_params ) );

		return rawurlencode( $post_url );
	}

	/**
	 * Query string sanitize
	 *
	 * @since 3.15
	 * @version 1.0.0
	 * @param Null
	 * @return String
	 */
	public static function get_query_string() {
		if ( ! isset( $_SERVER['QUERY_STRING'] ) ) {
			return false;
		}

		return self::rm_tags( $_SERVER['QUERY_STRING'], true );
	}

	/**
	 * Return clean url and add implements filter
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param string $url
	 * @return String
	 */
	public static function url_clean( $url ) {
		$name = WPUSB_App::SLUG . '-url-share';
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
	public static function get_tracking() {
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
	public static function get_real_title( $is_fixed = false, $is_widget = false ) {
		$title = apply_filters( WPUSB_App::SLUG . '-real-title', false, $is_fixed );

		if ( $title ) {
			return self::rm_tags( $title );
		}

		if ( ( $is_fixed || $is_widget ) && self::is_home() || self::is_home() && is_page( self::get_id() ) ) {
			return rawurlencode( self::site_name() );
		}

		if ( ! ( $is_fixed && self::is_archive_category() ) ) {
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
	public static function get_queried_object() {
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
	public static function get_image() {
		global $post;

		$thumbnail   = '';
		$filter_name = WPUSB_App::SLUG . '_thumbnail_url';

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
	 * @since 1.1
	 * @param null
	 * @return String content post
	 */
	public static function body_mail() {
		global $post;

		$content = '';

		if ( ( self::is_single() || self::is_page() ) && isset( $post->ID ) ) {
			$content = self::rm_tags( $post->post_content ? $post->post_content : $post->post_excerpt );
		}

		if ( empty( $content ) ) {
			$content = self::get_site_description();
		}

		$content = preg_replace( '/\[.*\]/', '', $content );

		return apply_filters( WPUSB_App::SLUG . '-body-email', $content, $post );
	}

	/**
	 * Plugin base name
	 *
	 * @since 1.0
	 * @param null
	 * @return String link base file
	 */
	public static function base_name( $filter = '' ) {
		return $filter . plugin_basename( WPUSB_App::FILE );
	}


	/**
	 * Plugin dir name
	 *
	 * @since 1.0
	 * @param null
	 * @return String
	 */
	public static function dirname( $path = '' ) {
		return dirname( self::base_name() ) . "/{$path}";
	}

	/**
	 * Descode html entityes UTF-8
	 *
	 * @since 1.0
	 * @param String $string
	 * @return String
	 */
	public static function html_decode( $string ) {
		return html_entity_decode( $string, ENT_NOQUOTES, get_bloginfo( 'charset' ) );
	}

	/**
	 * Plugin file url in assets directory
	 *
	 * @since 1.0
	 * @param String $file
	 * @param String $path
	 * @return String
	 */
	public static function plugin_url( $file, $path = 'assets/' ) {
		return plugins_url( "{$path}{$file}", __DIR__ );
	}

	/**
	 * Plugin file path in assets directory
	 *
	 * @since 1.0
	 * @param String $file
	 * @return String
	 */
	public static function file_path( $file = '', $path = 'assets/' ) {
		return plugin_dir_path( dirname( __FILE__ ) ) . "{$path}{$file}";
	}

	/**
	 * Generate file time style and scripts
	 *
	 * @since 1.0
	 * @param Int $path
	 * @return Integer
	 */
	public static function filetime( $path ) {
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
	public static function option( $name, $default = '', $sanitize = 'rm_tags' ) {
		$setting = WPUSB_Setting::get_instance();
		$option  = self::isset_get( $setting->options, $name, false );

		unset( $setting );

		if ( empty( $option ) ) {
			return $default;
		}

		$option = self::sanitize( $option, $sanitize );

		return apply_filters( WPUSB_App::SLUG . "-option-{$name}-value", $option );
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
	public static function error_server_json( $code, $message = 'Message Error', $echo = true ) {
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
	public static function ajax_verify_request( $request, $message = 'server_error', $code = 500 ) {
		if ( ! $request ) {
			http_response_code( $code );
			self::error_server_json( $code, $message );
			exit(0);
		}
	}

	/**
	 * Delete option
	 *
	 * @since 1.0.0
	 * @since 3.24
	 * @param String $option
	 * @return Bool
	 */
	public static function delete_option( $option ) {
		return delete_option( $option );
	}

	/**
	 * Get option
	 *
	 * @since 1.0.0
	 * @since 3.24
	 * @param String $option
	 * @return Mixed
	 */
	public static function get_option( $option ) {
		return get_option( $option );
	}

	/**
	 * Add option
	 *
	 * @since 1.0.0
	 * @since 3.24
	 * @param String $option
	 * @param String $value
	 * @return Bool
	 */
	public static function add_option( $option, $value ) {
		return add_option( $option, $value );
	}

	/**
	 * Update option
	 *
	 * @since 1.0.0
	 * @since 3.24
	 * @param String $option
	 * @param String $value
	 * @return Bool
	 */
	public static function update_option( $option, $value ) {
		if ( false === self::get_option( $option ) ) {
			return self::add_option( $option, $value );
		}

		return update_option( $option, $value );
	}

	/**
	 * Format number
	 *
	 * @since 1.0
	 * @param Integer $number
	 * @return String
	 */
	public static function number_format( $number ) {
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
	public static function isset_get( $args = array(), $index = '', $default = '' ) {
		if ( isset( $args[ $index ] ) ) {
			return $args[ $index ];
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
	public static function include_file_screen() {
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
	public static function get_update( $key ) {
		if ( ! ( $page = self::get( $key, false ) ) ) {
			return false;
		}

		if ( 'true' === $page ) {
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
	public static function bitly_short_url_cache( $token, $url ) {
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
	public static function bitly_short_url( $token, $url ) {
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

	    $body = wp_remote_retrieve_body( $response );

	    return self::_bitly_response( $body, $url );
	}

	/**
	 * Generate shorturl by bitly
	 *
	 * @since 1.0
	 * @param Array $response
	 * @return String
	 */
	private static function _bitly_response( $body, $url ) {
		$response   = json_decode( $body );
		$transient  = WPUSB_App::SLUG . '-shorturl-cache-expire';
		$cache_time = apply_filters( $transient, ( 4 * WEEK_IN_SECONDS ) );

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
	public static function add_default_options() {
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
	private static function _add_options_settings() {
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
		$value  = apply_filters( WPUSB_App::SLUG . '-options-settings', $value );

		self::add_option( $option['name'], $value );
	}

	/**
	 * Add options social media default
	 *
	 * @since 2.9.3
	 * @param Null
	 * @return Void
	 */
	private static function _add_options_social_media() {
		$option = self::get_option_group_name( 'social_media' );
		$value  = array(
			'facebook' => 'facebook',
			'twitter'  => 'twitter',
			'google'   => 'google',
			'whatsapp' => 'whatsapp',
			'share'    => 'share',
		);
		$value  = apply_filters( WPUSB_App::SLUG . '-options-social-media', $value );

		self::add_option( $option['name'], $value );
	}

	/**
	 * Add options extra settings default
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _add_options_extra_settings() {
		$option = self::get_option_group_name( 'extra_settings' );
		$value  = array(
			'disable_css'       => 'off',
			'disable_js'        => 'off',
			'report_cache_time' => 10,
		);
		$value = apply_filters( WPUSB_App::SLUG . '-options-extra-settings', $value );

		self::add_option( $option['name'], $value );
	}

	/**
	 * Get option name and group to register settings
	 *
	 * @since 1.0
	 * @param String $name
	 * @param String $group
	 * @return Array
	 */
	public static function get_option_group_name( $name, $group = 'group' ) {
		$prefix       = WPUSB_App::SLUG;
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
	public static function get_twitter_text( $title, $twitter_text_a, $twitter_text_b, $caracter ) {
		$text = "{$twitter_text_a}%20{$title}%20-%20{$twitter_text_b}%20{$caracter}%20";

		return apply_filters( WPUSB_App::SLUG . '-twitter-text', $text, $title );
	}

	/**
	 * Add class active current page in top menu
	 *
	 * @since 1.0
	 * @param String $current
	 * @return String|NULL
	 */
	public static function selected_menu( $current ) {
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
	public static function is_fixed_top() {
		return self::option( 'fixed_top', false );
	}

	/**
	 * Make sure is activated the Share Buttons in singles
	 *
	 * @since 3.1.0
	 * @param Null
	 * @return Boolean
	 */
	public static function is_single() {
		$tag = WPUSB_App::SLUG . '_is_single';

		if ( is_single() && self::option( 'single' ) === 'on' ) {
			return apply_filters( $tag, true );
		}

		return apply_filters( $tag, false );
	}

	/**
	 * Make sure is activated the Share Buttons in pages
	 *
	 * @since 3.1.0
	 * @param Null
	 * @return Boolean
	 */
	public static function is_page() {
		$tag = WPUSB_App::SLUG . '_is_page';

		if ( ( is_page() || is_page_template() ) && self::option( 'pages' ) === 'on' ) {
			return apply_filters( $tag, true );
		}

		return apply_filters( $tag, false );
	}

	/**
	 * make sure is activated the Share Buttons in home
	 *
	 * @since 3.1.0
	 * @param Null
	 * @return Boolean
	 */
	public static function is_home() {
		$tag = WPUSB_App::SLUG . '_is_home';

		if ( self::is_front_page() && self::option( 'home' ) === 'on' ) {
			return apply_filters( $tag, true );
		}

		return apply_filters( $tag, false );
	}

	/**
	 * Check is initial page
	 *
	 * @since 3.25
	 * @param Null
	 * @return Boolean
	 */
	public static function is_front_page() {
		return ( is_home() || is_front_page() );
	}

	/**
	 * make sure is activated the Share Buttons in archive and category page
	 *
	 * @since 3.2.2
	 * @param Null
	 * @return Boolean
	 */
	public static function is_archive_category() {
		$tag = WPUSB_App::SLUG . '_is_archive_category';

		if ( ( is_archive() || is_category() ) && self::option( 'archive_category' ) === 'on' ) {
			return apply_filters( $tag, true );
		}

		return apply_filters( $tag, false );
	}

	/**
	 * Verify is active page option
	 *
	 * @since 3.1.0
	 * @param Null
	 * @return Boolean
	 */
	public static function is_active() {
		$tag = WPUSB_App::SLUG . '_is_active';

		if ( self::is_home() || self::is_archive_category() ) {
			return apply_filters( $tag, true );
		}

		if ( self::is_page() || self::is_single() ) {
			return apply_filters( $tag, true );
		}

		return apply_filters( $tag, false );
	}

	/**
	 * Retrieve only the body from the raw response and decode json.
	 *
	 * @since 3.6.0
	 * @param mixed $response
	 * @return Array
	 */
	public static function retrieve_body_json( $response ) {
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
	public static function get_page_url() {
		return self::get_admin_url( WPUSB_App::SLUG );
	}

	/**
	 * Admin sanitize url
	 *
	 * @since 3.6.0
	 * @param String $page_name
	 * @return String
	 */
	public static function get_admin_url( $page_name = '' ) {
		$path = ( empty( $page_name ) ) ? '' : "admin.php?page={$page_name}";

		return esc_url( get_admin_url( null, $path ) );
	}

	/**
	 * All options name
	 *
	 * @since 3.8.0
	 * @param Null
	 * @return Array
	 */
	public static function get_options_name( $id = '' ) {
		$options_name = array(
			1 => WPUSB_App::SLUG . '_report_db_version',
			2 => WPUSB_App::SLUG . '_settings',
			3 => WPUSB_App::SLUG . '_social_media',
			4 => WPUSB_App::SLUG . '_extra_settings',
			5 => WPUSB_App::SLUG . '_custom_css',
		);

		return self::isset_get( $options_name, $id, $options_name );
	}

	/**
	 * Get component by type
	 *
	 * @since 3.9.0
	 * @param String $type
	 * @return String
	 */
	public static function get_component_by_type( $type = 'counter' ) {
		$component  = 'data-' . WPUSB_App::SLUG . '-component=';
		$attr_name  = ( self::is_sharing_report_disabled() ) ? 'data-report="no" ' : '';
		$attr_name .= ( self::is_disabled_social_counts_js() ) ? ' data-disabled-share-counts="1" ' : '';

		switch ( $type ) :

			case 'counter' :
				$attr_name .= $component . '"counter-social-share"';
				break;

			case 'modal' :
				$attr_name .= $component . '"social-modal"';
				break;

		endswitch;

		return apply_filters( WPUSB_App::SLUG . '-component-name', $attr_name, WPUSB_App::SLUG );
	}

	/**
	 * Get donate paypal url
	 *
	 * @since 3.9.0
	 * @param Null
	 * @return String
	 */
	public static function get_url_donate() {
		$code = 'KYRMWXEEQN58L';

		if ( 'pt_BR' === get_locale() ) {
			$code = 'X7BF5KKYQMA8E';
		}

		return 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=' . $code;
	}

	/**
	 * Check is WooCommerce product page
	 *
	 * @since 3.16
	 * @param Null
	 * @return Boolean
	 */
	public static function is_product() {
		if ( ! function_exists( 'is_product' ) ) {
			return false;
		}

		return ( ( self::option( 'woocommerce' ) === 'on' ) && is_product() );
	}

	/**
	 * Check is plugin admin page
	 *
	 * @since 3.16
	 * @param Null
	 * @return Boolean
	 */
	public static function is_plugin_page() {
		global $pagenow;

		if ( self::indexof( $pagenow, 'customize.php' ) ) {
			return true;
		}

		if ( self::indexof( $pagenow, 'widgets.php' ) ) {
			return true;
		}

		return self::indexof( self::get( 'page' ), WPUSB_App::SLUG );
	}

	/**
	 * Sanitize twitter params ( via | hashtags )
	 *
	 * @since 3.17
	 * @param String $value
	 * @return String
	 */
	public static function sanitize_twitter_params( $value ) {
		if ( empty( $value ) ) {
			return '';
		}

		return preg_replace( '/[^a-zA-Z0-9_,]+/', '', $value );
	}

	/**
	 * Check sharing report is disabled
	 *
	 * @since 3.20
	 * @param Null
	 * @return Boolean
	 */
	public static function is_sharing_report_disabled() {
		return ( 'on' === self::option( 'sharing_report_disabled' ) );
	}

	/**
	 * Check counts is disabled
	 *
	 * @since 3.21
	 * @param Null
	 * @return Boolean
	 */
	public static function is_count_disabled() {
		return ( '1' === self::option( 'disabled_count' ) );
	}

	/**
	 * Check component js share counts is disabled
	 *
	 * @since 3.21
	 * @param Null
	 * @return Boolean
	 */
	public static function is_disabled_social_counts_js() {
		return ( self::is_count_disabled() && self::is_sharing_report_disabled() );
	}

	/**
	 * Get text of the share count title. Default SHARES
	 *
	 * @since 3.22
	 * @version 1.0
	 * @param Null
	 * @return Boolean
	 */
	public static function get_share_count_label() {
		$share_text  = __( 'SHARES', WPUSB_App::TEXTDOMAIN );

		return self::option( 'share_count_label', $share_text );
	}

	/**
	 * Get custom css string
	 *
	 * @since 3.24
	 * @version 1.0
	 * @param Null
	 * @return String
	 */
	public static function get_custom_css() {
		$option     = self::get_options_name( 5 );
		$custom_css = self::get_option( $option );

		return self::rm_tags( $custom_css );
	}

	/**
	 * Build custom css
	 *
	 * @since 3.24
	 * @version 1.0
	 * @param Null
	 * @return Boolean
	 */
	public static function build_css( $custom_css ) {
		self::delete_custom_css_file();

		if ( empty( $custom_css ) ) {
			return ! self::file_css_min_exists();
		}

		$file     = self::get_file_css_min();
		$css_base = self::get_css_base();
		$fp       = @fopen( $file, 'wb' );
		$css      = self::minify_css( $css_base . $custom_css );

		@fwrite( $fp, $css );
		@fclose( $fp );
		@chmod( $file, 0644 );

		return file_exists( $file );
	}

	/**
	 * Minify custom css
	 *
	 * @since 3.24
	 * @version 1.0
	 * @param Null
	 * @return String
	 */
	public static function minify_css( $css ) {
		$css     = preg_replace( '!/\*[^*]*\*+([^\/][^*]*\*+)*/!', '', $css );
		$css     = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css );
		$search  = array( ': ', ', ', ' {', '; ', ' ;', ';}' );
		$replace = array( ':', ',', '{', ';', ';', '}' );
		$css     = str_replace( $search, $replace, $css );

	    return $css;
	}

	/**
	 * Get CSS base string
	 *
	 * @since 3.24
	 * @version 1.0
	 * @param Null
	 * @return String
	 */
	public static function get_css_base() {
		$base = self::file_path( 'stylesheets/style.css' );
		$file = @fopen( $base, 'r' );
		$tmp  = @fread( $file, @filesize( $base ) );

        @fclose( $file );

        return $tmp;
	}

	/**
	 * Get css min file
	 *
	 * @since 3.24
	 * @version 1.0
	 * @param Null
	 * @return string
	 */
	public static function get_file_css_min() {
		return self::file_path( self::get_path_css_min() );
	}

	/**
	 * Get custom background color for icons
	 *
	 * @since 3.26
	 * @version 1.0
	 * @param Array $option
	 * @return string
	 */
	public static function get_custom_background_color_icons( $option = array() ) {
		$background = '';

		if ( isset( $option['buttons_background_color'] ) ) {
			$background = self::rm_tags( $option['buttons_background_color'] );
		}

		if ( empty( $option ) ) {
			$background = self::option( 'buttons_background_color' );
		}

		return ( $background ) ? $background : '';
	}

	/**
	 * Get custom color for icons
	 *
	 * @since 3.26
	 * @version 1.0
	 * @param Array $option
	 * @return string
	 */
	public static function get_custom_color_icons( $option = array() ) {
		$color = '';

		if ( isset( $option['icons_color'] ) ) {
			$color = WPUSB_Utils::rm_tags( $option['icons_color'] );
		}

		if ( empty( $option ) ) {
			$color = WPUSB_Utils::option( 'icons_color' );
		}

		return $color;
	}

	/**
	 * Get validate color and icon color
	 *
	 * @since 3.26
	 * @version 1.0
	 * @param Array $option
	 * @return string
	 */
	public static function get_validate_color_icons( $color, $background ) {
		if ( empty( $color ) || empty( $background ) ) {
			$icon_color = '#fff';
		}

		if ( empty( $color ) && ! empty( $background ) ) {
			$color = $background;
		}

		$icon_color = isset( $icon_color ) ? $icon_color : $color;

		return array( $color, $icon_color );
	}

	/**
	 * Get path css min
	 *
	 * @since 3.25
	 * @version 1.0
	 * @param Null
	 * @return string
	 */
	public static function get_path_css_min() {
		$blog_id = '';

		if ( is_multisite() ) {
			$blog_id = get_current_blog_id();
		}

		return "stylesheets/style.min{$blog_id}.css";
	}

	/**
	 * Check CSS min exists
	 *
	 * @since 3.24
	 * @version 1.0
	 * @param Null
	 * @return Boolean
	 */
	public static function file_css_min_exists() {
		return file_exists( self::get_file_css_min() );
	}

	/**
	 * Delete file custom css if exists
	 *
	 * @since 3.25
	 * @version 1.0
	 * @param Null
	 * @return Void
	 */
	public static function delete_custom_css_file() {
		if ( self::file_css_min_exists() ) {
			@unlink( self::get_file_css_min() );
		}
	}

	/**
	 * Get CSS icons size
	 *
	 * @since 3.25
	 * @version 1.0
	 * @param Null
	 * @return String
	 */
	public static function get_all_custom_css( $custom_css = null, $option = array() ) {
		$settings_icons_size_css = '';
		$settings_icons_size     = '';
		$settings_icons_color    = WPUSB_Shares_View::get_css_icons_color( $option );

		if ( isset( $option['icons_size'] ) ) {
			$settings_icons_size = intval( $option['icons_size'] );
		}

		if ( empty( $option ) ) {
			$settings_icons_size = self::option( 'icons_size', 0, 'intval' );
		}

		if ( $settings_icons_size ) {
			$settings_icons_size_css = WPUSB_Shares_View::get_css_icons_size( $settings_icons_size );
		}

		if ( is_null( $custom_css ) ) {
			$custom_css = self::get_custom_css();
		}

		$css  = $custom_css;
		$css .= $settings_icons_size_css;
		$css .= $settings_icons_color;
		$css .= self::get_widget_custom_css();

		if ( ! empty( $css ) ) {
			return htmlspecialchars_decode( $css );
		}

		return '';
	}

	/**
	 * Get Widget custom CSS
	 *
	 * @since 3.25
	 * @version 1.0
	 * @param Null
	 * @return String
	 */
	public static function get_widget_custom_css() {
		$option_name = self::get_widget_id_base( true );
		$options     = self::get_option( $option_name );

		if ( isset( $options['_multiwidget'] ) ) {
			unset( $options['_multiwidget'] );
		}

		if ( empty( $options ) || ! is_array( $options ) ) {
			return '';
		}

		$icons_size_css  = '';
		$icons_color_css = '';

		foreach ( $options as $number => $option ) :
			$icons_size  = self::isset_get( $option, 'icons_size' );
			$icons_color = self::isset_get( $option, 'icons_color' );
			$background  = self::isset_get( $option, 'icons_background' );
			$layout      = self::isset_get( $option, 'layout' );

			if ( intval( $number ) && ! empty( $icons_size ) ) :
				$icons_size_css .= WPUSB_Shares_View::get_css_icons_size( $icons_size, $number, $layout );
			endif;

			if ( ! empty( $icons_color ) || ! empty( $background ) ) :
				$icons_color_css .= WPUSB_Shares_View::get_widget_css_icons_color( $number, $icons_color, $background );
			endif;
		endforeach;

		return "{$icons_size_css}{$icons_color_css}";
	}

	/**
	 * Table name for sharing reports
	 *
	 * @since 3.25
	 * @version 1.0
	 * @param Null
	 * @return String
	 */
	public static function get_table_name() {
		global $wpdb;

		return $wpdb->prefix . WPUSB_Setting::TABLE_NAME;
	}

	/**
	 * Check WP version and get all blog ids
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function get_sites() {
		global $wp_version;

		if ( version_compare( $wp_version, '4.6', '>=' ) ) {
			return function_exists( 'get_sites' ) ? get_sites() : false;
		}

		if ( version_compare( $wp_version, '3.7', '>=' ) ) {
			return function_exists( 'wp_get_sites' ) ? wp_get_sites() : false;
		}

		return false;
	}

	/**
	 * Widget id base or option name
	 *
	 * @since 1.0
	 * @param Boolean $option
	 * @return String
	 */
	public static function get_widget_id_base( $option = false ) {
		$id_base = 'widget-' . WPUSB_App::SLUG;

		return ( $option ) ? "widget_{$id_base}" : $id_base;
	}

	/**
	 * Minify html output
	 *
	 * @since 3.25
	 * @param String $html
	 * @return String
	 */
	public static function minify_html( $html ) {
		if ( 'on' !== self::option( 'minify_html' ) ) {
			return $html;
		}

		$search  = array( '/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s' );
		$replace = array( '>', '<', '\\1' );

	    return preg_replace( $search, $replace, $html );
	}

	/**
	 * Check plugin widget is activated
	 *
	 * @since 3.25
	 * @param null
	 * @return Mixed
	 */
	public static function is_active_widget() {
		$id_base = self::get_widget_id_base();
		return is_active_widget( false, false, $id_base, true );
	}

	/**
	 * Generate hash MD5 with json_econde
	 *
	 * @since 3.25.3
	 * @param Mixed $args
	 * @return String|Boolean
	 */
	public static function get_hash( $args = '' ) {
		if ( function_exists( 'json_encode' ) ) {
			return md5( json_encode( $args ) );
		}

		return false;
	}

	public static function log( $data, $log_name = '' )
	{
		$name = "{$log_name}-"  . date( 'd-m-Y' )        . '.log';
		$log  = print_r( $data, true ) . PHP_EOL;
		$log .= "\n=============================\n";

		file_put_contents( self::file_path( $name, 'logs/' ), $log, FILE_APPEND );
	}
}
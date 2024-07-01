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
	exit;
}

class WPUSB_Utils extends WPUSB_Utils_Share {
	/**
	 * Escape string for attribute class
	 *
	 * @since 1.0
	 * @param string $string
	 * @return string
	 */
	public static function esc_class( $class ) {
		if ( empty( $class ) || ! is_string( $class ) ) {
			return '';
		}

		return apply_filters( self::add_prefix( '_esc_class' ), sanitize_html_class( $class ) );
	}

	/**
	 * Sanitize value from custom method
	 *
	 * @since 3.4.1
	 * @version 1.0.0
	 * @param string $name
	 * @param mixed $default
	 * @param string|Array $sanitize Relative function
	 * @return mixed
	*/
	public static function request( $type, $name, $default, $sanitize = 'rm_tags' ) {
		$value = filter_input( $type, $name, FILTER_SANITIZE_SPECIAL_CHARS );

		return empty( $value ) ? $default : self::sanitize( $value, $sanitize );
	}

	/**
	 * Sanitize value from methods post
	 *
	 * @since 3.4.1
	 * @version 1.0.0
	 * @param string $name
	 * @param mixed $default
	 * @param string|Array $sanitize Relative function
	 * @return mixed
	*/
	public static function post( $name, $default = '', $sanitize = 'rm_tags' ) {
		return self::request( INPUT_POST, $name, $default, $sanitize );
	}

	/**
	 * Sanitize value from methods get
	 *
	 * @since 3.4.1
	 * @version 1.0.0
	 * @param string $name
	 * @param mixed $default
	 * @param string|Array $sanitize Relative function
	 * @return mixed
	*/
	public static function get( $name, $default = '', $sanitize = 'rm_tags' ) {
		return self::request( INPUT_GET, $name, $default, $sanitize );
	}

	/**
	 * Sanitize value from cookie
	 *
	 * @since 3.4.1
	 * @version 1.0.0
	 * @param string $name
	 * @param mixed $default
	 * @param string|Array $sanitize Relative function
	 * @return mixed
	*/
	public static function cookie( $name, $default = '', $sanitize = 'rm_tags' ) {
		return self::request( INPUT_COOKIE, $name, $default, $sanitize );
	}

	/**
	 * Get filtered super global server by key
	 *
	 * @since 1.2
	 * @param string $key
	 * @return string
	*/
	public static function get_server( $key ) {
		$value = self::get_value_by( $_SERVER, strtoupper( $key ) );

		return self::rm_tags( $value, true );
	}

	/**
	 * Get the menu url by slug
	 *
	 * @since 3.29
	 * @param string $slug
	 * @return string
	*/
	public static function get_page_url( $slug = WPUSB_App::SLUG ) {
		return menu_page_url( $slug, false );
	}

	/**
	 * Sanitize requests
	 *
	 * @since 3.4.1
	 * @version 1.0.0
	 * @param string $value Relative sanitize
	 * @param string $sanitize Relative function to use
	 * @return string
	*/
	public static function sanitize( $value, $sanitize ) {
		if ( ! is_callable( $sanitize ) ) {
			return self::rm_tags( $value );
		}

		if ( is_array( $value ) ) {
			return array_map( $sanitize, $value );
		}

		return call_user_func( $sanitize, $value );
	}

	/**
	 * Properly sanitize values
	 *
	 * @since 3.4.1
	 * @version 1.0.0
	 * @param mixed $value
	 * @return mixed
	 */
	public static function filter_var( $value ) {
		$filter = FILTER_SANITIZE_STRING;

		if ( is_array( $value ) ) {
			return filter_var_array( $value, $filter );
		}

		return filter_var( $value, $filter );
	}

	/**
	 * Properly strip all HTML tags including script and style
	 *
	 * @since 3.4.1
	 * @version 1.0.0
	 * @param mixed String|Array $value
	 * @param boolean $remove_breaks
	 * @return mixed string|array|int
	 */
	public static function rm_tags( $value, $remove_breaks = false ) {
		if ( empty( $value ) ) {
			return $value;
		}

		if ( is_array( $value ) ) {
			$values = self::filter_values_sanitize_option( $value, current_filter() );

			return array_map( __METHOD__, $values );
		}

		if ( is_numeric( $value ) ) {
			return absint( $value );
		}

		return esc_attr( wp_strip_all_tags( $value, $remove_breaks ) );
	}

	/**
	 * Remove empty values is sanitize option
	 *
	 * @since 3.24
	 * @version 1.0
	 * @param array $values
	 * @param string $filter
	 * @return array
	*/
	public static function filter_values_sanitize_option( $values, $filter ) {
		if ( self::is_sanitize_option_filter( $filter ) ) {
			if ( isset( $values['twitter_hashtags'] ) ) {
				$values['twitter_hashtags'] = self::sanitize_twitter_hashtags( $values['twitter_hashtags'] );
			}

			return array_filter( self::parse_post_types( $values ) );
		}

		return $values;
	}

	/**
	 * Verify is sanitize option filter
	 *
	 * @since 3.24
	 * @version 1.0
	 * @param string $filter
	 * @return boolean
	*/
	public static function is_sanitize_option_filter( $filter ) {
		return ( is_admin() && self::indexof( $filter, 'sanitize_option_' ) );
	}

	/**
	 * Find the position of the first occurrence of a substring in a string
	 *
	 * @since 3.24
	 * @version 1.0
	 * @param string $value
	 * @param string $search
	 * @return boolean
	*/
	public static function indexof( $value, $search ) {
		return ( false !== strpos( $value, $search ) );
	}

	/**
	 * Verify request ajax
	 *
	 * @since 1.0
	 * @return boolean
	*/
	public static function is_request_ajax() {
		$request_ajax = self::get_server( 'HTTP_X_REQUESTED_WITH' );

		return ( ! empty( $request_ajax ) && strtolower( $request_ajax ) === 'xmlhttprequest' );
	}

	/**
	 * Post title
	 *
	 * @since 1.0
	 * @return string
	 */
	public static function get_title() {
		$post_id = self::get_id();

		if ( $post_id ) {
			$post_title = get_the_title( $post_id );
			return self::rm_tags( self::html_decode( $post_title ) );
		}

		return self::site_name();
	}

	/**
	 * Site name
	 *
	 * @since 3.6.4
	 * @return string
	 */
	public static function site_name() {
		$site_name = self::get_option( 'blogname' );

		return self::rm_tags( $site_name );
	}

	/**
	 * Site description
	 *
	 * @since 3.6.4
	 * @return string
	 */
	public static function get_site_description() {
		$description = self::get_option( 'blogdescription' );

		return self::rm_tags( $description );
	}

	/**
	 * Get the blog post page ID
	 *
	 * @return int
	 */
	public static function get_page_posts_id() {
		return (int) get_option( 'page_for_posts' );
	}

	/**
	 * Post ID
	 *
	 * @since 1.0
	 * @return int
	 */
	public static function get_id() {
		global $post;

		return isset( $post->ID ) ? intval( $post->ID ) : false;
	}

	/**
	 * Current page id
	 *
	 * @since 3.30
	 * @return int
	 */
	public static function get_reference_id() {
		if ( self::is_archive_category() ) {
			return get_queried_object_id();
		}

		return self::get_id();
	}

	/**
	 * Site home url
	 *
	 * @since 3.6.4
	 * @return string
	 */
	public static function site_url( $path = '', $short = true ) {
		$site_url = get_home_url( null, "/{$path}" );
		$url      = self::parse_url_params( $site_url );

		return ( $short ) ? self::bitly_short_url( $url, true ) : $url;
	}

	/**
	 * Permalink post
	 *
	 * @since 1.0
	 * @param int $post
	 * @return string
	 */
	public static function get_permalink( $post = 0 ) {
		$post_id = $post ? $post : self::get_id();

		if ( $post_id ) {
			return self::parse_url_params( get_permalink( $post_id ) );
		}

		return self::site_url();
	}

	/**
	 * Permalinks post | archive | category
	 *
	 * @since 1.0
	 * @return string
	 */
	public static function get_real_permalink( $fixed = false, $widget = false, $short = true ) {
		$url = apply_filters( self::add_prefix( '-real-permalink' ), false, $fixed, $widget );

		if ( $url ) {
			return esc_url( $url );
		}

		$is_home = $widget ? self::is_front_page() : self::is_home();

		if ( ( $fixed || $widget ) && $is_home || $is_home && is_page( self::get_id() ) ) {
			return self::is_blog_page() ? self::get_permalink( self::get_page_posts_id() ) : self::site_url();
		}

		if ( ! ( ( $fixed || $widget ) && self::is_archive_category() ) ) {
			$url = self::get_permalink();
			return $short ? self::bitly_short_url( $url ) : $url;
		}

		return self::get_term_link( $short );
	}

	/**
	 * Get term link
	 *
	 * @since 3.6.4
	 * @return string
	 */
	public static function get_term_link( $short = true ) {
		$term      = self::get_queried_object();
		$term_link = get_term_link( $term );

		if ( is_wp_error( $term_link ) ) {
			return self::site_url();
		}

		$term_link = self::parse_url_params( $term_link );

		return ( $short ) ? self::bitly_short_url( $term_link ) : $term_link;
	}

	/**
	 * Generate hash name bitly short url cache
	 *
	 * @since 3.27
	 * @param string $permalink
	 * @return string
	 */
	public static function bitly_get_cache_id( $permalink ) {
		return md5( $permalink );
	}

	/**
	 * Generate short url by bitly
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @return string
	 */
	public static function bitly_short_url( $permalink, $is_fixed = false ) {
		$token = self::option( 'bitly_token' );

		if ( empty( $token ) || self::is_attachment() || self::is_customize_preview() ) {
			return self::url_clean( $permalink );
		}

		return self::bitly_get_url( $token, $permalink, $is_fixed );
	}

	/**
	 * Get short url in cache
	 *
	 * @since 1.0
	 * @param string $token
	 * @param string $url
	 * @return string
	 */
	public static function bitly_get_url( $token, $permalink, $is_fixed = false ) {
		$id        = self::bitly_get_cache_id( $permalink );
		$cache_url = WPUSB_URL_Shortener::get_cache( $id );

		if ( ! empty( $cache_url ) ) {
			return $cache_url;
		}

		if ( ! $is_fixed && ! is_singular() ) {
			return $permalink;
		}

		return self::bitly_remote_get_url( $token, $permalink );
	}

	/**
	 * Set cache shorturl bitly
	 *
	 * @since 1.0
	 * @param string $url_short
	 * @return string
	 */
	public static function bitly_set_cache( $url_short, $permalink ) {
		$tag  = self::add_prefix( '-shorturl-cache-expire' );
		$time = ( 12 * WEEK_IN_SECONDS );

		WPUSB_URL_Shortener::set_cache(
			self::bitly_get_cache_id( $permalink ),
			self::get_id(),
			esc_url_raw( $url_short ),
			apply_filters( $tag, $time )
		);
	}

	/**
	 * Remote request bitly API
	 *
	 * @since 1.0
	 * @param string $token
	 * @param string $url
	 * @return string
	 */
	public static function bitly_remote_get_url( $token, $permalink ) {
		$model     = new WPUSB_URL_Shortener( $permalink, $token );
		$url_short = $model->get_short();

		unset( $model );

		if ( ! $url_short ) {
			return $permalink;
		}

		self::bitly_set_cache( $url_short, $permalink );

		return esc_url( $url_short );
	}

	/**
	 * Check current post_type attachment
	 *
	 * @since 3.27
	 * @return boolean
	 */
	public static function is_attachment() {
		return ( get_post_type( self::get_id() ) === 'attachment' );
	}

	/**
	 * Parse url query args
	 *
	 * @since 3.15
	 * @version 1.0.0
	 * @param string $url
	 * @return string
	 */
	public static function parse_url_params( $permalink ) {
		$tracking     = self::get_tracking();
		$query_string = self::get_query_string();

		if ( empty( $tracking ) && empty( $query_string ) ) {
			$url = esc_url( $permalink );
			return rawurlencode( $url );
		}

		$has_param = self::indexof( $permalink, '?' );

		if ( ! empty( $tracking ) && empty( $query_string ) && ! $has_param ) {
			$url         = esc_url( $permalink );
			$build_query = self::build_query( $tracking );
			return rawurlencode( "{$url}?{$build_query}" );
		}

		if ( empty( $tracking ) && ! empty( $query_string ) && ! $has_param ) {
			$url         = esc_url( $permalink );
			$build_query = self::build_query( $query_string );
			return rawurlencode( "{$url}?{$build_query}" );
		}

		$args        = add_query_arg( $tracking, '', $query_string );
		$build_query = self::build_query( $args );

		if ( $has_param ) {
			$params = self::parse_str( $args );
			$url    = remove_query_arg( array_keys( $params ), $permalink );
			$url    = esc_url( add_query_arg( $build_query, '', $url ) );
			$url    = str_replace( '&#038;', '&', $url );
			return rawurlencode( $url );
		}

		$url = esc_url( "{$permalink}?{$build_query}" );
		$url = str_replace( '&#038;', '&', $url );

		return rawurlencode( $url );
	}

	/**
	 * Query string parse
	 *
	 * @since 3.27.1
	 * @version 1.0.0
	 * @param string $query_string
	 * @return string
	 */
	public static function build_query( $query_string ) {
		$params = self::parse_str( $query_string );
		return http_build_query( $params );
	}

	/**
	 * Parse query string parameters to array
	 *
	 * @since 3.28
	 * @version 1.0.0
	 * @param string $query_string
	 * @return array
	 */
	public static function parse_str( $query_string ) {
		parse_str( str_replace( '?', '', $query_string ), $params );
		return $params;
	}

	/**
	 * Query string sanitize
	 *
	 * @since 3.15
	 * @version 1.0.0
	 * @return string
	 */
	public static function get_query_string() {
		$query_string = self::get_server( 'QUERY_STRING' );
		return self::sanitize_query_string( $query_string );
	}

	/**
	 * Sanitize query string
	 *
	 * @since 3.27
	 * @param string $query_string
	 * @return string
	 */
	public static function sanitize_query_string( $query_string ) {
		$query_string = rawurldecode( $query_string );
		return self::rm_tags( $query_string, true );
	}

	/**
	 * Return clean url and add implements filter
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @param string $url
	 * @return string
	 */
	public static function url_clean( $url ) {
		$tag          = self::add_prefix( '-url-share' );
		$filtered_url = apply_filters( $tag, $url, self::get_id() );

		if ( $filtered_url === $url ) {
			return $url;
		}

		$decoded_url = rawurldecode( $filtered_url );

		return rawurlencode( esc_url( $decoded_url ) );
	}

	/**
	 * Return tracking UTM
	 *
	 * @since 3.1.4
	 * @version 1.0.0
	 * @return string
	 */
	public static function get_tracking() {
		$tracking = self::option( 'tracking' );

		return esc_attr( self::html_decode( $tracking ) );
	}

	/**
	 * Title for post | archive | category
	 *
	 * @since 1.0
	 * @return string
	 */
	public static function get_real_title( $fixed = false, $widget = false ) {
		$title = apply_filters( self::add_prefix( '-real-title' ), false, $fixed );

		if ( $title ) {
			return self::rm_tags( $title );
		}

		$is_home = ( $widget ) ? self::is_front_page() : self::is_home();

		if ( ( $fixed || $widget ) && $is_home || $is_home && is_page( self::get_id() ) ) {
			return rawurlencode( self::site_name() );
		}

		if ( ! ( ( $fixed || $widget ) && self::is_archive_category() ) ) {
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
	 * @return boolean | Object
	 */
	public static function get_queried_object() {
		$term = get_queried_object();

		if ( isset( $term->term_id ) ) {
			return $term;
		}

		return false;
	}

	/**
	 * Post thumbnail URL
	 *
	 * @since 1.0
	 * @return string
	 */
	public static function get_image() {
		$image_url = '';

		if ( $image_id = self::get_image_id() ) {
			$image_url = wp_get_attachment_url( $image_id );
		}

		return apply_filters( self::add_prefix( '_thumbnail_url' ), $image_url );
	}

	/**
	 * Post thumbnail ID
	 *
	 * @since 3.31
	 * @return string
	 */
	public static function get_image_id() {
		if ( $id = self::get_id() ) {
			return (int) get_post_meta( $id, '_thumbnail_id', true );
		}

		return false;
	}

	/**
	 * Post thumbnail alt description
	 *
	 * @since 3.31
	 * @return string
	 */
	public static function get_image_alt() {
		if ( $image_id = self::get_image_id() ) {
			$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			return self::rm_tags( $image_alt, true );
		}

		return '';
	}

	/**
	 * Add tag with prefix
	 *
	 * @since 1.0
	 * @param string $after
	 * @param string $before
	 * @return string
	 */
	public static function add_prefix( $after, $before = '' ) {
		return $before . WPUSB_App::SLUG . $after;
	}

	/**
	 * Component attribute
	 *
	 * @since 3.32
	 * @param string $name
	 * @return string
	 */
	public static function get_component( $name ) {
		return self::add_prefix( sprintf( '-component="%s"', $name ), 'data-' );
	}

	/**
	 * Get content posts
	 *
	 * @since 1.1
	 * @return string content post
	 */
	public static function body_mail() {
		global $post;

		$content = '';

		if ( ( self::is_single() || self::is_page() ) && isset( $post->ID ) ) {
			$content = self::rm_tags( empty( $post->post_excerpt ) ? $post->post_content : $post->post_excerpt );
		}

		if ( empty( $content ) ) {
			$content = self::get_site_description();
		}

		$content = preg_replace( '/\[.*\]/', '', $content );

		return apply_filters( self::add_prefix( '-body-email' ), $content, $post );
	}

	/**
	 * Plugin base name
	 *
	 * @since 1.0
	 * @return string link base file
	 */
	public static function basename( $filter = '' ) {
		return $filter . plugin_basename( WPUSB_PLUGIN_FILE );
	}

	/**
	 * Plugin basename
	 *
	 * @since 3.34
	 * @return string
	 */
	public static function plugin_basename() {
		return plugin_basename( dirname( WPUSB_PLUGIN_FILE ) );
	}

	/**
	 * Decode html entity.
	 *
	 * @since 1.0
	 * @param string $string
	 * @return string
	 */
	public static function html_decode( $string ) {
		return html_entity_decode( $string, ENT_NOQUOTES );
	}

	/**
	 * Plugin file url in assets directory
	 *
	 * @since 1.0
	 * @param string $file
	 * @param string $path
	 * @return string
	 */
	public static function plugin_url( $file, $path = 'assets/' ) {
		return plugins_url( "{$path}{$file}", __DIR__ );
	}

	/**
	 * Plugin build url.
	 *
	 * @since 3.40
	 * @param string $file
	 * @return string
	 */
	public static function build_url( $file ) {
		return self::plugin_url( $file, 'build/' );
	}

	/**
	 * Plugin build path.
	 *
	 * @since 3.40
	 * @param string $file
	 * @return string
	 */
	public static function build_path( $file ) {
		return self::file_path( $file, 'build/' );
	}

	/**
	 * Plugin file path in assets directory
	 *
	 * @since 1.0
	 * @param string $file
	 * @return string
	 */
	public static function file_path( $file = '', $path = 'assets/' ) {
		return plugin_dir_path( dirname( __FILE__ ) ) . "{$path}{$file}";
	}

	/**
	 * Generate file time style and scripts
	 *
	 * @since 1.0
	 * @param string $path
	 * @return string|integer
	 */
	public static function filetime( $path ) {
		if ( ! file_exists( $path ) ) {
			return WPUSB_PLUGIN_VERSION;
		}

		return filemtime( $path );
	}

	/**
	 * Get option unique and sanitize
	 *
	 * @since 1.0
	 * @param string $name Relative option name
	 * @param string $sanitize Relative function
	 * @return string
	 */
	public static function option( $name, $default = '', $sanitize = 'rm_tags' ) {
		$model = WPUSB_Setting::get_instance();
		$value = self::get_value_by( $model->get_options(), $name );

		if ( empty( $value ) ) {
			return $default;
		}

		$value = self::sanitize( $value, $sanitize );

		return apply_filters( self::add_prefix( "-option-{$name}-value" ), $value );
	}

	/**
	 * response error server json
	 *
	 * @since 1.0
	 * @param int $code
	 * @param string $message
	 * @param boolean $echo
	 * @return string
	 */
	public static function error_server_json( $code, $message = 'Message Error', $echo = true ) {
		$response = self::json_encode(
			array(
				'status'  => 'error',
				'code'    => $code,
				'message' => $message,
			)
		);

		if ( $echo ) {
			echo $response; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			exit;
		}

		return $response;
	}

	/**
	 * Request not found
	 *
	 * @since 1.0
	 * @param array|string|boolean|int $request
	 * @param int $code
	 * @param string $message
	 * @return void
	 */
	public static function ajax_verify_request( $request, $message = 'server_error', $code = 500 ) {
		if ( ! $request ) {
			http_response_code( $code );
			self::error_server_json( $code, $message );
			exit;
		}
	}

	/**
	 * Delete option
	 *
	 * @since 1.0.0
	 * @since 3.24
	 * @param string $option
	 * @return boolean
	 */
	public static function delete_option( $option ) {
		return delete_option( $option );
	}

	/**
	 * Get option
	 *
	 * @since 1.0.0
	 * @since 3.24
	 * @param string $option
	 * @return mixed
	 */
	public static function get_option( $option ) {
		return get_option( $option );
	}

	/**
	 * Add option
	 *
	 * @since 1.0.0
	 * @since 3.24
	 * @param string $option
	 * @param string $value
	 * @return boolean
	 */
	public static function add_option( $option, $value ) {
		return add_option( $option, $value );
	}

	/**
	 * Update option
	 *
	 * @since 1.0.0
	 * @since 3.24
	 * @param string $option
	 * @param string $value
	 * @return boolean
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
	 * @since 3.35
	 * @param float $number
	 * @param int $dec
	 * @param string $point
	 * @param string $sep
	 * @return string
	 */
	public static function format_number( $number, $dec = 0, $point = null, $sep = null ) {
		return number_format( (float)$number, $dec, $point, $sep );
	}

	/**
	 * Verify index in array and set
	 *
	 * @since 1.0
	 * @param array $args
	 * @param string|int $index
	 * @return string
	 */
	public static function isset_get( $args = array(), $index = '', $default = '' ) {
		if ( $value = self::get_value_by( $args, $index ) ) {
			return $value;
		}

		if ( isset( $args['elements'] ) ) {
			return self::get_value_by( $args['elements'], $index );
		}

		return $default;
	}

	/**
	 * Check field option equal the current option
	 *
	 * @since 1.0
	 * @param mixed $current
	 * @param mixed $selected
	 * @return string
	 */
	public static function selected( $selected, $current ) {
		if ( is_array( $current ) ) {
			return in_array( $selected, $current ) ? 'selected="selected"' : '';
		}

		return selected( $selected, $current, false );
	}

	/**
	 * Check field option equal the current option
	 *
	 * @since 1.0
	 * @param mixed $checked
	 * @param mixed $current
	 * @param boolean $echo
	 * @return string
	 */
	public static function checked( $checked, $current, $echo = false ) {
		return checked( $checked, $current, $echo );
	}

	/**
	 * Get field name option
	 *
	 * @since 3.29
	 * @param string $name
	 * @param string $prefix
	 * @param boolean $multiple
	 * @return string
	 */
	public static function get_field_name( $name, $prefix = '', $multiple = false ) {
		$prefix     = empty( $prefix ) ? WPUSB_App::SLUG : $prefix;
		$field_name = sprintf( '%s[%s]', $prefix, $name );

		return ( $multiple ) ? sprintf( '%s[]', $field_name ) : $field_name;
	}

	/**
	 * Get value by array index
	 *
	 * @since 3.29
	 * @param array $args
	 * @param string|int $index
	 * @return string
	 */
	public static function get_value_by( $args, $index, $default = '' ) {
		if ( ! isset( $args[ $index ] ) || empty( $args[ $index ] ) ) {
			return $default;
		}

		return self::rm_tags( $args[ $index ] );
	}

	/**
	 * Check WP version and include file screen correctly
	 *
	 * @since 1.0
	 * @return void
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
	 * @param string $key
	 * @return boolean
	 */
	public static function get_update( $key ) {
		return ( 'true' === self::get( $key ) );
	}

	/**
	 * Add options social media default
	 *
	 * @since 1.0
	 * @return void
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
	 * @return void
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
		$value  = apply_filters( self::add_prefix( '-options-settings' ), $value );

		self::add_option( $option['name'], $value );
	}

	/**
	 * Add options social media default
	 *
	 * @since 2.9.3
	 * @return void
	 */
	private static function _add_options_social_media() {
		$option = self::get_option_group_name( 'social_media' );
		$value  = array(
			'facebook' => 'facebook',
			'twitter'  => 'twitter',
			'whatsapp' => 'whatsapp',
			'share'    => 'share',
		);
		$value  = apply_filters( self::add_prefix( '-options-social-media' ), $value );

		self::add_option( $option['name'], $value );
	}

	/**
	 * Add options extra settings default
	 *
	 * @since 1.0
	 * @return void
	 */
	private static function _add_options_extra_settings() {
		$option = self::get_option_group_name( 'extra_settings' );
		$value  = array(
			'disable_css'             => 'off',
			'disable_js'              => 'off',
			'css_footer'              => 'off',
			'sharing_report_disabled' => 'off',
			'minify_html'             => 'off',
		);
		$value = apply_filters( self::add_prefix( '-options-extra-settings' ), $value );

		self::add_option( $option['name'], $value );
	}

	/**
	 * Get option name and group to register settings
	 *
	 * @since 1.0
	 * @param string $name
	 * @param string $group
	 * @return array
	 */
	public static function get_option_group_name( $name, $group = 'group' ) {
		$prefix       = WPUSB_App::SLUG;
		$option_name  = self::add_prefix( "_{$name}" );
		$group_name   = ( 'group' !== $group ) ? $prefix : $option_name;
		$option_group = "{$group_name}_{$group}";

		return array(
			'name' => $option_name,
			'group' => $option_group,
		);
	}

	/**
	 * Twitter text share
	 *
	 * @since 1.0
	 * @param string $title
	 * @param string $twitter_text_a
	 * @param string $twitter_text_b
	 * @param string $character
	 * @return string
	 */
	public static function get_twitter_text( $title, $twitter_text_a, $twitter_text_b, $character ) {
		$text = "{$twitter_text_a}%20{$title}%20-%20{$twitter_text_b}%20{$character}%20";

		return apply_filters( self::add_prefix( '-twitter-text' ), $text, $title );
	}

	/**
	 * Add class active current page in top menu
	 *
	 * @since 1.0
	 * @param string $current
	 * @return string|null
	 */
	public static function selected_menu( $current ) {
		return ( self::get( 'page' ) === $current ) ? 'active' : '';
	}

	/**
	 * Verify is button fixed in top
	 *
	 * @since 1.0
	 * @return string
	 */
	public static function is_fixed_top() {
		return self::option( 'fixed_top', false );
	}

	/**
	 * Make sure is activated the Share Buttons in singles
	 *
	 * @since 3.1.0
	 * @return boolean
	 */
	public static function is_single() {
		$tag = self::add_prefix( '_is_single' );

		if ( is_single() && self::option( 'single' ) === 'on' ) {
			return apply_filters( $tag, true );
		}

		return apply_filters( $tag, false );
	}

	/**
	 * Make sure is activated the Share Buttons in pages
	 *
	 * @since 3.1.0
	 * @return boolean
	 */
	public static function is_page() {
		$tag = self::add_prefix( '_is_page' );

		if ( ( is_page() || is_page_template() ) && self::option( 'pages' ) === 'on' ) {
			return apply_filters( $tag, true );
		}

		return apply_filters( $tag, false );
	}

	/**
	 * make sure is activated the Share Buttons in home
	 *
	 * @since 3.1.0
	 * @return boolean
	 */
	public static function is_home() {
		$tag = self::add_prefix( '_is_home' );

		if ( self::is_front_page() && self::option( 'home' ) === 'on' ) {
			return apply_filters( $tag, true );
		}

		return apply_filters( $tag, false );
	}

	/**
	 * Check is initial page
	 *
	 * @since 3.25
	 * @return boolean
	 */
	public static function is_front_page() {
		$tag = self::add_prefix( '_is_front_page' );

		return apply_filters( $tag, ( is_home() || is_front_page() ) );
	}

	/**
	 * make sure is activated the Share Buttons in archive and category page
	 *
	 * @since 3.2.2
	 * @return boolean
	 */
	public static function is_archive_category() {
		$tag = self::add_prefix( '_is_archive_category' );

		if ( ( is_archive() || is_category() ) && self::option( 'archive_category' ) === 'on' ) {
			return apply_filters( $tag, true );
		}

		return apply_filters( $tag, false );
	}

	/**
	 * Check is WooCommerce product page
	 *
	 * @since 3.16
	 * @return boolean
	 */
	public static function is_product() {
		$tag = self::add_prefix( '_is_product' );

		if ( ! function_exists( 'is_product' ) ) {
			return apply_filters( $tag, false );
		}

		return apply_filters( $tag, self::option( 'woocommerce' ) === 'on' && is_product() );
	}

	/**
	 * Verify is active page option
	 *
	 * @since 3.2.0
	 * @return boolean
	 */
	public static function is_active() {
		if (
			self::is_home() ||
			self::is_archive_category() ||
			self::is_page() ||
			self::is_single() ||
			self::is_product()
		) {
			$active = true;
		}

		return apply_filters( self::add_prefix( '_is_active' ), isset( $active ) );
	}

	/**
	 * Retrieve only the body from the raw response and decode json.
	 *
	 * @since 3.6.0
	 * @param mixed $response
	 * @return array
	 */
	public static function retrieve_body_json( $response ) {
		$body = wp_remote_retrieve_body( $response );

		return self::json_decode( $body );
	}

	/**
	 * Admin sanitize url
	 *
	 * @since 3.6.0
	 * @param string $path
	 * @return string
	 */
	public static function get_admin_url( $path = '' ) {
		return esc_url( get_admin_url( null, $path ) );
	}

	/**
	 * All options name
	 *
	 * @since 3.8.0
	 * @return array|string
	 */
	public static function get_options_name( $id = '' ) {
		$options_name = array(
			1 => WPUSB_App::SLUG . '_report_db_version',
			2 => WPUSB_App::SLUG . '_settings',
			3 => WPUSB_App::SLUG . '_social_media',
			4 => WPUSB_App::SLUG . '_extra_settings',
			5 => WPUSB_App::SLUG . '_custom_css',
		);

		return self::get_value_by( $options_name, $id, $options_name );
	}

	/**
	 * Get component by type
	 *
	 * @since 3.9.0
	 * @since 3.32
	 * @return string
	 */
	public static function get_component_by_type() {
		$attrs  = ( self::is_sharing_report_disabled() ) ? 'data-report="no" ' : '';
		$attrs .= ( self::is_count_disabled() ) ? ' data-disabled-share-counts="1" ' : '';
		$attrs .= self::get_component( 'counter-social-share' );

		return apply_filters( self::add_prefix( '-component-name' ), $attrs, WPUSB_App::SLUG );
	}

	/**
	 * Get donate paypal url
	 *
	 * @since 3.9.0
	 * @return string
	 */
	public static function get_url_donate() {
		$code = 'KYRMWXEEQN58L';

		if ( 'pt_BR' === get_locale() ) {
			$code = 'X7BF5KKYQMA8E';
		}

		return 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=' . $code;
	}

	/**
	 * Check is plugin admin page
	 * Check is customize page preview
	 *
	 * @since 3.16
	 * @return boolean
	 */
	public static function is_plugin_page() {
		global $pagenow;

		if ( self::indexof( $pagenow, 'customize.php' ) ) {
			return true;
		}

		if ( self::indexof( $pagenow, 'widgets.php' ) ) {
			return true;
		}

		return self::is_dashboard_page();
	}

	/**
	 * Check is plugin dashboards page
	 *
	 * @since 3.32
	 * @return boolean
	 */
	public static function is_dashboard_page() {
		return self::indexof( self::get( 'page' ), WPUSB_App::SLUG );
	}

	/**
	 * Sanitize twitter params ( via | hashtags )
	 *
	 * @since 3.17
	 * @param string $value
	 * @return string
	 */
	public static function sanitize_twitter_params( $value ) {
		return empty( $value ) ? '' : preg_replace( '/[^a-zA-Z0-9_,]+/', '', $value );
	}

	/**
	 * Sanitize twitter param hashtags
	 *
	 * @since 3.17
	 * @param string $hashtags
	 * @return string
	 */
	public static function sanitize_twitter_hashtags( $hashtags ) {
		if ( empty( $hashtags ) ) {
			return $hashtags;
		}

		$tags     = explode( ',', $hashtags );
		$new_tags = array();

		foreach ( $tags as $hashtag ) :
			$tag = preg_replace( '/\s+/', ', ', self::rm_tags( $hashtag, true ) );

			if ( empty( $tag ) ) {
				continue;
			}

			$new_tags[ $tag ] = $tag;
		endforeach;

		return implode( ', ', $new_tags );
	}

	/**
	 * Check sharing report is disabled
	 *
	 * @since 3.20
	 * @return boolean
	 */
	public static function is_sharing_report_disabled() {
		return ( 'on' === self::option( 'sharing_report_disabled' ) );
	}

	/**
	 * Check counts is disabled
	 *
	 * @since 3.21
	 * @return boolean
	 */
	public static function is_count_disabled() {
		return ( 1 === self::option( 'disabled_count' ) );
	}

	/**
	 * Get text of the share count title. Default SHARES
	 *
	 * @since 3.22
	 * @version 1.0
	 * @return string
	 */
	public static function get_share_count_label() {
		$share_text = __( 'SHARES', 'wpupper-share-buttons' );

		return self::option( 'share_count_label', $share_text );
	}

	/**
	 * Get custom css string
	 *
	 * @since 3.24
	 * @version 1.0
	 * @return string
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
	 * @return boolean
	 */
	public static function build_css( $custom_css ) {
		global $wp_filesystem;

		if ( empty( $custom_css ) ) {
			self::delete_custom_css_file();
			return ! self::file_css_min_exists();
		}

		require_once ABSPATH . 'wp-admin/includes/file.php';
		\WP_Filesystem();

		$file = self::get_file_css_min();
		$css  = self::minify_css( self::get_css_base() . $custom_css );

		$wp_filesystem->put_contents( $file, $css, FS_CHMOD_FILE );

		return $wp_filesystem->exists( $file );
	}

	/**
	 * Minify custom css
	 *
	 * @since 3.24
	 * @version 1.0
	 * @return string
	 */
	public static function minify_css( $css ) {
		$css     = preg_replace( '!/\*[^*]*\*+([^\/][^*]*\*+)*/!', '', $css );
		$css     = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );
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
	 * @return string
	 */
	public static function get_css_base() {
		global $wp_filesystem;

		require_once ABSPATH . 'wp-admin/includes/file.php';

		\WP_Filesystem();

		return $wp_filesystem->get_contents( self::build_path( 'style.css' ) );
	}

	/**
	 * Get css min file
	 *
	 * @since 3.24
	 * @version 1.0
	 * @return string
	 */
	public static function get_file_css_min() {
		return self::build_path( self::get_path_css_min() );
	}

	/**
	 * Get path css min
	 *
	 * @since 3.25
	 * @version 1.0
	 * @return string
	 */
	public static function get_path_css_min() {
		$blog_id = is_multisite() ? get_current_blog_id() : '';

		return sprintf( 'style.min%s.css', $blog_id );
	}

	/**
	 * Check CSS min exists
	 *
	 * @since 3.24
	 * @version 1.0
	 * @return boolean
	 */
	public static function file_css_min_exists() {
		return file_exists( self::get_file_css_min() );
	}

	/**
	 * Delete file custom css if exists
	 *
	 * @since 3.25
	 * @version 1.0
	 * @return void
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
	 * @return string
	 */
	public static function get_all_custom_css( $custom_css = null, $options = array() ) {
		$settings_css      = WPUSB_Shares_View::get_css_buttons_styles( $options );
		$widgets_css       = self::get_widget_custom_css();
		$widget_follow_css = self::get_widget_follow_custom_css();

		if ( is_null( $custom_css ) ) {
			$custom_css = self::get_custom_css();
		}

		$css  = $custom_css;
		$css .= $settings_css;
		$css .= $widgets_css;
		$css .= $widget_follow_css;

		$css = apply_filters( self::add_prefix( '_custom_css' ), $css );

		return empty( $css ) ? '' : self::html_decode( $css );
	}

	/**
	 * Get Widget custom CSS
	 *
	 * @since 3.25
	 * @version 1.0
	 * @return string
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

		$widgets_css    = '';
		$widget_options = array();

		foreach ( $options as $number => $option ) :
			$widget_options = array(
				'icons_size'        => self::get_value_by( $option, 'icons_size' ),
				'icons_color'       => self::get_value_by( $option, 'icons_color' ),
				'btn_inside_color'  => self::get_value_by( $option, 'btn_inside_color' ),
				'counts_text_color' => self::get_value_by( $option, 'counts_text_color' ),
				'counts_bg_color'   => self::get_value_by( $option, 'counts_bg_color' ),
				'button_bg_color'   => self::get_value_by( $option, 'icons_background' ),
			);
			$widget_id    = self::get_widget_attr_id( $number );
			$widgets_css .= WPUSB_Shares_View::get_css_buttons_styles( $widget_options, "#{$widget_id}" );
		endforeach;

		return $widgets_css;
	}

	/**
	 * Get Widget Follow custom CSS
	 *
	 * @since 3.27
	 * @version 1.0
	 * @return string
	 */
	public static function get_widget_follow_custom_css() {
		$option_name = self::get_widget_follow_id_base( true );
		$options     = self::get_option( $option_name );

		if ( isset( $options['_multiwidget'] ) ) {
			unset( $options['_multiwidget'] );
		}

		if ( empty( $options ) || ! is_array( $options ) ) {
			return '';
		}

		$widgets_css = '';

		foreach ( $options as $number => $option ) :
			$widget_options = array(
				'icons_size'        => self::get_value_by( $option, 'icons_size' ),
				'icons_color'       => self::get_value_by( $option, 'icons_color' ),
				'btn_inside_color'  => '',
				'counts_text_color' => '',
				'counts_bg_color'   => '',
				'button_bg_color'   => '',
			);
			$widget_id    = self::get_widget_follow_attr_id( $number );
			$widgets_css .= WPUSB_Shares_View::get_css_buttons_styles( $widget_options, "#{$widget_id}" );
		endforeach;

		return $widgets_css;
	}

	/**
	 * Get Widget follow attribute ID
	 *
	 * @since 3.27
	 * @version 1.0
	 * @return string
	 */
	public static function get_widget_follow_attr_id( $number ) {
		return sprintf( '%s-follow-widget-%d', WPUSB_App::SLUG, $number );
	}

	/**
	 * Table name for sharing reports
	 *
	 * @since 3.25
	 * @version 1.0
	 * @return string
	 */
	public static function get_table_name() {
		global $wpdb;

		return $wpdb->prefix . WPUSB_Setting::TABLE_NAME;
	}

	/**
	 * Check WP version and get all blog ids
	 *
	 * @since 1.0
	 * @return array
	 */
	public static function get_sites() {
		global $wpdb;

		if ( ! isset( $wpdb->blogs ) ) {
			return array();
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		return $wpdb->get_col(
			"SELECT
				`blog_id`
			 FROM
			 	`{$wpdb->blogs}`
			 WHERE
			 	`public` = 1
			"
		);
	}

	/**
	 * Widget id base or option name
	 *
	 * @since 1.0
	 * @param boolean $option
	 * @return string
	 */
	public static function get_widget_id_base( $option = false ) {
		$id_base = 'widget-' . WPUSB_App::SLUG;

		return $option ? "widget_{$id_base}" : $id_base;
	}

	/**
	 * Widget follow us id base or option name
	 *
	 * @since 1.0
	 * @param boolean $option
	 * @return string
	 */
	public static function get_widget_follow_id_base( $option = false ) {
		$id_base = self::get_widget_id_base() . '-follow';

		return $option ? "widget_{$id_base}" : $id_base;
	}

	/**
	 * Minify html output
	 *
	 * @since 3.25
	 * @param string $html
	 * @param boolean $force
	 * @return string
	 */
	public static function minify_html( $html ) {
		if ( ! self::is_active_minify_html() ) {
			return $html;
		}

		$search  = array( '/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s' );
		$replace = array( '>', '<', '\\1' );

		return preg_replace( $search, $replace, $html );
	}

	/**
	 * Verify is active minify html option.
	 *
	 * @since 3.40
	 * @return bool
	 */
	public static function is_active_minify_html() {
		return 'on' === self::option( 'minify_html' );
	}

	/**
	 * Check plugin widget is activated
	 *
	 * @since 3.25
	 * @return mixed
	 */
	public static function is_active_widget() {
		return ( self::is_active_widget_share() || self::is_active_widget_follow() );
	}

	/**
	 * Check plugin widget share is activated
	 *
	 * @since 3.27
	 * @return mixed
	 */
	public static function is_active_widget_share() {
		$id_base = self::get_widget_id_base();

		return is_active_widget( false, false, $id_base, true );
	}

	/**
	 * Check plugin widget follow is activated
	 *
	 * @since 3.27
	 * @return mixed
	 */
	public static function is_active_widget_follow() {
		$id_base = self::get_widget_follow_id_base();

		return is_active_widget( false, false, $id_base, true );
	}

	/**
	 * Check is disabled css
	 *
	 * @since 3.27
	 * @return mixed
	 */
	public static function is_disabled_css() {
		return ( 'on' === self::option( 'disable_css' ) );
	}

	/**
	 * Generate hash MD5 with json_encode.
	 *
	 * @since 3.25.3
	 * @param mixed $args
	 * @return string|boolean
	 */
	public static function get_hash( $args = '' ) {
		return md5( self::json_encode( $args ) );
	}

	/**
	 * Check curl function exists
	 *
	 * @since 3.27
	 * @return boolean
	 */
	public static function has_curl() {
		return function_exists( 'curl_init' );
	}

	/**
	 * Check json functions exist
	 *
	 * @since 3.27
	 * @return boolean
	 */
	public static function has_json() {
		return function_exists( 'json_encode' );
	}

	/**
	 * Json decode string to object
	 *
	 * @since 3.27
	 * @param string $value
	 * @return mixed Object|false
	 */
	public static function json_decode( $value, $assoc = false ) {
		if ( ! self::has_json() || empty( $value ) ) {
			return false;
		}

		return json_decode( $value, $assoc );
	}

	/**
	 * Json encode string to object
	 *
	 * @since 3.27
	 * @param string $value
	 * @return mixed Object|Array
	 */
	public static function json_encode( $value ) {
		if ( ! self::has_json() ) {
			return false;
		}

		return json_encode( $value );
	}

	/**
	 * Default class for all buttons link
	 *
	 * @since 3.27
	 * @return string
	 */
	public static function get_class_btn() {
		return self::add_prefix( '-btn' );
	}

	/**
	 * Default class for all buttons inside title
	 *
	 * @since 3.27
	 * @return string
	 */
	public static function get_class_btn_inside() {
		return self::add_prefix( '-btn-inside' );
	}

	/**
	 * Get widget attribute tag id by number
	 *
	 * @since 3.27
	 * @param int $number
	 * @return string
	 */
	public static function get_widget_attr_id( $number ) {
		return sprintf( '%s-share-widget-%d', WPUSB_App::SLUG, $number );
	}

	/**
	 * Get CSS option by key
	 *
	 * @since 3.27
	 * @param string $key
	 * @param array $options
	 * @return string
	 */
	public static function get_field_css_by_key( $key, $options = '' ) {
		$field = '';

		if ( isset( $options[ $key ] ) && ! empty( $options[ $key ] ) ) {
			$field = self::rm_tags( $options[ $key ] );
		}

		if ( empty( $options ) ) {
			$field = self::option( $key );
		}

		return $field;
	}

	/**
	 * Get CSS icon size option
	 *
	 * @since 3.27
	 * @param array $options
	 * @return string
	 */
	public static function get_css_icons_size( $options ) {
		$size = self::get_field_css_by_key( 'icons_size', $options );

		if ( ! empty( $size ) ) {
			$size = sprintf( 'width: %1$dpx; height: %1$dpx;', $size );
		}

		return $size;
	}

	/**
	 * Get CSS icon color option
	 *
	 * @since 3.27
	 * @param array $options
	 * @return string
	 */
	public static function get_css_icons_color( $options ) {
		$color = self::get_field_css_by_key( 'icons_color', $options );

		if ( ! empty( $color ) ) {
			$color = sprintf( 'fill: %s;', $color );
		}

		return $color;
	}

	/**
	 * Get CSS btn inside option
	 *
	 * @since 3.27
	 * @param array $options
	 * @return string
	 */
	public static function get_css_btn_inside( $options ) {
		return self::get_field_css_by_key( 'btn_inside_color', $options );
	}

	/**
	 * Get CSS text count color option
	 *
	 * @since 3.27
	 * @param array $options
	 * @return string
	 */
	public static function get_css_counts_color( $options ) {
		return self::get_field_css_by_key( 'counts_text_color', $options );
	}

	/**
	 * Get CSS background color share counts option
	 *
	 * @since 3.27
	 * @param array $options
	 * @return string
	 */
	public static function get_css_counts_bg_color( $options ) {
		return self::get_field_css_by_key( 'counts_bg_color', $options );
	}

	/**
	 * Get CSS background color buttons option
	 *
	 * @since 3.27
	 * @param array $options
	 * @return string
	 */
	public static function get_css_bg_color( $options ) {
		return self::get_field_css_by_key( 'button_bg_color', $options );
	}

	/**
	 * Get plugin post meta value
	 *
	 * @since 3.27
	 * @param int $post_id
	 * @return string
	 */
	public static function get_meta( $post_id ) {
		$value = get_post_meta( $post_id, WPUSB_Setting::META_KEY, true );
		return self::rm_tags( $value );
	}

	/**
	 * Check is plugin deactivate on current post
	 *
	 * @since 3.27
	 * @since 3.32
	 * @param int $ID
	 * @return boolean
	 */
	public static function is_disabled_by_meta( $ID = null ) {
		$ID    = $ID ? $ID : self::get_id();
		$type  = get_post_type( $ID );
		$types = self::option( 'post_types' );

		return ( $types && ! isset( $types[ $type ] ) || self::get_meta( $ID ) === 'yes' );
	}

	/**
	 * Check if plugin is disabled to showing in the current post.
	 *
	 * @since 3.50
	 * @param int $ID
	 * @return boolean
	 */
	public static function is_disabled( $ID = null ) {
		return self::is_disabled_by_meta( $ID ) || post_password_required( $ID ? $ID : self::get_id() );
	}

	/**
	 * Check is customize preview
	 *
	 * @since 3.27
	 * @return string
	 */
	public static function is_customize_preview() {
		return ( function_exists( 'is_customize_preview' ) && is_customize_preview() );
	}

	/**
	 * Get all public Bitly domains
	 *
	 * @since 3.27
	 * @return array
	 */
	public static function get_bitly_domains() {
		return array(
			'default' => __( 'Default', 'wpupper-share-buttons' ),
			'com'     => 'bitly.com',
			'ly'      => 'bit.ly',
			'mp'      => 'j.mp',
		);
	}

	/**
	 * Get Bitly domain by key
	 *
	 * @since 3.27
	 * @param string $key
	 * @return mixed String|boolean
	 */
	public static function get_bitly_domain( $key ) {
		$domains = self::get_bitly_domains();

		if ( $key === 'default' ) {
			return $domains['ly'];
		}

		unset( $domains['default'] );

		return self::get_value_by( $domains, $key, false );
	}

	/**
	 * Get the class for min count display
	 *
	 * @since 3.29
	 * @return string
	 */
	public static function get_hide_count_class() {
		$min_count = self::option( 'min_count_display', '', 'absint' );

		return empty( $min_count ) ? '' : self::add_prefix( '-hide' );
	}

	/**
	 * Get the social network order
	 *
	 * @since 3.30
	 * @param boolean $check
	 * @return array|boolean
	 */
	public static function get_networks_order( $check = false ) {
		$order    = self::json_decode( self::option( 'order' ) );
		$elements = WPUSB_Social_Elements::$items_available;

		if ( ! is_array( $order ) || empty( $order ) ) {
			return $check ? false : $elements;
		}

		$new_order = array();

		foreach ( $order as $item ) {
			if ( isset( $elements[ $item ] ) ) {
				$new_order[ $item ] = $item;
			}
		}

		return array_merge( $new_order, $elements );
	}

	/**
	 * Get the column post_date
	 *
	 * @since 3.30
	 * @param int $post_id
	 * @param string $sanitize
	 * @return string
	 */
	public static function get_post_date( $post_id, $format = 'Y-m-d' ) {
		if ( ! $post = get_post( $post_id ) ) {
			return esc_sql( date_i18n( $format ) );
		}

		return esc_sql( date_i18n( $format, strtotime( $post->post_date ) ) );
	}

	/**
	 * Template file located
	 *
	 * @since 3.32
	 * @param string $file
	 * @param string $path
	 * @param string $class_name
	 * @return string
	 */
	public static function get_template_located( $file, $path, $class_name ) {
		$path               = '/' . self::add_prefix( $path );
		$template_primary   = get_stylesheet_directory() . $path;
		$template_secondary = get_template_directory() . $path;

		if ( file_exists( $template_primary ) ) {
			return $template_primary;
		} elseif ( file_exists( $template_secondary ) ) {
			return $template_secondary;
		}

		$template = apply_filters( self::add_prefix( '_template_include' ), $file, $class_name );

		return file_exists( $template ) ? $template : $file;
	}

	/**
	 * Check fixed layout option
	 *
	 * @since 3.0
	 * @return boolean
	 */
	public static function is_position_fixed() {
		return ( 'on' === self::option( 'fixed' ) );
	}

	/**
	 * Convert date for sql
	 *
	 * @since 3.32
	 * @param string $date
	 * @param string $format
	 * @return mixed String|boolean
	 */
	public static function convert_date_for_sql( $date, $format = 'Y-m-d H:i' ) {
		return empty( $date ) ? false : esc_sql( self::convert_date( $date, $format, '/', '-' ) );
	}

	/**
	 * Convert date format
	 *
	 * @since 3.32
	 * @param string $date
	 * @param string $format
	 * @param string $search
	 * @param string $replace
	 * @return string
	 */
	public static function convert_date( $date, $format = 'Y-m-d H:i', $search = '/', $replace = '-' ) {
		if ( $search && $replace ) {
			$date = str_replace( $search, $replace, $date );
		}

		return date_i18n( $format, strtotime( $date ) );
	}

	/**
	 * Get post types publics
	 *
	 * @since 3.27
	 * @param array $args
	 * @param string $output
	 * @return array
	 */
	public static function get_post_types( $args = array(), $output = 'names' ) {
		$defaults = array(
			'public'  => true,
			'show_ui' => true,
		);
		$args = array_merge( $defaults, $args );
		$args = apply_filters( self::add_prefix( '_post_types_args' ), $args );

		return get_post_types( $args, $output );
	}

	/**
	 * Parse post types option
	 *
	 * @since 3.32
	 * @param array $settings
	 * @return array
	 */
	public static function parse_post_types( $settings ) {
		$key = 'post_types';

		if ( ! isset( $settings[ $key ] ) || ! is_array( $settings[ $key ] ) ) {
			return $settings;
		}

		$post_types = array();

		foreach ( $settings[ $key ] as $type ) :
			$post_types[ $type ] = $type;
		endforeach;

		$settings[ $key ] = $post_types;

		return $settings;
	}

	/**
	 * Check is home dashboard
	 *
	 * @since 3.32
	 * @return boolean
	 */
	public static function is_panel_home() {
		return ( WPUSB_App::SLUG === self::get( 'page' ) );
	}

	/**
	 * Check is sharing report page
	 *
	 * @since 3.32
	 * @return boolean
	 */
	public static function is_sharing_report_page() {
		return ( WPUSB_Setting::SHARING_REPORT === self::get( 'page' ) );
	}

	/**
	 * Check is custom css page
	 *
	 * @since 3.32
	 * @return boolean
	 */
	public static function is_custom_css_page() {
		return ( WPUSB_Setting::CUSTOM_CSS === self::get( 'page' ) );
	}

	/**
	 * Get charset option
	 *
	 * @since 3.32
	 * @return string
	 */
	public static function get_charset() {
		return self::rm_tags( get_bloginfo( 'charset' ) );
	}

	/**
	 *
	 * Check the current page is blog page
	 *
	 * @since 3.34
	 * @return boolean
	 */
	public static function is_blog_page() {
		if ( is_front_page() && is_home() || is_front_page() ) {
			return false;
		}

		return is_home();
	}

	/**
	 *
	 * Get capability permission pages
	 *
	 * @since 3.34
	 * @return string
	 */
	public static function get_capability() {
		return apply_filters( WPUSB_App::SLUG . '_page_capability', 'manage_options' );
	}
}

<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Utils Helper
 * @version 2.3.0
 */

if ( ! function_exists( 'add_action' ) )
	exit(0);

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
		if ( empty( $class ) )
			return '';

		if ( is_array( $class ) )
			return array_map( array( 'WPUSB_Utils', 'esc_class' ), $class );

        $class = str_replace( '_', '-', $class );
        $class = preg_replace( '/[^a-zA-Z0-9\s-]|[\s-]+/', '', $class );

        return strtolower( $class );
	}

	/**
	 * Sanitize value from methods post
	 *
	 * @since 1.0
	 * @param String $key Relative as request method
	 * @param Mixed Int/String/Array $default return this function
	 * @param String $sanitize Relative function
	 * @return String
	*/
	public static function post( $key, $default = '', $sanitize = 'rip_tags' )
	{
		$post = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

		if ( ! isset( $post[$key] ) || empty( $post[$key] ) )
			return $default;

		if ( is_array( $post[$key] ) )
			return self::rip_tags( $post[$key] );

		return self::sanitize( $post[$key], $sanitize );
	}

	/**
	 * Sanitize value from methods get
	 *
	 * @since 1.0
	 * @param String $key Relative as request method
	 * @param Mixed Int/String/Array $default return this function
	 * @param String $sanitize Relative function
	 * @return String
	*/
	public static function get( $key, $default = '', $sanitize = 'rip_tags' )
	{
		$get = filter_input_array( INPUT_GET, FILTER_SANITIZE_STRING );

		if ( ! isset( $get[$key] ) || empty( $get[$key] ) )
			return $default;

		if ( is_array( $get[$key] ) )
			return self::rip_tags( $get[$key] );

		return self::sanitize( $get[$key], $sanitize );
	}

	/**
	 * Sanitize requests
	 *
	 * @since 1.0
	 * @param String $value Relative sanitize
	 * @param String $function_name Relative function to use
	 * @return String
	*/
	public static function sanitize( $value, $function )
	{
		if ( ! is_callable( $function ) )
			return self::rip_tags( $value );

		return call_user_func( $function, $value );
	}

	/**
	 * Properly strip all HTML tags including script and style
	 *
	 * @param string $string | String containing HTML tags
	 * @return string The processed string.
	 */
	public static function rip_tags( $string )
	{
		if ( is_array( $string ) )
			return array_map( array( __CLASS__, 'rip_tags' ), $string );

	    return wp_strip_all_tags( $string, true );
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
		if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) )
			$request_ajax = $_SERVER['HTTP_X_REQUESTED_WITH'];

		return ( ! empty( $request_ajax ) && strtolower( $request_ajax ) == 'xmlhttprequest' );
	}

	/**
	 * Post title
	 *
	 * @since 1.0
	 * @param null
	 * @return String title posts
	 */
	public static function get_title()
	{
		global $post;

		$post_title = '';

		if ( isset( $post->ID ) )
			$post_title = get_the_title( $post->ID );

		return self::html_decode( $post_title );
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

		if ( isset( $post->ID ) )
			return intval( $post->ID );

		return 0;
	}

	/**
	 * Permalinks posts
	 *
	 * @since 1.0
	 * @param null
	 * @return String
	 */
	public static function get_permalink()
	{
		global $post;

		$permalink = '';

		if ( isset( $post->ID ) )
			$permalink = esc_url( get_permalink( $post->ID ) );

		if ( is_home() || is_front_page() )
			$permalink = esc_url( get_site_url( null, '/' ) );

		return $permalink;
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

		$thumbnail = '';

		if ( isset( $post->ID ) && has_post_thumbnail() )
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );

		if ( ! $thumbnail )
			return apply_filters( WPUSB_App::SLUG . 'thumbnail-url', '' );

		return apply_filters( WPUSB_App::SLUG . 'thumbnail-url', $thumbnail[0] );
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

		if ( isset( $post->post_content ) )
			$content = $post->post_content;

		$content = self::rip_tags( $content );
		$content = preg_replace( '/\[.*\]/', null, $content );

		return apply_filters( WPUSB_App::SLUG . 'body-email', $content );
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
		return plugin_basename( plugin_dir_path( __DIR__ ) . basename( WPUSB_App::FILE ) );
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
		$model   = new WPUSB_Setting();
		$options = $model->get_options();

		if ( ! isset( $options[$name] ) || empty( $options[$name] ) )
			return $default;

		$option = self::sanitize( $options[$name], $sanitize );

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
	public static function error_server_json( $code, $message = 'Message Error', $echo = true )
	{
		$response = json_encode(
			array(
				'status' 	=> 'error',
				'code'   	=> $code,
				'message'	=> $message,
			)
		);

		if ( $echo ) :
			echo $response;
			exit(0);
		endif;

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
	public static function ajax_verify_request( $request, $code = 500, $message = 'server_error' )
	{
		if ( ! $request ) :
			http_response_code( $code );
			self::error_server_json( $code, $message );
			exit(0);
		endif;
	}

	/**
	 * Convert array in objects
	 *
	 * @since 1.0
	 * @param Array $arguments
	 * @return Object
	 */
	public static function parse( $arguments )
	{
        foreach( $arguments as $key => $value )
        	$object[$key] = (object) $value;

		return (object) $object;
	}

	/**
	 * Verify option exists and update option
	 *
	 * @since 1.0
	 * @param String $option_name
	 * @return String
	 */
	public static function add_update_option( $option_name )
	{
		$option = get_site_option( $option_name );

		if ( $option )
			return update_option( $option_name, WPUSB_Setting::DB_VERSION );

		return add_option( $option_name, WPUSB_Setting::DB_VERSION );
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

		if ( ! $number )
			return $number;

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
	public static function isset_get( $args = array(), $index )
	{
		if ( isset( $args[$index] ) )
			return $args[$index];

		if ( isset( $args['elements'] ) )
			return $args['elements'][$index];

		return '';
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

		if ( version_compare( $wp_version, '4.4', '>=' ) )
			require_once( ABSPATH . 'wp-admin/includes/class-wp-screen.php' );
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
		if ( ! isset( $_GET[$key] ) )
			return false;

		if ( 'true' == $_GET[$key] )
			return true;
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

		if ( false !== $cache_url )
			return $cache_url;

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
		$api_url = 'https://api-ssl.bitly.com/v3/shorten/';
		$params  = "?access_token={$token}&longUrl={$url}";
		$args    =  array(
			'method'    => 'GET',
			'sslverify' => false,
			'headers'   => array(
		        'Content-Type' => 'application/json',
	    	),
	    );

	    $response = wp_remote_get( "{$api_url}{$params}", $args );

	    if ( is_wp_error( $response ) )
	    	return $url;

	    return static::_bitly_response( $response, $url );
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
		$transient  = WPUSB_App::SLUG . '-shorturl-cache-expire';
		$cache_time = apply_filters( $transient, ( WEEK_IN_SECONDS * 1 ) );

		if ( 200 !== $response->status_code )
			return $url;

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
		static::_add_options_settings();
		static::_add_options_social_media();
		static::_add_options_extra_settings();
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
			'single'    => 'on',
			'before'    => 'on',
			'after'     => 'off',
			'pages'     => 'off',
			'home'      => 'off',
			'class'     => '',
			'layout'    => 'default',
			'fixed_top' => '',
		);
		$value  = apply_filters( WPUSB_App::SLUG . '-options-settings', $value );

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
			'facebook'  => 'facebook',
			'twitter'   => 'twitter',
			'google'    => 'google',
			'whatsapp'  => 'whatsapp',
			'telegram'  => 'telegram',
			'skype'     => 'skype',
			'viber'     => 'viber',
			'pinterest' => 'pinterest',
			'linkedin'  => 'linkedin',
			'tumblr'    => 'tumblr',
			'email'     => 'email',
			'printer'   => 'printer',
			'like'      => 'like',
		);
		$value  = apply_filters( WPUSB_App::SLUG . '-options-social-media', $value );

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
			'twitter_username'  => '',
			'twitter_text'      => '',
			'bitly_token'       => '',
			'remove_count'      => 0,
			'remove_inside'     => 0,
			'tracking'          => '',
			'report_cache_time' => 10,
		);
		$value = apply_filters( WPUSB_App::SLUG . '-options-extra-settings', $value );

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
		$prefix       = WPUSB_Setting::PREFIX;
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

		return apply_filters( WPUSB_App::SLUG . '-twitter-text', $text, $title );
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

		if ( $page === $current )
			return ' class="active"';

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
		if ( is_single() && self::option( 'single' ) === 'on' )
			return true;

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
		if ( ( is_page() || is_page_template() ) && self::option( 'pages' ) === 'on' )
			return true;

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
		if ( ( is_home() || is_front_page() ) && self::option( 'home' ) === 'on' )
			return true;

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
		return ( self::is_single() || self::is_page() || self::is_home() );
	}
}
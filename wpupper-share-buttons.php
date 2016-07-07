<?php
/**
 * @package WPUpper Share Buttons
 */
/*
	Plugin Name: WPUpper Share Buttons
	Plugin URI:  https://github.com/victorfreitas
	Version:     3.1.3
	Author:      WPUpper
	Author URI:  https://github.com/victorfreitas
	License:     GPL2
	Text Domain: wpupper-share-buttons
	Domain Path: /languages
	Description: Insert share buttons of social networks. The buttons are inserted automatically or can be called via shortcode or php method.
*/
/*
	Copyright 2016 WPUpper Share Buttons by Victor Freitas (victorfreitas1@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
 */
if ( ! function_exists( 'add_action' ) )
	exit(0);

class WPUSB_App
{
    /**
     * The short slug
     *
     * @var String
     */
	const SLUG = 'wpusb';

    /**
     * Text domain real dir name
     *
     * @var String
     */
	const TEXTDOMAIN = 'wpupper-share-buttons';

    /**
     * Initial file path
     *
     * @var String
     */
	const FILE = __FILE__;

    /**
     * Version
     *
     * @var String
     */
	const VERSION = '3.1.3';

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 2.0
	 * @return Void
	 */
	public static function uses( $class, $location )
	{
		$extension = 'php';
		$sep       = DIRECTORY_SEPARATOR;
		$dirname   = dirname( __FILE__ );

		if ( in_array( $location, array( 'View', 'Controller', ) ) )
			$extension = strtolower( $location ) . ".{$extension}";

		require_once( "{$dirname}{$sep}{$location}{$sep}{$class}.{$extension}" );
	}

	/**
	 * Automatic list files in
	 * Helpers, Controllers and Templates.
	 *
	 * @since 3.0.0
	 * @return Array
	 */
	public static function get_files()
	{
		$root    = dirname( __FILE__ );
		$pattern = "{$root}{/Helper/,/Controller/,/Templates/}*.php";
		$files   = glob( $pattern, GLOB_BRACE );

		return ( is_null( $files ) ) ? array() : $files;
	}

	/**
	 * Automatic include files in
	 * Helpers, Controllers and Templates.
	 *
	 * @since 3.0.0
	 * @return Void
	 */
	public static function require_files()
	{
		$files = self::get_files();

		foreach( $files as $key => $file )
			require_once( $file );
	}
}

WPUSB_App::uses( 'core', 'Config' );
new WPUSB_Core();
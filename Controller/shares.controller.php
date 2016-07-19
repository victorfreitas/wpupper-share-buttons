<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Social Icons Display
 * @version 2.2.0
 */

if ( ! function_exists( 'add_action' ) )
	exit(0);

use WPUSB_Utils as Utils;
use WPUSB_App as App;

//View
App::uses( 'shares', 'View' );

class WPUSB_Shares_Controller
{
	private $_filter = 'wpusb-buttons';
	protected $position;

	/**
	* Initialize the plugin by setting localization, filters, and administration functions.
	*
	* @since 1.2
	*/
	public function __construct()
	{
		add_shortcode( App::SLUG, array( &$this, 'share' ) );
		add_filter( 'the_content', array( &$this, 'content' ), 20 );
		add_action( 'wp_footer', array( &$this, 'buttons_fixed' ), 20 );
	}

	/**
	 * The content check insertions
	 *
	 * @since 3.2.2
	 * @version 1.2.0
	 * @param Null
	 * @return Void
	 */
	protected function _set_position()
	{
		$before = Utils::option( 'before' );
		$after  = Utils::option( 'after' );

		if ( 'on' === $before && 'on' === $after ) {
			$this->position = 'full';
			return;
		}

		if ( 'on' === $before ) {
			$this->position = 'before';
			return;
		}

		if ( 'on' === $after ) {
			$this->position = 'after';
			return;
		}

		$this->position = false;
	}

	/**
	 * The content after it is finished processing
	 * single | page | home | archive | category
	 *
	 * @since 3.2.2
	 * @version 2.0.0
	 * @param String $content
	 * @return String
	 */
	public function content( $content )
	{
		$this->_set_position();

		if ( $this->position && Utils::is_active() )
	    	return $this->_get_new_content( $content );

		return $content;
	}

	private function _get_new_content( $content )
	{
		$buttons = apply_filters( $this->_filter, $this->buttons_share() );

		switch ( $this->position ) :
			case 'full' :
	      		$new_content  = $buttons;
	      		$new_content .= $content;
	      		$new_content .= $buttons;
				break;

			case 'before' :
				$new_content  = $buttons;
				$new_content .= $content;
				break;

			case 'after' :
				$new_content  = $content;
				$new_content .= $buttons;
				break;
		endswitch;

		return $new_content;
	}

	/**
	 * Add buttons on footer case selected layout fixed
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	public function buttons_fixed()
	{
		$is_position_fixed = Utils::is_position_fixed();
		$this->_add_modal( $is_position_fixed );

		if ( ! $is_position_fixed )
			return;

		if ( Utils::is_active() ) {
			$buttons = $this->buttons_share( array(), true );

			echo apply_filters( "{$this->_filter}-fixed", $buttons );
		}
	}

	/**
	 * Generate all icons sharing
	 *
	 * @since 1.0
	 * @param Array $atts
	 * @return HTML
	 *
	 */
	public function share( $atts = array() )
	{
		$atts =	shortcode_atts(
			array(
				'class_first'    => '',
				'class_second'   => '',
				'class_link'     => '',
				'class_icon'     => '',
				'layout'         => '',
				'remove_inside'  => false,
				'remove_counter' => false,
			),
			$atts,
			App::SLUG
		);

		$args = Utils::sanitize_atts( $atts );

		return Utils::get_buttons( $args );
	}

	/**
	 * Create custom class from icons
	 *
	 * @since 1.0
	 * @param Array $atts
	 * @param Boolean $fixed
	 * @return String
	 */
	public function buttons_share( $atts = array(), $fixed = false )
	{
		return Utils::buttons_share( $atts, $fixed );
	}

	/**
	 * Adding in footer html modal social networks
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	protected function _add_modal( $is_fixed )
	{
		if ( ! ( $is_fixed || $this->position ) )
			return;

		if ( Utils::is_active() )
			WPUSB_All_Items::init();
	}
}
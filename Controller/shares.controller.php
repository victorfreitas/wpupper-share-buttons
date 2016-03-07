<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  WPUpper
 * @subpackage Social Icons Display
 * @version 2.0.0
 */

if ( ! function_exists( 'add_action' ) )
	exit(0);

//View
WPUSB_App::uses( 'shares', 'View' );

class WPUSB_Shares_Controller
{
	private $_fixed = false;
	private $_filter = 'wpu-buttons';

	/**
	* Initialize the plugin by setting localization, filters, and administration functions.
	*
	* @since 1.2
	*/
	public function __construct()
	{
		add_shortcode( 'wpusb', array( 'WPUSB_Shares_View', 'share' ) );
		add_filter( 'the_content', array( &$this, 'content' ), 20 );
		add_action( 'wp_footer', array( &$this, 'footer' ), 20 );
	}

	/**
	 * The content check insertions
	 *
	 * @since 1.0
	 * @param Null
	 * @return string
	 */
	protected function _check_position()
	{
		$position = '';
		$before   = WPUSB_Utils::option( 'before' );
		$after    = WPUSB_Utils::option( 'after' );
		$fixed    = WPUSB_Utils::option('fixed');

		if ( 'on' === $before &&  'on' === $after )
			$position = 'full';

		if ( 'on' === $before && 'on' !== $after )
			$position = 'before';

		if ( 'on' !== $before && 'on' === $after )
			$position = 'after';

		if ( 'on' === $fixed )
			$position = 'fixed';

		return $position;
	}

	/**
	 * The content after it is finished processing
	 *
	 * @since 1.0
	 * @param String $content
	 * @return String content single, pages, home
	 */
	public function content( $content )
	{
		if ( $this->_is_single() || $this->_is_page() || $this->_is_home() ) :
			$buttons = apply_filters( $this->_filter, WPUSB_Shares_View::buttons_share() );

			switch ( $this->_check_position() ) :
				case 'full' :
		      		$new_content  = $buttons;
		      		$new_content .= $content;
		      		$new_content .= $buttons;
		      		$content      = $new_content;
					break;

				case 'before' :
					$new_content  = $buttons;
					$new_content .= $content;
					$content      = $new_content;
					break;

				case 'after' :
					$new_content  = $content;
					$new_content .= $buttons;
					$content      = $new_content;
					break;

				case 'fixed' :
					$this->_fixed = true;
					break;
			endswitch;

	    	return $content;
		endif;

		return $content;
	}

	/**
	 * Make sure is activated the Share Buttons in singles
	 *
	 * @since 1.0
	 * @param Null
	 * @return Boolean
	 */
	protected function _is_single()
	{
		if ( is_single() && WPUSB_Utils::option( 'single' ) === 'on' )
			return true;

		return false;
	}

	/**
	 * Make sure is activated the Share Buttons in pages
	 *
	 * @since 1.0
	 * @param Null
	 * @return Boolean
	 */
	protected function _is_page()
	{
		if ( ( is_page() || is_page_template() )  && WPUSB_Utils::option( 'pages' ) === 'on' )
			return true;

		return false;
	}

	/**
	 * make sure is activated the Share Buttons in home
	 *
	 * @since 1.0
	 * @param Null
	 * @return Boolean
	 */
	protected function _is_home()
	{
		if ( ( is_home() || is_front_page() ) && WPUSB_Utils::option( 'home' ) === 'on' )
			return true;

		return false;
	}

	/**
	 * Add buttons on footer case selected layout fixed
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	public function footer()
	{
		if ( ! $this->_fixed )
			return;

		if ( $this->_is_single() || $this->_is_page() || $this->_is_home() )
			echo apply_filters( "{$this->_filter}-fixed", WPUSB_Shares_View::buttons_share() );
	}
}

<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Social Icons Display
 * @version 2.2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit(0);
}

//View
WPUSB_App::uses( 'shares', 'View' );

class WPUSB_Shares_Controller {

	private $_filter = 'wpusb-buttons';

	protected $position = false;

	/**
	* Initialize the plugin by setting localization, filters, and administration functions.
	*
	* @since 1.2
	*/
	public function __construct() {
		add_shortcode( WPUSB_App::SLUG, array( $this, 'share' ) );
		add_filter( 'the_content', array( $this, 'content' ) );
		add_action( 'woocommerce_share', array( $this, 'wc_render_share' ) );
		add_action( 'wp_footer', array( $this, 'buttons_fixed' ) );
	}

	/**
	 * Add share buttons on WooCommerce product page
	 *
	 * @since 3.16
	 * @version 0.0.1
	 * @param Null
	 * @return Void
	 */
	public function wc_render_share() {
		if ( WPUSB_Utils::option( 'woocommerce' ) !== 'on' ) {
			return;
		}

		$args = apply_filters( WPUSB_App::SLUG . '_wc_share_args', array() );

		echo apply_filters( $this->_filter, $this->buttons_share( $args ), 'woocommerce_share' );
	}

	/**
	 * The content check insertions
	 *
	 * @since 3.2.2
	 * @version 1.2.0
	 * @param Null
	 * @return Void
	 */
	protected function _set_position() {
		$before = WPUSB_Utils::option( 'before' );
		$after  = WPUSB_Utils::option( 'after' );

		if ( 'on' === $before && 'on' === $after ) {
			$this->position = 'both';
		} elseif ( 'on' === $before ) {
			$this->position = 'before';
		} elseif ( 'on' === $after ) {
			$this->position = 'after';
		}
	}

	/**
	 * The content after it is finished processing
	 * single | page | home | archive | category
	 *
	 * @since 3.2.2
	 * @version 2.0
	 * @param String $content
	 * @return String
	 */
	public function content( $content ) {
		if ( is_feed() || WPUSB_Utils::is_product() ) {
			return $content;
		}

		$this->_set_position();

		if ( $this->position && WPUSB_Utils::is_active() ) {
	    	return $this->_get_new_content( $content );
		}

		return $content;
	}

	/**
	 * Render content share
	 * single | page | home | archive | category
	 *
	 * @since 3.2.2
	 * @version 2.0.0
	 * @param String $content
	 * @return String
	 */
	private function _get_new_content( $content ) {
		$buttons = apply_filters( $this->_filter, $this->buttons_share() );

		switch ( $this->position ) {
			case 'both' :
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
		}

		return $new_content;
	}

	/**
	 * Add buttons on footer case selected layout fixed
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	public function buttons_fixed() {
		if ( ! WPUSB_Utils::is_position_fixed() ) {
			return;
		}

		if ( WPUSB_Utils::is_active() ) {
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
	public function share( $atts = array() ) {
		$atts =	shortcode_atts(
			array(
				'class_first'    => '',
				'class_second'   => '',
				'class_link'     => '',
				'class_icon'     => '',
				'layout'         => '',
				'remove_inside'  => false,
				'remove_counter' => false,
				'items'          => '',
				'url'            => '',
				'title'          => '',
				'header_title'   => '',
			),
			$atts,
			WPUSB_App::SLUG
		);

		$args = WPUSB_Utils::sanitize_atts( $atts );

		return WPUSB_Utils::get_buttons( $args );
	}

	/**
	 * Create custom class from icons
	 *
	 * @since 1.0
	 * @param Array $atts
	 * @param Boolean $fixed
	 * @return String
	 */
	public function buttons_share( $atts = array(), $fixed = false ) {
		return WPUSB_Utils::buttons_share( $atts, $fixed );
	}
}
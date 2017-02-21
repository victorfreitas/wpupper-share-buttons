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
		add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta' ) );
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
		if ( ! $this->is_wc_active() || $this->is_disabled() ) {
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
	 *
	 * @since 3.2.2
	 * @version 2.0
	 * @param String $content
	 * @return String
	 */
	public function content( $content ) {
		if ( $this->is_disabled() || is_feed() || WPUSB_Utils::is_product() ) {
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

	public function is_wc_active() {
		return ( WPUSB_Utils::option( 'woocommerce' ) === 'on' );
	}

	public function is_disabled() {
		return WPUSB_Utils::is_disabled_by_meta();
	}

	public function get_post_types() {
		return get_post_types( array(
			'public'  => true,
			'show_ui' => true,
		) );
	}

	public function register_meta_boxes() {
		global $wp_version;

		$post_types = $this->get_post_types();

		if ( version_compare( $wp_version, '4.4.0', '>=' ) ) {
			return $this->add_meta_box( $post_types );
		}

		foreach ( $post_types as $post_type ) :
			$this->add_meta_box( $post_type );
		endforeach;
	}

	public function add_meta_box( $screen ) {
		add_meta_box(
			WPUSB_App::TEXTDOMAIN,
			WPUSB_App::NAME,
			array( $this, 'render_meta_box' ),
			$screen,
			'side',
			'low'
		);
	}

	public function render_meta_box( $post ) {
		WPUSB_Shares_View::render_meta_box( $post );
	}

	public function save_meta( $post_id ) {
		if ( wp_is_post_revision( $post_id ) || defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		$meta_key = WPUSB_Setting::META_KEY;
		$value    = WPUSB_Utils::post( $meta_key );

		if ( empty( $value ) ) {
			return delete_post_meta( $post_id, $meta_key );
		}

		update_post_meta( $post_id, $meta_key, $value );
	}
}
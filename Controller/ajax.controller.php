<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage Ajax Controller
 * @version 3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
}

class WPUSB_Ajax_Controller {

	private $capability;

	public function __construct() {
		$prefix           = WPUSB_App::SLUG;
		$this->capability = apply_filters( WPUSB_Utils::add_prefix( '_page_capability' ), 'manage_options' );

		add_action( "wp_ajax_{$prefix}_share_preview", array( $this, 'share_preview_request' ) );
		add_action( "wp_ajax_{$prefix}_save_custom_css", array( $this, 'save_custom_css_request' ) );
	}

	public function share_preview_request() {
		if ( ! WPUSB_Utils::is_request_ajax() || ! current_user_can( $this->capability ) ) {
			exit( 0 );
		}

		$layout   = WPUSB_Utils::post( 'layout', false );
		$checkeds = WPUSB_Utils::post( 'checked', false );

		if ( ! ( $layout || $checkeds ) ) {
			wp_send_json_error();
		}

		$this->_share_preview( $layout, $checkeds );
	}

	private function _share_preview( $layout, $checkeds ) {
		$checkeds = $this->_json_decode_quoted( $checkeds );

		if ( ! is_array( $checkeds ) ) {
			wp_send_json_error();
		}

		$this->_share_preview_list( $layout, $checkeds );
	}

	private function _share_preview_list( $layout, $checkeds ) {
		global $wp_version;

		$list         = array();
		$count        = 0;
		$fixed_layout = WPUSB_Utils::post( 'fixed_layout', 'buttons' );
		$networks     = WPUSB_Social_Elements::social_media();
		$total        = ( count( $checkeds ) - 1 );
		$title        = WPUSB_Utils::option( 'title' );
		$label        = WPUSB_Utils::get_share_count_label();

		foreach ( $checkeds as $element ) {
			if ( ! isset( $networks->{$element} ) ) {
				continue;
			}

			$item   = $networks->{$element};
			$list[] = array(
				'prefix'          => WPUSB_App::SLUG,
				'counter'         => str_replace( '.', '', $wp_version ),
				'itemClass'       => $item->element,
				'itemName'        => $item->name,
				'inside'          => true,
				'first'           => ( 0 === $count ),
				'last'            => ( $count === $total ),
				'layout'          => $layout,
				'itemTitle'       => $item->title,
				'hasCounter'      => $item->has_counter,
				'itemInside'      => ( $item->inside ) ? $item->inside : '',
				'fixedLayout'     => ( $fixed_layout === 'square2' ) ? 'default' : $fixed_layout,
				'btnClass'        => ( $fixed_layout === 'buttons' ) ? 'button' : 'default',
				'isFixed2'        => ( $fixed_layout !== 'buttons' ),
				'square2Class'    => ( $fixed_layout === 'square2' ) ? WPUSB_Utils::add_prefix( '-buttons' ) : '',
				'currentLayout'   => $fixed_layout,
				'shareCountLabel' => $label,
				'title'           => $title,
			);
			$count++;
		}

		wp_send_json( $list );
	}

	public function save_custom_css_request() {
		if ( ! WPUSB_Utils::is_request_ajax() || ! current_user_can( $this->capability ) ) {
			exit( 0 );
		}

		if ( ! isset( $_POST['custom_css'] ) ) {
			wp_send_json_error( '' );
		}

		$this->_save_custom_css();
	}

	private function _save_custom_css() {
		$custom_css = WPUSB_Utils::post( 'custom_css' );

		$this->_change_custom_css_option( $custom_css );

		$css = WPUSB_Utils::get_all_custom_css( $custom_css );

		if ( WPUSB_Utils::build_css( $css ) ) {
			wp_send_json_success( '' );
		}

		wp_send_json_error( __( 'Error: Could not process css file.', 'wpupper-share-buttons' ) );
	}

	private function _change_custom_css_option( $custom_css ) {
		$option = WPUSB_Utils::get_options_name( 5 );

		if ( empty( $custom_css ) ) {
			return WPUSB_Utils::delete_option( $option );
		}

		WPUSB_Utils::update_option( $option, $custom_css );
	}

	private function _json_decode_quoted( $txt ) {
		$text = htmlspecialchars_decode( $txt );
		$text = WPUSB_Utils::rm_tags( $text, true );

		return WPUSB_Utils::json_decode( $text, true );
	}
}

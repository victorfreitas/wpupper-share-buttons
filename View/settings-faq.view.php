<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage View Admin Page
 * @version 1.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	 // Exit if accessed directly.
	exit( 0 );
}

class WPUSB_Settings_Faq_View {

	/**
	 * Display page setting
	 *
	 * @since 1.3
	 * @param Null
	 * @return Void Display page
	 */
	public static function render_page_faq() {
	?>
		<div class="wrap">
			<h2>
				<?php _e( 'WPUpper Share Buttons', 'wpupper-share-buttons' ); ?>
			</h2>

			<p class="description">
				<?php _e( 'Add the Share Buttons automatically.', 'wpupper-share-buttons' ); ?>
			</p>

			<?php WPUSB_Utils_View::page_notice(); ?>

			<span class="<?php echo WPUSB_Utils::add_prefix( '-title-wrap' ); ?>">
				<?php _e( 'Use options', 'wpupper-share-buttons' ); ?>
			</span>

			<?php WPUSB_Utils_View::menu_top(); ?>

			<div class="<?php echo WPUSB_Utils::add_prefix( '-wrap-faq' ); ?>">
<pre data-element="highlight">
	<code class="php">
/*
 * Via method PHP
 *
 * Items Available:
<?php
foreach ( WPUSB_Social_Elements::$items_available as $item ) :
	echo " * {$item}\n";
endforeach;
?>
 *
 * Layout options: default, buttons, rounded, square, square-plus
 *
 * Default Arguments
 */
$args = array(
	 'class_first'  => '', // String
	 'class_second' => '', // String
	 'class_link'   => '', // String
	 'class_icon'   => '', // String
	 'layout'       => 'default', //String
	 'items'        => '', // Mixed String|Array -- Example: 'facebook, google' | array( 'facebook', 'google' )
	 'title'        => '', //String
	 'header_title' => '', //String
	 'url'          => '', //string
	 'elements'     => array( // Array
		 'remove_inside'  =>  false, // Boolean
		 'remove_counter' =>  false, // Boolean
	),
);

/*
 * Example usage
 */
$args = array(
	'layout' => 'square-plus',
	'items'  => array( 'facebook', 'twitter', 'google', 'whatsapp' ),
);

if ( class_exists( 'WPUSB_Shares_View' ) ) :
	// $args is optional
	echo WPUSB_Shares_View::buttons_share( $args );
endif;

/*
 * Via shortcode in content
 *
 * Open mode text in content and add shortcode
 *
 * Use the parameters described above in ( Via method PHP )
 * Example: [wpusb layout="rounded" items="facebook, twitter"]
 */
[wpusb]

/*
 * Via PHP Using function WordPress]
 *
 * Use the parameters described above in ( Via method PHP )
 * Example: [wpusb layout="rounded" items="facebook, twitter"]
 */
echo do_shortcode( '[wpusb]' );
	</code>
</pre>

<hr>

<h2>
	<?php _e( 'Available filters', 'wpupper-share-buttons' ); ?>
</h2>

<hr>

<pre data-element="highlight">
	<code class="php">
/*
 * Parameter that the function receives
 *
 * String|Boolean $ga_js|false
 * Object $social_network
 */
add_filter( 'wpusb-ga-event', 'your_function_name', 10, 2 );

/*
 * Parameter that the function receives
 *
 * Boolean $is_active
 */
add_filter( 'wpusb-add-scripts', 'your_function_name' );

/*
 * Parameter that the function receives
 *
 * String $prefix_icons
 */
add_filter( 'wpusb_prefix_class_icons', 'your_function_name' );

/*
 * Parameter that the function receives
 *
 * String $class_icon
 */
add_filter( 'wpusb_class_icon', 'your_function_name' );

/*
 * Parameter that the function receives
 *
 * Object $social_networks
 * String $title
 * String $url
 * Array $args
 */
add_filter( 'wpusb-elements-share', 'your_function_name', 10, 4 );

/*
 * Parameter that the function receives
 * Change SOCIAL_NAME by the name of the item available, all described at the top of this page in the (Items Available).
 *
 * Object $social_networks
 */
add_filter( 'wpusb-SOCIAL_NAME-items', 'your_function_name' );

/*
 * Parameter that the function receives
 *
 * Array $arguments
 */
add_filter( 'wpusb-arguments', 'your_function_name' );

/*
 * Parameter that the function receives
 *
 * String $url
 */
add_filter( 'wpusb-url-share', 'your_function_name' );

/*
 * Parameter that the function receives
 *
 * Object $elements_sortable
 */
add_filter( 'wpusb-elements-share-sortable', 'your_function_name' );

/*
 * Parameter that the function receives
 *
 * String $tracking
 * Integer $post_id
 */
add_filter( 'wpusb-tracking', 'your_function_name', 10, 2 );

/*
 * Parameter that the function receives
 *
 * String $thumbnail
 * Integer $post_id
 */
add_filter( 'wpusb-thumbnail', 'your_function_name', 10, 2 );

/*
 * Parameter that the function receives
 *
 * String $body_mail
 * Integer $post_id
 */
add_filter( 'wpusb-body-mail', 'your_function_name', 10, 2 );

/*
 * Parameter that the function receives
 *
 * String $caracter
 */
add_filter( 'wpusb-caracter', 'your_function_name' );

/*
 * Parameter that the function receives
 *
 * String $text
 */
add_filter( 'wpusb-viber-text', 'your_function_name' );

/*
 * Parameter that the function receives
 *
 * String $text
 */
add_filter( 'wpusb-whatsapp-text', 'your_function_name' );

/*
 * Parameter that the function receives
 *
 * Boolean $active
 */
add_filter( 'wpusb-modal-html-active', 'your_function_name' );

/*
 * Parameter that the function receives
 *
 * Boolean $show_modal
 */
add_filter( 'wpusb-show-modal', 'your_function_name' );

/*
 * Parameter that the function receives
 *
 * Boolean $class_icon
 */
add_filter( 'wpusb_item_class_icon', 'your_function_name' );

/*
 * Parameter that the function receives
 *
 * String|Boolean $url|false
 * Boolean $is_fixed
 */
add_filter( 'wpusb-real-permalink', 'your_function_name', 10, 2 );

/*
 * Parameter that the function receives
 *
 * String|Boolean $title|false
 * Boolean $is_fixed
 */
add_filter( 'wpusb-real-title', 'your_function_name', 10, 2 );

/*
 * Parameter that the function receives
 *
 * String $component
 * String $prefix
 */
add_filter( 'wpusb-component-name', 'your_function_name', 10, 2 );

/*
 * Parameter that the function receives
 *
 * String $permalink
 */
add_filter( 'wpusb-modal-permalink', 'your_function_name' );

/*
 * Parameter that the function receives
 *
 * String $title
 */
add_filter( 'wpusb-modal-title', 'your_function_name' );
	</code>
</pre>
			</div>
		</div>
	<?php
	}
}

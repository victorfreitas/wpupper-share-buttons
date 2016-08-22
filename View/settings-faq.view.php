<?php
/**
 *
 * @package WPUpper Share Buttons
 * @author  Victor Freitas
 * @subpackage View Admin Page
 * @version 1.4.0
 */
if ( ! function_exists( 'add_action' ) ) {
	exit(0);
}

use WPUSB_Social_Elements as Elements;

class WPUSB_Settings_Faq_View
{
	/**
	 * Display page setting
	 *
	 * @since 1.3
	 * @param Null
	 * @return Void Display page
	 */
	public static function render_page_faq()
	{
		$prefix           = WPUSB_Setting::PREFIX;
		$use_options_file = dirname( __FILE__ ) . '/use-options.php';
	?>
		<div class="wrap">
			<h2><?php _e( 'WPUpper Share Buttons', WPUSB_App::TEXTDOMAIN ); ?></h2>
			<p class="description"><?php _e( 'Add the Share Buttons automatically.', WPUSB_App::TEXTDOMAIN ); ?></p>
			<span class="<?php echo "{$prefix}-title-wrap"; ?>">
				<?php _e( 'Use options', WPUSB_App::TEXTDOMAIN ); ?>
			</span>

			<?php WPUSB_Settings_View::menu_top(); ?>

			<div class="<?php echo "{$prefix}-wrap-faq"; ?>">
<pre data-element="highlight">
	<code class="php">
/*
 * Via method PHP
 *
 * Items Available:
<?php
foreach ( Elements::$items_available as $item ) :
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
			</div>
		</div>
	<?php
	}
}
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
	exit(0);
}

class WPUSB_Settings_Extra_View extends WPUSB_Utils_View {

	/**
	 * Display page setting
	 *
	 * @since 1.2
	 * @param Null
	 * @return Void, Display page
	 */
	public static function render_settings_extra() {
		$prefix        = WPUSB_App::SLUG;
		$extra_setting = sprintf( '%s_extra_settings', $prefix );
		$domain        = WPUSB_App::TEXTDOMAIN;

		parent::set_options();
		parent::set_prefix( $extra_setting );
	?>
		<div class="wrap" <?php echo WPUSB_Utils::get_component( 'extra-settings' ); ?>>
			<h2><?php _e( 'WPUpper Share Buttons', $domain ); ?></h2>

			<?php
				if ( WPUSB_Utils::get_update( 'settings-updated' ) ) {
					parent::update_notice();
				}
			?>

			<p class="description">
				<?php _e( 'Add the Share Buttons automatically.', $domain ); ?>
			</p>

			<?php parent::page_notice(); ?>

			<span class="<?php echo "{$prefix}-title-wrap"; ?>">
				<?php _e( 'Extra Settings', $domain ); ?>
			</span>

			<?php parent::menu_top(); ?>

			<div class="<?php echo "{$prefix}-wrap extra-settings-wrap"; ?>">
				<form action="options.php"
					  method="post"
					  data-action="form"
					  data-element="form">

					<table class="form-table table-extras" data-table="extras">
						<tbody>
						<?php
							parent::tr( array(
								'key'         => 'twitter-username',
								'label'       => __( 'Twitter username', $domain ),
								'text'        => __( 'Your twitter username', $domain ),
								'placeholder' => __( 'Twitter username', $domain ),
							) );

							parent::tr( array(
								'key'          => 'twitter-hashtags',
								'label'        => __( 'Twitter hashtags', $domain ),
								'placeholder'  => __( 'Twitter hashtags', $domain ),
								'text'         => __( 'Optional Hashtags appended onto the tweet (comma separated. don\'t include "#")', $domain ),
								'block_text'   => 'social, share, like',
								'block_strong' => __( 'Example: ', $domain ),
							) );

							parent::tr( array(
								'key'          => 'twitter-text',
								'label'        => __( 'Twitter text', $domain ),
								'placeholder'  => __( 'Twitter text', $domain ),
								'text'         => __( 'Use {title} to add the post title', $domain ),
								'block_text'   => __( 'I just saw', $domain ) . ' {title}',
								'block_strong' => __( 'Example: ', $domain ),
							) );

							parent::tr( array(
								'key'          => 'tracking',
								'label'        => __( 'UTM tracking', $domain ),
								'placeholder'  => __( 'Add UTM tracking (Analytics)', $domain ),
								'text'         => __( 'Use <code>?</code> and', $domain ) . ' ' . __( 'adding parameters to use <code>&</code> in the tracking.', $domain ),
								'block_text'   => '?utm_source=share_buttons&utm_medium=social_media&utm_campaign=social_share',
								'block_strong' => __( 'Example: ', $domain ),
							) );

							parent::tr( array(
								'key'         => 'bitly-token',
								'label'       => __( 'Bitly access token', $domain ),
								'placeholder' => __( 'Insert your access token Bitly', $domain ),
								'text'        => __( 'Shorten urls using bitly, generate token in ', $domain ),
								'link'        => 'https://bitly.is/2lQjWHF',
								'attr'        => array(
									'data-element' => 'bitly-token',
								),
							) );

							parent::tr( array(
								'type'    => 'select',
								'key'     => 'bitly-domain',
								'label'   => __( 'Select Bitly domain', $domain ),
								'class'   => 'regular-text',
								'options' => WPUSB_Utils::get_bitly_domains(),
								'default' => 'default',
							) );

							$post_types = WPUSB_Utils::get_post_types();

							parent::tr( array(
								'type'     => 'select',
								'key'      => 'post-types',
								'label'    => __( 'Post types is enabled', $domain ),
								'class'    => 'regular-text',
								'options'  => $post_types,
								'default'  => $post_types,
								'multiple' => true,
								'text'     => __( 'Minimum 1 post type, default all.', $domain ),
							) );

							parent::tr( array(
								'type'    => 'checkbox',
								'key'     => 'minify-html',
								'label'   => __( 'Minify html buttons share', $domain ),
								'checked' => 'on',
								'text'    => __( 'Minify the HTML helps site performance.', $domain ),
							) );

							parent::tr( array(
								'type'    => 'checkbox',
								'key'     => 'sharing-report-disabled',
								'label'   => __( 'Deactivate sharing report', $domain ),
								'checked' => 'on',
								'text'    => __( 'This allows you to disable counting of the shares report. You will not lose the report you have already computed.', $domain ),
							) );

							parent::tr( array(
								'type'    => 'checkbox',
								'key'     => 'disable-css',
								'label'   => __( 'Disable CSS', $domain ),
								'checked' => 'on',
							) );

							parent::tr( array(
								'type'    => 'checkbox',
								'key'     => 'disable-js',
								'label'   => __( 'Disable JS', $domain ),
								'checked' => 'on',
							) );

							parent::tr( array(
								'type'    => 'checkbox',
								'key'     => 'css-footer',
								'label'   => __( 'CSS file in footer', $domain ),
								'checked' => 'on',
								'text'    => __( 'Keep the CSS style in the footer is recommended to improve the performance of your website.', $domain ),
							) );
						?>
						</tbody>
					</table>
					<?php
						settings_fields( "{$extra_setting}_group" );
						submit_button();
					?>
					<div class="<?php echo $prefix; ?>-info-error" data-element="bitly-message"></div>
				</form>
			</div>
		</div>
	<?php
	}
}
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

class WPUSB_Settings_Extra_View extends WPUSB_Utils_View {

	/**
	 * Display page setting
	 *
	 * @since 1.2
	 * @param Null
	 * @return Void, Display page
	 */
	public static function render_settings_extra() {
		$extra_setting = sprintf( '%s_extra_settings', WPUSB_App::SLUG );

		parent::set_options();
		parent::set_prefix( $extra_setting );
	?>
		<div class="wrap" <?php echo WPUSB_Utils::get_component( 'extra-settings' ); ?>>
			<h2>
				<?php _e( 'WPUpper Share Buttons', 'wpupper-share-buttons' ); ?>
			</h2>

			<?php
			if ( WPUSB_Utils::get_update( 'settings-updated' ) ) {
				parent::update_notice();
			}
			?>

			<p class="description">
				<?php _e( 'Add the Share Buttons automatically.', 'wpupper-share-buttons' ); ?>
			</p>

			<?php parent::page_notice(); ?>

			<span class="<?php echo WPUSB_App::SLUG . '-title-wrap'; ?>">
				<?php _e( 'Extra Settings', 'wpupper-share-buttons' ); ?>
			</span>

			<?php parent::menu_top(); ?>

			<div class="<?php echo WPUSB_App::SLUG . '-wrap extra-settings-wrap'; ?>">
				<form action="options.php"
					  method="post"
					  data-action="form"
					  data-element="form">

					<table class="form-table table-extras" data-table="extras">
						<tbody>
						<?php
							parent::tr(
								array(
									'key'         => 'twitter-username',
									'label'       => __( 'Twitter username', 'wpupper-share-buttons' ),
									'text'        => __( 'Your twitter username', 'wpupper-share-buttons' ),
									'placeholder' => __( 'Twitter username', 'wpupper-share-buttons' ),
								)
							);

							parent::tr(
								array(
									'key'          => 'twitter-hashtags',
									'label'        => __( 'Twitter hashtags', 'wpupper-share-buttons' ),
									'placeholder'  => __( 'Twitter hashtags', 'wpupper-share-buttons' ),
									'text'         => __( 'Optional Hashtags appended onto the tweet (comma separated. don\'t include "#")', 'wpupper-share-buttons' ),
									'block_text'   => 'social, share, like',
									'block_strong' => __( 'Example: ', 'wpupper-share-buttons' ),
								)
							);

							parent::tr(
								array(
									'key'          => 'twitter-text',
									'label'        => __( 'Twitter text', 'wpupper-share-buttons' ),
									'placeholder'  => __( 'Twitter text', 'wpupper-share-buttons' ),
									'text'         => __( 'Use {title} to add the post title', 'wpupper-share-buttons' ),
									'block_text'   => __( 'I just saw', 'wpupper-share-buttons' ) . ' {title}',
									'block_strong' => __( 'Example: ', 'wpupper-share-buttons' ),
								)
							);

							parent::tr(
								array(
									'key'          => 'tracking',
									'label'        => __( 'UTM tracking', 'wpupper-share-buttons' ),
									'placeholder'  => __( 'Add UTM tracking (Analytics)', 'wpupper-share-buttons' ),
									'text'         => __( 'Use <code>?</code> and', 'wpupper-share-buttons' ) . ' ' . __( 'adding parameters to use <code>&</code> in the tracking.', 'wpupper-share-buttons' ),
									'block_text'   => '?utm_source=share_buttons&utm_medium=social_media&utm_campaign=social_share',
									'block_strong' => __( 'Example: ', 'wpupper-share-buttons' ),
								)
							);

							parent::tr(
								array(
									'key'         => 'bitly-token',
									'label'       => __( 'Bitly access token', 'wpupper-share-buttons' ),
									'placeholder' => __( 'Insert your access token Bitly', 'wpupper-share-buttons' ),
									'text'        => __( 'Shorten urls using bitly, generate token in ', 'wpupper-share-buttons' ),
									'link'        => 'https://bitly.is/2lQjWHF',
									'attr'        => array(
										'data-element' => 'bitly-token',
									),
								)
							);

							parent::tr(
								array(
									'type'    => 'select',
									'key'     => 'bitly-domain',
									'label'   => __( 'Select Bitly domain', 'wpupper-share-buttons' ),
									'class'   => 'regular-text',
									'options' => WPUSB_Utils::get_bitly_domains(),
									'default' => 'default',
								)
							);

							$post_types        = WPUSB_Utils::get_post_types( array(), 'objects' );
							$options_post_type = array();

							foreach ( $post_types as $name => $object ) :
								$options_post_type[ $name ] = $object->label;
							endforeach;

							parent::tr(
								array(
									'type'     => 'select',
									'key'      => 'post-types',
									'label'    => __( 'Post types is enabled', 'wpupper-share-buttons' ),
									'class'    => 'regular-text',
									'options'  => $options_post_type,
									'default'  => $options_post_type,
									'multiple' => true,
									'text'     => __( 'Minimum 1 post type, default all.', 'wpupper-share-buttons' ),
									'reverse'  => true,
								)
							);

							parent::tr(
								array(
									'type'    => 'checkbox',
									'key'     => 'minify-html',
									'label'   => __( 'Minify html buttons share', 'wpupper-share-buttons' ),
									'checked' => 'on',
									'text'    => __( 'Minify the HTML helps site performance.', 'wpupper-share-buttons' ),
								)
							);

							parent::tr(
								array(
									'type'    => 'checkbox',
									'key'     => 'sharing-report-disabled',
									'label'   => __( 'Deactivate sharing report', 'wpupper-share-buttons' ),
									'checked' => 'on',
									'text'    => __( 'This allows you to disable counting of the shares report. You will not lose the report you have already computed.', 'wpupper-share-buttons' ),
								)
							);

							parent::tr(
								array(
									'type'    => 'checkbox',
									'key'     => 'disable-css',
									'label'   => __( 'Disable CSS', 'wpupper-share-buttons' ),
									'checked' => 'on',
								)
							);

							parent::tr(
								array(
									'type'    => 'checkbox',
									'key'     => 'disable-js',
									'label'   => __( 'Disable JS', 'wpupper-share-buttons' ),
									'checked' => 'on',
								)
							);

							parent::tr(
								array(
									'type'    => 'checkbox',
									'key'     => 'css-footer',
									'label'   => __( 'CSS file in footer', 'wpupper-share-buttons' ),
									'checked' => 'on',
									'text'    => __( 'Keep the CSS style in the footer is recommended to improve the performance of your website.', 'wpupper-share-buttons' ),
								)
							);
						?>
						</tbody>
					</table>
					<?php
						settings_fields( "{$extra_setting}_group" );
						submit_button();
					?>
					<div class="<?php echo WPUSB_App::SLUG; ?>-info-error" data-element="bitly-message"></div>
				</form>
			</div>
		</div>
	<?php
	}
}

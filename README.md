# WPUpper Share Buttons
Author URL:  
Contributors: victorfreitas  
Donate link: [Donate Now](https://www.redcross.org/donate/donation)  
Tags: share, social, buttons, share buttons, whatsapp, facebook, twitter, google plus, compartilhar, redes sociais, social plugin, tweet button, share image, sharebar, social bookmarking, email form, social media buttons, click to tweet, pinterest, linkedin.  
Requires at least: 3.0  
Tested up to: 4.4.2  
Stable tag: 2.3.0  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html  

Add the share buttons of the main social networks.

## Description

### Credits
* Plugin icon by [IcoMoon](https://icomoon.io/)

## Installation
You can either install it automatically from the WordPress admin, or do it manually:
1. Upload the whole `wpupper-share-buttons` directory into your plugins folder(`/wp-content/plugins/`)
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Plugin settings page is located in WP-Admin -> Share Buttons 

## Screenshots
1. [`WordPress Plugin Page`](https://wordpress.org/plugins/wpupper-share-buttons/screenshots/)

## Asked Questions
###### How do I add this to my theme?
1. It is automatically inserted into your post after activation of the plugin
2. Using shortcode on a specific part of theme
``` PHP
if ( shortcode_exists( 'wpusb' ) :
    echo do_shortcode( '[wpusb class_first="" class_second="" class_link="" class_icon="" layout="default" remove_inside="0" remove_counter="0"]' );
endif;
```
3. Using PHP method on a specific part of theme
``` PHP
//Default Arguments
$args = array(
    'class_first'  => '',
    'class_second' => '',
    'class_link'   => '',
    'class_icon'   => '',
    'layout'       => 'default',
    'elements'     => array(
        'remove_inside'  => false,
        'remove_counter' => false,
    ),
);
if ( class_exists( 'WPUSB_Shares_View' ) ) :
    echo WPUSB_Shares_View::share( $args );
endif;

/*
$args
(Array) (optional)
Layout options: default, buttons, rounded, square
*/
```
4. Using the content editor -> [wpusb class_first="" class_second="" class_link="" class_icon="" layout="default" remove_inside="0" remove_counter="0"]  

## Changelog

#### 1.0.0
* Initial release
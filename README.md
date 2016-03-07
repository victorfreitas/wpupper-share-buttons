# Share Buttons
Author URL:  
Contributors: victorfreitas  
Donate link: [Donate Now](https://www.redcross.org/donate/donation)  
Tags: share, social, buttons, share buttons, sharing buttons, whatsapp, facebook, twitter, google plus, compartilhar, redes sociais, social plugin, tweet button, share image, sharebar, sharing, social bookmarking, email form, social media buttons, click to tweet, pinterest, linkedin.  
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

### 2.3.0

* FIXED: Bug fixed in buttons text
* FIXED: Bug fixed in sortable share report page
* NEW: Improvements
* NEW: Updating the translations
* NEW: Implements search in share report page

### 2.2.4

* FIXED: Bug fix UTM Tracking option
* FIXED: Change slug filters and page
* NEW: Improvements button style printfriendly
* NEW: Effect hide buttons fixed left

### 2.2.3

* FIXED: Bug fixes counter sharing, before and after buttons on content. [Related by athalas]

### 2.2.2

* FIXED: Bug fix whatsapp UTM Tracking params

### 2.2.1
* FIXED: Bug fix
* NEW: Update languages, Improvements short url, change namespace js

### 2.2.0
* FIXED: Bug fix
* NEW: adds shortener url with bitly

### 2.1.1
* FIXED: Bug fix whatsapp icon
* FIXED: Bug fix counter markup style in theme Square Plus
* FIXED: Improvements perfomance preview share buttons in settings page
* NEW: Add spinner before preview share buttons

### 2.1.0
* FIXED: Bug fix and improvements performance
* NEW: Adding possibility to order the buttons of social networks
* NEW: Style of buttons
* NEW: Update Google Plus icon
* NEW: Preview share buttons in settings page

#### 2.0.4
* FIXED: Bug fix pagination sharing report page [Related by nagal #post-7832935]

#### 2.0.3
* FIXED: Bug fix icon email, whatsapp [Related by theadarshmehta]
* FIXED: Bug fix translate title icon email, printfriendly [Related by theadarshmehta]
* FIXED: Bug fix sharing report admin page in WordPress 4.4
* NEW: Tested in WordPress 4.4
* NEW: Releasing some filters for customization dev
* NEW: Logo
* NEW: Performance improvements

#### 2.0.2
* FIXED: Remove twitter counter, API discontinued

#### 2.0.1
* FIXED: Bug fix

#### 2.0.0
* NEW: new layouts
* NEW: Improvements in settings
* NEW: new features
* NEW: new customizations
* NEW: Removing old layouts that were broken
* FIXED: Performance improvements
* FIXED: Bug fix

#### 1.4.2
* FIXED: Bug fix
* FIXED: Improving performance

#### 1.4.1
* FIXED: Bug fix

#### 1.4.0
* NEW: Preparing for internationalization
* NEW: Adding English translation
* NEW: Adding Spanish translation
* NEW: Change button style theme 3

#### 1.3.0

* NEW: Adding WP List Table in the sharing report page
* NEW: Small internal improvements

#### 1.2.1

* NEW: Tested WordPress version 4.3
* NEW: Validations in the use of PHP method to call buttons
* NEW: Option remove scripts in front
* NEW: Option to time set cache reports of the page sharing of posts
* FIXED: Bug fix

#### 1.2.0

* FIXED: Improving performance in SQL queries

#### 1.1.1

* FIXED: Bug fix

#### 1.1.0

* NEW: Theme
* NEW: Optimize icons mobile
* NEW: Icons style
* FIXED: Bug fix

#### 1.0.5

* FIXED: Bug fix

#### 1.0.3

* NEW: Adds submenu page
* NEW: Page report share counter
* NEW: Counter for google plus
* NEW: Submenus
* FIXED: Code patterns fix

#### 1.0.2

* NEW: Adds option UTM tracking for analytics
* NEW: Patterners fix style admin page
* NEW: Change screenshots
* FIXED: Code patterns fix

#### 1.0.1

* NEW: Layout admin page configurations
* NEW: Change layout buttons secondary
* FIXED: Fix style layout buttons primary
* FIXED: Code patterns fix

#### 1.0.0
* Initial release

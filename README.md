# WPUpper Share Buttons
Author URL: WPUpper 
Contributors: victorfreitas  
Donate link: [Donate Now](https://www.redcross.org/donate/donation)  
Tags: share, social, buttons, share buttons, whatsapp, facebook, twitter, google plus, compartilhar, redes sociais, social plugin, tweet button, share image, sharebar, social bookmarking, email form, social media buttons, click to tweet, pinterest, reddit, viber, telegram, gmail, skype, like, linkedin.  
Requires at least: 3.0.0  
Tested up to: 4.5.3  
Stable tag: 3.4.0  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html  

Implement the Share Buttons of the major social networks, including the Whats App on your website or blog.

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

### 3.4.0

* New: Add share on Reddit

### 3.3.0

* Bug fixes
* New: Possiblity add buttons share on Archive and Category
* Minor improvements

### 3.2.1

* Bug fixes

### 3.2.0
* New: Layout fixed by context
* Internal Improvements
* Updating translations
* Bug fixes

### 3.1.3

* Internal Improvements
* Improvements in the colors of the buttons on administration page
* Improved checkbox buttons in administration page
* Updating translations
* Bug fixes

### 3.1.2

* Add custom PHP method to include the buttons.

### 3.1.1

* Bug fixed

### 3.1.0

* New position fixed right
* New send by Gmail
* Improvements performance
* Update translations
* Bug fixes

### 3.0.2

* Bug fixes links

### 3.0.1

* Bug fixes PHP < 5.5

### 3.0.0

* Enabling modal to show all buttons.
* Adding one more button to open modal social networks.
* Exchanging email color and icon.
* Improvements buttons.
* Enabling the possibility of having fixed buttons on the left and content.
* Improving animation on hover of fixed buttons left.
* Enabling highlight of buttons by reference.
* internal improvements.
* Updating translations.
* Update fonts.
* Bug fixes.

### 2.9.3
* Bug fixed checked persistent items in admin settings

### 2.9.2
* Bug fixes

### 2.9.1
* Bug fixes

### 2.9.0

* Bug fixes
* Add position fixed top buttons
* Add option Twitter text in extra settings page
* Add top menu in the settings
* Change color inputs in the settings page
* Update translations
* Tested in version 4.5.1

### 2.8.2

* Bug fixes

### 2.8.1

* Updated Russian translation

#### 2.8.0

* New button - like on Facebook

#### 2.7.0

* Improvements layout fixed left
* Responsive layout fixed left
* New screenshots

#### 2.6.1

* Bug fixes

#### 2.6.0

* Tested in version 4.5
* Add icons sharing for Telegram, Skype and Viber
* Bug fixes
* Improvements performance
* Update langs pt_BR and es_ES

#### 2.5.3

* Fixed bug links social networks share unsafe script when https

#### 2.5.2

* Fixed bug

#### 2.5.1

* Update languages

#### 2.5.0

* Bug fixes
* Improvements
* new icons for filter

#### 2.4.1

* Bug fixes

#### 2.3.1

* Improvements internal

#### 2.3.0

* Bug fixed in buttons text
* Bug fixed in sortable share report page
* Improvements
* Updating the translations
* Implements search in share report page

#### 2.2.4

* Bug fix UTM Tracking option
* Change slug filters and page
* Improvements button style printfriendly
* Effect hide buttons fixed left

#### 2.2.3

* Bug fixes counter sharing, before and after buttons on content. [Related by athalas]

#### 2.2.2

* Bug fix whatsapp UTM Tracking params

#### 2.2.1

* Bug fix
* Update languages, Improvements short url, change namespace js

#### 2.2.0

* Bug fix
* adds shortener url with bitly

#### 2.1.1

* Bug fix whatsapp icon
* Bug fix counter markup style in theme Square Plus
* Improvements perfomance preview share buttons in settings page
* Add spinner before preview share buttons

#### 2.1.0

* Bug fix and improvements performance
* Adding possibility to order the buttons of social networks
* Style of buttons
* Update Google Plus icon
* Preview share buttons in settings page

#### 2.0.4

* Bug fix pagination sharing report page [Related by nagal #post-7832935]

#### 2.0.3

* Bug fix icon email, whatsapp. [Related by theadarshmehta]
* Bug fix translate title icon email, printfriendly. [Related by theadarshmehta]
* Bug fix sharing report admin page in WordPress 4.4
* Tested in WordPress 4.4
* Releasing some filters for customization dev
* Logo
* Performance improvements

#### 2.0.2

* Remove twitter counter, API discontinued

#### 2.0.1

* Bug fix

#### 2.0.0

* new layouts
* Improvements in settings
* new features
* new customizations
* Removing old layouts that were broken
* Performance improvements
* Bug fix

#### 1.4.2

* Bug fix
* Improving performance

#### 1.4.1

* Bug fix

#### 1.4.0

* Preparing for internationalization
* Adding English translation
* Adding Spanish translation
* Change button style theme 3

#### 1.3.0

* Adding WP List Table in the sharing report page
* Small internal improvements

#### 1.2.1

* Tested WordPress version 4.3
* Validations in the use of PHP method to call buttons
* Option remove scripts in front
* Option to time set cache reports of the page sharing of posts
* Bug fix

#### 1.2.0

* Improving performance in SQL queries

#### 1.1.1

* Bug fix

#### 1.1.0

* Theme
* Optimize icons mobile
* Icons style
* Bug fix

#### 1.0.5

* Bug fix

#### 1.0.3

* Adds submenu page
* Page report share counter
* Counter for google plus
* Submenus
* Code patterns fix

#### 1.0.2

* Adds option UTM tracking for analytics
* Patterners fix style admin page
* Change screenshots
* Code patterns fix

#### 1.0.1

* Layout admin page configurations
* Change layout buttons secondary
* Fix style layout buttons primary
* Code patterns fix

#### 1.0.0

* Initial release
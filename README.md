# WPUpper Share Buttons
Author URL: Victor Freitas 
Contributors: victorfreitas  
Donate link: [Donate Now](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=KYRMWXEEQN58L)  
Tags: share, social, buttons, share buttons, whatsapp, facebook, twitter, google plus, compartilhar, redes sociais, social plugin, tweet button, share image, sharebar, social bookmarking, email form, social media buttons, click to tweet, pinterest, reddit, viber, telegram, gmail, skype, like, linkedin.  
Requires at least: 3.0  
Tested up to: 4.8.2  
PHP version: 5.2  
Stable tag: 3.36.1  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html  

Implement the Share Buttons of the major social networks, including the Whats App on your website or blog.

## Description

#### Extensions

* Sharing Count Update

[![Sharing Count Update](https://i.vimeocdn.com/video/660548514.jpg)]
(https://vimeo.com/237981148 "Sharing Count Update")
[Buy Now](https://letzup.com/product/wpupper-share-buttons-sharing-count-update/)

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
if ( class_exists( 'WPUSB_Shares_View' ) ) :
    // $args is optional
    echo WPUSB_Shares_View::buttons_share( $args );
endif;

/*
$args
(Array) (optional)
Layout options: default, buttons, rounded, square
*/
```
4. Using the content editor -> [wpusb class_first="" class_second="" class_link="" class_icon="" layout="default" remove_inside="0" remove_counter="0"]  

## Changelog

## 3.36.1

* Bug fixes charset

## 3.36

* Add page Extensions with addons to add new features to your WPUpper Share Buttons

## 3.35

* Add classification by social network on sharing report page
* Improvements list table

## 3.34

* WhatsApp share available on desktop
* Refactory code i18n
* Bug fixes

## 3.33.3

* Bug fix custom CSS
* Tested up to 4.8

## 3.33.2

* Fixed bug, two Popup when using Twitter share button

## 3.33.1

* Bug fixes

## 3.33

* Fix: Add new tag version because the update was not working properly.

## 3.32.1

* Fix twitter hashtags with special characters. [Reported by @madeiranetwork]
* Request share counts performance improvements. [Reported by @madeiranetwork]
* Show scripts improvements
* Bug fixes

## 3.32

* NEW: Select which post types shows the sharing buttons. [Extra Settings Dashboard]
* NEW: Share count Buffer
* NEW: Sharing report post date field
* NEW: Sharing report filtering by date range. Thanks @daniloalvess
* NEW: Sharing report export to CSV
* NEW: Layout fixed square 2
* NEW: Follow US on VKontakte in Widget
* NEW: Located templates or filter templates for developer customization.
* Sharing report improvements
* Removed cache on sharing report dashboard
* Dashboard internal code structure improvements
* Fix: Layout fixed button close
* Bitly validation on add key
* New fitlers
* Add animation on open modal
* Update grunt js, add grunt wp i18n
* Languages update
* Bug fixes

## 3.31.1

* Fix Pinterest icon

## 3.31

* New option; Use in description of Pinterest the alt text of highlighted image in place of title of post.
* Languages update

## 3.30

* New options: Add share button on VK
* Languages update
* Bug fixes

## 3.29

* New option: Now you can enter a minimum value to start displaying the amount of sharing for each supported social network.
* Update banner
* Update languages

## 3.28

* NEW: Behance follow us
* NEW: Buffer share button
* Share Telegram on desktop available.
* Bug fix. [Reported by @ablekinetic]

## 3.27.2

* Fix: URLs with query string. It was not returning the query strings on some servers. [Reported by @robertkyambo]

## 3.27.1

* Fix: URL with space in query string.
* Fix: Twitter text option. [Reported by @robertkyambo]

## 3.27

* New option: Alter share text on layout fixed rounded
* New option: Alter count share background color in Dashboard and Widget
* New option: Alter count share text color in Dashboard and Widget
* New option: Alter buttons title color in Dashboard and Widget
* New option: Add Widget Follow Us
* New option: Deactivate share buttons for specific Post, Page and publics Custom Post Types via metabox
* New option: Select the Bitly domain
* NEW: Update Widget share options
* NEW: Real time preview share buttons customization in Dashboard page
* Update font icons
* Widget selective preview improvents
* Update languages
* Support for PHP version 5.1 is being deprecated
* Bitly URL shortener improvements performance
* Bug fixes
* Code improvements

## 3.26

* New option: Custom background color icons
* Style improvements in admin settings page
* Bug fixes
* Improvements performance
* Update languages

## 3.25.2

* Bug fixes

## 3.25.1

* Bug fixes

## 3.25

* New option: Change size icons
* New option: Change color icons
* New option: Widget share buttons available
* New option: Minify HTML share buttons output
* Improvements custom css option
* Update languages
* Improvements in multisite
* Improvements on admin and frontend
* Correction of alignment for layout fixed right. [Reported by @talgalili]
* Bug fixes

## 3.24

* New option: Now you can add custom css directly in the plugin settings.
* Code improvements
* Update languages

## 3.23

* NEW: Add option insert title above the share buttons
* Improvements performance font icons. [Reported by @marius84]
* Update languages

## 3.22

* NEW: Add option change share count label for theme Square Plus
* NEW: Change layout share count for theme Square Plus
* Admin page layout improvements
* Code improvements
* Update languages

## 3.21.2

* Bug fixes JS. [Reported by @marius84]

## 3.21.1

* Bug fixes featured referrer

## 3.21

* Bug fixes. [Reported by @countrygirlorg]
* Improvements

## 3.20

* Added possibility of disabling the shares report. [Reported by @marius84]

## 3.19

* Removed autoload

## 3.18.1

* Bug fix layout fixed on tablet. [Reported by @marius84]

## 3.18

* Fix bug share on Messenger. [Reported by @marius84]
* Show mobile items on landscape tablet. [Reported by @marius84]

## 3.17

* Tested in version 4.7
* Performance improvements on get Google Plus share count
* Bug fixes email send on mobile. [Reported by @marius84]
* Code improvements
* Social share API improvements
* Add Twitter hashtags option

### 3.16

* Add WooCommerce Share support
* Remove plugin scripts another's pages on admin

### 3.15

* Required PHP version 5.2.4 or above
* Bug fix permalink params

### 3.14

* Bug fix PHP version < 5.3.0 on plugin activation
* Displaying formatted share count
* Change text color total counts for layout square plus

### 3.13

* NEW: Share count support on Tumblr
* Update Tumblr share API url
* Update filters support
* Bug fixes

### 3.12

* New button: Facebook Messenger
* Add message on plugin admin page
* Update languages
* Bug fixes

### 3.11

* Performance improvements
* Bug fixes
* Change class name WPUSB_All_Items to WPUSB_Modal

### 3.10

* Bug fixes GLOB_BRACE flag is not available on some non GNU systems

### 3.9.0

* General coding standards and improvements
* Improvements modal social networks
* NEW: Add buton share on Flipboard
* NEW: Option set url via shortcode or method php
* NEW: Option set title via shortcode or method php
* Bug fixes

### 3.8.2

* Add filter classes icons

### 3.8.1

* Add filter prefix classes icons
* Bug fixes

### 3.8.0

* Improvements performance
* Adding option on extra settings for to keep CSS in the footer, this is good for performance of your website.
* Update translations

### 3.7.0

* NEW: Option to choose which social networks show through shortcode, PHP method
* You can see more details on using the shortcode and PHP method on the "Use Options" in the administration of the plugin.

### 3.6.6

* Bug fixed: Shares count because of the update of the Facebook API response

### 3.6.5

* Compatible up to: 4.6

### 3.6.4

* Bug fixes (https://wordpress.org/support/topic/not-sharing-the-article-sharing-the-web-site-address-instead?replies=1)

### 3.6.3

* Bug fixes

### 3.6.2

* Bug fixes multisite admin page

### 3.6.1

* Bug fixes
* Removed persistent message

### 3.6.0

* Bug fixed
* Fixed fatal error on first install
* Fixed security requests ajax
* Update translations
* Remove fields: "Remove count" and "Remove title" from extra settings
* Add fields: "Remove count" and "Remove title" in General Settings

### 3.5.3

* Bug fixes css

### 3.5.3

* Bug fixes

### 3.5.2

* Bug fixes

### 3.5.1

* Bug fixes

### 3.5.0

* NEW: Layout rounded for position fixed
* Internal improvements
* Bug fixes
* Update translations

### 3.4.2

* Bug fixes

### 3.4.1

* General internal improvements
* Performance improvements
* Bug fixes

### 3.4.0

* NEW: Add share on Reddit
* Updating translations

### 3.3.0

* Bug fixes
* NEW: Possiblity add buttons share on Archive and Category
* Minor improvements

### 3.2.1

* Bug fixes

### 3.2.0
* NEW: Layout fixed by context
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

* Bug fixes counter sharing, before and after buttons on content. [Reported by athalas]

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

* Bug fix pagination sharing report page [Reported by nagal #post-7832935]

#### 2.0.3

* Bug fix icon email, whatsapp. [Reported by theadarshmehta]
* Bug fix translate title icon email, printfriendly. [Reported by theadarshmehta]
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
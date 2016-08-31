# Changelog

### 1.7.1
* Updated price output in the flowers shortcode if only the gram price is added
* Added 'placement' and 'display' options to the WP Dispensary settings page
* Added 'category' option to shortcodes to allow for separation of menu type by category
* Updated metaboxes to use text input rather than number input, so decimals can be used

### 1.7
* Updated `languages/wp-dispensary.pot` file with all current translatable text throughout the plugin
* Added Growers menu type
* Added API endpoints for Growers menu type
* Added Widget for Growers menu type
* Added `[wpd-growers]` shortcode for Growers menu type

### 1.6
* Added WP Dispensary settings page to the WordPress admin menu
* Added in automatic output of menu item details and pricing to `the_content`
* Updated `admin/post-types/wp-dispensary-metaboxes.php` to fix Serving information metabox details
* WordPress Coding Standards updates ([issue](https://github.com/deviodigital/wp-dispensary/issues/1))

### 1.5.2
* Removed file that was left behind for the plugin recommendation

### 1.5.1
* Removed plugin recommendation since it was causing upgrade errors

### 1.5
* Added various new output options for shortcode display
* Updated CSS in `public/css/wp-dispensary-public.css` for improved display in the widgets
* Added WPD icon to each menu section in dashboard "At A Glance" box
* Added option to randomize menu item output in widgets
* Added plugin recommendation for [Dispensary Coupons](https://wordpress.org/plugins/dispensary-coupons/)
* PHP_CodeSniffer WordPress Coding Standards updates throughout various plugin files

### 1.4
* PHP_CodeSniffer WordPress Coding Standards updates throughout various plugin files
* Created the Topicals menu type, with Widget, Shortcode and WP-API output options
* Updated the output style of the Shortcode item information
* Added the WP Dispensary icon to each CPT in the admin dashboard for easier visual recognition
* Added `active_plugins` check for "Subtitles" plugin in `admin/wp-dispensary-rest-api.php` API output
* Added sanitization to $_POST in `admin/post-types/wp-dispensary-metaboxes.php` pre-roll flower selection drop down

### 1.3.1
* Fixed CBD being called BCD #typingtoofast

### 1.3
* Added THC% and CBD% metaboxes
* Added custom image size for the shortcodes

### 1.2
* Added Shortcode output for use with any theme
* Removed code causing error on Menus page

### 1.1
* Added WordPress REST API integration

### 1.0
* Initial release

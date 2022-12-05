<?php
/**
 * searchAlert
 *
 * @package           searchAlert
 * @author            Exlac
 * @copyright         2022 Exlac
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Search Alert - Set Notification for New Post
 * Description:       Notify user based on previous search when a post available in your site.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Exlac
 * Author URI:        https://exlac.com/
 * Text Domain:       search-alert
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://wordpress.org/plugins/search-alert/
 */

require dirname( __FILE__ ) . '/vendor/autoload.php';
require dirname( __FILE__ ) . '/app.php';

if ( ! function_exists( 'searchAlert' ) ) {
    function searchAlert() {
        return searchAlert::get_instance();
    }
}
searchAlert();


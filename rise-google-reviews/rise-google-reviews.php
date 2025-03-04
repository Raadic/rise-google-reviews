<?php
/**
 * Plugin Name: Rise Google Reviews
 * Plugin URI: https://example.com/rise-google-reviews
 * Description: Display Google reviews on your website with customizable shortcodes. Features include filtering by star rating and multiple display styles.
 * Version: 1.0.0
 * Author: Rise
 * Author URI: https://example.com
 * Text Domain: rise-google-reviews
 * Domain Path: /languages
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('RISE_GR_VERSION', '1.0.0');
define('RISE_GR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('RISE_GR_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once RISE_GR_PLUGIN_DIR . 'includes/class-rise-google-reviews.php';
require_once RISE_GR_PLUGIN_DIR . 'includes/class-rise-google-reviews-api.php';
require_once RISE_GR_PLUGIN_DIR . 'includes/class-rise-google-reviews-shortcodes.php';

// Initialize the plugin
function rise_google_reviews_init() {
    $plugin = new Rise_Google_Reviews();
    $plugin->init();
}
add_action('plugins_loaded', 'rise_google_reviews_init');

// Register AJAX handlers
function rise_google_reviews_ajax_handlers() {
    add_action('wp_ajax_rise_gr_clear_cache', 'rise_google_reviews_clear_cache');
}
add_action('admin_init', 'rise_google_reviews_ajax_handlers');

// Clear cache AJAX handler
function rise_google_reviews_clear_cache() {
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'rise_gr_admin_nonce')) {
        wp_send_json_error('Invalid nonce');
    }
    
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Insufficient permissions');
    }
    
    // Clear cache
    $api = new Rise_Google_Reviews_API();
    $api->clear_cache();
    
    wp_send_json_success('Cache cleared successfully');
}

// Register activation hook
register_activation_hook(__FILE__, 'rise_google_reviews_activate');
function rise_google_reviews_activate() {
    // Activation code here
    flush_rewrite_rules();
}

// Register deactivation hook
register_deactivation_hook(__FILE__, 'rise_google_reviews_deactivate');
function rise_google_reviews_deactivate() {
    // Deactivation code here
    flush_rewrite_rules();
}

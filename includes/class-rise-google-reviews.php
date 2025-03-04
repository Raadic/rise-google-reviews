<?php
/**
 * The main plugin class
 *
 * @since      1.0.0
 * @package    Rise_Google_Reviews
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main plugin class
 */
class Rise_Google_Reviews {

    /**
     * API instance
     *
     * @var Rise_Google_Reviews_API
     */
    private $api;

    /**
     * Shortcodes instance
     *
     * @var Rise_Google_Reviews_Shortcodes
     */
    private $shortcodes;

    /**
     * Initialize the plugin
     */
    public function init() {
        // Initialize API
        $this->api = new Rise_Google_Reviews_API();
        
        // Initialize shortcodes
        $this->shortcodes = new Rise_Google_Reviews_Shortcodes($this->api);
        
        // Register admin menu
        add_action('admin_menu', array($this, 'register_admin_menu'));
        
        // Register settings
        add_action('admin_init', array($this, 'register_settings'));
        
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    /**
     * Register admin menu
     */
    public function register_admin_menu() {
        add_menu_page(
            __('Rise Google Reviews', 'rise-google-reviews'),
            __('Google Reviews', 'rise-google-reviews'),
            'manage_options',
            'rise-google-reviews',
            array($this, 'render_admin_page'),
            'dashicons-star-filled',
            30
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('rise_google_reviews_settings', 'rise_gr_api_key');
        register_setting('rise_google_reviews_settings', 'rise_gr_place_id');
        register_setting('rise_google_reviews_settings', 'rise_gr_cache_time', array(
            'default' => 24, // 24 hours default
            'sanitize_callback' => 'absint',
        ));
    }

    /**
     * Render admin page
     */
    public function render_admin_page() {
        include RISE_GR_PLUGIN_DIR . 'admin/admin-page.php';
    }

    /**
     * Enqueue frontend assets
     */
    public function enqueue_frontend_assets() {
        // Slider styles and scripts from CDN
        wp_enqueue_style(
            'rise-gr-slick',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',
            array(),
            '1.8.1'
        );
        
        wp_enqueue_style(
            'rise-gr-slick-theme',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css',
            array('rise-gr-slick'),
            '1.8.1'
        );
        
        wp_enqueue_style(
            'rise-gr-styles',
            RISE_GR_PLUGIN_URL . 'public/css/rise-google-reviews-public.css',
            array('rise-gr-slick', 'rise-gr-slick-theme'),
            RISE_GR_VERSION
        );
        
        wp_enqueue_script(
            'rise-gr-slick',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
            array('jquery'),
            '1.8.1',
            true
        );
        
        wp_enqueue_script(
            'rise-gr-script',
            RISE_GR_PLUGIN_URL . 'public/js/rise-google-reviews-public.js',
            array('jquery', 'rise-gr-slick'),
            RISE_GR_VERSION,
            true
        );
    }

    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        if ('toplevel_page_rise-google-reviews' !== $hook) {
            return;
        }
        
        // Enqueue Google Fonts - Manrope
        wp_enqueue_style(
            'rise-gr-google-fonts',
            'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap',
            array(),
            RISE_GR_VERSION
        );
        
        // Enqueue admin styles
        wp_enqueue_style(
            'rise-gr-admin-styles',
            RISE_GR_PLUGIN_URL . 'admin/css/rise-google-reviews-admin.css',
            array(),
            RISE_GR_VERSION
        );
        
        // Enqueue branding styles
        wp_enqueue_style(
            'rise-gr-branding',
            RISE_GR_PLUGIN_URL . 'admin/css/rise-branding.css',
            array('rise-gr-admin-styles', 'rise-gr-google-fonts'),
            RISE_GR_VERSION
        );
        
        wp_enqueue_script(
            'rise-gr-admin-script',
            RISE_GR_PLUGIN_URL . 'admin/js/rise-google-reviews-admin.js',
            array('jquery'),
            RISE_GR_VERSION,
            true
        );
        
        // Add nonce for AJAX requests
        wp_localize_script(
            'rise-gr-admin-script',
            'rise_gr_admin',
            array(
                'nonce' => wp_create_nonce('rise_gr_admin_nonce'),
            )
        );
    }
}

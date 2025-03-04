<?php
/**
 * Admin page template
 *
 * @since      1.0.0
 * @package    Rise_Google_Reviews
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap rise-wrapper rise-gr-admin">
    <div class="rise-header">
        <img src="<?php echo esc_url(RISE_GR_PLUGIN_URL . 'public/images/rise-logo.png'); ?>" alt="Rise" class="rise-logo">
        <div class="rise-header-content">
            <h1 class="rise-title"><?php echo esc_html(get_admin_page_title()); ?></h1>
            <div class="rise-version">Version <?php echo RISE_GR_VERSION; ?></div>
        </div>
    </div>
    
    <div class="rise-gr-admin-tabs">
        <div class="rise-nav">
            <a href="#settings" class="nav-tab nav-tab-active"><?php esc_html_e('Settings', 'rise-google-reviews'); ?></a>
            <a href="#shortcodes" class="nav-tab"><?php esc_html_e('Shortcodes', 'rise-google-reviews'); ?></a>
            <a href="#help" class="nav-tab"><?php esc_html_e('Help', 'rise-google-reviews'); ?></a>
        </div>
        
        <div class="tab-content">
            <div id="settings" class="tab-pane active">
                <div class="rise-card">
                    <form method="post" action="options.php">
                        <?php settings_fields('rise_google_reviews_settings'); ?>
                        
                        <div class="rise-form-row">
                            <label for="rise_gr_api_key" class="rise-label"><?php esc_html_e('Google Places API Key', 'rise-google-reviews'); ?></label>
                            <input type="text" id="rise_gr_api_key" name="rise_gr_api_key" value="<?php echo esc_attr(get_option('rise_gr_api_key')); ?>" class="rise-input">
                        </div>
                        <p class="rise-text">
                            <?php esc_html_e('Enter your Google Places API key. You can get one from the Google Cloud Console.', 'rise-google-reviews'); ?>
                            <a href="https://developers.google.com/maps/documentation/places/web-service/get-api-key" target="_blank"><?php esc_html_e('Learn more', 'rise-google-reviews'); ?></a>
                        </p>
                        
                        <div class="rise-form-row">
                            <label for="rise_gr_place_id" class="rise-label"><?php esc_html_e('Place ID', 'rise-google-reviews'); ?></label>
                            <input type="text" id="rise_gr_place_id" name="rise_gr_place_id" value="<?php echo esc_attr(get_option('rise_gr_place_id')); ?>" class="rise-input">
                        </div>
                        <p class="rise-text">
                            <?php esc_html_e('Enter your Google Place ID. This is the unique identifier for your business listing.', 'rise-google-reviews'); ?>
                            <a href="https://developers.google.com/maps/documentation/places/web-service/place-id" target="_blank"><?php esc_html_e('Find your Place ID', 'rise-google-reviews'); ?></a>
                        </p>
                        
                        <div class="rise-form-row">
                            <label for="rise_gr_cache_time" class="rise-label"><?php esc_html_e('Cache Time (hours)', 'rise-google-reviews'); ?></label>
                            <input type="number" id="rise_gr_cache_time" name="rise_gr_cache_time" value="<?php echo esc_attr(get_option('rise_gr_cache_time', 24)); ?>" class="rise-input" min="1" max="168" style="max-width: 100px;">
                        </div>
                        <p class="rise-text">
                            <?php esc_html_e('How long to cache the reviews before fetching new ones from Google (in hours).', 'rise-google-reviews'); ?>
                        </p>
                        
                        <div class="rise-form-row" style="margin-top: 30px;">
                            <?php submit_button(__('Save Changes', 'rise-google-reviews'), 'primary', 'submit', false); ?>
                            <button type="button" id="rise-gr-clear-cache" class="button-secondary"><?php esc_html_e('Clear Cache', 'rise-google-reviews'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div id="shortcodes" class="tab-pane">
                <h2><?php esc_html_e('Available Shortcodes', 'rise-google-reviews'); ?></h2>
                
                <div class="rise-shortcode-box">
                    <h3><?php esc_html_e('Reviews Slider', 'rise-google-reviews'); ?></h3>
                    <code>[rise_google_reviews_slider min_rating="4" max_reviews="10" slides_to_show="3" autoplay="true" theme="light"]</code>
                    
                    <h4><?php esc_html_e('Parameters', 'rise-google-reviews'); ?></h4>
                    <ul>
                        <li><code>min_rating</code> - <?php esc_html_e('Minimum star rating to display (1-5)', 'rise-google-reviews'); ?></li>
                        <li><code>max_reviews</code> - <?php esc_html_e('Maximum number of reviews to display', 'rise-google-reviews'); ?></li>
                        <li><code>slides_to_show</code> - <?php esc_html_e('Number of slides to show at once', 'rise-google-reviews'); ?></li>
                        <li><code>slides_to_scroll</code> - <?php esc_html_e('Number of slides to scroll at once', 'rise-google-reviews'); ?></li>
                        <li><code>autoplay</code> - <?php esc_html_e('Enable autoplay (true/false)', 'rise-google-reviews'); ?></li>
                        <li><code>autoplay_speed</code> - <?php esc_html_e('Autoplay speed in milliseconds', 'rise-google-reviews'); ?></li>
                        <li><code>arrows</code> - <?php esc_html_e('Show navigation arrows (true/false)', 'rise-google-reviews'); ?></li>
                        <li><code>dots</code> - <?php esc_html_e('Show navigation dots (true/false)', 'rise-google-reviews'); ?></li>
                        <li><code>theme</code> - <?php esc_html_e('Color theme (light/dark)', 'rise-google-reviews'); ?></li>
                    </ul>
                </div>
                
                <div class="rise-shortcode-box">
                    <h3><?php esc_html_e('Floating Badge', 'rise-google-reviews'); ?></h3>
                    <code>[rise_google_reviews_badge min_rating="4" max_reviews="5" position="bottom-right" theme="light" show_reviews="true"]</code>
                    
                    <h4><?php esc_html_e('Parameters', 'rise-google-reviews'); ?></h4>
                    <ul>
                        <li><code>min_rating</code> - <?php esc_html_e('Minimum star rating to display (1-5)', 'rise-google-reviews'); ?></li>
                        <li><code>max_reviews</code> - <?php esc_html_e('Maximum number of reviews to display', 'rise-google-reviews'); ?></li>
                        <li><code>position</code> - <?php esc_html_e('Badge position (top-left, top-right, bottom-left, bottom-right)', 'rise-google-reviews'); ?></li>
                        <li><code>theme</code> - <?php esc_html_e('Color theme (light/dark)', 'rise-google-reviews'); ?></li>
                        <li><code>show_reviews</code> - <?php esc_html_e('Show reviews in popup (true/false)', 'rise-google-reviews'); ?></li>
                    </ul>
                </div>
                
                <div class="rise-shortcode-box">
                    <h3><?php esc_html_e('Minimalist Cards', 'rise-google-reviews'); ?></h3>
                    <code>[rise_google_reviews_cards min_rating="4" max_reviews="10" slides_to_show="3" theme="light" show_stars="true" show_date="true" card_style="rounded"]</code>
                    
                    <h4><?php esc_html_e('Parameters', 'rise-google-reviews'); ?></h4>
                    <ul>
                        <li><code>min_rating</code> - <?php esc_html_e('Minimum star rating to display (1-5)', 'rise-google-reviews'); ?></li>
                        <li><code>max_reviews</code> - <?php esc_html_e('Maximum number of reviews to display', 'rise-google-reviews'); ?></li>
                        <li><code>slides_to_show</code> - <?php esc_html_e('Number of slides to show at once', 'rise-google-reviews'); ?></li>
                        <li><code>slides_to_scroll</code> - <?php esc_html_e('Number of slides to scroll at once', 'rise-google-reviews'); ?></li>
                        <li><code>autoplay</code> - <?php esc_html_e('Enable autoplay (true/false)', 'rise-google-reviews'); ?></li>
                        <li><code>autoplay_speed</code> - <?php esc_html_e('Autoplay speed in milliseconds', 'rise-google-reviews'); ?></li>
                        <li><code>arrows</code> - <?php esc_html_e('Show navigation arrows (true/false)', 'rise-google-reviews'); ?></li>
                        <li><code>dots</code> - <?php esc_html_e('Show navigation dots (true/false)', 'rise-google-reviews'); ?></li>
                        <li><code>theme</code> - <?php esc_html_e('Color theme (light/dark)', 'rise-google-reviews'); ?></li>
                        <li><code>show_stars</code> - <?php esc_html_e('Show rating stars (true/false)', 'rise-google-reviews'); ?></li>
                        <li><code>show_date</code> - <?php esc_html_e('Show review date (true/false)', 'rise-google-reviews'); ?></li>
                        <li><code>card_style</code> - <?php esc_html_e('Card style (rounded, square, minimal)', 'rise-google-reviews'); ?></li>
                    </ul>
                </div>
            </div>
            
            <div id="help" class="tab-pane">
                <h2><?php esc_html_e('Getting Started', 'rise-google-reviews'); ?></h2>
                
                <div class="rise-card rise-gr-help-section">
                    <h3><?php esc_html_e('1. Get a Google Places API Key', 'rise-google-reviews'); ?></h3>
                    <p><?php esc_html_e('To use this plugin, you need a Google Places API key:', 'rise-google-reviews'); ?></p>
                    <ol>
                        <li><?php esc_html_e('Go to the Google Cloud Console', 'rise-google-reviews'); ?></li>
                        <li><?php esc_html_e('Create a new project or select an existing one', 'rise-google-reviews'); ?></li>
                        <li><?php esc_html_e('Enable the Places API', 'rise-google-reviews'); ?></li>
                        <li><?php esc_html_e('Create an API key', 'rise-google-reviews'); ?></li>
                        <li><?php esc_html_e('Copy the API key and paste it in the settings tab', 'rise-google-reviews'); ?></li>
                    </ol>
                    <p>
                        <a href="https://developers.google.com/maps/documentation/places/web-service/get-api-key" target="_blank" class="button button-primary"><?php esc_html_e('Google Cloud Console', 'rise-google-reviews'); ?></a>
                    </p>
                </div>
                
                <div class="rise-card rise-gr-help-section">
                    <h3><?php esc_html_e('2. Find Your Place ID', 'rise-google-reviews'); ?></h3>
                    <p><?php esc_html_e('You need to find your Google Place ID:', 'rise-google-reviews'); ?></p>
                    <ol>
                        <li><?php esc_html_e('Go to the Place ID Finder tool', 'rise-google-reviews'); ?></li>
                        <li><?php esc_html_e('Enter your business name and location', 'rise-google-reviews'); ?></li>
                        <li><?php esc_html_e('Select your business from the results', 'rise-google-reviews'); ?></li>
                        <li><?php esc_html_e('Copy the Place ID and paste it in the settings tab', 'rise-google-reviews'); ?></li>
                    </ol>
                    <p>
                        <a href="https://developers.google.com/maps/documentation/places/web-service/place-id" target="_blank" class="button button-primary"><?php esc_html_e('Place ID Finder', 'rise-google-reviews'); ?></a>
                    </p>
                </div>
                
                <div class="rise-card rise-gr-help-section">
                    <h3><?php esc_html_e('3. Add Shortcodes to Your Site', 'rise-google-reviews'); ?></h3>
                    <p><?php esc_html_e('Use the shortcodes to display your Google reviews:', 'rise-google-reviews'); ?></p>
                    <ul>
                        <li><?php esc_html_e('For a slider: [rise_google_reviews_slider]', 'rise-google-reviews'); ?></li>
                        <li><?php esc_html_e('For a floating badge: [rise_google_reviews_badge]', 'rise-google-reviews'); ?></li>
                        <li><?php esc_html_e('For minimalist cards: [rise_google_reviews_cards]', 'rise-google-reviews'); ?></li>
                    </ul>
                    <p><?php esc_html_e('See the Shortcodes tab for all available options.', 'rise-google-reviews'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

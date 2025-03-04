<?php
/**
 * API handling class
 *
 * @since      1.0.0
 * @package    Rise_Google_Reviews
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Google Places API handler class
 */
class Rise_Google_Reviews_API {

    /**
     * API endpoint
     *
     * @var string
     */
    private $api_endpoint = 'https://maps.googleapis.com/maps/api/place/details/json';

    /**
     * Get reviews from Google Places API
     *
     * @param int $min_rating Minimum rating to filter by (1-5)
     * @param int $max_reviews Maximum number of reviews to return
     * @return array|WP_Error Array of reviews or WP_Error on failure
     */
    public function get_reviews($min_rating = 1, $max_reviews = 5) {
        $api_key = get_option('rise_gr_api_key');
        $place_id = get_option('rise_gr_place_id');
        
        if (empty($api_key) || empty($place_id)) {
            return new WP_Error('missing_credentials', __('API Key or Place ID is missing', 'rise-google-reviews'));
        }
        
        // Check cache first
        $cache_key = 'rise_gr_reviews_' . md5($place_id . $min_rating . $max_reviews);
        $cached_reviews = get_transient($cache_key);
        
        if (false !== $cached_reviews) {
            return $cached_reviews;
        }
        
        // Prepare API request
        $url = add_query_arg(
            array(
                'placeid' => $place_id,
                'key' => $api_key,
                'fields' => 'reviews,rating,name,vicinity',
                'reviews_sort' => 'newest',
            ),
            $this->api_endpoint
        );
        
        // Make API request
        $response = wp_remote_get($url);
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (empty($data) || 'OK' !== $data['status']) {
            return new WP_Error(
                'api_error',
                isset($data['error_message']) ? $data['error_message'] : __('Unknown API error', 'rise-google-reviews')
            );
        }
        
        // Process and filter reviews
        $reviews = array();
        
        if (isset($data['result']['reviews']) && is_array($data['result']['reviews'])) {
            foreach ($data['result']['reviews'] as $review) {
                if ($review['rating'] >= $min_rating) {
                    $reviews[] = array(
                        'author_name' => $review['author_name'],
                        'author_url' => isset($review['author_url']) ? $review['author_url'] : '',
                        'profile_photo_url' => isset($review['profile_photo_url']) ? $review['profile_photo_url'] : '',
                        'rating' => $review['rating'],
                        'text' => isset($review['text']) ? $review['text'] : '',
                        'time' => isset($review['time']) ? $review['time'] : '',
                        'relative_time' => isset($review['relative_time_description']) ? $review['relative_time_description'] : '',
                    );
                    
                    if (count($reviews) >= $max_reviews) {
                        break;
                    }
                }
            }
        }
        
        // Add place data
        $place_data = array(
            'name' => isset($data['result']['name']) ? $data['result']['name'] : '',
            'vicinity' => isset($data['result']['vicinity']) ? $data['result']['vicinity'] : '',
            'rating' => isset($data['result']['rating']) ? $data['result']['rating'] : 0,
            'reviews' => $reviews,
        );
        
        // Cache the results
        $cache_time = get_option('rise_gr_cache_time', 24) * HOUR_IN_SECONDS;
        set_transient($cache_key, $place_data, $cache_time);
        
        return $place_data;
    }
    
    /**
     * Clear cached reviews
     */
    public function clear_cache() {
        global $wpdb;
        
        $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_rise_gr_reviews_%'");
        $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_timeout_rise_gr_reviews_%'");
    }
}

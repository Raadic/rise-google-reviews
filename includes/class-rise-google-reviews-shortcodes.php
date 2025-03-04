<?php
/**
 * Shortcodes handling class
 *
 * @since      1.0.0
 * @package    Rise_Google_Reviews
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Shortcodes handler class
 */
class Rise_Google_Reviews_Shortcodes {

    /**
     * API instance
     *
     * @var Rise_Google_Reviews_API
     */
    private $api;

    /**
     * Constructor
     *
     * @param Rise_Google_Reviews_API $api API instance
     */
    public function __construct($api) {
        $this->api = $api;
        
        // Register shortcodes
        add_shortcode('rise_google_reviews_slider', array($this, 'render_slider_shortcode'));
        add_shortcode('rise_google_reviews_badge', array($this, 'render_badge_shortcode'));
        add_shortcode('rise_google_reviews_cards', array($this, 'render_cards_shortcode'));
    }

    /**
     * Render slider shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string Shortcode output
     */
    public function render_slider_shortcode($atts) {
        $atts = shortcode_atts(
            array(
                'min_rating' => 1,
                'max_reviews' => 5,
                'slides_to_show' => 3,
                'slides_to_scroll' => 1,
                'autoplay' => 'true',
                'autoplay_speed' => 3000,
                'arrows' => 'true',
                'dots' => 'true',
                'theme' => 'light',
            ),
            $atts,
            'rise_google_reviews_slider'
        );
        
        // Sanitize attributes
        $min_rating = max(1, min(5, intval($atts['min_rating'])));
        $max_reviews = max(1, intval($atts['max_reviews']));
        $slides_to_show = max(1, intval($atts['slides_to_show']));
        $slides_to_scroll = max(1, intval($atts['slides_to_scroll']));
        $autoplay = filter_var($atts['autoplay'], FILTER_VALIDATE_BOOLEAN);
        $autoplay_speed = max(1000, intval($atts['autoplay_speed']));
        $arrows = filter_var($atts['arrows'], FILTER_VALIDATE_BOOLEAN);
        $dots = filter_var($atts['dots'], FILTER_VALIDATE_BOOLEAN);
        $theme = in_array($atts['theme'], array('light', 'dark')) ? $atts['theme'] : 'light';
        
        // Get reviews
        $place_data = $this->api->get_reviews($min_rating, $max_reviews);
        
        if (is_wp_error($place_data)) {
            return '<div class="rise-gr-error">' . esc_html($place_data->get_error_message()) . '</div>';
        }
        
        if (empty($place_data['reviews'])) {
            return '<div class="rise-gr-error">' . esc_html__('No reviews found.', 'rise-google-reviews') . '</div>';
        }
        
        // Prepare slider settings
        $slider_settings = array(
            'slidesToShow' => $slides_to_show,
            'slidesToScroll' => $slides_to_scroll,
            'autoplay' => $autoplay,
            'autoplaySpeed' => $autoplay_speed,
            'arrows' => $arrows,
            'dots' => $dots,
            'responsive' => array(
                array(
                    'breakpoint' => 768,
                    'settings' => array(
                        'slidesToShow' => min(2, $slides_to_show),
                    ),
                ),
                array(
                    'breakpoint' => 480,
                    'settings' => array(
                        'slidesToShow' => 1,
                    ),
                ),
            ),
        );
        
        // Start output buffer
        ob_start();
        
        // Include template
        include RISE_GR_PLUGIN_DIR . 'templates/slider.php';
        
        // Return output
        return ob_get_clean();
    }

    /**
     * Render badge shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string Shortcode output
     */
    public function render_badge_shortcode($atts) {
        $atts = shortcode_atts(
            array(
                'min_rating' => 1,
                'max_reviews' => 5,
                'position' => 'bottom-right',
                'theme' => 'light',
                'show_reviews' => 'true',
            ),
            $atts,
            'rise_google_reviews_badge'
        );
        
        // Sanitize attributes
        $min_rating = max(1, min(5, intval($atts['min_rating'])));
        $max_reviews = max(1, intval($atts['max_reviews']));
        $position = in_array($atts['position'], array('top-left', 'top-right', 'bottom-left', 'bottom-right')) ? $atts['position'] : 'bottom-right';
        $theme = in_array($atts['theme'], array('light', 'dark')) ? $atts['theme'] : 'light';
        $show_reviews = filter_var($atts['show_reviews'], FILTER_VALIDATE_BOOLEAN);
        
        // Get reviews
        $place_data = $this->api->get_reviews($min_rating, $max_reviews);
        
        if (is_wp_error($place_data)) {
            return '<div class="rise-gr-error">' . esc_html($place_data->get_error_message()) . '</div>';
        }
        
        // Start output buffer
        ob_start();
        
        // Include template
        include RISE_GR_PLUGIN_DIR . 'templates/badge.php';
        
        // Return output
        return ob_get_clean();
    }
    
    /**
     * Render minimalist cards shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string Shortcode output
     */
    public function render_cards_shortcode($atts) {
        $atts = shortcode_atts(
            array(
                'min_rating' => 1,
                'max_reviews' => 5,
                'slides_to_show' => 3,
                'slides_to_scroll' => 1,
                'autoplay' => 'true',
                'autoplay_speed' => 3000,
                'arrows' => 'true',
                'dots' => 'true',
                'theme' => 'light',
                'show_stars' => 'true',
                'show_date' => 'true',
                'card_style' => 'rounded', // rounded, square, minimal
            ),
            $atts,
            'rise_google_reviews_cards'
        );
        
        // Sanitize attributes
        $min_rating = max(1, min(5, intval($atts['min_rating'])));
        $max_reviews = max(1, intval($atts['max_reviews']));
        $slides_to_show = max(1, intval($atts['slides_to_show']));
        $slides_to_scroll = max(1, intval($atts['slides_to_scroll']));
        $autoplay = filter_var($atts['autoplay'], FILTER_VALIDATE_BOOLEAN);
        $autoplay_speed = max(1000, intval($atts['autoplay_speed']));
        $arrows = filter_var($atts['arrows'], FILTER_VALIDATE_BOOLEAN);
        $dots = filter_var($atts['dots'], FILTER_VALIDATE_BOOLEAN);
        $theme = in_array($atts['theme'], array('light', 'dark')) ? $atts['theme'] : 'light';
        $show_stars = filter_var($atts['show_stars'], FILTER_VALIDATE_BOOLEAN);
        $show_date = filter_var($atts['show_date'], FILTER_VALIDATE_BOOLEAN);
        $card_style = in_array($atts['card_style'], array('rounded', 'square', 'minimal')) ? $atts['card_style'] : 'rounded';
        
        // Get reviews
        $place_data = $this->api->get_reviews($min_rating, $max_reviews);
        
        if (is_wp_error($place_data)) {
            return '<div class="rise-gr-error">' . esc_html($place_data->get_error_message()) . '</div>';
        }
        
        if (empty($place_data['reviews'])) {
            return '<div class="rise-gr-error">' . esc_html__('No reviews found.', 'rise-google-reviews') . '</div>';
        }
        
        // Prepare slider settings
        $slider_settings = array(
            'slidesToShow' => $slides_to_show,
            'slidesToScroll' => $slides_to_scroll,
            'autoplay' => $autoplay,
            'autoplaySpeed' => $autoplay_speed,
            'arrows' => $arrows,
            'dots' => $dots,
            'responsive' => array(
                array(
                    'breakpoint' => 768,
                    'settings' => array(
                        'slidesToShow' => min(2, $slides_to_show),
                    ),
                ),
                array(
                    'breakpoint' => 480,
                    'settings' => array(
                        'slidesToShow' => 1,
                    ),
                ),
            ),
        );
        
        // Start output buffer
        ob_start();
        
        // Include template
        include RISE_GR_PLUGIN_DIR . 'templates/cards.php';
        
        // Return output
        return ob_get_clean();
    }
}

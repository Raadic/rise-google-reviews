<?php
/**
 * Slider template
 *
 * @since      1.0.0
 * @package    Rise_Google_Reviews
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Variables available:
// $place_data - Array of place data
// $slider_settings - Array of slider settings
// $theme - Theme (light/dark)
?>

<div class="rise-gr-slider-container rise-gr-theme-<?php echo esc_attr($theme); ?>" data-settings="<?php echo esc_attr(wp_json_encode($slider_settings)); ?>">
    <div class="rise-gr-header">
        <div class="rise-gr-place-info">
            <h3 class="rise-gr-place-name"><?php echo esc_html($place_data['name']); ?></h3>
            <div class="rise-gr-place-rating">
                <div class="rise-gr-stars">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <?php if ($i <= round($place_data['rating'])) : ?>
                            <span class="rise-gr-star rise-gr-star-full">★</span>
                        <?php elseif ($i - 0.5 <= $place_data['rating']) : ?>
                            <span class="rise-gr-star rise-gr-star-half">★</span>
                        <?php else : ?>
                            <span class="rise-gr-star rise-gr-star-empty">☆</span>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <span class="rise-gr-rating-text">
                    <?php 
                    /* translators: %s: rating value */
                    echo sprintf(esc_html__('%s out of 5 stars', 'rise-google-reviews'), esc_html($place_data['rating'])); 
                    ?>
                </span>
            </div>
            <?php if (!empty($place_data['vicinity'])) : ?>
                <div class="rise-gr-place-address"><?php echo esc_html($place_data['vicinity']); ?></div>
            <?php endif; ?>
        </div>
        <div class="rise-gr-google-logo">
            <a href="https://search.google.com/local/reviews?placeid=<?php echo esc_attr(get_option('rise_gr_place_id')); ?>" target="_blank" rel="noopener noreferrer">
                <img src="<?php echo esc_url(RISE_GR_PLUGIN_URL . 'public/images/google-logo.png'); ?>" alt="Google">
            </a>
        </div>
    </div>
    
    <div class="rise-gr-slider">
        <?php foreach ($place_data['reviews'] as $review) : ?>
            <div class="rise-gr-review-slide">
                <div class="rise-gr-review-inner">
                    <div class="rise-gr-review-header">
                        <?php if (!empty($review['profile_photo_url'])) : ?>
                            <div class="rise-gr-author-image">
                                <img src="<?php echo esc_url($review['profile_photo_url']); ?>" alt="<?php echo esc_attr($review['author_name']); ?>">
                            </div>
                        <?php endif; ?>
                        <div class="rise-gr-author-info">
                            <div class="rise-gr-author-name">
                                <?php if (!empty($review['author_url'])) : ?>
                                    <a href="<?php echo esc_url($review['author_url']); ?>" target="_blank" rel="noopener noreferrer">
                                        <?php echo esc_html($review['author_name']); ?>
                                    </a>
                                <?php else : ?>
                                    <?php echo esc_html($review['author_name']); ?>
                                <?php endif; ?>
                            </div>
                            <div class="rise-gr-review-date"><?php echo esc_html($review['relative_time']); ?></div>
                        </div>
                    </div>
                    
                    <div class="rise-gr-review-rating">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <?php if ($i <= $review['rating']) : ?>
                                <span class="rise-gr-star rise-gr-star-full">★</span>
                            <?php else : ?>
                                <span class="rise-gr-star rise-gr-star-empty">☆</span>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    
                    <?php if (!empty($review['text'])) : ?>
                        <div class="rise-gr-review-text">
                            <?php 
                            $text = $review['text'];
                            // Truncate if too long
                            if (strlen($text) > 200) {
                                $text = substr($text, 0, 200) . '...';
                            }
                            echo esc_html($text); 
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
/**
 * Minimalist Cards template
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
// $show_stars - Whether to show stars
// $show_date - Whether to show date
// $card_style - Card style (rounded, square, minimal)
?>

<div class="rise-gr-cards-container rise-gr-theme-<?php echo esc_attr($theme); ?> rise-gr-style-<?php echo esc_attr($card_style); ?>" data-settings="<?php echo esc_attr(wp_json_encode($slider_settings)); ?>">
    <div class="rise-gr-cards-slider">
        <?php foreach ($place_data['reviews'] as $review) : ?>
            <div class="rise-gr-card-slide">
                <div class="rise-gr-card-inner">
                    <div class="rise-gr-card-header">
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
                            <?php if ($show_date && !empty($review['relative_time'])) : ?>
                                <div class="rise-gr-review-date"><?php echo esc_html($review['relative_time']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if ($show_stars) : ?>
                        <div class="rise-gr-review-rating">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <?php if ($i <= $review['rating']) : ?>
                                    <span class="rise-gr-star rise-gr-star-full">★</span>
                                <?php else : ?>
                                    <span class="rise-gr-star rise-gr-star-empty">☆</span>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($review['text'])) : ?>
                        <div class="rise-gr-review-text">
                            <?php 
                            $text = $review['text'];
                            // Truncate if too long
                            if (strlen($text) > 150) {
                                $text = substr($text, 0, 150) . '...';
                            }
                            echo esc_html($text); 
                            ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="rise-gr-card-footer">
                        <img src="<?php echo esc_url(RISE_GR_PLUGIN_URL . 'public/images/google-icon.png'); ?>" alt="Google" class="rise-gr-google-icon">
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
/**
 * Badge template
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
// $position - Badge position (top-left, top-right, bottom-left, bottom-right)
// $theme - Theme (light/dark)
// $show_reviews - Whether to show reviews in popup (true/false)
?>

<div class="rise-gr-badge rise-gr-badge-<?php echo esc_attr($position); ?> rise-gr-theme-<?php echo esc_attr($theme); ?>">
    <div class="rise-gr-badge-trigger">
        <div class="rise-gr-badge-inner">
            <div class="rise-gr-badge-rating">
                <span class="rise-gr-badge-rating-value"><?php echo esc_html(number_format($place_data['rating'], 1)); ?></span>
                <div class="rise-gr-badge-stars">
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
            </div>
            <div class="rise-gr-badge-info">
                <div class="rise-gr-badge-name"><?php echo esc_html($place_data['name']); ?></div>
                <div class="rise-gr-badge-based">
                    <?php 
                    /* translators: %d: number of reviews */
                    echo sprintf(esc_html(_n('Based on %d review', 'Based on %d reviews', count($place_data['reviews']), 'rise-google-reviews')), count($place_data['reviews'])); 
                    ?>
                </div>
            </div>
            <div class="rise-gr-badge-logo">
                <img src="<?php echo esc_url(RISE_GR_PLUGIN_URL . 'public/images/google-icon.png'); ?>" alt="Google">
            </div>
        </div>
    </div>
    
    <?php if ($show_reviews) : ?>
    <div class="rise-gr-badge-popup">
        <div class="rise-gr-badge-popup-inner">
            <div class="rise-gr-badge-popup-header">
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
                <button class="rise-gr-badge-popup-close" aria-label="<?php esc_attr_e('Close', 'rise-google-reviews'); ?>">×</button>
            </div>
            
            <div class="rise-gr-badge-popup-reviews">
                <?php foreach ($place_data['reviews'] as $review) : ?>
                    <div class="rise-gr-review-item">
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
                                <?php echo esc_html($review['text']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="rise-gr-badge-popup-footer">
                <a href="https://search.google.com/local/reviews?placeid=<?php echo esc_attr(get_option('rise_gr_place_id')); ?>" target="_blank" rel="noopener noreferrer" class="rise-gr-view-all">
                    <?php esc_html_e('View all reviews', 'rise-google-reviews'); ?>
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

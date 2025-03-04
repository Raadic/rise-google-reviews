/**
 * Rise Google Reviews - Public JavaScript
 */
(function($) {
    'use strict';

    /**
     * Initialize sliders
     */
    function initSliders() {
        // Initialize regular sliders
        $('.rise-gr-slider').each(function() {
            const $slider = $(this);
            const $container = $slider.closest('.rise-gr-slider-container');
            const settings = $container.data('settings') || {};
            
            $slider.slick(settings);
        });
        
        // Initialize cards sliders
        $('.rise-gr-cards-slider').each(function() {
            const $slider = $(this);
            const $container = $slider.closest('.rise-gr-cards-container');
            const settings = $container.data('settings') || {};
            
            $slider.slick(settings);
        });
    }

    /**
     * Initialize badges
     */
    function initBadges() {
        const $badges = $('.rise-gr-badge');
        
        // Badge click handler
        $badges.each(function() {
            const $badge = $(this);
            const $trigger = $badge.find('.rise-gr-badge-trigger');
            const $popup = $badge.find('.rise-gr-badge-popup');
            
            if ($popup.length) {
                // Open popup on badge click
                $trigger.on('click', function(e) {
                    e.preventDefault();
                    $popup.fadeIn(200);
                    $('body').addClass('rise-gr-popup-open');
                });
                
                // Close popup on close button click
                $popup.find('.rise-gr-badge-popup-close').on('click', function(e) {
                    e.preventDefault();
                    $popup.fadeOut(200);
                    $('body').removeClass('rise-gr-popup-open');
                });
                
                // Close popup on background click
                $popup.on('click', function(e) {
                    if ($(e.target).is($popup)) {
                        $popup.fadeOut(200);
                        $('body').removeClass('rise-gr-popup-open');
                    }
                });
                
                // Close popup on ESC key
                $(document).on('keydown', function(e) {
                    if (e.key === 'Escape' && $popup.is(':visible')) {
                        $popup.fadeOut(200);
                        $('body').removeClass('rise-gr-popup-open');
                    }
                });
            }
        });
    }

    // Initialize when document is ready
    $(document).ready(function() {
        initSliders();
        initBadges();
    });

})(jQuery);

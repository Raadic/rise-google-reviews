/**
 * Rise Google Reviews - Admin JavaScript
 */
(function($) {
    'use strict';

    /**
     * Initialize tabs
     */
    function initTabs() {
        const $tabs = $('.rise-gr-admin-tabs');
        
        if ($tabs.length) {
            const $navLinks = $tabs.find('.nav-tab');
            const $tabPanes = $tabs.find('.tab-pane');
            
            $navLinks.on('click', function(e) {
                e.preventDefault();
                
                const target = $(this).attr('href');
                
                // Update active tab
                $navLinks.removeClass('nav-tab-active');
                $(this).addClass('nav-tab-active');
                
                // Show target tab
                $tabPanes.removeClass('active');
                $(target).addClass('active');
                
                // Save active tab in localStorage
                if (typeof localStorage !== 'undefined') {
                    localStorage.setItem('rise_gr_active_tab', target);
                }
            });
            
            // Restore active tab from localStorage
            if (typeof localStorage !== 'undefined') {
                const activeTab = localStorage.getItem('rise_gr_active_tab');
                
                if (activeTab && $tabs.find(`a[href="${activeTab}"]`).length) {
                    $tabs.find(`a[href="${activeTab}"]`).trigger('click');
                }
            }
        }
    }

    /**
     * Initialize clear cache button
     */
    function initClearCache() {
        const $clearCacheBtn = $('#rise-gr-clear-cache');
        
        if ($clearCacheBtn.length) {
            $clearCacheBtn.on('click', function(e) {
                e.preventDefault();
                
                const $btn = $(this);
                const originalText = $btn.text();
                
                // Disable button and show loading state
                $btn.prop('disabled', true).text('Clearing...');
                
                // Send AJAX request
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'rise_gr_clear_cache',
                        nonce: rise_gr_admin.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            $btn.text('Cache Cleared!');
                            
                            setTimeout(function() {
                                $btn.text(originalText).prop('disabled', false);
                            }, 2000);
                        } else {
                            $btn.text('Error!');
                            
                            setTimeout(function() {
                                $btn.text(originalText).prop('disabled', false);
                            }, 2000);
                            
                            console.error('Error clearing cache:', response.data);
                        }
                    },
                    error: function(xhr, status, error) {
                        $btn.text('Error!');
                        
                        setTimeout(function() {
                            $btn.text(originalText).prop('disabled', false);
                        }, 2000);
                        
                        console.error('AJAX error:', error);
                    }
                });
            });
        }
    }

    // Initialize when document is ready
    $(document).ready(function() {
        initTabs();
        initClearCache();
    });

})(jQuery);

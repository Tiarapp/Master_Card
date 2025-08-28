/**
 * Select2 Standalone Initialization
 * Isolated implementation to avoid conflicts with other scripts
 */

(function() {
    'use strict';
    
    // Wait for DOM and other scripts to load
    function initSelect2Safely() {
        console.log('🚀 Safe Select2 Initialization Starting...');
        
        // Check jQuery availability
        if (typeof window.jQuery === 'undefined') {
            console.error('❌ jQuery not found');
            return false;
        }
        
        const $ = window.jQuery;
        
        // Check Select2 availability
        if (typeof $.fn.select2 === 'undefined') {
            console.error('❌ Select2 not found');
            return false;
        }
        
        console.log('✅ jQuery and Select2 available');
        
        try {
            // Configuration
            const config = {
                theme: 'bootstrap4',
                width: '100%',
                allowClear: true,
                escapeMarkup: function (markup) {
                    return markup;
                },
                language: {
                    noResults: function() {
                        return "Tidak ada hasil ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    }
                }
            };
            
            // Initialize filters
            const filters = [
                { id: '#jenis_filter', placeholder: '-- Pilih Jenis --', search: true },
                { id: '#gsm_filter', placeholder: '-- Pilih GSM --', search: 5 },
                { id: '#lebar_filter', placeholder: '-- Pilih Lebar --', search: 5 },
                { id: '#supplier_filter', placeholder: '-- Pilih Supplier --', search: true }
            ];
            
            filters.forEach(function(filter) {
                const element = $(filter.id);
                if (element.length > 0) {
                    try {
                        const filterConfig = Object.assign({}, config, {
                            placeholder: filter.placeholder,
                            minimumResultsForSearch: filter.search === true ? 0 : filter.search
                        });
                        
                        element.select2(filterConfig);
                        console.log('✅ Initialized:', filter.id);
                    } catch (e) {
                        console.error('❌ Failed to initialize:', filter.id, e);
                    }
                }
            });
            
            // Event handlers
            $('.select2').off('change.safeSelect2').on('change.safeSelect2', function() {
                console.log('Filter changed:', $(this).attr('id'), '=', $(this).val());
            });
            
            $('#clearFilters').off('click.safeSelect2').on('click.safeSelect2', function(e) {
                e.preventDefault();
                $('.select2').val(null).trigger('change');
                console.log('All filters cleared');
            });
            
            console.log('🎉 Safe Select2 initialization completed successfully!');
            return true;
            
        } catch (error) {
            console.error('❌ Error in safe Select2 initialization:', error);
            return false;
        }
    }
    
    // Multiple initialization attempts
    function attemptInit() {
        let attempts = 0;
        const maxAttempts = 5;
        
        function tryInit() {
            attempts++;
            console.log(`Attempt ${attempts}/${maxAttempts} to initialize Select2...`);
            
            if (initSelect2Safely()) {
                return; // Success
            }
            
            if (attempts < maxAttempts) {
                setTimeout(tryInit, 1000 * attempts); // Exponential backoff
            } else {
                console.error('❌ Failed to initialize Select2 after', maxAttempts, 'attempts');
            }
        }
        
        tryInit();
    }
    
    // Start initialization when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(attemptInit, 500);
        });
    } else {
        setTimeout(attemptInit, 500);
    }
    
})();

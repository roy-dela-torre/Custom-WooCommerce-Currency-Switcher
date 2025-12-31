jQuery(document).ready(function($) {
    
    // Toggle currency switcher dropdown
    $('.cwc-switcher-toggle').on('click', function(e) {
        e.preventDefault();
        $('.cwc-switcher-dropdown').slideToggle(200);
    });
    
    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.cwc-currency-switcher').length) {
            $('.cwc-switcher-dropdown').slideUp(200);
        }
    });
    
    // Handle currency selection
    $('.cwc-currency-option').on('click', function(e) {
        e.preventDefault();
        
        var currencyId = $(this).data('id');
        var currencyText = $(this).find('.cwc-symbol').text() + ' ' + $(this).find('.cwc-code').text().replace('(', '').replace(')', '');
        
        // Show loading state
        $('.cwc-current-currency').html('<span class="cwc-loading">...</span>');
        
        // Send AJAX request
        $.ajax({
            url: cwc_frontend.ajax_url,
            type: 'POST',
            data: {
                action: 'cwc_switch_currency',
                currency_id: currencyId,
                nonce: cwc_frontend.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Update display
                    $('.cwc-current-currency').text(currencyText);
                    $('.cwc-switcher-dropdown').slideUp(200);
                    
                    // Reload page to update all prices
                    location.reload();
                } else {
                    alert(response.data.message || 'Error switching currency');
                    $('.cwc-current-currency').text(currencyText);
                }
            },
            error: function() {
                alert('Error switching currency. Please try again.');
                location.reload();
            }
        });
    });
    
});

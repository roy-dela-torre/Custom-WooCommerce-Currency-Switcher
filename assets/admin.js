jQuery(document).ready(function($) {
    
    // Delete currency
    $('.cwc-delete-currency').on('click', function(e) {
        e.preventDefault();
        
        if (!confirm(cwc_admin.confirm_delete)) {
            return;
        }
        
        var button = $(this);
        var currencyId = button.data('id');
        var row = button.closest('tr');
        
        // Disable button
        button.prop('disabled', true).text('Deleting...');
        
        $.ajax({
            url: cwc_admin.ajax_url,
            type: 'POST',
            data: {
                action: 'cwc_delete_currency',
                currency_id: currencyId,
                nonce: cwc_admin.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Remove row with animation
                    row.fadeOut(300, function() {
                        $(this).remove();
                        
                        // Show success message
                        if ($('.wrap .notice-success').length === 0) {
                            $('.wrap h1').after('<div class="notice notice-success is-dismissible"><p>' + response.data.message + '</p></div>');
                        }
                    });
                } else {
                    alert(response.data.message || 'Error deleting currency');
                    button.prop('disabled', false).text('Delete');
                }
            },
            error: function() {
                alert('Error deleting currency. Please try again.');
                button.prop('disabled', false).text('Delete');
            }
        });
    });
    
    // Form validation
    $('form[action*="cwc-currencies"]').on('submit', function(e) {
        var multiplier = parseFloat($('#multiplier').val());
        
        if (multiplier < 0) {
            e.preventDefault();
            alert('Multiplier must be a positive number');
            $('#multiplier').focus();
            return false;
        }
        
        var currencyCode = $('#currency_code').val().trim();
        if (currencyCode.length < 2 || currencyCode.length > 10) {
            e.preventDefault();
            alert('Currency code must be between 2 and 10 characters');
            $('#currency_code').focus();
            return false;
        }
    });
    
    // Auto-uppercase currency code
    $('#currency_code').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });
    
    // Format multiplier on blur
    $('#multiplier').on('blur', function() {
        var value = parseFloat($(this).val());
        if (!isNaN(value)) {
            $(this).val(value.toFixed(6));
        }
    });
    
});

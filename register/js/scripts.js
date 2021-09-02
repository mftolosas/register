(function ($, Drupal, drupalSettings) {
    $( document ).ready(function() {        
        $('#edit-mobile-number, #edit-candidate-age').keypress(function (e) {    
            var charCode = (e.which) ? e.which : event.keyCode    
            if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                return false;                        
        });
        $('#edit-candidate-name, #edit-web-site').keypress(function(e) {
            var key = e.keyCode;
            if (key >= 48 && key <= 57)
                e.preventDefault();
        });
    });
} (jQuery, Drupal, drupalSettings));
'use strict';

import Forward from '../common/core.min.js';

export const name = 'forward-login';
export default function() {
    Forward.console('[Module] Login imported');
}

/**
 * FORM
 * Sign In
 */
(function() {
    jQuery('#login-form').on('submit', function(e) {
        e.preventDefault();

        if (jQuery('#login-alert').is(':visible')) {
            jQuery('#login-alert').slideToggle();
        }

        jQuery.ajax({
            url: forward.ajax,
            type: 'post',
            data: jQuery("#login-form").serialize(),
            success: function(e) {
                //console.log(e);
                if (e == 's01') {
                    location.reload();
                } else {
                    jQuery('#login-alert').slideToggle();
                }
            },
            fail: function(xhr, textStatus, errorThrown) {
                jQuery('#login-alert').slideToggle();
            }
        });
    });
}());
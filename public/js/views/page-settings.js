'use strict';

import Forward from '../common/core.min.js';

export const name = 'forward-settings';
export default function() {
    Forward.console('[Module] Settings imported');
}

/**
 * FORM
 * Save settings
 */
(function() {
    jQuery('#settings-form').on('submit', function(e) {
        e.preventDefault();

        Forward.ajax(jQuery(this).serialize(),
            function(e) {
                if (e == 's01') {
                    Forward.toast(Forward.__('success'), 'The settings have been saved!', 6000, 'success');
                } else {
                    Forward.toast(Forward.__('error'), 'Settings could not be saved!', 6000, 'alert');
                }
                console.log(e);
            });
    });
}());
'use strict';

import Forward from '../common/core.min.js';

export const name = 'forward-install';
export default function() {
    Forward.console('[Module] Install imported');
}

/**
 * FORM
 * Install
 */
(function() {
    jQuery('#install-forward').on('click', function(e) {
        e.preventDefault();

        jQuery('#install-forward').attr('disabled', 'disabled');
        jQuery('#install-form > div, #install-forward, #install-form-alert').fadeOut(200);
        jQuery('#install-form').slideUp(400, function() {
            jQuery('#install-progress').slideDown(400);
        });

        jQuery.ajax({
            url: forward.baseurl,
            type: 'post',
            data: {
                action: 'setup',
                input_scriptname: jQuery('#input_scriptname').val(),
                input_baseuri: jQuery('#input_baseuri').val(),
                input_db_name: jQuery('#input_db_name').val(),
                input_db_user: jQuery('#input_db_user').val(),
                input_db_host: jQuery('#input_db_host').val(),
                input_db_password: jQuery('#input_db_password').val(),
                input_user_name: jQuery('#input_user_name').val(),
                input_user_password: jQuery('#input_user_password').val(),
            },
            success: function(e) {
                console.log(e);
                if (Forward.isJson(e) && e != null) {
                    let result = JSON.parse(e);

                    if (result.status == 'error') {
                        window.setTimeout(function() {
                            jQuery('#install-form, #install-form-alert').hide();
                            jQuery('#install-form > div, #install-forward, #install-progress').show();

                            jQuery('#install-form-alert > span').html(result.message);

                            jQuery('#install-progress').slideUp(400, function() {
                                jQuery('#install-forward').removeAttr('disabled');
                                jQuery('#install-form').slideDown(400, function(e) {
                                    jQuery('#install-form-alert').slideDown(400);
                                });
                            });
                        }, 1500);


                    } else if (result.status == 'success') {
                        window.setTimeout(function() {
                            jQuery('#install-progress').fadeOut(400, function() {
                                jQuery('#install-done').fadeIn(400);
                                window.setTimeout(function() {
                                    window.location.href = jQuery('#input_baseuri').val() + 'dashboard';
                                }, 3000);
                            });
                        }, 1000);
                    }
                } else {
                    console.log('error');
                }
            },
            fail: function(xhr, textStatus, errorThrown) {
                jQuery('#install-progress').slideUp(400);
                console.log(xhr);
                console.log(textStatus);
                alert(errorThrown);
            }
        });
    });
}());
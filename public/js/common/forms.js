'use strict';

import Forward from './core.min.js';

export const name = 'forward-forms';
export default function() {
    Forward.console('[Module] Forms imported');
}

/**
 * FORM
 * Add user
 */
(function() {
    jQuery('#user-add-form').on('submit', function(e) {
        e.preventDefault();

        Forward.ajax(jQuery(this).serialize(),
            function(e) {
                if (e == 's01') {
                    jQuery('#input_user_username, #input_user_display_name, #input_user_email, #input_user_password, #input_user_password_confirm').val('');
                    Forward.toast(Forward.__('success'), 'New user successfully added!', 6000, 'success');
                } else {

                    let errorMessage = 'The new user could not be added';

                    switch (e) {
                        case 'e00':
                            errorMessage = "E00 - Unknown error";
                            break;
                        case 'e05':
                            errorMessage = "No permission";
                            break;
                        case 'e06':
                            errorMessage = "Missing arguments";
                            break;
                        case 'e07':
                            errorMessage = "Empty arguments";
                            break;
                        case 'e12':
                            errorMessage = "Passwords does not match";
                            break;
                        case 'e13':
                            errorMessage = "Password too short";
                            break;
                        case 'e15':
                            errorMessage = "Invalid email";
                            break;
                        case 'e16':
                            errorMessage = "Username with special characters";
                            break;
                        case 'e17':
                            errorMessage = "User with provided email exists";
                            break;
                        case 'e18':
                            errorMessage = "User with provided username exists";
                            break;
                        case 'e19':
                            errorMessage = "Unknown MySQL error";
                            break;
                    }
                    Forward.toast(Forward.__('error'), errorMessage, 6000, 'alert');
                }
                console.log(e);
            });
    });
}());



/**
 * FORM
 * Change password
 */
(function() {
    jQuery('#user-change_password').on('submit', function(e) {
        e.preventDefault();

        Forward.ajax(jQuery(this).serialize(),
            function(e) {
                switch (e) {
                    case 's01':
                        jQuery('#input_user_new_password, #input_user_new_password_confirm').val('');
                        Forward.toast(Forward.__('success'), 'User password has been changed', 6000, 'success');
                        break;
                    case 'e07':
                        Forward.toast(Forward.__('error'), 'You must complete all the fields', 6000, 'alert');
                        break;
                    case 'e12':
                        Forward.toast(Forward.__('error'), 'The passwords do not match', 6000, 'alert');
                        break;
                    case 'e13':
                        Forward.toast(Forward.__('error'), 'Password is too short', 6000, 'alert');
                        break;
                    default:
                        Forward.toast(Forward.__('error'), 'Password update failed. Unknown error.', 6000, 'alert');
                        break;
                }
                console.log(e);
            });
    });
}());

/**
 * FORM
 * Update user
 */
(function() {
    jQuery('#user-update').on('submit', function(e) {
        e.preventDefault();

        Forward.ajax(jQuery(this).serialize(),
            function(e) {
                if (e == 's01') {
                    Forward.toast(Forward.__('success'), 'User data has been updated', 6000, 'success');
                } else {
                    Forward.toast(Forward.__('error'), 'User data could not be updated!', 6000, 'alert');
                }
                console.log(e);
            });
    });
}());
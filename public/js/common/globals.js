'use strict';

import Forward from './core.min.js';

export const name = 'forward-global';
export default function() {
    Forward.console('[Module] Globals imported');
}

//Sort tables
(function() {
    jQuery('table.sortable').each(function(index) {
        jQuery(this).tablesort();
    });
}());

/**
 * Show/hide password
 */
(function() {
    jQuery('.input-password-preview a').on('click', function(event) {
        event.preventDefault();
        let parent = jQuery(this).parent().parent();
        let passwordBox = parent.children('input.input-password-preview__field');

        if (passwordBox.attr('type') == 'text') {
            passwordBox.attr('type', 'password');

            parent.addClass('password-hidden');
            parent.removeClass('password-visible');
        } else if (passwordBox.attr('type') == 'password' && passwordBox.val().length < 1) {
            passwordBox.attr('type', 'text');

            parent.addClass('password-visible');
            parent.removeClass('password-hidden');
        }
    });
}());

/**
 * Show password strength
 */
(function() {
    jQuery('.password_strength_control').each(function(e) {
        let fieldData = jQuery(this).data();
        let targetClass = 'def_password--strength';

        if ('strengthTarget' in fieldData) {
            targetClass = fieldData['strengthTarget'];
        }

        jQuery(this).on('change paste keyup', function() {
            let e = jQuery(this).val(),
                s = zxcvbn(e);
            "" !== e ? jQuery('.' + targetClass).html(Forward.__('strength') + ": <strong>" + {
                0: Forward.__('worst') + " ☹",
                1: Forward.__('bad') + " ☹",
                2: Forward.__('weak') + " ☹",
                3: Forward.__('good') + " 🙃",
                4: Forward.__('strong') + " 🙂"
            }[s.score] + "</strong><br/><span style='display:block;margin-bottom:.8rem;' class='feedback'>" + s.feedback.warning + " " + s.feedback.suggestions + "</span>") : jQuery('.' + targetClass).html('')
        });
    });
}());

/**
 * FORM
 * Quick add
 */
(function() {
    jQuery('.forward-header__navigation__form').on('submit', function(e) {
        e.preventDefault();
        Forward.console('New record via Quick Add');

        let target = jQuery('#input-record-url').val();

        Forward.ajax(jQuery(this).serialize(),
            function(e) {
                if (e == 's01') {
                    let slug = jQuery('#input-record-slug').val();
                    if (slug == '') {
                        slug = jQuery('#input-rand-value').val();
                    }
                    let url = forward.baseurl + slug;
                    let target_shorted = jQuery('#input-record-url').val();
                    let date = new Date();
                    date = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

                    Forward.toast('Success!', 'New record has been added', 6000, 'success');
                    if (forward.pagenow == 'dashboard') {
                        appendRecordToList(-1, slug, target, 0);
                    }
                } else {

                    let error_text = Forward.__('e1');

                    if (e == 'e07') {
                        error_text = Forward.__('e7');
                    } else if (e == 'e08') {
                        error_text = Forward.__('e8');
                    } else if (e == 'e10') {
                        error_text = Forward.__('e10');
                    }

                    Forward.toast(Forward.__('error_qa'), error_text, 6000, 'alert');
                }
                console.log(e);
            });
    });
}());
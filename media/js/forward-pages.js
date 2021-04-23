/*!
 * Forward 2.0.2 (https://github.com/rapiddev/Forward)
 * Copyright 2018-2021 RapidDev
 * Licensed under MIT (https://github.com/rapiddev/Forward/blob/master/LICENSE)
 */

/**
 * show_hide_password
 */
jQuery('#show_hide_password a').on('click', function(event) {
    event.preventDefault();

    if (jQuery('#show_hide_password input').attr("type") == "text") {
        jQuery('#show_hide_password input').attr('type', 'password');
    } else if (jQuery('#show_hide_password input').attr("type") == "password") {
        jQuery('#show_hide_password input').attr('type', 'text');
    }
});

/**
 * appendRecordToList
 */
function appendRecordToList(id, slug, target, url, clicks) {
    jQuery('.records-list__container').prepend('<div class="records-list__record record-' +
        id + '" data-clipboard-text="' + forward.baseurl + slug + '" data-id="' +
        id + '"><p>/' +
        slug + '</p><span>' +
        target + '</span><h4>' +
        clicks + '</h4></div>');
}

/**
 * appendRecordToList
 */
jQuery('.forward-header__navigation__form').on('submit', function(e) {
    e.preventDefault();
    Forward.console('New record via Quick Add');

    let target = jQuery('#input-record-url').val();

    jQuery.ajax({
        url: forward.ajax,
        type: 'post',
        data: jQuery('.forward-header__navigation__form').serialize(),
        success: function(e) {
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
                    appendRecordToList(-1, slug, target, url, 0);
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

                Forward.toast('Quick add error!', error_text, 6000, 'alert');
            }
            console.log(e);
        },
        fail: function(xhr, textStatus, errorThrown) {
            console.log(xhr);
            console.log(textStatus);
            console.log(errorThrown);
            jQuery('#add-alert').slideToggle();
        }
    });
});



/**
 * pageInstall
 * Features for the Install page
 */
function pageInstall() {
    Forward.console('The functions for page Install have been loaded.');
    jQuery("#input_user_password").on("change paste keyup", function() {
        let e = jQuery(this).val(),
            s = zxcvbn(e);
        "" !== e ? jQuery(".def_password--strength").html("Strength: <strong>" + { 0: "Worst ☹", 1: "Bad ☹", 2: "Weak ☹", 3: "Good 🙃", 4: "Strong 🙂" }[s.score] + "</strong><br/><span class='feedback'>" + s.feedback.warning + " " + s.feedback.suggestions + "</span") : jQuery(".def_password--strength").html("")
    });

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
}

/**
 * pageLogin
 * Features for the Login page
 */
function pageLogin() {
    Forward.console('The functions for page Login have been loaded.');

    jQuery("#passsword").on("change paste keyup", function() {
        let e = jQuery(this).val(),
            s = zxcvbn(e);
        "" !== e ? jQuery(".def_password--strength").html("Strength: <strong>" + { 0: "Worst ☹", 1: "Bad ☹", 2: "Weak ☹", 3: "Good 🙃", 4: "Strong 🙂" }[s.score] + "</strong><br/><span class='feedback'>" + s.feedback.warning + " " + s.feedback.suggestions + "</span") : jQuery(".def_password--strength").html("")
    });

    jQuery('#button-form').on('click', function(e) {
        e.preventDefault();
        LoginQuery();
    });

    jQuery('#login-form').on('submit', function(e) {
        e.preventDefault();
        LoginQuery();
    });

    function LoginQuery() {
        if (jQuery('#login-alert').is(':visible')) {
            jQuery('#login-alert').slideToggle();
        }

        jQuery.ajax({
            url: forward.ajax,
            type: 'post',
            data: jQuery("#login-form").serialize(),
            success: function(e) {
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
    }
}

/**
 * pageDashboard
 * Features for the Dashboard page
 */
function pageDashboard() {
    Forward.console('The functions for page Dashboard have been loaded.');

    let clipboard_link = new ClipboardJS('.dashboard__btn--copy-recent');
    clipboard_link.on('success', function(e) {
        //showGlobalSnackbar('Success!', 'The link has been copied to your clipboard!', 4000, 'success');
        Forward.toast('Success!', 'The link has been copied to your clipboard!', 3000, 'success');
    });

    function getRecordById(id) {

    }

    jQuery('.records-list__record').on('click', function(e) {
        console.log(e);
    });

    jQuery('.forward-dashboard__add__form').on('submit', function(e) {
        e.preventDefault();
        Forward.console('New record via Standard Add');

        let target = jQuery('#input-dashboard-record-url').val();
        jQuery.ajax({
            url: forward.ajax,
            type: 'post',
            data: jQuery('.forward-dashboard__add__form').serialize(),
            success: function(e) {
                if (e == 's01') {
                    let slug = jQuery('#input-dashboard-record-slug').val();
                    if (slug == '') {
                        slug = jQuery('#input-dashboard-rand-value').val();
                    }

                    let url = forward.baseurl + slug;
                    let target_shorted = jQuery('#input-record-url').val();
                    let date = new Date();
                    date = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

                    appendRecordToList(-1, slug, target, url, 0);
                    Forward.toast('Success!', 'New record has been added', 6000, 'success');
                } else {

                    let error_text = Forward.__('e1');

                    if (e == 'e07') {
                        error_text = Forward.__('e7');
                    } else if (e == 'e08') {
                        error_text = Forward.__('e8');
                    } else if (e == 'e10') {
                        error_text = Forward.__('e10');
                    }

                    Forward.toast('Error!', error_text, 6000, 'alert');
                }
                console.log(e);
            },
            fail: function(xhr, textStatus, errorThrown) {
                console.log(xhr);
                console.log(textStatus);
                console.log(errorThrown);
                jQuery('#add-alert').slideToggle();
            }
        });
    });
}

/*
let snackbarBottom = -400;
let snackbarThread = null;

function showGlobalSnackbar(header, message, timeout = 3000, type = 'default') {
    snackbarThread = Forward.generateId(9);

    let localDelay = 0;

    let snackbarElement = jQuery('#global-snackbar');
    if (snackbarElement == null || snackbarElement == undefined)
        return;

    snackbarBottom = -(snackbarElement.outerHeight() + 50);

    if (snackbarElement.is(':visible')) {
        localDelay = 300;
        snackbarElement.animate({ 'opacity': 0, 'bottom': snackbarBottom }, 300);

    }
    snackbarElement.delay(localDelay).css('bottom', snackbarBottom + 'px');
    //snackbarElement.slideToggle(300);


    jQuery('#global-snackbar-header').delay(localDelay).html(header);
    jQuery('#global-snackbar-message').delay(localDelay).html(message);
    snackbarBottom = -(snackbarElement.outerHeight() + 50);
    snackbarElement.removeClass('info').removeClass('alert').removeClass('success').removeClass('default');

    switch (type) {
        case 'alert':
            snackbarElement.addClass('alert');
            break;
        case 'success':
            snackbarElement.addClass('success');
            break;
        case 'info':
            snackbarElement.addClass('info');
            break;
        default:
            snackbarElement.addClass('default');
            break;
    }
    //snackbarElement.delay(300).slideToggle(300);
    snackbarElement.delay(localDelay).animate({ 'opacity': 1, 'bottom': 0 }, 300);

    let currentSnackbar = snackbarThread;
    window.setTimeout(function() {

        if (currentSnackbar == snackbarThread && snackbarElement.is(':visible'))
            snackbarElement.animate({ 'opacity': 0, 'bottom': snackbarBottom }, 300);
    }, timeout);
}
jQuery('#global-snackbar-dismiss').on('click', function(e) {
    snackbarThread = Forward.generateId(9);

    let snackbarElement = jQuery('#global-snackbar');
    if (snackbarElement == null || snackbarElement == undefined)
        return;

    if (snackbarElement.is(':visible'))
        snackbarElement.animate({ 'opacity': 0, 'bottom': snackbarBottom }, 300);
});
*/
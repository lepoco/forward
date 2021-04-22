/*!
 * Forward 2.0.2 (https://github.com/rapiddev/Forward)
 * Copyright 2018-2021 RapidDev
 * Licensed under MIT (https://github.com/rapiddev/Forward/blob/master/LICENSE)
 */

/**
 * A simple Chartist plugin to put labels on top of bar charts.
 * https://github.com/yorkshireinteractive/chartist-bar-labels
 *
 * Copyright (c) 2015 Yorkshire Interactive (yorkshireinteractive.com)
 * Modified by RapidDev Leszek Pomianowski (rdev.cc)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.  IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
! function(n, t, e) {
    "use strict";
    let l = { labelClass: "ct-bar-label", labelInterpolationFnc: e.noop, labelOffset: { x: 0, y: 0 }, position: { x: null, y: null } };
    e.plugins = e.plugins || {}, e.plugins.ctBarLabels = function(n, t) {
        let o = (n = e.extend({}, l, n)).position.x || function(t) { return (t.x1 + t.x2) / 2 + n.labelOffset.x },
            a = n.position.y || function(t) { return (t.y1 + t.y2) / 2 + n.labelOffset.y };
        return function(l) { l instanceof e.Bar && (l.on("draw", function(e) { "bar" === e.type && e.group.elem("text", { x: o(e), y: a(e), style: "text-anchor: start" }, n.labelClass + " ct-bar-label-" + e.index).text(n.labelInterpolationFnc(t[e.index])) })) }
    }
}(window, document, Chartist);

/**
 * Array.prototype.forEach
 * Lets use foreach
 */
Array.prototype.forEach || (Array.prototype.forEach = function(r) { let t = this.length; if ("function" != typeof r) throw new TypeError; for (let o = arguments[1], h = 0; h < t; h++) h in this && r.call(o, this[h], h, this) });

/**
 * escapeHtml
 * Credit: https://stackoverflow.com/a/4835406
 */
function escapeHtml(text) {
    let map = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#039;"
    };

    return text.replace(/[&<>"']/g, function(m) {
        return map[m];
    });
}

/**
 * Helper function for converting Objects to Arrays after sorting the keys
 * Credit: PiHole
 */
function objectToArray(obj) {
    let arr = [];
    let idx = [];
    let keys = Object.keys(obj);

    keys.sort(function(a, b) {
        return a - b;
    });

    for (let i = 0; i < keys.length; i++) {
        arr.push(obj[keys[i]]);
        idx.push(keys[i]);
    }

    return [idx, arr];
}

/**
 * jsonParse
 * Verifies that a text string can be represented as json
 */
function jsonParse(string) { if (string == '') { return false; } if (/^[\],:{}\s]*$/.test(string.replace(/\\["\\\/bfnrtu]/g, "@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]").replace(/(?:^|:|,)(?:\s*\[)+/g, ""))) { return true; } else { return false; } }

/**
 * consoleLog
 * Adds a nice way to display logs
 */
function consoleLog(message, color = "#fff") { console.log("%cForward: " + "%c" + message, "color:#dc3545;font-weight: bold;", "color: " + color); }
console.log("==============================\nForward \nversion: " + forward.version + "\nCopyright © 2019-2021 RapidDev\nhttps://rdev.cc/\n==============================");

/**
 * DOMContentLoaded
 * The function starts when all resources are loaded
 */
document.addEventListener('DOMContentLoaded', function() {
    if (forward.usernonce != jQuery('head').attr('user-nonce')) {
        console.log(forward);
        if (forward.page == 'install') {
            themeFunctions();
        }

        throw new Error('User nonce compliance not detected.!');
    }

    consoleLog('JavaScript loaded successfully');
    consoleLog('Base url: ' + forward.baseurl);
    if (forward.pagenow != 'home')
        consoleLog('Ajax gate: ' + forward.ajax);
    consoleLog('Page now: ' + forward.pagenow);
    consoleLog('Nonce: ' + forward.usernonce);

    themeFunctions();
});


/**
 * __T
 * Translates the text string if it exists in the translator object
 */
function __T(text) {
    if (typeof translator == 'undefined') {
        return text;
    } else {
        if (translator.length == 0) {
            return text;
        } else {
            if (text in translator) {
                return translator[text];
            } else {
                return text;
            }
        }
    }
}

/**
 * isMobile
 * Are we in mobile mode
 */
function isMobile() {
    return (jQuery('html').height() < 992);
}

/**
 * show_hide_password
 * Hides or shows the password in the supported form field
 */
jQuery('#show_hide_password a').on('click', function(event) {
    event.preventDefault();

    if (jQuery('#show_hide_password input').attr("type") == "text") {
        jQuery('#show_hide_password input').attr('type', 'password');
    } else if (jQuery('#show_hide_password input').attr("type") == "password") {
        jQuery('#show_hide_password input').attr('type', 'text');
    }
});

function generateId(length) {
    var result = [];
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result.push(characters.charAt(Math.floor(Math.random() *
            charactersLength)));
    }
    return result.join('');
}

function showTimeoutToast(header, message, timeout = 3000, type = 'default') {
    let currentdate = new Date();
    let toastId = 'toast-' + generateId(32);

    let icon = null;
    switch (type) {
        case 'success':
            icon = '<path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/><path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/>';
            break;
        case 'alert':
            icon = '<path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/><path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>';
            break;
        default:
            icon = '<path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>';
            break;
    }

    jQuery('#global-toast-container').append('<div id="' +
        toastId + '" class="toast fade hide"><div class="toast-header"><svg fill="currentColor" width="20" height="20" xmlns="http://www.w3.org/2000/svg" focusable="false">' + icon + '</svg><strong class="me-auto">' +
        header + '</strong><small>' +
        currentdate.getHours() +
        ':' +
        currentdate.getMinutes() +
        ':' +
        currentdate.getSeconds() + '</small></div><div class="toast-body">' +
        message + '</div></div>');

    let toastElement = new bootstrap.Toast(document.getElementById(toastId), { animate: true, delay: timeout });;
    toastElement.show();
}

let snackbarBottom = -400;
let snackbarThread = null;

function showGlobalSnackbar(header, message, timeout = 3000, type = 'default') {
    snackbarThread = generateId(9);

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
    snackbarThread = generateId(9);

    let snackbarElement = jQuery('#global-snackbar');
    if (snackbarElement == null || snackbarElement == undefined)
        return;

    if (snackbarElement.is(':visible'))
        snackbarElement.animate({ 'opacity': 0, 'bottom': snackbarBottom }, 300);
});

/**
 * themeFunctions
 * Triggers the functions of the selected page
 */
function themeFunctions() {
    consoleLog('The main functions of the theme have loaded correctly.');

    jQuery('.forward-header__navigation__form').on('submit', function(e) {
        e.preventDefault();
        consoleLog('New record via Quick Add');

        let target = jQuery('#input-record-url').val();

        jQuery.ajax({
            url: forward.ajax,
            type: 'post',
            data: jQuery('.forward-header__navigation__form').serialize(),
            success: function(e) {
                if (e == 's01') {
                    //jQuery('#add-success').slideToggle();

                    //jQuery('#total_records_count').html(parseInt(jQuery('#total_records_count').html()) + 1);


                    let slug = jQuery('#input-record-slug').val();
                    if (slug == '') {
                        slug = jQuery('#input-rand-value').val();
                    }
                    let url = forward.baseurl + slug;
                    let target_shorted = jQuery('#input-record-url').val();
                    let date = new Date();
                    date = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

                    showTimeoutToast('Success!', 'New record has been added', 6000, 'success');
                    if (forward.pagenow == 'dashboard') {
                        appendRecordToList(-1, slug, target, url, 0);
                    }
                } else {

                    let error_text = __T('e1');

                    if (e == 'e07') {
                        error_text = __T('e7');
                    } else if (e == 'e08') {
                        error_text = __T('e8');
                    } else if (e == 'e10') {
                        error_text = __T('e10');
                    }

                    showTimeoutToast('Quick add error!', error_text, 6000, 'alert');
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

    if (forward.pagenow == 'install') {
        pageInstall();
    } else if (forward.pagenow == 'dashboard') {
        pageDashboard();
    } else if (forward.pagenow == 'login') {
        pageLogin();
    } else {
        consoleLog('This page has no special functions.');
    }
}

/**
 * pageInstall
 * Features for the Install page
 */
function pageInstall() {
    consoleLog('The functions for page Install have been loaded.');
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
                if (jsonParse(e) && e != null) {
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
    consoleLog('The functions for page Login have been loaded.');

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
    consoleLog('The functions for page Dashboard have been loaded.');

    let clipboard_link = new ClipboardJS('.dashboard__btn--copy-recent');
    clipboard_link.on('success', function(e) {
        //showGlobalSnackbar('Success!', 'The link has been copied to your clipboard!', 4000, 'success');
        showTimeoutToast('Success!', 'The link has been copied to your clipboard!', 3000, 'success');
    });

    function appendRecordToList(id, slug, target, url, clicks) {
        jQuery('.records-list__container').prepend('<div class="records-list__record record-' +
            id + '" data-clipboard-text="' + forward.baseurl + slug + '" data-id="' +
            id + '"><p>/' +
            slug + '</p><span>' +
            target + '</span><h4>' +
            clicks + '</h4></div>');
    }

    jQuery('.records-list__record').on('click', function(e) {
        console.log(e);
    });

    jQuery('.forward-dashboard__add__form').on('submit', function(e) {
        e.preventDefault();
        consoleLog('New record via Standard Add');

        let target = jQuery('#input-dashboard-record-url').val();
        jQuery.ajax({
            url: forward.ajax,
            type: 'post',
            data: jQuery('.forward-dashboard__add__form').serialize(),
            success: function(e) {
                if (e == 's01') {
                    //jQuery('#add-success').slideToggle();

                    //jQuery('#total_records_count').html(parseInt(jQuery('#total_records_count').html()) + 1);


                    let slug = jQuery('#input-dashboard-record-slug').val();
                    if (slug == '') {
                        slug = jQuery('#input-dashboard-rand-value').val();
                    }

                    let url = forward.baseurl + slug;
                    let target_shorted = jQuery('#input-record-url').val();
                    let date = new Date();
                    date = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

                    appendRecordToList(-1, slug, target, url, 0);
                    showTimeoutToast('Success!', 'New record has been added', 6000, 'success');
                    //jQuery("#records_list div:nth-child(2)").after('<div class="card links-card" data-clipboard-text="' + url + '"><div class="card-body"><div><small>' + date + '</small><h2><a target="_blank" rel="noopener" class="overflow-url" href="' + url + '">/' + slug + '</a></h2><p><a target="_blank" rel="noopener" href="' + target_shorted + '">' + target + '...</a></p></div><span>0</span></div></div>');;

                    /*window.setTimeout(function() {
                        jQuery('#add-success').slideToggle(400, function() { jQuery('#add-success').hide(); });
                    }, 3000);*/
                } else {

                    let error_text = __T('e1');

                    if (e == 'e07') {
                        error_text = __T('e7');
                    } else if (e == 'e08') {
                        error_text = __T('e8');
                    } else if (e == 'e10') {
                        error_text = __T('e10');
                    }

                    showTimeoutToast('Error!', error_text, 6000, 'alert');
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
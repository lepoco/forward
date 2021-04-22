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

/**
 * themeFunctions
 * Triggers the functions of the selected page
 */
function themeFunctions() {
    consoleLog('The main functions of the theme have loaded correctly.');

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

                    appendRecordToList(-1, slug, target, url, 0);
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

                    jQuery('#error_text').html(error_text);
                    jQuery('#add-alert').slideToggle();
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
/*!
 * Forward 2.0.2 (https://github.com/rapiddev/Forward)
 * Copyright 2018-2021 RapidDev
 * Licensed under MIT (https://github.com/rapiddev/Forward/blob/master/LICENSE)
 */

Array.prototype.forEach || (Array.prototype.forEach = function(r) { let t = this.length; if ("function" != typeof r) throw new TypeError; for (let o = arguments[1], h = 0; h < t; h++) h in this && r.call(o, this[h], h, this) });

class Forward {

    constructor() {
        this._debug = false;
        this._version = forward.version;
        this.initialize();
    }

    /**
     * initialize
     * Displays basic information and loads page functions.
     */
    initialize() {
        console.log("==============================\nForward \nversion: " + this._version + "\nCopyright © 2019-2021 RapidDev\nhttps://rdev.cc/\n==============================");

        let parent = this;
        document.addEventListener('DOMContentLoaded', function() {
            if (forward.usernonce != jQuery('head').attr('user-nonce')) {
                console.log(forward);
                if (forward.page == 'install')
                    parent.loadThemeFunctions();

                throw new Error('User nonce compliance not detected.!');
            }
            Forward.console('Base url: ' + forward.baseurl);
            if (forward.pagenow != 'home')
                Forward.console('Ajax gate: ' + forward.ajax);
            Forward.console('Page now: ' + forward.pagenow);
            Forward.console('Nonce: ' + forward.usernonce);

            parent.loadThemeFunctions();
        });
    }

    /**
     * loadThemeFunctions
     * Loads custom extensions for the given page.
     */
    loadThemeFunctions() {
        Forward.console('The main functions of the theme have loaded correctly.');

        if (forward.pagenow == 'install') {
            pageInstall();
        } else if (forward.pagenow == 'dashboard') {
            pageDashboard();
        } else if (forward.pagenow == 'login') {
            pageLogin();
        } else {
            Forward.console('This page has no special functions.');
        }
    }

    /**
     * ajax
     * Sends a query to the server
     */
    static ajax(formData, actionOnDone) {
        jQuery.ajax({
            url: forward.ajax,
            type: 'post',
            data: formData,
            success: function(e) {
                actionOnDone(e);
            },
            fail: function(xhr, textStatus, errorThrown) {
                console.log(xhr);
                console.log(textStatus);
                console.log(errorThrown);
                Forward.toast(Forward.__('error'), errorThrown, 6000, 'alert');
            }
        });
    }

    /**
     * toast
     * Displays a new message in the corner of the screen.
     */
    static toast(header, message = null, timeout = 3000, type = 'default') {
        let toastId = 'toast-' + Forward.generateId(32);
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
            (new Date(Date.now() - ((new Date()).getTimezoneOffset() * 60000))).toISOString().substr(11, 8) + '</small></div><div class="toast-body">' +
            message + '</div></div>');

        //let element = document.getElementById('global-toast-container');
        //element.appendChild(tag);

        let toastElement = new bootstrap.Toast(document.getElementById(toastId), { animate: true, delay: timeout });;
        toastElement.show();
    }


    /**
     * __()
     * Translate a string if possible.
     */
    static __(text) {
        if (typeof forward.translator == 'undefined') {
            return text;
        } else {
            if (forward.translator.length == 0) {
                return text;
            } else {
                if (text in forward.translator) {
                    return forward.translator[text];
                } else {
                    return text;
                }
            }
        }
    }

    /**
     * generateId
     * Generates a random string of the given length.
     */
    static generateId(length, type = 'ULN') {

        let characters = '';

        type = type.toLowerCase();
        if (type.includes('u')) //uppercase
            characters += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        if (type.includes('l')) //lowercase
            characters += 'abcdefghijklmnopqrstuvwxyz';

        if (type.includes('n')) //numbers
            characters += '0123456789';

        if (type.includes('s')) //special characters
            characters += '!@#$%^&*(){}[];:_-=+~';

        let result = [];
        let charactersLength = characters.length;
        for (let i = 0; i < length; i++) {
            result.push(characters.charAt(Math.floor(Math.random() *
                charactersLength)));
        }
        return result.join('');
    }

    /**
     * shuffle
     * Randomize array
     */
    static shuffle(array) {
        let currentIndex = array.length,
            temporaryValue, randomIndex;

        // While there remain elements to shuffle...
        while (0 !== currentIndex) {

            // Pick a remaining element...
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            // And swap it with the current element.
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }
        return array;
    }

    /**
     * isMobile
     * Checks app height, if less than 992 guess it's a phone.
     */
    static isMobile() {
        return (document.getElementById('forward-app').offsetHeight < 992);
    }

    /**
     * isJson
     * Checks whether the text string is a valid JSON.
     */
    static isJson(string) {
        if (string == '') { return false; }
        if (/^[\],:{}\s]*$/.test(string.replace(/\\["\\\/bfnrtu]/g, "@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]").replace(/(?:^|:|,)(?:\s*\[)+/g, ""))) { return true; } else { return false; }
    }

    /**
     * console
     * Custom Console Return.
     */
    static console(message, color = "#fff") {
        console.log("%cForward: " + "%c" + message, "color:#dc3545;font-weight: bold;", "color: " + color);
    }
}

(new Forward());
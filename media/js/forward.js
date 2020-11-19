/*!
 * Forward 2.0.0 (https://github.com/rapiddev/Forward)
 * Copyright 2018-2020 RapidDev
 * Licensed under MIT (https://github.com/rapiddev/Forward/blob/master/LICENSE)
 */

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
console.log("==============================\nForward \nversion: " + forward.version + "\nCopyright © 2019-2020 RapidDev\nhttps://rdev.cc/\n==============================");

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
 * platformTranslator
 * Translate platform code from database into nicer name
 */
function platformTranslator(name) {
    switch (name) {
        case __T('unknown'):
            return 'Unknown';
        case 'windows_10':
            return 'Windows 10';
        case 'windows_81':
            return 'Windows 8.1';
        case 'windows_8':
            return 'Windows 8';
        case 'windows_7':
            return 'Windows 7';
        case 'windows_vista':
            return 'Windows Vista';
        case 'windows_xp':
            return 'Windows XP';
        case 'windows':
            return 'Windows (?)';
        case 'windows_ce':
            return 'Windows CE';
        case 'apple':
            return 'Apple iMac / MacBook';
        case 'linux':
            return 'Linux';
        case 'os_2':
            return 'OS/2';
        case 'beos':
            return 'BeOS';
        case 'iphone':
            return 'Apple iPhone';
        case 'ipod':
            return 'Apple iPod';
        case 'ipad':
            return 'Apple iPad';
        case 'apple_tv':
            return 'Apple TV';
        case 'blackberry':
            return 'BlackBerry';
        case 'nokia':
            return 'Nokia';
        case 'freebsd':
            return 'FreeBSD';
        case 'openbsd':
            return 'OpenBSD';
        case 'netbsd':
            return 'NetBSD';
        case 'sunos':
            return 'SunOS';
        case 'opensolaris':
            return 'Open Solaris';
        case 'android':
            return 'Android';
        case 'sony_playstation':
            return 'Sony PlayStation';
        case 'roku':
            return 'Roku';
        case 'terminal':
            return 'Terminal';
        case 'fire_os':
            return 'Fire OS';
        case 'smart_tv':
            return 'Smart TV';
        case 'chrome_os':
            return 'Chrome OS';
        case 'java_android':
            return 'Java / Android';
        case 'postman':
            return 'Postman';
        case 'iframely':
            return 'iFramely';
        default:
            return name;
    }
}

/**
 * agentTranslator
 * Translate browser code from database into nicer name
 */
function agentTranslator(name) {
    switch (name) {
        case __T('unknown'):
            return 'Unknown';
        case 'chrome':
            return 'Google Chrome';
        case 'firefox':
            return 'Mozilla Firefox';
        case 'edge':
            return 'MS Edge';
        case 'opera':
            return 'Opera';
        case 'internet_explorer':
            return 'MS Internet Explorer';
        case 'iphone':
            return 'iPhone Safari';
        case 'safari':
            return 'Safari';
        default:
            return name;
    }
}

function originTranslator(name) {
    switch (name) {
        case __T('unknown'):
            return 'Unknown';
        case 'direct':
            return 'Email / SMS / Direct';
        case 'www.facebook.com':
            return 'Facebook';
        case 'www.youtube.com':
            return 'YouTube';
        default:
            return name;
    }
}

function languageTranslator(name) {
    switch (name) {
        case __T('en-us'):
            return 'English (United States)';
        case 'en-gb':
            return 'English (United Kingdom)';
        case 'www.facebook.com':
            return 'Facebook';
        case 'www.youtube.com':
            return 'YouTube';
        default:
            return name;
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

    /** Adjust dashboard height for desktop page **/
    if (!isMobile()) {
        jQuery('body').css('display', 'initial');
        jQuery('#rdev-dashboard').css('height', jQuery('#forward').outerHeight() - jQuery('.navbar').outerHeight() + 'px');
    }

    /** CTRL pressed **/
    let ctrl_click = false;
    jQuery(document).keydown(function(event) {
        //17 ctrl
        //18 alt
        //16 shift
        if (event.which == 17)
            ctrl_click = true;
    });
    jQuery(document).keyup(function() {
        ctrl_click = false;
    });

    /** Copy to clipboard **/
    jQuery('.shorted-url').on('click', function(e) { e.preventDefault(); });
    jQuery('.links-card').on('click', function(e) {
        e.preventDefault();

        if (jQuery(this).data()['id'] in records) {
            console.log(records);
            fillRecordData(jQuery(this).data()['id']);
        }
        if (ctrl_click) {
            consoleLog('Links card pressed with ctrl button.');
            //clipboardAlert();
        }
    });

    function clipboardAlert() {
        if (jQuery('#links-copied').is(':hidden')) {
            jQuery('#links-copied').slideToggle();
            window.setTimeout(function() {
                jQuery('#links-copied').slideToggle(400, function() { jQuery('#links-copied').hide(); });
            }, 3000);
        }
    }
    let clipboard_link = new ClipboardJS('.shorted-url');
    let clipboard_card = new ClipboardJS('.links-card');
    let clipboard_button = new ClipboardJS('#preview-record-copy > button');
    clipboard_link.on('success', function(e) { clipboardAlert(); });
    clipboard_card.on('success', function(e) { clipboardAlert(); });
    clipboard_button.on('success', function(e) { clipboardAlert(); });

    /** Get record data via ajax **/
    function ajaxRecordData(rid, ondone) {
        let record_id = rid;
        jQuery.ajax({
            url: forward.ajax,
            type: 'post',
            data: {
                action: 'get_record_data',
                nonce: forward.getrecord,
                input_record_id: record_id
            },
            success: function(e) {
                console.log(e);
                if (jsonParse(e)) {
                    let result = JSON.parse(e);
                    ondone(result);
                } else {
                    fillCharts([''], [0.1], [''], [0.1]);
                    barChartAnimate([]);
                }
            },
            fail: function(xhr, textStatus, errorThrown) {
                console.log(xhr);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }

    function iPLookup(ip, id) {
        if ('geoip' in forward) {
            let construct = 'json/';

            jQuery.getJSON(forward.geoip + construct + ip, function(data) {
                console.log(data);
                /*let items = [];

                jQuery.each( data, function( key, val ) {
                	items.push( "<li id='" + key + "'>" + val + "</li>" );
                });

                jQuery( "<ul/>", {
                	"class": "my-new-list",
                	html: items.join( "" )
                }).appendTo( "body" );*/
            });
        }


        //ip-lookup-' + id + '
    }

    function barChartAnimate(days) {
        let is_mobile = isMobile();

        let t = new Chartist.Bar(".ct-chart", {
            labels: bar_chart_labels,
            series: [days]
        }, {
            fullWidth: true,
            height: bar_chart_height,
            axisX: {
                position: 'start',
                labelInterpolationFnc: function skipLabels(value, index) {
                    if (is_mobile)
                        return index % 3 === 0 ? value : null;
                    else
                        return value;
                }
            },
            axisY: { position: 'end' }
        });

        let a = 0;

        t.on("created", function() {
            a = 0
        });

        t.on("draw", function(e) {
            if (a++, "label" === e.type && "x" === e.axis.units.pos) e.element.animate({ y: { begin: 10 * a, dur: 500, from: e.y - 100, to: e.y, easing: "easeOutQuart" }, opacity: { begin: 10 * a, dur: 500, from: 0, to: 1, easing: "easeOutQuart" } });
            else if ("label" === e.type && "y" === e.axis.units.pos) e.element.animate({ x: { begin: 10 * a, dur: 500, from: e.x + 100, to: e.x, easing: "easeOutQuart" }, opacity: { begin: 10 * a, dur: 500, from: 0, to: 1, easing: "easeOutQuart" } });
            else if ("bar" === e.type) e.element.animate({ y1: { begin: 10 * a, dur: 500, from: 0, to: e.y1, easing: "easeOutQuart" }, opacity: { begin: 10 * a, dur: 500, from: 0, to: 1, easing: "easeOutQuart" } });
            else if ("grid" === e.type) {
                let t = { begin: 10 * a, dur: 500, from: e[e.axis.units.pos + "1"] - 30, to: e[e.axis.units.pos + "1"], easing: "easeOutQuart" },
                    i = { begin: 10 * a, dur: 500, from: e[e.axis.units.pos + "2"] - 100, to: e[e.axis.units.pos + "2"], easing: "easeOutQuart" },
                    n = {};
                n[e.axis.units.pos + "1"] = t, n[e.axis.units.pos + "2"] = i, n.opacity = { begin: 10 * a, dur: 500, from: 0, to: 1, easing: "easeOutQuart" }, e.element.animate(n)
            }
        })
    }

    /** Fill charts with passed data **/
    function fillCharts(agents_names, agents_values, platforms_names, platforms_values, languages_names, languages_values, origins_names, origins_values) {
        let letterbox = [
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm'
        ];

        //Browsers labels
        jQuery('.pie-browsers-labels').empty();
        for (let i = 0; i < agents_names.length; i++) {
            jQuery('.pie-browsers-labels').append('<li class="pie-browsers-label-' + letterbox[i] + '">' + agents_names[i] + '</li>');
        }

        //Browsers pie
        let browsers_chart = new Chartist.Pie('.pie-browsers', {
            series: agents_values
        }, {
            fullWidth: true,
            donut: true,
            showLabel: false
        });
        browsers_chart.on('created', function(bar) {
            jQuery('.pie-browsers .ct-series').on('mouseover', function() {
                let current_series = (jQuery(this).attr('class').split(' ')[1]).substr(10);
                jQuery(this).addClass('ct-hover');
                jQuery('.pie-browsers-label-' + current_series).addClass('li-hover');

                let value = jQuery(this).children('path').attr('ct:value');
                if (value != 0.1)
                    jQuery('#pie-browsers-count').html(value);
            });
            jQuery('.pie-browsers .ct-series').on('mouseout', function() {
                jQuery('.pie-browsers .ct-series').removeClass('ct-hover');
                jQuery('.pie-browsers-labels > li').removeClass('li-hover');
                jQuery('#pie-browsers-count').empty();
            });
        });
        browsers_chart.on('draw', function(data) {
            if (data.type === 'slice') {
                let pathLength = data.element._node.getTotalLength();
                data.element.attr({
                    'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
                });
                let animationDefinition = {
                    'stroke-dashoffset': {
                        id: 'anim' + data.index,
                        dur: 500,
                        from: -pathLength + 'px',
                        to: '0px',
                        easing: Chartist.Svg.Easing.easeOutQuint,
                        fill: 'freeze'
                    }
                };
                if (data.index !== 0) {
                    animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
                }
                data.element.attr({
                    'stroke-dashoffset': -pathLength + 'px'
                });
                data.element.animate(animationDefinition, false);
            }
        });

        //Platforms labels
        jQuery('.pie-platforms-labels').empty();
        for (let i = 0; i < platforms_names.length; i++) {
            jQuery('.pie-platforms-labels').append('<li class="pie-platforms-label-' + letterbox[i] + '">' + platforms_names[i] + '</li>');
        }
        //Platforms pie
        let platforms_chart = new Chartist.Pie('.pie-platforms', {
            series: platforms_values
        }, {
            fullWidth: true,
            donut: true,
            showLabel: false
        });
        platforms_chart.on('created', function(bar) {
            jQuery('.pie-platforms .ct-series').on('mouseover', function() {
                let current_series = (jQuery(this).attr('class').split(' ')[1]).substr(10);
                jQuery(this).addClass('ct-hover');
                jQuery('.pie-platforms-label-' + current_series).addClass('li-hover');

                let value = jQuery(this).children('path').attr('ct:value');
                if (value != 0.1)
                    jQuery('#pie-platforms-count').html(value);
            });
            jQuery('.pie-platforms .ct-series').on('mouseout', function() {
                jQuery('.pie-platforms .ct-series').removeClass('ct-hover');
                jQuery('.pie-platforms-labels > li').removeClass('li-hover');
                jQuery('#pie-platforms-count').empty();
            });
        });
        platforms_chart.on('draw', function(data) {
            if (data.type === 'slice') {
                let pathLength = data.element._node.getTotalLength();
                data.element.attr({
                    'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
                });
                let animationDefinition = {
                    'stroke-dashoffset': {
                        id: 'anim' + data.index,
                        dur: 500,
                        from: -pathLength + 'px',
                        to: '0px',
                        easing: Chartist.Svg.Easing.easeOutQuint,
                        fill: 'freeze'
                    }
                };
                if (data.index !== 0) {
                    animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
                }
                data.element.attr({
                    'stroke-dashoffset': -pathLength + 'px'
                });
                data.element.animate(animationDefinition, false);
            }
        });


        //Origins
        let origins_chart = new Chartist.Bar('.bar-origins', {
            labels: origins_names,
            series: [origins_values]
        }, {
            height: 250,
            fullWidth: true,
            seriesBarDistance: 0,
            reverseData: true,
            horizontalBars: true,
            axisX: {
                onlyInteger: true
            },
            axisY: {
                showGrid: false,
                showLabel: false
            },
            plugins: [
                Chartist.plugins.ctBarLabels({
                    position: {
                        x: function(data) {
                            return data.x1 + 10
                        }
                    },
                    labelOffset: {
                        y: 7
                    },
                    labelInterpolationFnc: function(text) {
                        return text; //visible text
                    }
                }, origins_names)
            ]
        });

        //Languages
        let languages_chart = new Chartist.Bar('.bar-languages', {
            labels: languages_names,
            series: [languages_values]
        }, {
            height: 250,
            fullWidth: true,
            seriesBarDistance: 0,
            reverseData: true,
            horizontalBars: true,
            axisX: {
                onlyInteger: true
            },
            axisY: {
                showGrid: false,
                showLabel: false //for a while
            },
            plugins: [
                Chartist.plugins.ctBarLabels({
                    position: {
                        x: function(data) {
                            return data.x1 + 10
                        }
                    },
                    labelOffset: {
                        y: 7
                    },
                    labelInterpolationFnc: function(text) {
                        return text; //visible text
                    }
                }, languages_names)
            ]
        });
    }

    /** Populate the record data based on the data **/
    function fillRecordData(record) {
        if (!(record in records)) {
            console.log('fillRecordData, - the specified record [' + record + '] does not exist in the object \'let records\'');
            return '';
        }
        record = records[record];
        console.log(record);

        let date = new Date(record[6]);
        date = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

        jQuery('#preview-record-date').html(date);
        jQuery('#preview-record-slug').html('/' + record[3]);
        jQuery('#preview-record-url').html(record[4]);
        jQuery('#preview-record-url').attr('href', record[4]);
        jQuery('#preview-record-copy > button').attr('data-clipboard-text', forward.baseurl + record[3]);
        jQuery('#preview-record-copy > button').attr('data-record-id', record[0]);
        jQuery('#preview-record-share > button').attr('data-record-url', record[4]);
        jQuery('#preview-record-delete > button').attr('data-record-id', record[0]);
        jQuery('#confirm-delete-record').attr('data-record-id', record[0]);
        jQuery('#preview-record-user').attr('href', forward.baseurl + 'users/' + record[1]);
        for (let i = 0; i < users.length; i++) {
            if (users[i][0] == record[1]) {
                jQuery('#preview-record-user').html(users[i][1]);
            }
        }

        ajaxRecordData(record[0], function(e) {
            console.log(e);

            let agents_keys = Object.keys(e.agents);
            let agents_names = [];
            let agents_values = [];
            for (let i = 0; i < agents_keys.length; i++) {
                agents_names.push(agentTranslator(visitor_data.agents[agents_keys[i]]));
                agents_values.push(e.agents[agents_keys[i]]);
            }

            let platforms_keys = Object.keys(e.platforms);
            let platforms_names = [];
            let platforms_values = [];
            for (let i = 0; i < platforms_keys.length; i++) {
                platforms_names.push(platformTranslator(visitor_data.platforms[platforms_keys[i]]));
                platforms_values.push(e.platforms[platforms_keys[i]]);
            }

            let languages_keys = Object.keys(e.languages);
            let languages_names = [];
            let languages_values = [];
            for (let i = 0; i < languages_keys.length; i++) {
                languages_names.push(languageTranslator(visitor_data.languages[languages_keys[i]]));
                languages_values.push(e.languages[languages_keys[i]]);
            }

            let origins_keys = Object.keys(e.origins);
            let origins_names = [];
            let origins_values = [];
            for (let i = 0; i < origins_keys.length; i++) {
                origins_names.push(originTranslator(visitor_data.origins[origins_keys[i]]));
                origins_values.push(e.origins[origins_keys[i]]);
            }

            let ips = Object.keys(e.ip);

            //http://ip-api.com/json/31.60.145.130
            for (let i = 0; i < ips.length; i++) {
                if (ips[i] != '') {
                    iPLookup(ips[i], i);
                    jQuery('#records-ip-list').append('<tr><th scope="row">' + (i + 1) + '</th><td>' + ips[i] + '</td><td class="ip-lookup-' + i + '">---</td></tr>');
                }
            }


            barChartAnimate(e.days);
            fillCharts(agents_names, agents_values, platforms_names, platforms_values, languages_names, languages_values, origins_names, origins_values);
        });
    }

    function ajaxAddRecord() {
        if (jQuery('#add-alert').is(':visible')) { jQuery('#add-alert').slideToggle(400, function() { jQuery('#add-alert').hide(); }); }
        if (jQuery('#add-success').is(':visible')) { jQuery('#add-success').slideToggle(400, function() { jQuery('#add-success').hide(); }); }

        jQuery.ajax({
            url: forward.ajax,
            type: 'post',
            data: jQuery("#add-record-form").serialize(),
            success: function(e) {
                if (e == 's01') {
                    jQuery('#add-success').slideToggle();

                    jQuery('#total_records_count').html(parseInt(jQuery('#total_records_count').html()) + 1);


                    let slug = jQuery('#input-record-slug').val();
                    if (slug == '') {
                        slug = jQuery('#input-rand-value').val();
                    }
                    let url = forward.baseurl + slug;
                    let target = jQuery('#input-record-url').val();
                    let target_shorted = jQuery('#input-record-url').val();
                    let date = new Date();
                    date = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);;

                    jQuery("#records_list div:nth-child(2)").after('<div class="card links-card" data-clipboard-text="' + url + '"><div class="card-body"><div><small>' + date + '</small><h2><a target="_blank" rel="noopener" class="overflow-url" href="' + url + '">/' + slug + '</a></h2><p><a target="_blank" rel="noopener" href="' + target_shorted + '">' + target + '...</a></p></div><span>0</span></div></div>');;

                    window.setTimeout(function() {
                        jQuery('#add-success').slideToggle(400, function() { jQuery('#add-success').hide(); });
                    }, 3000);
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
    }
    jQuery('#add-record-form').on('submit', function(e) {
        e.preventDefault();
        ajaxAddRecord();
    });
    jQuery('#add-record-send').on('click', function(e) {
        e.preventDefault();
        ajaxAddRecord();
    });

    jQuery('#delete-selected-record').on('click', function(e) {
        e.preventDefault();
        if (jQuery('#delete-record-alert').is(':hidden')) {
            jQuery('#delete-record-alert').slideToggle();
        }
    });

    jQuery('#cancel-delete-record').on('click', function(e) {
        e.preventDefault();

        if (jQuery('#delete-record-alert').is(':visible')) {
            jQuery('#delete-record-alert').slideToggle();
        }
    });

    jQuery('#confirm-delete-record').on('click', function(e) {
        let record_id = jQuery(this).data('recordId');

        jQuery.ajax({
            url: forward.ajax,
            type: 'post',
            data: {
                action: 'remove_record',
                nonce: forward.removerecord,
                input_record_id: record_id
            },
            success: function(e) {
                console.log(e);

                if (e == 's01') {
                    if (jQuery('.record-' + record_id).is(':visible')) {
                        jQuery('.record-' + record_id).slideToggle(400, function() {
                            jQuery('.record-' + record_id).remove();

                            let prev_record = jQuery("#records_list div:nth-child(3)").attr('class').split(' ')[2];

                            console.log(records[parseInt(prev_record.substr(7))]);

                            fillRecordData(parseInt(prev_record.substr(7)));
                        });
                    }

                    if (jQuery('#delete-record-alert').is(':visible')) {
                        jQuery('#delete-record-alert').slideToggle();
                    }
                }
            },
            fail: function(xhr, textStatus, errorThrown) {
                console.log(xhr);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    });

    if (Object.keys(records).length > 0) {
        fillRecordData(Object.keys(records)[Object.keys(records).length - 1]);
    }
}


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
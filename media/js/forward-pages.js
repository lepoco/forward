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
 * Sort records table
 */
jQuery('table.sortable').each(function(index) {
    jQuery(this).tablesort();
});


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

                Forward.toast(Forward.__('error_qa'), error_text, 6000, 'alert');
            }
            console.log(e);
        },
        fail: function(xhr, textStatus, errorThrown) {
            console.log(xhr);
            console.log(textStatus);
            console.log(errorThrown);
            Forward.toast(Forward.__('error'), errorThrown, 6000, 'alert');
        }
    });
});

jQuery('#settings-form').on('submit', function(e) {
    e.preventDefault();

    jQuery.ajax({
        url: forward.ajax,
        type: 'post',
        data: jQuery("#settings-form").serialize(),
        success: function(e) {
            if (e == 's01') {
                Forward.toast(Forward.__('success'), 'The settings have been saved!', 6000, 'success');
            } else {
                Forward.toast(Forward.__('error'), 'Settings could not be saved!', 6000, 'alert');
            }
            console.log(e);
        },
        fail: function(xhr, textStatus, errorThrown) {
            console.log(xhr);
            console.log(textStatus);
            console.log(errorThrown);

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
        Forward.toast(Forward.__('success'), 'The link has been copied to your clipboard!', 3000, 'success');
    });

    //Main dashboard charts
    let chartColors = ["#696ffb", "#7db8f9", "#05478f", "#00cccc", "#6CA5E0", "#1A76CA"];
    let chartGridLineColor = '#383e5d';
    let chartFontcolor = '#b9c0d3';

    if (jQuery("#main-dashboard-chart").length) {
        let e = {
                type: "line",
                data: {
                    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                    datasets: [
                        { label: "# of clicks", data: [12, 19, 3, 5, 2, 3], backgroundColor: chartColors[0], borderColor: chartColors[0], borderWidth: 1 },
                        //{ label: "# of Points", data: [7, 11, 5, 8, 3, 7], borderColor: chartColors[1], borderWidth: 1, backgroundColor: chartColors[1] },
                    ],
                },
                options: {
                    fill: true,
                    responsive: true,
                    maintainAspectRatio: false,
                    tension: .4,
                    scales: {
                        xAxes: [{ display: !1, ticks: { reverse: !1, display: !1, beginAtZero: !1 }, gridLines: { drawBorder: !1, color: chartGridLineColor, zeroLineColor: chartGridLineColor } }],
                        yAxes: [{ ticks: { max: 25, min: 0, fontColor: chartFontcolor, beginAtZero: !1 }, gridLines: { color: chartGridLineColor, zeroLineColor: chartGridLineColor, display: !0, drawBorder: !1 } }],
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                },
            },
            t = document.getElementById("main-dashboard-chart").getContext("2d");
        new Chart(t, e);
    };

    /*


    //

    //Test chart
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Facebook", "Messenger", "Google", "YouTube", "rdev.cc", "Orange"],
            datasets: [{
                label: '# of clicks',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: chartColors,
                borderColor: 'transparent',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    */

    if (jQuery("#dashboard-chart-origins").length) {
        let e = {
                type: "bar",
                data: {
                    labels: ["Facebook", "Messenger", "Google", "YouTube", "rdev.cc", "4geek.co"],
                    datasets: [{
                        label: '# of clicks',
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: chartColors,
                        borderColor: 'transparent',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            },
            t = document.getElementById("dashboard-chart-origins").getContext("2d");
        new Chart(t, e);
    };

    if (jQuery("#dashboard-chart-languages").length) {
        let e = {
                type: "pie",
                data: {
                    labels: ["English", "Polish", "German", "Green", "Purple", "Orange"],
                    datasets: [{
                            data: [12, 19, 3, 5, 2, 3],
                            backgroundColor: chartColors,
                            borderColor: 'transparent',
                            borderWidth: 1
                        },
                        //{ label: "# of Points", data: [7, 11, 5, 8, 3, 7], borderColor: chartColors[1], borderWidth: 1, backgroundColor: chartColors[1] },
                    ],
                },
                options: {
                    fill: true,
                    responsive: true,
                    maintainAspectRatio: true,
                    tension: .4,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                },
            },
            t = document.getElementById("dashboard-chart-languages").getContext("2d");
        new Chart(t, e);
    };
    if (jQuery("#dashboard-chart-platforms").length) {
        let e = {
                type: "pie",
                data: {
                    labels: ["English", "Polish", "German", "Green", "Purple", "Orange"],
                    datasets: [{
                            data: [2, 9, 13, 45, 2, 3],
                            backgroundColor: chartColors,
                            borderColor: 'transparent',
                            borderWidth: 1
                        },
                        //{ label: "# of Points", data: [7, 11, 5, 8, 3, 7], borderColor: chartColors[1], borderWidth: 1, backgroundColor: chartColors[1] },
                    ],
                },
                options: {
                    fill: true,
                    responsive: true,
                    maintainAspectRatio: true,
                    tension: .4,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                },
            },
            t = document.getElementById("dashboard-chart-platforms").getContext("2d");
        new Chart(t, e);
    };
    if (jQuery("#dashboard-chart-browsers").length) {
        let e = {
                type: "pie",
                data: {
                    labels: ["English", "Polish", "German", "Green", "Purple", "Orange"],
                    datasets: [{
                            data: [23, 9, 13, 45, 2, 3],
                            backgroundColor: chartColors,
                            borderColor: 'transparent',
                            borderWidth: 1
                        },
                        //{ label: "# of Points", data: [7, 11, 5, 8, 3, 7], borderColor: chartColors[1], borderWidth: 1, backgroundColor: chartColors[1] },
                    ],
                },
                options: {
                    fill: true,
                    responsive: true,
                    maintainAspectRatio: true,
                    tension: .4,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                },
            },
            t = document.getElementById("dashboard-chart-browsers").getContext("2d");
        new Chart(t, e);
    };

    function getRecordById(record_id) {
        jQuery.ajax({
            url: forward.ajax,
            type: 'post',
            data: {
                'action': 'get_record_data',
                'nonce': forward.getrecord,
                'input_record_id': record_id
            },
            success: function(e) {
                console.log(e);
                Forward.toast(Forward.__('error'), e, 6000, 'alert');
                if (e == 's01') {} else {}

            },
            fail: function(xhr, textStatus, errorThrown) {
                console.log(xhr);
                console.log(textStatus);
                console.log(errorThrown);

                Forward.toast(Forward.__('error'), errorThrown, 6000, 'alert');
            }
        });

        return true;
    }

    jQuery('.records-list__record').on('click', function(e) {
        let coreData = jQuery(this).data();
        if (coreData['id'] < 1)
            return;

        let recordData = getRecordById(coreData['id']);
        console.log(recordData);
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
                    Forward.toast(Forward.__('success'), 'New record has been added', 6000, 'success');
                } else {

                    let error_text = Forward.__('e1');

                    if (e == 'e07') {
                        error_text = Forward.__('e7');
                    } else if (e == 'e08') {
                        error_text = Forward.__('e8');
                    } else if (e == 'e10') {
                        error_text = Forward.__('e10');
                    }

                    Forward.toast(Forward.__('error'), error_text, 6000, 'alert');
                }
                console.log(e);
            },
            fail: function(xhr, textStatus, errorThrown) {
                console.log(xhr);
                console.log(textStatus);
                console.log(errorThrown);
                Forward.toast(Forward.__('error'), errorThrown, 6000, 'alert');
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
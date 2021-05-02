/*!
 * Forward 2.0.2 (https://github.com/rapiddev/Forward)
 * Copyright 2018-2021 RapidDev
 * Licensed under MIT (https://github.com/rapiddev/Forward/blob/master/LICENSE)
 */

let current_record = {
    id: null,
    url: null,
    target: null,
    name: null,
    display_name: null
};

/**
 * show_hide_password
 */
jQuery('.input-password-preview a').on('click', function(event) {
    event.preventDefault();
    let parent = jQuery(this).parent().parent();
    let passwordBox = parent.children('input[name="password"]');

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

/**
 * Password suggest
 */
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

/**
 * appendRecordToList
 */
function appendRecordToList(id, slug, target, clicks) {
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

let clipboard_link = new ClipboardJS('.dashboard__btn--copy-recent');

/**
 * pageDashboard
 * Features for the Dashboard page
 */
function pageDashboard() {
    Forward.console('The functions for page Dashboard have been loaded.');

    let record_keys = Object.keys(records);
    for (let i = 0; i < record_keys.length; i++) {
        appendRecordToList(records[record_keys[i]][0], records[record_keys[i]][4], records[record_keys[i]][5], records[record_keys[i]][1]);
        if (i == record_keys.length - 1) {
            updateRecordData(records[record_keys[i]][0]);
        }
    }


    clipboard_link.destroy();
    clipboard_link = new ClipboardJS('.dashboard__btn--copy-recent');
    clipboard_link.on('success', function(e) {
        //showGlobalSnackbar('Success!', 'The link has been copied to your clipboard!', 4000, 'success');
        Forward.toast(Forward.__('success'), 'The link has been copied to your clipboard!', 3000, 'success');
    });



    //Main dashboard charts
    let chartColors = ["#696ffb", "#7db8f9", "#05478f", "#00cccc", "#6CA5E0", "#1A76CA"];
    let chartGridLineColor = '#383e5d';
    let chartFontcolor = '#b9c0d3';

    let ds_chart_days = null;
    let ds_chart_origins = null;
    let ds_chart_languages = null;
    let ds_chart_platforms = null;
    let ds_chart_agents = null;

    let recentDaysList = [];
    for (let i = 0; i < 30; i++) {
        let cDate = new Date();
        cDate.setDate(cDate.getDate() - i);
        recentDaysList.push(('0' + cDate.getDate()).slice(-2) + ' ' + forward.months_short[cDate.getMonth()]);
    }
    if (jQuery('#ds_chart_days').length) {
        ds_chart_days = new Chart(document.getElementById('ds_chart_days').getContext('2d'), {
            type: 'bar',
            data: {
                labels: recentDaysList.reverse(),
                datasets: [{
                    label: '# ' + Forward.__('of clicks'),
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: Forward.shuffle(chartColors),
                    borderColor: 'transparent',
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        display: true,
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 5
                        }
                    },
                    y: {
                        display: false,
                        min: 0
                    }
                }
            },
        });
    };

    if (jQuery("#ds_chart_origins").length) {
        ds_chart_origins = new Chart(document.getElementById("ds_chart_origins").getContext("2d"), {
            type: "doughnut",
            data: {
                labels: [Forward.__('unknown')],
                datasets: [{
                    data: [1],
                    backgroundColor: Forward.shuffle(chartColors),
                    borderColor: 'transparent',
                    borderWidth: 1
                }],
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
        });
    };

    if (jQuery("#ds_chart_languages").length) {
        ds_chart_languages = new Chart(document.getElementById("ds_chart_languages").getContext("2d"), {
            type: "doughnut",
            data: {
                labels: [Forward.__('unknown')],
                datasets: [{
                    data: [1],
                    backgroundColor: Forward.shuffle(chartColors),
                    borderColor: 'transparent',
                    borderWidth: 1
                }],
            },
            options: {
                fill: true,
                responsive: true,
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                tooltips: {
                    mode: 'label',
                    position: 'nearest',
                    intersect: true,
                },
                maintainAspectRatio: true,
                tension: .4,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            },
        });
    };
    if (jQuery("#ds_chart_platforms").length) {
        ds_chart_platforms = new Chart(document.getElementById("ds_chart_platforms").getContext("2d"), {
            type: "doughnut",
            data: {
                labels: [Forward.__('unknown')],
                datasets: [{
                    data: [1],
                    backgroundColor: Forward.shuffle(chartColors),
                    borderColor: 'transparent',
                    borderWidth: 1
                }],
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
        });
    };
    if (jQuery("#ds_chart_agents").length) {
        ds_chart_agents = new Chart(document.getElementById('ds_chart_agents').getContext('2d'), {
            type: "doughnut",
            data: {
                labels: [Forward.__('unknown')],
                datasets: [{
                    data: [1],
                    backgroundColor: Forward.shuffle(chartColors),
                    borderColor: 'transparent',
                    borderWidth: 1
                }],
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
        });
    };

    function updateRecordCharts(days, origins, languages, platforms, agents) {

        if (days != null && ds_chart_days != null) {
            let days_labels = Object.keys(days);
            let days_labels_converted = [];
            let day_splitted = null;
            for (let i = 0; i < days_labels.length; i++) {
                day_splitted = days_labels[i].split('-');
                days_labels_converted.push(day_splitted[0] + ' ' + forward.months_short[parseInt(day_splitted[1]) - 1]);
            }
            let days_data = [];
            for (let i = 0; i < days_labels.length; i++) {
                days_data.push(days[days_labels[i]]);
            }
            ds_chart_days.data.labels = days_labels_converted;
            ds_chart_days.data.datasets[0].data = days_data;
            ds_chart_days.update();
        }
        if (origins != null && ds_chart_origins != null) {
            if (origins.length < 1) {
                ds_chart_origins.data.labels = [Forward.__('nodata')];
                ds_chart_origins.data.datasets[0].data = [1];
            } else {
                let origins_labels = Object.keys(origins);
                let origins_data = [];
                for (let i = 0; i < origins_labels.length; i++) {
                    origins_data.push(origins[origins_labels[i]]);
                }

                let origin_labels_converted = [];
                for (let i = 0; i < origins_labels.length; i++) {
                    origin_labels_converted.push(Forward.__(forward.visitors.origins[origins_labels[i]]));
                }

                ds_chart_origins.data.labels = origin_labels_converted;
                ds_chart_origins.data.datasets[0].data = origins_data;
            }
            ds_chart_origins.data.datasets[0].backgroundColor = Forward.shuffle(chartColors);
            ds_chart_origins.update();
        }

        if (languages != null && ds_chart_languages != null) {
            if (languages.length < 1) {
                ds_chart_languages.data.labels = [Forward.__('nodata')];
                ds_chart_languages.data.datasets[0].data = [1];
            } else {
                let languages_labels = Object.keys(languages);
                let languages_data = [];
                for (let i = 0; i < languages_labels.length; i++) {
                    languages_data.push(languages[languages_labels[i]]);
                }

                let language_labels_converted = [];
                for (let i = 0; i < languages_labels.length; i++) {
                    language_labels_converted.push(Forward.__(forward.visitors.languages[languages_labels[i]]));
                }

                ds_chart_languages.data.labels = language_labels_converted;
                ds_chart_languages.data.datasets[0].data = languages_data;
            }
            ds_chart_languages.update();
        }

        if (platforms != null && ds_chart_platforms != null) {
            if (platforms.length < 1) {
                ds_chart_platforms.data.labels = [Forward.__('nodata')];
                ds_chart_platforms.data.datasets[0].data = [1];
            } else {
                let platforms_labels = Object.keys(platforms);
                let platforms_data = [];
                for (let i = 0; i < platforms_labels.length; i++) {
                    platforms_data.push(platforms[platforms_labels[i]]);
                }

                let platform_labels_converted = [];
                for (let i = 0; i < platforms_labels.length; i++) {
                    platform_labels_converted.push(Forward.__(forward.visitors.platforms[platforms_labels[i]]));
                }

                ds_chart_platforms.data.labels = platform_labels_converted;
                ds_chart_platforms.data.datasets[0].data = platforms_data;
            }
            ds_chart_platforms.update();
        }

        if (agents != null && ds_chart_agents != null) {
            if (agents.length < 1) {
                ds_chart_agents.data.labels = [Forward.__('nodata')];
                ds_chart_agents.data.datasets[0].data = [1];
            } else {
                let agents_labels = Object.keys(agents);
                let agents_data = [];
                for (let i = 0; i < agents_labels.length; i++) {
                    agents_data.push(agents[agents_labels[i]]);
                }

                let agent_labels_converted = [];
                for (let i = 0; i < agents_labels.length; i++) {
                    agent_labels_converted.push(Forward.__(forward.visitors.agents[agents_labels[i]]));
                }

                ds_chart_agents.data.labels = agent_labels_converted;
                ds_chart_agents.data.datasets[0].data = agents_data;
            }
            ds_chart_agents.update();
        }
    }

    function updateRecordData(record_id) {
        Forward.ajax({
            'action': 'get_record_data',
            'nonce': forward.getrecord,
            'input_record_id': record_id
        }, function(e) {
            //console.log(e);
            if (Forward.isJson(e)) {

                let parsed = JSON.parse(e);
                //console.log(parsed);

                current_record.id = parsed['record_id'];
                current_record.url = forward.baseurl + parsed['record_name'];
                current_record.target = parsed['record_url'];
                current_record.name = parsed['record_name'];
                current_record.display_name = parsed['record_display_name'];

                updateRecordCharts(parsed['visitors']['days'], parsed['visitors']['origins'], parsed['visitors']['languages'], parsed['visitors']['platforms'], parsed['visitors']['agents']);

                jQuery('#ds_record_name').html('/' + parsed['record_display_name']);
                jQuery('#ds_record_url').html(parsed['record_url']);
                jQuery('#ds_record_clicks').html(parsed['record_clicks']);

                jQuery('#ds_archive_name').html('/' + parsed['record_display_name']);
                jQuery('#ds_archive_target').html(parsed['record_url']);
                jQuery('#ds_archive_clicks').html(parsed['record_clicks']);
                jQuery('#ds_archive_action').attr('data-id', parsed['record_id']);

                jQuery('#ds_record_copy').attr('data-clipboard-text', forward.baseurl + parsed['record_name']);

                clipboard_link.destroy();
                clipboard_link = new ClipboardJS('.dashboard__btn--copy-recent');

                clipboard_link.on('success', function(e) {
                    //showGlobalSnackbar('Success!', 'The link has been copied to your clipboard!', 4000, 'success');
                    Forward.toast(Forward.__('success'), 'The link has been copied to your clipboard!', 3000, 'success');
                });
            } else {
                Forward.toast(Forward.__('error'), 'Something went wrong...', 6000, 'alert');
            }
        });
    }

    jQuery('.records-list__record').on('click', function(e) {
        e.preventDefault();
        let coreData = jQuery(this).data();
        if (coreData['id'] < 1)
            return;

        updateRecordData(coreData['id']);
    });

    jQuery('#ds_archive_action').on('click', function(e) {
        e.preventDefault();
        console.log(jQuery(this).data());
        console.log('ARCHIVE RECORD');

        let archiveModal = bootstrap.Modal.getInstance(document.getElementById('archiveRecordModal'));
        archiveModal.hide();
        Forward.toast(Forward.__('success'), 'The link has been archived', 6000, 'success');
    });

    jQuery('#ds_record_qrcode').on('click', function(e) {
        let qrcodeModal = new bootstrap.Modal(document.getElementById('qrcodeRecordModal'), {
            keyboard: false
        });

        let qrColor = '#000000ff';
        if (jQuery('.forward-app').hasClass('dark-theme')) {
            qrColor = '#ffffffff';
        }

        jQuery('#ds_qrcode_download').attr('download', 'forward_qrcode_' + current_record.display_name + '.png');

        QRCode.toDataURL(document.getElementById('ds_qrcode_canvas'), current_record.url, {
            errorCorrectionLevel: 'H',
            type: 'image/png',
            quality: 1,
            margin: 0,
            scale: 10,
            color: {
                dark: qrColor,
                light: '#00000000'
            }
        }, function(error, url) {
            if (error) {
                qrcodeModal.hide();
                Forward.toast(Forward.__('error'), error, 6000, 'alert');
                return;
            }
            jQuery('#ds_qrcode_download').attr('href', url);
        });

        qrcodeModal.show();
    });

    jQuery('.forward-dashboard__add__form').on('submit', function(e) {
        e.preventDefault();
        Forward.console('New record via Standard Add');

        let target = jQuery('#input-dashboard-record-url').val();
        Forward.ajax(jQuery('.forward-dashboard__add__form').serialize(), function(e) {
            if (e == 's01') {
                let slug = jQuery('#input-dashboard-record-slug').val();
                if (slug == '') {
                    slug = jQuery('#input-dashboard-rand-value').val();
                }

                let url = forward.baseurl + slug;
                let target_shorted = jQuery('#input-record-url').val();
                let date = new Date();
                date = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

                appendRecordToList(-1, slug, target, 0);
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
        });
    });
};

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
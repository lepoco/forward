'use strict';

import Forward from '../common/core.min.js';

export const name = 'forward-dashboard';
export default function() {
    Forward.console('[Module] Dashboard imported');
}

let current_record = {
    id: null,
    url: null,
    target: null,
    name: null,
    display_name: null
};

let clipboard_link = new ClipboardJS('.dashboard__btn--copy-recent');

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


/**
 * FORM
 * Add record
 */
(function() {
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
}());

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
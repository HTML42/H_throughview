var _cs = document.currentScript;
setTimeout(function () {
    if (!TV_User.id) {
        window._tv_check_response = function (response) {
            TV_User.set_id(response ? response : TV_generate_userid());
            TV_step2();
        };
        TV_append_script('http://throughview.local/tv/embed/check.php');
    } else {
        TV_step2();
    }
}, 5);

setInterval(function () {
    document.querySelectorAll('[data-tv-event]:not([data-tv-event-watch])').forEach(function (element) {
        element.setAttribute('data-tv-event-watch', '');
        element.addEventListener("click", function () {
            TV_event(element.getAttribute('data-tv-event'));
        });
    });
}, 2000);

function TV_step2() {
    TV_view();
    setTimeout('TV_timer(10)', 10000);
    setTimeout('TV_timer(20)', 20000);
    setTimeout('TV_timer(30)', 30000);
    setTimeout('TV_timer(60)', 60000);
    setTimeout('TV_timer(120)', 120000);
    setTimeout('TV_timer(180)', 180000);
    setTimeout('TV_timer(300)', 300000);
}

window.TV = {
    iframe: null,
    pageview: false,
    nocookie: TV_script_data('nocookie')
};

function TV_script_data(key) {
    if (TV_is_tag(_cs)) {
        return typeof _cs.getAttribute('data-' + key) == 'string';
    }
    return false;
}

function TV_iframe(url) {
    var iframe = document.createElement('iframe');
    iframe.setAttribute('src', url);
    iframe.setAttribute('style', 'border:0;height:0;width:0;overflow:hidden;padding:0;margin:0;opacity:0.1;position:absolute;float:left;z-index:-10;');
    document.body.appendChild(iframe);
    return iframe;
}
function TV_view() {
    TV_embed('view');
}
function TV_timer(seconds) {
    TV_embed('timer', {t: parseInt(seconds)});
}
function TV_event(eventname) {
    var parameters = {};
    if (typeof eventname == 'string' && eventname.length) {
        parameters.n = eventname;
    }
    TV_embed('event', parameters);
}
function TV_embed(filename, parameters) {
    if (typeof parameters != 'object' || parameters == null) {
        parameters = {};
    }
    parameters.r = document.location.href;
    parameters.u = TV_User.id;
    var iframe_url = 'http://throughview.local/tv/embed/';
    iframe_url += filename + '.php?';
    var _parameters = [];
    for (var key in parameters) {
        _parameters.push(key + '=' + encodeURIComponent(parameters[key]));
    }
    var iframe = TV_iframe(iframe_url + _parameters.join('&'));
    setTimeout(function () {
        iframe.parentNode.removeChild(iframe);
    }, 2000);
}
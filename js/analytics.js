var _cs = document.currentScript;
setTimeout(function () {
    console.log('Throughview - Start');
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

function TV_step2() {
    console.log('User-ID:', TV_User.id);
    TV_iframe('http://throughview.local/tv/embed/?r=' + encodeURIComponent(document.location.href) + '&u=' + TV_User.id);
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
}
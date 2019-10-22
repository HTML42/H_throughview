function TV_cookie_set(key, value, days) {
    return TV_cookie(key, value, days);
}

function TV_cookie_get(key) {
    return TV_cookie(key);
}

function TV_cookie(key, value, days) {
    if (typeof value == 'string' || typeof value == 'number') {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = key + "=" + (value || "") + expires + "; path=/";
    } else {
        var _return = null;
        var cookies = document.cookie.split(';');
        for (_i in cookies) {
            var cookie_data = cookies[_i].split('=');
            if (typeof cookie_data[0] == 'string' && typeof cookie_data[1] == 'string') {
                var c_key = cookie_data[0].replace(/\s/g, '');
                var c_value = cookie_data[1].replace(/\s/g, '');
                if (c_key == key) {
                    _return = c_value;
                    break;
                }
            }
        }
        //
        if (_return) {
            if (_return.match(/\{.*\}/) || _return.match(/\[.*\]/)) {
                var _return_json = false;
                try {
                    _return_json = JSON.parse(_return);
                } catch (exception) {
                    _return_json = false;
                }
                if (_return_json) {
                    _return = _return_json;
                }
            } else if (_return === 'true') {
                _return = true;
            } else if (_return === 'false') {
                _return = false;
            }
        }
        //
        return _return;
    }
}
function TV_is_tag(element) {
    return (typeof element == 'object' && element != null && typeof element.tagName == 'string');
}
function TV_generate_userid(length) {
    var _a = 'abcdefghijklmnopqrstuvwxyz';
    var symbols = '0123456789' + _a + _a.toUpperCase();
    if (typeof length != 'number') {
        length = 42;
    }
    var id = '';
    for (var i = 0; i < length; i++) {
        id += symbols[Math.round(Math.random() * (symbols.length - 1))];
    }
    return id;
}
function TV_append_script(url) {
    var s = document.createElement('script');
    s.src = url;
    s.async = true;
    document.head.appendChild(s);
}
var TV_UserObject = function () {
    this.id = this.fetch_id_by_front();
    if (this.id && !window.TV.nocookie) {
        TV_cookie_set('_tv', this.id, 90);
    }
};
TV_UserObject.prototype.fetch_id_by_front = function () {
    return TV_cookie_get('_tv') || localStorage.getItem('_tv') || sessionStorage.getItem('_tv') || false;
};
TV_UserObject.prototype.set_id = function (new_id) {
    this.id = new_id;
    localStorage.setItem('_tv', this.id);
    sessionStorage.setItem('_tv', this.id);
    if (!window.TV.nocookie) {
        TV_cookie_set('_tv', this.id, 90);
    }
    return this.id;
};

var TV_User = new TV_UserObject();
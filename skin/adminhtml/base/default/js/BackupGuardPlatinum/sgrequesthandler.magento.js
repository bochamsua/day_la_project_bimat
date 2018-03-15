sgRequestHandler.prototype.prepareData = function() {
    this.url = getAjaxUrl();

    if (typeof this.data === 'undefined') {
        if (this.dataIsObject === true) this.data = {};
        else this.data = '';
    }

    if (this.dataIsObject === 'pxik') {
        return;
    }

    if (this.dataIsObject === true) {
        if (this.data instanceof FormData) {
            this.data.append('form_key', getFormKey());
            this.data.append('action', 'importBackup');
        }
        else {
            this.data['form_key'] = getFormKey();
            this.data['action'] = this.action;
        }
    }
    else {
        if (this.data !== '') this.data += '&';
        this.data += 'form_key='+getFormKey();
        this.data += '&action='+this.action;
    }
}
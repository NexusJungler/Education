var ajax = {

    data: null,
    xhr : new XMLHttpRequest(),
    actor: null,
    bindXhr:null,

    init: function(actor, methode, phpfile, post) {
        this.actor = document.querySelector(actor);
        this.data = null;
        var action = 'GET';
        if (methode) {action = 'POST'}
        this.xhr.open(action, phpfile, true);
        if (methode) {
            this.xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            this.xhr.send(post);
        } else {this.xhr.send()}
        this.bindXhr = this.dataRead.bind(this);
        this.xhr.addEventListener('readystatechange', this.bindXhr);
       },
    dataRead: function() {
        if (this.xhr.status === 200 && this.xhr.readyState === 4) {
            this.xhr.removeEventListener('readystatechange', this.bindXhr);
            var evt = new CustomEvent('dataReady', { 'detail' : {'toto' : null} });
            this.data = JSON.parse(this.xhr.responseText);
            //console.log('dataReady');
            //console.log('response ajax: ' + this.xhr.responseText);
            this.actor.dispatchEvent(evt);
        }
    },
    getdata: function() {
        return this.data;
    }
};

(function () {
    class MirrorHandler {
        constructor (rest, data, resource) {
            this.resource = resource;
            this.rest = rest;
            this.data = data || {};
            this.dates = [];
            this.files = [];
            this.meta = [];
        }
        file (name, alias) {
            this.files[name] = alias;
        }
        date (name, alias) {
            this.dates[name] = alias;
        }
        initialice (initial) {
            for (var i in this.dates) {
                if (initial && this.data[i])
                    this[this.dates[i]] = new Date(this.data[i]);
                else
                    this[this.dates[i]] = new Date();
            }
            for (var i in this.files) {
                this[this.files[i]] = null;
            }
        }
        flameData () {
            let isFile = false;
            let form = new FormData();

            for (var i in this.dates) {
                this.data[i] = Help.timeToString (this[this.dates[i]]);
            }
            
            for (var i in this.files) {
                if (this[this.files[i]] != null) {
                    isFile = true;
                    form.append (this.files[i], this[this.files[i]]);
                }
            }
            
            if (isFile) {
                this.form = form;
            }
            
            return this.data;
        }
        selectQuery (append) {
            return this._query(append);
        }
        updateQuery () {
            return this._query();
        }
        createQuery () {
            return this._query();
        }
        removeQuery () {
            return this._query();
        }
        _query (append) {
            this.flameData();
            let turn = {};
            
            if (this.form) {
                for (var i in append) {
                    this.form.append (i, append[i]);
                }
                this.form.append ("data", JSON.stringify (this.data));
            } else {
                for (var i in append) {
                    turn[i] = append[i];
                }
                turn.data = this.data;
                for (var i in this.meta) {
                    turn[i] = this.meta[i];
                }
            }
            
            return this.form ? this.form : turn;
        }
        _send () {
            if (!this.url) {
                return;
            }
        }
        query ( data ) {
            return this.rest.send (this.resource, data, "get");
        }
        create (data) {
            return this.rest.send (this.resource, data, "post");
        }
        remove (data) {
            return this.rest.send (this.resource, data, "delete");
        }
        update (data) {
            return this.rest.send (this.resource, data, "put");
        }
    }

    window.MirrorHandler = MirrorHandler;
})();
class User {
    init(fields) {
        this.fields = fields;

        for (let field in fields) {
            this[field] = fields[field];
        }
    }

    destroy() {
        if (!this.authenticated()) {
            return;
        }

        for (let field in this.fields) {
            delete this[field];
        }

        delete this.fields;
    }

    authenticated() {
        return this.auth;
    }
}

export default User;
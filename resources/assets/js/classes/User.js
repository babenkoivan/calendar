class User {
    constructor(fields) {
        for (let field in fields) {
            this[field] = fields[field];
        }
    }

    authenticated() {
        return this.hasOwnProperty('id');
    }
}

export default User;
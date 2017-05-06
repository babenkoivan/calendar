class Form {
    constructor(vueForm) {
        this.vueForm = vueForm;
        this.vueFields = {};
    }

    addField(field) {
        this.vueFields[field.name] = field;
    }

    data(data) {
        if (data) {
            for (let name in data) {
                this.vueFields[name].value = $.trim(data[name]);
            }
        } else {
            data = {};

            for (let name in this.vueFields) {
                let value = $.trim(this.vueFields[name].value);

                if (value.length > 0) {
                    data[name] = this.vueFields[name].value;
                }
            }

            return data;
        }
    }

    isEmpty() {
        let data = this.data();

        return $.isEmptyObject(data);
    }

    reset() {
        this.vueForm.error = '';

        for (let name in this.vueFields) {
            let field = this.vueFields[name];

            field.value = '';
            field.error = '';
        }
    }

    type() {
        return this.vueForm.type ? this.vueForm.type.toLowerCase() : 'post';
    }

    action() {
        return this.vueForm.action;
    }

    submit() {
        this.vueForm.error = '';

        axios[this.type()](this.action(), this.data())
            .then(response => {
                if (typeof this.vueForm.success == 'function') {
                    this.vueForm.success(response.data, this);
                } else {
                    this.reset();
                }
            })
            .catch(error => {
                if (!error.response || !error.response.data) {
                    return;
                }

                let data = error.response.data;

                if (typeof data == 'object') {
                    for (let name in data) {
                        this.vueFields[name].error = data[name][0];
                    }
                } else {
                    this.vueForm.error = data;
                }
            });
    }
}

export default Form;
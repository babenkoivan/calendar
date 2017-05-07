class Form {
    constructor(vueForm) {
        this.vueForm = vueForm;
        this.vueFields = {};
        this.vueButton = null;
    }

    addField(field) {
        this.vueFields[field.name] = field;
    }

    addButton(button) {
        this.vueButton = button;
    }

    data(data) {
        if (data) {
            for (let name in data) {
                this.vueFields[name].value = $.trim(data[name]);
            }
        } else {
            data = {};

            for (let name in this.vueFields) {
                data[name] = this.vueFields[name].value;
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
        this.vueButton.loading = true;

        axios[this.type()](this.action(), this.data())
            .then(response => {
                this.vueButton.loading = false;

                if (typeof this.vueForm.success == 'function') {
                    if (this.vueForm.success(response.data, this) === false) {
                        return;
                    }
                }

                this.reset();
            })
            .catch(error => {
                this.vueButton.loading = false;

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
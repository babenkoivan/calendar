<template>
    <div>
        <input v-model="value" :class='["input", {"is-danger": error}]' :name.prop="name" type="text" data-field="datetime" readonly/>
        <p class="help is-danger" v-if="error">{{ error }}</p>
    </div>
</template>

<script>
    import DateTimePicker from 'datetimepicker';

    export default {
        props: ['name', 'preset'],
        data() {
            return {
                value: this.preset || '',
                error: '',
                dateTimeBox: null
            };
        },
        watch: {
            value() {
                this.$parent.$emit('value-changed');

                this.error = '';
            }
        },
        methods: {
            initDatePicker() {
                let self = this,
                    body = $('body');

                self.dateTimeBox = body.children('#dt_box');

                if (self.dateTimeBox.length == 0) {
                    self.dateTimeBox = $('<div id="dt_box"></div>');

                    body.append(self.dateTimeBox);

                    self.dateTimeBox.DateTimePicker({
                        mode: 'datetime',
                        dateTimeFormat: 'yyyy-MM-dd hh:mm:ss',
                        settingValueOfElement(boxValue, boxDateTime, boxInput) {
                            self.$root.$emit('updated:datepicker.' + boxInput[0].name, boxValue);
                        }
                    });
                }

                self.$root.$on('updated:datepicker.' + this.name, value => {
                    self.value = value;
                });
            }
        },
        mounted() {
            this.$parent.form.addField(this);

            this.initDatePicker();
        }
    }
</script>
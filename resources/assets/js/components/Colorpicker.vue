<template>
    <div>
        <div>
            <input v-model="value" :name.prop="name" type="text"/> {{value}}
        </div>

        <p class="help is-danger" v-if="error">{{ error }}</p>
    </div>
</template>

<script>
    import spectrum from 'spectrum-colorpicker';

    export default {
        props: ['name', 'preset'],
        data() {
            return {
                value: this.preset || '',
                error: '',
                input: null
            };
        },
        watch: {
            value(value) {
                this.input.spectrum('set', value);

                this.$parent.event.$emit('value-changed');

                this.error = '';
            }
        },
        methods: {
            initColorPicker() {
                let self = this;

                self.input = $(self.$el).find('input');

                self.input.spectrum({
                    color: self.value,
                    showAlpha: true,
                    preferredFormat: 'hex',
                    change(color) {
                        self.value = color.toHexString();
                    }
                });
            }
        },
        mounted() {
            this.$parent.form.addField(this);

            this.initColorPicker();
        }
    }
</script>
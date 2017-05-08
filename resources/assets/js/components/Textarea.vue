<template>
    <div>
        <textarea v-model="value" :class='["textarea", {"is-danger": error}]' :name.prop="name"></textarea>
        <p class="help is-danger" v-if="error">{{ error }}</p>
    </div>
</template>

<script>
    export default {
        props: ['name', 'preset'],
        data() {
            return {
                value: this.preset || '',
                error: ''
            };
        },
        watch: {
            value() {
                this.$parent.$emit('value-changed');

                this.error = '';
            }
        },
        mounted() {
            this.$parent.form.addField(this);
        }
    }
</script>
<template>
    <div>
        <input v-model="value" :class='["input", {"is-danger": error}]' :name.prop="name" :type.prop="type"/>
        <p class="help is-danger" v-if="error">{{ error }}</p>
    </div>
</template>

<script>
    export default {
        props: ['name', 'type', 'preset'],
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
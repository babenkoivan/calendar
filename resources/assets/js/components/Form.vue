<template>
    <form @submit.prevent="form.submit()">
        <div class="notification is-danger" v-if="error">{{ error }}</div>

        <slot></slot>
    </form>
</template>

<script>
    import Form from '../classes/Form';

    export default {
        props: ['action', 'type', 'name', 'success'],
        data() {
            return {
                form: new Form(this),
                event: new Vue(),
                error: ''
            }
        },
        mounted() {
            if (this.name) {
                this.$root.mounted.register('form.' + this.name, this);
            }
        }
    }
</script>
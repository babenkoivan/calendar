<template>
    <button type="submit" :disabled="disabled" :class='{"is-loading": loading}' >
        <slot></slot>
    </button>
</template>

<script>
    export default {
        data() {
            return {
                disabled: true,
                loading: false
            };
        },
        mounted() {
            this.$parent.$on('value-changed', () => {
                this.disabled = this.$parent.form.isEmpty();
            });

            this.$parent.form.addButton(this);
        }
    }
</script>
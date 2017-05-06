<template>
    <button type="submit" :disabled="disabled">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        data() {
            return {
                disabled: true
            };
        },
        mounted() {
            this.$parent.event.$on('value-changed', () => {
                this.disabled = this.$parent.form.isEmpty();
            });
        }
    }
</script>
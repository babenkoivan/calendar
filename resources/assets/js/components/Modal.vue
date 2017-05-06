<template>
    <div :class='["modal", {"is-active": !hidden}]' >
        <div class="modal-background" @click="hide()"></div>

        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">
                    <slot name="title"></slot>
                </p>

                <button class="delete" @click="hide()"></button>
            </header>

            <section class="modal-card-body">
                <slot></slot>
            </section>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                hidden: true
            }
        },
        methods: {
            hide() {
                this.hidden = true;
            },
            show() {
                this.hidden = false;
            }
        },
        mounted() {
            this.$parent.event.$on('modal-hide', () => {
                this.hide();
            });

            this.$parent.event.$on('modal-show', () => {
                this.show();
            });
        }
    }
</script>
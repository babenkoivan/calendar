<template>
    <div>
        <div class="full-calendar"></div>

        <c-modal name="event">
            <h1 slot="title">{{ tmp.modalTitle }}</h1>

            <c-form :action="tmp.form.action" :type="tmp.form.type" :success="refetchEvents" name="event"
                :class="{disabled: tmp.event && !tmp.event.editable}">

                <div class="field">
                    <label class="label">Title</label>
                    <p class="control">
                        <c-input type="text" name="name"></c-input>
                    </p>
                </div>

                <div class="field">
                    <label class="label">Time start</label>
                    <p class="control">
                        <c-datepicker name="time_start"></c-datepicker>
                    </p>
                </div>

                <div class="field">
                    <label class="label">Time end</label>
                    <p class="control">
                        <c-datepicker name="time_end"></c-datepicker>
                    </p>
                </div>

                <div class="field">
                    <label class="label">Color</label>
                    <p class="control">
                        <c-colorpicker name="color"></c-colorpicker>
                    </p>
                </div>

                <div class="field">
                    <label class="label">Description</label>
                    <p class="control">
                        <c-textarea type="text" name="description"></c-textarea>
                    </p>
                </div>

                <div class="field is-grouped buttons">
                    <p class="control" v-if="!tmp.event || tmp.event.editable">
                        <c-submit-button class="button is-success">Save</c-submit-button>
                    </p>

                    <p class="control" v-if="tmp.event && tmp.event.editable">
                        <a class="button is-danger" @click.prevent="removeEvent()">Delete</a>
                    </p>

                    <p class="control">
                        <button class="button is-link" @click.prevent="modal.hide()">Cancel</button>
                    </p>
                </div>
            </c-form>
        </c-modal>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                modal: null,
                form: null,
                calendar: null,
                dateFormat: 'YYYY-MM-DD HH:mm:ss',
                tmp: {
                    modalTitle: '',
                    form: {
                        type: '',
                        action: ''
                    },
                    event: null
                }
            };
        },
        methods: {
            showAddForm(day) {
                this.tmp = {
                    modalTitle: 'New event',
                    form: {
                        type: 'post',
                        action: '/events'
                    },
                    event: null
                };

                day.hours(0).minutes(0);

                this.form.data({
                    name: '',
                    time_start: day.format(this.dateFormat),
                    time_end: day.add(1, 'd').format(this.dateFormat),
                    color: '#7D9EC0',
                    description: ''
                });

                this.modal.show();
            },
            showEditForm(event) {
                this.tmp = {
                    modalTitle: event.author + ': ' + event.title,
                    form: {
                        type: 'put',
                        action: '/events/' + event.id
                    },
                    event: event
                };

                this.form.data({
                    name: event.title,
                    time_start: event.start.format(this.dateFormat),
                    time_end: event.end.format(this.dateFormat),
                    color: event.color,
                    description: event.description
                });

                this.modal.show();
            },
            refetchEvents() {
                this.calendar.fullCalendar('refetchEvents');

                this.modal.hide();

                return false;
            },
            removeEvent() {
                if (!this.tmp.event) {
                    return;
                }

                axios.delete('/events/' + this.tmp.event.id).then(() => {
                    this.refetchEvents();
                });
            },
            updateEventTime(event) {
                axios.put('/events/' + event.id, {
                    time_start: event.start.format(this.dateFormat),
                    time_end: event.end.format(this.dateFormat)
                }).then(() => {
                    this.refetchEvents();
                });
            },
            initCalendar() {
                let self = this;

                this.calendar = $(self.$el).find('.full-calendar');

                this.calendar.fullCalendar({
                    events: '/events',
                    navLinks: true,
                    eventLimit: true,
                    dayClick(day) {
                        self.showAddForm(day);
                    },
                    eventClick(event) {
                        self.showEditForm(event);
                    },
                    eventDrop(event) {
                        self.updateEventTime(event)
                    },
                    eventResize(event) {
                        self.updateEventTime(event)
                    }
                });
            }
        },
        mounted() {
            this.initCalendar();

            this.form = this.$root.mounted.get('form.event').form;
            this.modal = this.$root.mounted.get('modal.event');
        }
    }
</script>
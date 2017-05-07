<template>
    <div>
        <div class="full-calendar"></div>

        <c-modal name="event_modal">
            <h1 slot="title">{{ tmp.modalTitle }}</h1>

            <c-form :action="tmp.form.action" :type="tmp.form.type" :success="refetchEvents" name="event_form">
                <div class="field">
                    <label class="label">Name</label>
                    <p class="control">
                        <c-input type="text" name="name" />
                    </p>
                </div>

                <div class="field">
                    <label class="label">Time start</label>
                    <p class="control">
                        <c-input name="time_start" type="datetime-local" />
                    </p>
                </div>

                <div class="field">
                    <label class="label">Time end</label>
                    <p class="control">
                        <c-input name="time_end" type="datetime-local" />
                    </p>
                </div>

                <div class="field">
                    <label class="label">Color</label>
                    <p class="control">
                        <c-input type="color" name="color" />
                    </p>
                </div>

                <div class="field">
                    <label class="label">Description</label>
                    <p class="control">
                        <c-textarea type="text" name="description"></c-textarea>
                    </p>
                </div>

                <div class="field is-grouped">
                    <p class="control">
                        <c-submit-button class="button is-success">Save</c-submit-button>
                    </p>

                    <p class="control" v-if="this.tmp.event">
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
                dateFormat: 'YYYY-MM-DD[T]HH:mm',
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

                let currentTime = new Date();
                day.hours(currentTime.getHours())
                   .minutes(currentTime.getMinutes());

                this.form.data({
                    name: '',
                    time_start: day.format(this.dateFormat),
                    time_end: '',
                    color: '#71bab0',
                    description: ''
                });

                this.modal.show();
            },
            showEditForm(event) {
                this.tmp = {
                    modalTitle: event.title,
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
                });
            },
            initCalendar() {
                let self = this;

                this.calendar = $(self.$el).find('.full-calendar');

                this.calendar.fullCalendar({
                    events: '/events',
                    navLinks: true,
                    editable: true,
                    eventLimit: true,
                    dayClick(day) {
                        self.showAddForm(day);
                    },
                    eventClick(event) {
                        self.showEditForm(event);
                    },
                    eventDrop(event) {
                        self.updateEventTime(event)
                    }
                });
            }
        },
        mounted() {
            this.initCalendar();

            this.form = this.$root.mounted.get('form.event_form').form;
            this.modal = this.$root.mounted.get('modal.event_modal');
        }
    }
</script>
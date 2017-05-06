<template>
    <div>
        <div class="full-calendar"></div>

        <c-modal>
            <h1 slot="title">{{ temp.modalTitle }}</h1>

            <c-form :action="temp.formAction" :type="temp.formType" :success="refetchEvents">
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

                    <p class="control" v-if="this.temp.selectedEvent">
                        <a class="button is-danger" @click.prevent="removeEvent()">Delete</a>
                    </p>

                    <p class="control">
                        <button class="button is-link" @click.prevent="hideForm()">Cancel</button>
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
                event: new Vue(),
                form: null,
                calendar: null,
                dateFormat: 'YYYY-MM-DD[T]HH:mm',
                temp: {
                    modalTitle: '',
                    formType: '',
                    formAction: '',
                    selectedEvent: null
                }
            };
        },
        methods: {
            showAddForm(day) {
                this.temp = {
                    modalTitle: 'New event',
                    formType: 'post',
                    formAction: '/events',
                    selectedEvent: null
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

                this.event.$emit('modal-show');
            },
            showEditForm(event) {
                this.temp = {
                    modalTitle: event.title,
                    formType: 'put',
                    formAction: '/events/' + event.id,
                    selectedEvent: event
                };

                this.form.data({
                    name: event.title,
                    time_start: event.start.format(this.dateFormat),
                    time_end: event.end.format(this.dateFormat),
                    color: event.color,
                    description: event.description
                });

                this.event.$emit('modal-show');
            },
            hideForm() {
                this.event.$emit('modal-hide');
            },
            refetchEvents() {
                this.calendar.fullCalendar('refetchEvents');

                this.event.$emit('modal-hide');
            },
            removeEvent() {
                if (!this.temp.selectedEvent) {
                    return;
                }

                axios.delete('/events/' + this.temp.selectedEvent.id).then(() => {
                    this.refetchEvents();
                });
            },
            updateEventTime(event) {
                axios.put('/events/' + event.id, {
                    time_start: event.start.format(this.dateFormat),
                    time_end: event.end.format(this.dateFormat)
                });
            }
        },
        mounted() {
            let self = this;

            this.calendar = $(self.$el).find('.full-calendar');
            this.form = this.calendar.next().find('form').get(0).__vue__.form;

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
    }
</script>
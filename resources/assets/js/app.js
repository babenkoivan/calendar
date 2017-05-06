require('./bootstrap');

// Vue components
Vue.component('c-form', require('./components/Form.vue'));
Vue.component('c-input', require('./components/Input.vue'));
Vue.component('c-textarea', require('./components/Textarea.vue'));
Vue.component('c-submit-button', require('./components/SubmitButton.vue'));
Vue.component('c-calendar', require('./components/Calendar.vue'));
Vue.component('c-modal', require('./components/Modal.vue'));

// Classes
import User from './classes/User';

window.app = new Vue({
    el: '#calendar',
    data: {
        user: new User()
    },
    methods: {
        initUser(fields) {
            this.user = new User(fields);
        }
    }
});
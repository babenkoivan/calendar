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
import ComponentContainer from './classes/ComponentContainer';

window.app = new Vue({
    el: '#calendar',
    data: {
        user: new User(),
        mounted: new ComponentContainer(),
        ready: false
    },
    methods: {
        initUser(fields) {
            this.user.init(fields);
            this.$forceUpdate();
        },
        logout() {
            axios.post('/auth/logout');

            this.user.destroy();
            this.$forceUpdate();
        }
    },
    created() {
        this.ready = true;

        history.pushState(null, null, '/');
    }
});
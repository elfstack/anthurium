import AppForm from '../app-components/Form/AppForm';

Vue.component('user-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                email:  '' ,
                password:  '',
            },
            countdown: -1,
            mediaCollections: ['avatar'],
        }
    },
    methods: {
        sendVerification () {
            // TODO: THIS METHOD IS DISABLED
        }
    }
});

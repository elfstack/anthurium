import AppForm from '../app-components/Form/AppForm';

Vue.component('attendance-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                arrived_at:  '' ,
                left_at:  '' ,
                activity_id:  '' ,
                user_id:  '' ,
                
            }
        }
    }

});
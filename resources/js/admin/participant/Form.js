import AppForm from '../app-components/Form/AppForm';

Vue.component('participant-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                enrolled_at:  '' ,
                activity_id:  '' ,
                user_id:  '' ,
                attendance_id:  '' ,
                
            }
        }
    }

});
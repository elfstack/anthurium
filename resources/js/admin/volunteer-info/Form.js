import AppForm from '../app-components/Form/AppForm';

Vue.component('volunteer-info-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                user_id:  '' ,
                id_number:  '' ,
                alias:  '' ,
                gender:  '' ,
                birthday:  '' ,
                education:  '' ,
                organisation:  '' ,
                mobile_number:  '' ,
                address:  '' ,
                interests:  '' ,
                emergency_contact:  '' ,
                volunteer_experences:  '' ,
                references:  '' ,
                
            }
        }
    }

});
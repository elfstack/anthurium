import AppForm from '../app-components/Form/AppForm';

Vue.component('budget-category-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                
            }
        }
    }

});
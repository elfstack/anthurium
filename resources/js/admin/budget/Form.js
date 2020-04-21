import AppForm from '../app-components/Form/AppForm';

Vue.component('budget-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                activity_id:  '' ,
                budget_category_id:  '' ,
                budget:  '' ,
                expense:  '' ,
                name:  '' ,

            },
            budgetSelected: null
        }
    },
    mounted () {
        if (data) {
            // TODO: set multiselect value
        }
    },
    methods: {
        onSuccess (data) {
            this.$modal.hide('edit-budget');
            this.$emit('update', data);
        }
    }

});

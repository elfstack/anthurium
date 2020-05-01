import AppForm from '../app-components/Form/AppForm';

Vue.component('activity-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                starts_at:  '' ,
                ends_at:  '' ,
                content:  '' ,
                quota:  '' ,
                is_published: false,
                is_public: false,
                visible_to: []
            }
        }
    },
    methods: {
        togglePublished () {
            this.sendRequest({ is_published: this.form.is_published });
        },
        togglePublicity () {
            this.sendRequest({ is_public: this.form.is_public });
        },
        toggleVisibility () {
            this.sendRequest({ visible_to: this.form.visible_to });
        },
        // TODO: debounce
        sendRequest (data) {
            window.axios.patch('/api/activity/' + this.data.id + '/visibility', data).then(({ data }) => {
                this.$notify({
                    type: 'info',
                    title: 'Success'
                })
            }).catch(e => {
                this.$notify({
                    type: 'error',
                    title: 'Error',
                    text: e.response.data.message
                })
                this.form[Object.keys(data)[0]] = !this.form[Object.keys(data)[0]]
            })
        }
    }

});

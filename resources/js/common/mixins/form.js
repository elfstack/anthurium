export default {
    methods: {
        /**
         * Submit the form
         *
         * @param ref reference to form
         * @param api api used for making request, will use data.api if not provided
         * @param payload data for request, will use data.data if not provided
         * @returns {Q.Promise<any> | Promise<void> | PromiseLike<any>}
         */
        $submit(ref = 'form', api=this.api, payload=this.data) {
            const form = this.$refs[ref]
            return form.validate().then(() => {
                return api(payload).then(response => {
                    return response
                }).catch(error => {
                    if (error.response.status === 422) {
                        const errors = error.response.data.errors
                        form.fields.filter(field => errors[field.prop] !== undefined).forEach(field => {
                            field.validateState = 'error'
                            // set to first error message
                            field.validateMessage = errors[field.prop][0]
                        })
                    }
                })
            })
        }
    }
}

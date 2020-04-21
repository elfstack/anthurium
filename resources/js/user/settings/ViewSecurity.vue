<template>

</template>

<script>
    export default {
        name: "ViewSecurity",
        props: {
            generatedKey: {
                type: String,
                required: true
            }
        },
        data () {
            return {
                otp: ''
            }
        },
        methods: {
            enable2FA () {
                window.axios.post('/api/otp/enable', {
                    key: this.generatedKey,
                    otp: this.otp
                }).then(({data}) => {
                    if (data.message == 'success') {
                        // enabled
                    } else {
                        // not enabled
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>

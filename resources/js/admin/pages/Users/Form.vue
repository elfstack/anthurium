<template>
    <a-form-model :model="data" ref="form" :label-col="labelCol" :wrapper-col="wrapperCol">
        <a-form-model-item label="Name" prop="name">
            <a-input v-model="data.name"></a-input>
        </a-form-model-item>

        <a-form-model-item label="Email" prop="email">
            <a-input v-model="data.email"></a-input>
        </a-form-model-item>

        <a-form-model-item label="Password" prop="password">
            <a-input v-model="data.password" type="password"></a-input>
        </a-form-model-item>

        <a-form-model-item label="Confirm Password" prop="password_confirm">
            <a-input v-model="data.password_confirm" type="password"></a-input>
        </a-form-model-item>
    </a-form-model>
</template>

<script>
    import form from "../../../common/mixins/form";

    export default {
        name: "Form",
        mixins: [ form ],
        props: {
            api: {
                type: Function,
                required: true
            },
            data: {
                type: Object,
                required: true
            }
        },
        data () {
            let validateConfirmPassword = (rule, value, callback) => {
                if (this.data.password !== '' && value !== this.data.password) {
                    callback(new Error('Password not match'))
                }
                callback()
            }

            return {
                loading: false,
                rules: {
                    name: [
                        {required: true}
                    ],
                    email: [
                        {required: true}
                    ],
                    password: [
                        {min: 6},
                    ],
                    password_confirm: [
                        {validator: validateConfirmPassword, trigger: 'change'}
                    ],
                }
            }
        }
    }
</script>

<style scoped>

</style>

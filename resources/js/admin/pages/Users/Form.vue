<template>
    <a-form-model :model="data" ref="form" :label-col="labelCol" :wrapper-col="wrapperCol" :rules="rules">
        <a-form-model-item label="Name" prop="name">
            <a-input v-model="data.name"></a-input>
        </a-form-model-item>

        <a-form-model-item label="Email" prop="email">
            <a-input v-model="data.email"></a-input>
        </a-form-model-item>

        <a-form-model-item label="Group" prop="user_group.id">
          <a-select
            @dropdownVisibleChange="getUserGroups"
            :loading="loading"
            @change="value => data.user_group.id = value"
          >
            <a-select-option
              v-for="group in userGroups"
              :key="group.id"
            >
              {{ group.name }}
            </a-select-option>
          </a-select>
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
    import userGroup from "../../../api/admin/userGroup";
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
                userGroups: [],
                loading: false,
                rules: {
                    name: [
                        {required: true}
                    ],
                    email: [
                        {required: true}
                    ],
                    'user_group.id': [
                      { required: true }
                    ],
                    password: [
                        {min: 6},
                    ],
                    password_confirm: [
                        {validator: validateConfirmPassword, trigger: 'change'}
                    ],
                }
            }
        },
        methods: {
          // TODO: use a set
          getUserGroups() {
            if (!this.userGroups.length) {
              this.loading = true
              userGroup.index().then(({data}) => {
                this.userGroups = data.user_groups
                this.loading = false
              })
            }
          },
        }
    }
</script>

<style scoped>

</style>

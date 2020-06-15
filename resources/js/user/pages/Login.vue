<template>
    <a-layout class="h-100">
        <a-row type="flex" justify="center" align="middle" class="h-100">
            <a-col :xs="24" :md="12" :lg="8">
                <a-card>
                    <h1 class="h1">Login</h1>
                    <div class="mb1">
                        <a-alert
                            message="Invalid credential"
                            banner
                            v-show="showError"
                        />
                    </div>
                    <a-form-model ref="login-form" :model="form" :rules="rules">
                        <a-form-model-item has-feedback prop="email">
                            <a-input v-model="form.email" type="email" size="large" placeholder="Email">
                                <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)"/>
                            </a-input>
                        </a-form-model-item>
                        <a-form-model-item has-feedback prop="password">
                            <a-input-password v-model="form.password" size="large" placeholder="Password">
                                <a-icon slot="prefix" type="lock" style="color:rgba(0,0,0,.25)"/>
                            </a-input-password>
                        </a-form-model-item>
                        <a-form-model-item>
                            <a-checkbox @change="onChange">
                                Remember Me
                            </a-checkbox>
                        </a-form-model-item>
                        <a-form-model-item>

                            <router-link class="login-form-forgot" :to="{ name: 'app.reset-password' }">
                                Forgot password
                            </router-link>
                            <a-button
                                type="primary"
                                html-type="submit"
                                @click="submit"
                                class="right"
                            >
                                Log in
                            </a-button>
                        </a-form-model-item>
                    </a-form-model>
                </a-card>
            </a-col>
        </a-row>
    </a-layout>
</template>

<script>
    import { mapActions } from 'vuex'

    export default {
        name: "Login",
        metaInfo: {
            title: 'Login | Anthurium'
        },
        data () {
            return {
                showError: false,
                form: {
                    email: '',
                    password: '',
                    remember: false
                },
                rules: {
                    email: [
                        {required: true, trigger: 'blur'},
                        {type: 'email', trigger: 'change'}
                    ],
                    password: [
                        {required: true, trigger: 'blur'}
                    ]
                }
            }
        },
        methods: {
            submit () {
                this.$refs['login-form'].validate(valid => {
                    if (valid) {
                        this.showError = false
                        this.login(this.form).catch((e) => {
                            this.showError = true
                        })
                    }
                })
            },
            onChange (e) {
                this.form.remember = e.target.checked
            },
            ...mapActions('user', [
                'login'
            ])
        }
    }
</script>

<style scoped>
.h-100 {
    height: 100%;
}
</style>

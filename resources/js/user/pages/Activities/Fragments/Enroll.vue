<template>
    <a-modal
        title="Enroll"
        :visible="visible"
        @ok="handleOk"
        ok-text="Enroll"
        @cancel="handleCancel"
    >
        <template v-if="$isLoggedIn()">
            Are you sure to enroll this activity?
        </template>
        <template v-else>
            <a-alert
                message="Already have an account? Login now."
                close-text="Login"
                @close="$router.push({ name: 'app.login' })"
            />
            <a-form-model>
                <a-form-model-item>
                    <a-form-model-item label="Name">
                        <a-input v-model="form.name" />
                    </a-form-model-item>

                    <a-form-model-item label="Email">
                        <a-input v-model="form.email" />
                    </a-form-model-item>
                </a-form-model-item>
            </a-form-model>
        </template>
    </a-modal>
</template>

<script>
    import activity from "../../../../api/user/activity";

    export default {
        name: "Enroll",
        props: {
            id: {
                type: Number,
                required: true
            }
        },
        data () {
            return {
                visible: false,
                form: {
                    name: '',
                    email: ''
                }
            }
        },
        methods: {
            $toggleVisibility () {
                this.visible = !this.visible
            },
            handleOk () {
                const enroll = this.$isLoggedIn() ? this.userEnroll : this.guestEnroll;

                enroll().then(({ data }) => {
                    this.$toggleVisibility()
                    this.$message.success(data.message)
                  // TODO: update view when successfully enrolled
                })
            },
            handleCancel () {
                this.$toggleVisibility()
            },
            userEnroll () {
                return activity.enroll(this.id, null)
            },
            guestEnroll () {
                return activity.enroll(this.id, this.form)
            }
        }
    }
</script>

<style scoped>

</style>

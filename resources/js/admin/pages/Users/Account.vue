<template>
    <div>
        <a-row :gutter="[16,16]">
            <a-col>
                <a-card title="Account Info">
                    <user-form
                        ref="user-form"
                        :data.sync="user"
                        :api="api"/>

                    <template #extra>
                        <a-button type="primary" @click="submit">Update</a-button>
                    </template>
                </a-card>
            </a-col>
        </a-row>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import Form from './form'
    import user from "../../../api/admin/user";

    export default {
        name: "Account",
        components: {
            'user-form': Form
        },
        data () {
            return {
                api: (payload) => user.update(this.user.id, payload)
            }
        },
        computed: {
            ...mapState({
                user: state => state.user.user
            })
        },
        methods: {
            submit () {
                this.$refs['user-form'].$submit().then(() => {
                    this.$message.success('User updated!')
                    // TODO: update state
                })
            }
        }
    }
</script>

<style scoped>

</style>

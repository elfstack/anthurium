<template>
    <div>
      <a-row :gutter="[16, 16]">
        <a-col>
          <div v-for="action in user.pending_actions" :key="action.id">
            <template v-if="action.type === 'member-application'">
              <a-alert
                message="Membership Application"
                type="info"
                show-icon
              >
                <template #description>
                  <p>
                    {{ `${user.name} has been applied for membership` }}
                  </p>

                  <a @click="activeActionId = action.id">View Application Form</a>
                </template>
              </a-alert>
              <action-model :id.sync="activeActionId" v-if="activeActionId"/>
            </template>
          </div>
        </a-col>
      </a-row>
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
    import Form from '../Form'
    import user from "../../../../api/admin/user";

    import ActionModel from '../../../components/ActionModel'

    export default {
        name: "Account",
        components: {
            'user-form': Form,
            'action-model': ActionModel
        },
        data () {
            return {
                api: (payload) => user.update(this.user.id, payload),
                user: null,
                activeActionId: null
            }
        },
        mounted () {
            this.user = Object.assign({}, this.$store.state.user.user)
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

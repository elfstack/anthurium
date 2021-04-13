<template>
  <div>
    <a-page-header title="Create User" @back="$router.go(-1)"></a-page-header>
    <div class="p2">
      <a-row :gutter="[16,16]">
        <a-col>
          <a-card title="Account">
            <user-account-form
              ref="user-form"
              :data.sync="user"
              :api="api"/>

            <template #extra>
              <a-button type="primary" @click="submit">Create</a-button>
            </template>
          </a-card>
        </a-col>
      </a-row>
    </div>
  </div>
</template>

<script>
  import Form from './Form'
  import user from "../../../api/admin/user";

  export default {
    name: "Create",
    components: {
      userAccountForm: Form
    },
    data() {
      return {
        api: user.create,
        user: {
          name: '',
          email: ''
        }
      }
    },
    methods: {
      submit () {
        this.$refs['user-form'].$submit().then(({data}) => {
          this.$message.success('User created!')
          this.$router.push({ name: 'admin.members.show.account', params: { id: data.user.id }})
        })
      }
    }
  }
</script>

<style scoped>

</style>

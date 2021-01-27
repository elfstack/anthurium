<template>
  <div class="p3">
    <h1>Register</h1>
    <a-row :gutter="[16,16]">
      <a-col>
        <a-card>
            <a-form-model :model="form" ref="form" :label-col="labelCol" :wrapper-col="wrapperCol">
              <a-form-model-item label="Name" prop="name">
                <a-input v-model="form.name"></a-input>
              </a-form-model-item>

              <a-form-model-item label="Email" prop="email">
                <a-input v-model="form.email"></a-input>
              </a-form-model-item>

              <a-form-model-item label="Password" prop="password">
                <a-input v-model="form.password" type="password"></a-input>
              </a-form-model-item>

              <a-form-model-item label="Confirm Password" prop="password_confirm">
                <a-input v-model="form.password_confirm" type="password"></a-input>
              </a-form-model-item>

              <a-form-model-item :wrapper-col="btnWrapperCol">
                <a-button type="primary" @click="register">Register</a-button>
              </a-form-model-item>
            </a-form-model>
        </a-card>

      </a-col>
    </a-row>

    <a-row :gutter="[16,16]" type="flex" justify="center">
      <a-col>
      </a-col>
    </a-row>
  </div>
</template>

<script>
  import user from "../../api/user/user";
  import form from "../../common/mixins/form";

  export default {
    name: "Register",
    mixins: [ form ],
    data () {
      return {
        form: {

        }
      }
    },
    metaInfo: {
        title: 'Register'
    },
    methods: {
      register () {
        user.register(this.form).then(({ data }) => {
          this.$message.success('Success')
          this.$router.push({ name: 'app.login' })
        })
      }
    }
  }
</script>

<style scoped>

</style>

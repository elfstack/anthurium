<template>
  <div class="p3">
    <h1>Register</h1>
    <a-row :gutter="[16,16]">
      <a-col>
        <a-card title="Account">
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
            </a-form-model>
        </a-card>

      </a-col>
    </a-row>

    <a-row :gutter="[16,16]" type="flex" justify="center">
      <a-col>
        <a-button type="primary" @click="register">Register</a-button>
      </a-col>
    </a-row>
  </div>
</template>

<script>
  import form from "../../common/mixins/form"
  import formApi from '../../api/user/form'
  import Question from '../components/Question'
  import user from "../../api/user/user"

  export default {
    name: "Register",
    mixins: [ form ],
    components: {
      'question': Question
    },
    data () {
      return {
        form: {
          answers: []
        },
        questions: [],
      }
    },
    beforeRouteEnter (to, from, next) {
        const registrationFormId = 6
        formApi.questions(registrationFormId).then(({ data }) => {
        next(vm => {
          vm.setQuestions(data.questions)
        })
      })
    },
    beforeRouteUpdate (to, from, next) {
      // TODO: replace with real form id
      const registrationFormId = 6
      formApi.questions(registrationFormId).then(({ data }) => {
        this.setQuestions(data.questions)
        next()
      })
    },
    metaInfo: {
        title: 'Register'
    },
    methods: {
      setQuestions (questions) {
        this.questions = []
        this.questions = questions
      },
      register () {
        this.form.answers = this.$refs['question'].map(function (question) {
          return question.$collectAnswer()
        })

        user.register(this.form).then(({ data }) => {
          this.$message.success('Success')
          // TODO: logged in current user
        })
      }
    }
  }
</script>

<style scoped>

</style>

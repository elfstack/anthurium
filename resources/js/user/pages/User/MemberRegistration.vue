<template>
    <div class="p2">
      <h1>Member Registration</h1>
      <a-row :gutter="[16, 16]">
        <a-col>
          <a-card class="card-dense">
            <a-steps :current="step">
              <a-step title="Personal Info" />
              <a-step title="Pending Approval" />
              <a-step title="Joined" />
            </a-steps>
          </a-card>
        </a-col>
      </a-row>
      <a-row :gutter="[16, 16]">
        <a-col>
          <a-card v-if="step === 0">
            <question v-for="question in questions"
                      :key="question.id"
                      :question="question"
                      ref="question"
            is-editing/>
            <a-button type="primary" @click="collectAnswer">Submit</a-button>
          </a-card>

          <a-card v-if="step === 1">
            <div style="text-align: center">
              <a-icon type="clock-circle" theme="filled" style="font-size: 72px; color: #1890ff"></a-icon>
              <h1>Pending Approval</h1>
              <p>
                You have submitted the member application form. Our staff will review your application and notify you soon.
              </p>
            </div>
          </a-card>
        </a-col>
      </a-row>
    </div>
</template>

<script>
  import { mapState } from 'vuex';

  import Question from '../../components/Question';
  import form from "../../../api/user/form";

  export default {
      name: "MemberRegistration",
      components: {
        'question': Question
      },
      data () {
        return {
          questions: [],
          response: {},
          step: 0
        }
      },
      computed: {
        ...mapState({
          isMemberApplicationFormFilled: state => state.user.is_member_application_form_filled
        })
      },
      mounted () {
        if (this.isMemberApplicationFormFilled) this.step = 1

        form.questions(this.$config('user.member_application.data_collection').form_id).then(({data}) => {
          this.questions = data.questions
        })
      },
      methods: {
        collectAnswer () {
          this.response = this.$refs['question'].map(function (question) {
            return question.$collectAnswer()
          })

          console.log(this.response)

          form.saveResponse(this.$config('user.member_application.data_collection').id, {
            response: this.response
          }).then(({data}) => {
            this.step = 1
          })
        }
      }
  }
</script>

<style scoped>

</style>

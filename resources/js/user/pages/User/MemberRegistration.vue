<template>
  <div class="p2">
    <h1>Member Registration</h1>
    <a-row :gutter="[16, 16]">
      <a-col>
        <a-card class="card-dense">
          <a-steps :current="step">
            <a-step title="Personal Info"/>
            <a-step title="Pending Approval"/>
            <a-step title="Finish"/>
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
              You have submitted the member application form. Our staff will review your application and notify you
              soon.
            </p>
          </div>
        </a-card>

        <a-card v-if="step === 2">
          <div style="text-align: center" v-if="action.result === 'rejected'">
            <a-icon type="close-circle" theme="filled" style="font-size: 72px; color: #ff4d4f"/>
            <h1>Member Application Not Passed</h1>
            <p>
              Your application does not fulfill our standard. Please edit and resubmit.
            </p>
            <a-button type="primary" @click="restart">Retry</a-button>
          </div>

          <div style="text-align: center" v-if="action.result === 'approved'">
            <a-icon type="check-circle" theme="filled" style="font-size: 72px; color: #52c41a"/>
            <h1>Member Application Passed</h1>
            <p>
              Congratulation! You are now a member of our organisation.
            </p>
          </div>
        </a-card>

      </a-col>
    </a-row>
  </div>
</template>

<script>
  import {mapState} from 'vuex'

  import Question from '../../components/Question'
  import form from "../../../api/user/form"
  import action from '../../../api/user/action'
  import dataCollection from "../../../api/user/dataCollection";

  export default {
    name: "MemberRegistration",
    components: {
      'question': Question
    },
    data() {
      return {
        questions: [],
        response: {},
        step: 0,
        action: null
      }
    },
    mounted() {
      action.findAction('member-application').then(({data}) => {
        this.step = data.action.step
        this.action = data.action

        if (data.action.dataCollectionResponse) {
          this.questions = data.action.dataCollectionResponse.response
        }
      }).catch((e) => {
        // TODO: only 404
        form.questions(this.form.id).then(({data}) => {
          this.questions = data.questions
        })
      })
    },
    methods: {
      collectAnswer() {
        this.response = this.$refs['question'].map(function (question) {
          return question.$collectAnswer()
        })

        dataCollection.saveResponse(this.$route.id, {
          response: this.response
        }).then(({data}) => {
          this.step = 1
        })
      },
      async restart() {
        try {
          await action.restart(this.action.id)
          this.step = 0
        } catch (e) {
          // TODO: handle error
        }
      }
    },
  }
</script>

<style scoped>

</style>

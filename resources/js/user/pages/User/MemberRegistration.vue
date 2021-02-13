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
          <a-card>
            <question v-for="question in questions"
                      :key="question.id"
                      :question="question"
                      ref="question"
            is-editing/>
            <a-button type="primary" @click="collectAnswer">Submit</a-button>
          </a-card>
        </a-col>
      </a-row>
    </div>
</template>

<script>
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
      mounted () {
        form.questions(1).then(({data}) => {
          this.questions = data.questions
        })
      },
      methods: {
        collectAnswer () {
          this.response = this.$refs['question'].map(function (question) {
            return question.$collectAnswer()
          })

          console.log(this.response)

          form.saveResponse(7, {
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

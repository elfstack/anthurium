<template>
  <div>
    <a-card v-if="!isEditing && questions.length === 0">
      <a-empty>
        <a-button type="primary" @click="addQuestion">
          Add Question
        </a-button>
      </a-empty>
    </a-card>
    <template v-else>
    <a-skeleton v-if="loading"/>
    <template v-else>
      <a-row :gutter="[16,16]" v-for="(question, idx) in questions" :key="question.id">
        <a-col>
          <a-card :title="`Question ${idx + 1}`">
            <template #extra v-if="isEditing">
              <a-button icon="delete" @click="removeQuestion(idx)"></a-button>
              <a-button icon="edit" @click="startQuestionEdit(idx)" v-show="currentEditingIndex === null"></a-button>
              <a-button icon="save" @click="saveQuestionEdit" v-show="currentEditingIndex === idx"
                        type="primary"></a-button>
            </template>
            <template v-if="idx === currentEditingIndex">
              <a-form-model :model="questionForm" :wrapper-col="wrapperCol" :label-col="labelCol">
                <a-form-item label="Question" prop="question">
                  <a-input v-model="questionForm.question"></a-input>
                </a-form-item>

                <a-form-item label="Required" prop="is_required">
                  <a-switch v-model="questionForm.is_required"></a-switch>
                </a-form-item>

                <a-form-item label="Type" prop="type">
                  <a-select v-model="questionForm.type" @change="initQuestionForm">
                    <a-select-option value="text">
                      Text
                    </a-select-option>
                    <a-select-option value="textarea">
                      Textarea
                    </a-select-option>
                    <a-select-option value="checkbox">
                      Checkbox
                    </a-select-option>
                    <a-select-option value="radio">
                      Radio
                    </a-select-option>
                  </a-select>
                </a-form-item>

                <template v-if="questionForm.type.substr(0, 4) === 'text'">
                  <a-form-item prop="max_character" label="Max Character">
                    <a-input-number v-model="questionForm.max_character"></a-input-number>
                  </a-form-item>
                </template>
                <template v-else>
                  <a-form-item prop="options" label="Options">
                    <a-form-item
                      v-for="(option, index) in questionForm.options"
                      :key="option.id"
                      :required="false"
                    >
                      <a-input
                        v-decorator="[
                        `names[${index}]`,
                        {
                          validateTrigger: ['change', 'blur'],
                          rules: [
                            {
                              required: true,
                              whitespace: true,
                              message: 'Please input passenger\'s name or delete this field.',
                            },
                          ],
                        },
                      ]"
                        :placeholder="`Option: ${index}`"
                        style="width: 60%; margin-right: 8px"
                        v-model="questionForm.options[index].value"
                      />
                      <a-icon
                        v-if="questionForm.options.length > 1"
                        class="dynamic-delete-button"
                        type="minus-circle-o"
                        :disabled="questionForm.options.length === 1"
                        @click="() => removeOption(index)"
                      />
                    </a-form-item>
                    <a-form-item>
                      <a-button type="dashed" @click="addOption">
                        <a-icon type="plus"/>
                        Add Option
                      </a-button>
                    </a-form-item>
                  </a-form-item>
                </template>
              </a-form-model>
            </template>
            <template v-else>
              <p :class="{ 'ant-form-item-required': question.is_required }">{{ question.question }}</p>
              <template v-if="question.type === 'checkbox' || question.type === 'radio'">
                <component :is="`a-${question.type}`" v-for="option in question.options">{{ option.value }}</component>
              </template>
            </template>
          </a-card>
        </a-col>
      </a-row>

      <a-row :gutter="[16,16]">
        <a-col>
          <a-button type="dashed" icon="plus" block @click="addQuestion" v-show="!currentEditingIndex && isEditing">
            Add
          </a-button>
        </a-col>
      </a-row>
    </template>
    </template>
  </div>
</template>

<script>
  import form from "../../../api/admin/form";
  import formLayouts from "../../../common/mixins/formLayouts";

  export default {
    name: "Questions",
    mixins: [formLayouts],
    props: {
      formId: {
        required: true,
        type: Number
      },
      isEditing: {
        required: true,
        type: Boolean,
        default: false
      }
    },
    data() {
      return {
        loading: true,
        // questions: [
        //   {
        //     id: '1',
        //     type: 'checkbox',
        //     question: 'Price of t-shirt?',
        //     options: [
        //       { value: 'test' },
        //       { value: 'test1' },
        //       { value: 'test3' },
        //       { value: 'test4' }
        //     ]
        //   }
        // ],
        questions: [],
        questionForm: {
          question: ''
        },
        currentEditingIndex: null
      }
    },
    mounted () {
      this.loadQuestions()
    },
    watch: {
      'formId': 'loadQuestions'
    },
    methods: {
      loadQuestions() {
        this.loading = true
        form.questions(this.formId).then(({data}) => {
          this.questions = data.questions
          this.loading = false
        })
      },
      startQuestionEdit(idx) {
        this.questionForm = Object.assign({}, this.questions[idx])
        this.initQuestionForm(this.questionForm.type)
        this.currentEditingIndex = idx
      },
      initQuestionForm(value) {
        if (value.substr(0, 4) === 'text') {
          delete this.questionForm.options
        } else {
          delete this.questionForm.max_character
          if (!this.questionForm.options) {
            this.questionForm.options = []
          }
        }
      },
      addQuestion() {
        this.isEditing = true
        this.questions.push({
          question: '',
          type: 'text'
        })
        this.startQuestionEdit(this.questions.length - 1)
      },
      addOption() {
        this.questionForm.options.push({value: ''})
      },
      removeOption(idx) {
        this.questionForm.options.splice(idx, 1)
      },
      saveQuestionEdit() {
        let request;

        if (!this.questionForm.sequence) {
          this.questionForm.sequence = this.currentEditingIndex
        }

        if (this.questionForm.id) {
          request = form.updateQuestion(this.$route.params.id, this.questionForm.id, this.questionForm)
        } else {
          request = form.createQuestion(this.$route.params.id, this.questionForm)
        }

        request.then(({data}) => {
          this.questions.splice(this.currentEditingIndex, 1, data.question)
          this.currentEditingIndex = null
        })
      },
      removeQuestion(idx) {
        // FIXME: this method is not reactive
        const questionId = this.questions[idx].id
        const deleteQuestionIdx = this.questions.findIndex(question => question.id === questionId)
        console.log('questions before delete', this.questions)
        console.log('question id will be deleted', questionId)
        console.log('delete question idx', deleteQuestionIdx)
        console.log('questions after delete', this.questions)

        if (questionId) {
          form.removeQuestion(this.$route.params.id, questionId).then(({data}) => {
            this.$delete(this.questions, deleteQuestionIdx)
            this.$message.success('deleted')
          })
        } else {
          this.$delete(this.questions, deleteQuestionIdx)
          this.$message.success('deleted')
        }
      }
    }
  }
</script>

<style scoped>

</style>

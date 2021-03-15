<template>
  <div>
    <a-page-header title='Form' :sub-title="form.title" @back="$router.go(-1)" style="background: #fff">
      <template slot="extra">
        <a-button type="primary" @click="isEditing = true" v-if="!isEditing">Edit Questions</a-button>
        <a-button @click="isEditing = false" v-else>Quit Editing</a-button>
      </template>
    </a-page-header>

    <div class="p2">
    <a-row :gutter="[16, 16]">
      <a-col>
        <h3>Description</h3>
        <a-card
          :loading="isLoading">
          {{ form.description }}
        </a-card>
      </a-col>
    </a-row>
    <a-row :gutter="[16, 16]">
      <a-col>
        <h3>Questions</h3>
        <questions :form-id="form.id" :is-editing="isEditing"/>
      </a-col>
    </a-row>
    </div>
  </div>
</template>

<script>
  import form from "../../../api/admin/form"
  import listing from "../../../common/mixins/listing"
  import Questions from './Questions'

  export default {
    name: "Show",
    mixins: [ listing ],
    components: {
      'questions': Questions
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.loadForm(to.params.id)
      })
    },
    beforeRouteUpdate(to, from, next) {
      this.loadForm(to.params.id)
      next()
    },
    data () {
      return {
        isLoading: true,
        isEditing: false,
        form: { }
      }
    },
    methods: {
      async loadForm (id) {
        form.show(id).then(({data}) => {
          this.form = data.form
          this.isLoading = false
        }).catch(error => {
          if (error.response.status === 404) {
            this.$router.replace({name: '404'})
          }
        })
      },
    }
  }
</script>

<style scoped>

</style>

<template>
  <div>
    <a-page-header :title="form.title" @back="$router.go(-1)" style="background: #fff">
      <template slot="extra">
        <a-button type="primary" @click="isEditing = true" v-if="!isEditing">Edit</a-button>
        <a-button @click="isEditing = false" v-else>Quit Editing</a-button>
      </template>
      <template slot="footer">
        <a-tabs default-active-key="show" @change="changeTab">
          <a-tab-pane key="show" tab="Questions"/>
          <a-tab-pane key="show.data-collection" tab="Data Collection" />
        </a-tabs>
      </template>
    </a-page-header>

    <div class="p2">
    <a-row :gutter="[16, 16]">
      <a-col>
        <a-card
          :loading="isLoading">
          <div style="white-space: pre-line">{{ form.description }}</div>
        </a-card>
      </a-col>
    </a-row>
    <a-row :gutter="[16, 16]">
      <a-col>
        <questions :form-id="form.id" :is-editing="isEditing" v-if="form.id"/>
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
      changeTab (key) {
        this.$router.push({ name: 'admin.forms.' + key, params: { id: this.$route.params.id } })
      }
    }
  }
</script>

<style scoped>

</style>

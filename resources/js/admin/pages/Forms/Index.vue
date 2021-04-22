<template>
  <a-layout>
    <a-modal
      title="Create Form"
      :visible="createModalVisible"
      :confirm-loading="creating"
      @ok="createForm"
      @cancel="() => { createModalVisible = false }"
    >
      <a-form-model
        :model="form"
        ref="form"
        :rules="rules"
        :wrapper-col="wrapperCol"
        :label-col="labelCol">
        <a-form-model-item prop="title" label="Title">
          <a-input v-model="form.title" placeholder="Title"/>
        </a-form-model-item>

        <a-form-model-item prop="description" label="Description">
          <a-textarea v-model="form.description" placeholder="Description"/>
        </a-form-model-item>

      </a-form-model>
    </a-modal>

    <a-page-header title="Forms">
      <template #extra>
        <a-button type="primary" icon="plus" @click="createModalVisible = true">
          Create
        </a-button>
      </template>
    </a-page-header>

    <div class="p2">
      <a-card class="card-dense">
        <a-table
          @change="handleChange"
          :pagination="listing.pagination"
          :loading="loading"
          :columns="columns"
          row-key="id"
          :data-source="data">

          <span slot="action" slot-scope="text,record">
              <router-link
                :to="{ name: 'admin.forms.show', params: { id: record.id }}">View</router-link>
          </span>

        </a-table>
      </a-card>
    </div>
  </a-layout>
</template>

<script>
  import listing from "../../../common/mixins/listing";
  import formMixin from "../../../common/mixins/form";

  import form from "../../../api/admin/form";

  export default {
    name: "Index",
    mixins: [listing, formMixin],
    metaInfo: {
      title: 'Data Collection'
    },
    data() {
      return {
        api: form.index,
        createModalVisible: false,
        formListVisible: false,
        creating: false,
        purposeColourMap: {
          'member-application': 'purple',
        },
        form: {
          title: '',
          description: ''
        },
        rules: {
          title: [
            {required: true}
          ]
        },
        columns: [
          {
            dataIndex: 'title',
            title: 'Title'
          },
          {
            dataIndex: 'updated_at',
            title: 'Updated At',
            customRender: (text) => this.$moment(text).format('LLL')
          },
          {
            dataIndex: 'action',
            title: 'Action',
            scopedSlots: {customRender: 'action'}
          },
        ]
      }
    },
    methods: {
      createForm() {
        this.$submit('form', form.create, this.form).then(({data}) => {
          this.$router.push({name: 'admin.forms.show.questions', params: {id: data.form.id}})
        })
      },
    }
  }
</script>

<style scoped>

</style>

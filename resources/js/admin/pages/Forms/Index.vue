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

    <a-page-header title="Data Collection">
      <template #extra>
        <a-button-group>
          <a-button type="primary" icon="profile" @click="formListVisible = true">
            Forms
          </a-button>
        </a-button-group>
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

          <span slot="purpose" slot-scope="text,record">
            <a-tag :color="purposeColourMap[text] ? purposeColourMap[text] : 'blue'">
              {{ text }}
            </a-tag>
          </span>

          <span slot="action" slot-scope="text,record">
              <router-link
                :to="{ name: 'admin.data-collection.show', params: { id: record.id }}">View</router-link>
          </span>

        </a-table>
      </a-card>
    </div>

    <a-drawer
      width="40%"
      placement="right"
      :closable="false"
      :visible="formListVisible"
      @close="formListVisible = false"
    >
      <template #title>
        <div style="display: flex; justify-content: space-between">
          <h3 style="margin: 0">Forms</h3>
          <a-button type="primary" icon="plus" @click="createModalVisible = true">
            Create
          </a-button>
        </div>
      </template>
      <form-index />
    </a-drawer>

  </a-layout>

</template>

<script>
  import FormIndex from './FormIndex';

  import listing from "../../../common/mixins/listing";
  import formMixin from "../../../common/mixins/form";

  import form from "../../../api/admin/form";
  import dataCollection from "../../../api/admin/dataCollection";

  export default {
    name: "Index",
    mixins: [listing, formMixin],
    metaInfo: {
      title: 'Data Collection'
    },
    components: {
      'form-index': FormIndex
    },
    data() {
      return {
        api: dataCollection.index,
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
            dataIndex: 'purpose',
            title: 'Purpose',
            scopedSlots: {customRender: 'purpose'}
          },
          {
            dataIndex: 'form.title',
            title: 'Form'
          },
          {
            dataIndex: 'created_at',
            title: 'Created At',
            customRender: (text) => this.$moment(text).format('LLL')
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
          }
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

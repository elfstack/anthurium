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
      <a-row :gutter="[16,16]">
        <a-col>
          <a-card>
            <a-table
              @change="handleChange"
              :pagination="listing.pagination"
              :loading="loading"
              :columns="columns"
              row-key="id"
              :data-source="data">

                            <span slot="action" slot-scope="text,record">
                                <router-link
                                  :to="{ name: 'admin.forms.show', params: { id: record.id }}">Details</router-link>
                            </span>

            </a-table>
          </a-card>
        </a-col>
      </a-row>
    </div>

  </a-layout>

</template>

<script>
  import form from "../../../api/admin/form";
  import listing from "../../../common/mixins/listing";
  import formMixin from "../../../common/mixins/form";

  export default {
    name: "Index",
    mixins: [listing, formMixin],
    metaInfo: {
      title: 'Forms'
    },
    data() {
      return {
        createModalVisible: false,
        creating: false,
        form: {
          title: '',
          description: ''
        },
        rules: {
          title: [
            {required: true}
          ]
        },
        api: form.index,
        columns: [
          {
            dataIndex: 'id',
            key: 'id',
            title: 'ID',
            sorter: true
          },
          {
            dataIndex: 'title',
            key: 'title',
            title: 'Title'
          },
          {
            dataIndex: 'action',
            key: 'action',
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

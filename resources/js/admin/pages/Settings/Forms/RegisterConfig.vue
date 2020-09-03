<template>
  <div>
    <a-form-model :model="configs" ref="form" :rules="rules" :label-col="labelCol" :wrapper-col="wrapperCol">
        <a-form-model-item label="Allow Registration" prop="registration">
            <a-switch v-model="configs.registration"/>
        </a-form-model-item>

        <a-form-model-item label="Collect Register Info" prop="registration_form" v-if="configs.registration">
          <a-switch v-model="configs.registration_form"/>
        </a-form-model-item>

        <a-form-model-item label="Registration Form" prop="registration_form_id" v-if="configs.registration_form">
            <a-input @click="showModal" :value="formRepr"></a-input>
        </a-form-model-item>

        <a-form-model-item :wrapper-col="btnWrapperCol">
          <a-button type="primary" @click="$submit('form', submitApi, configs)">Save</a-button>
        </a-form-model-item>
    </a-form-model>

    <a-modal
      title="Select Form"
      :visible="modalVisible"
      @cancel="handleCancel"
      @ok="handleOk"
    >
      <a-table
        v-if="modalVisible"
        @change="handleChange"
        :pagination="listing.pagination"
        :scroll="{ y: 240 }"
        :loading="loading"
        :columns="columns"
        row-key="id"
        :row-selection="{
              type: 'radio',
              onSelect: onFormSelected
            }"
        :data-source="data">
      </a-table>
    </a-modal>
  </div>
</template>

<script>
  import config from '../../../../api/admin/config'
    import formApi from '../../../../api/admin/form'
    import form from "../../../../common/mixins/form";
    import listing from "../../../../common/mixins/listing";

    export default {
      name: "RegisterConfigs",
      props: {
        settings: {
          required: true,
          type: Object
        }
      },
      watch: {
        'settings': function (val) {
          this.configs = Object.assign({}, val)
        }
      },
      mixins: [ form, listing ],
      data () {
        return {
          configs: {
          },
          forms: [],
          modalVisible: false,
          selectedForm: {},
          api: formApi.index,
          submitApi: config.update,
          rules: {},
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
          ],
          form: null
        }
      },
      computed: {
        formRepr () {
          if (this.form) {
            return this.form.title
          }
          else {
            return this.configs.registration_form_id_repr
          }
        }
      },
      methods: {
        onOpen () {
          formApi.index().then(({ data }) => {
            this.forms = data.data
          })
        },
        showModal () {
          this.modalVisible = true
        },
        onFormSelected (record) {
          this.selectedForm = record
        },
        handleOk(e) {
          this.form = Object.assign({}, this.selectedForm)
          this.configs.registration_form_id = this.selectedForm.id
          this.modalVisible = false
        },
        handleCancel(e) {
          this.modalVisible = false
        },
      }
    }
</script>

<style scoped>

</style>

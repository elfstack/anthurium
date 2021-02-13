<template>
  <div class="p2">
    <a-row :gutter="[16,16]">
      <a-col>
        <a-form-model :wrapper-col="wrapperCol" :label-col="labelCol">
          <a-form-model-item label="Stage">
            <a-select :options="dataCollectionStageOptions">

            </a-select>
          </a-form-model-item>

          <a-form-model-item label="Form">
            <a-select>

            </a-select>
          </a-form-model-item>

          <a-form-model-item :wrapper-col="btnWrapperCol">
            <a-button type="primary">Create</a-button>
          </a-form-model-item>
        </a-form-model>
      </a-col>
    </a-row>
    <a-row :gutter="[16,16]">
      <a-col>
        <a-card class="card-dense">
          <a-table
            @change="handleChange"
            :pagination="listing.pagination"
            :loading="loading"
            :columns="columns"
            row-key="id"
            :data-source="data">
            <span slot="stage" slot-scope="text, record">
              <a-tag>{{ text }}</a-tag>
            </span>
          </a-table>
        </a-card>
      </a-col>
    </a-row>
  </div>
</template>

<script>
  import listing from "../../../../common/mixins/listing";
  import activity from "../../../../api/admin/activity";
  import form from "../../../../common/mixins/form";

  export default {
    name: "DataCollection",
    mixins: [listing, form],
    data() {
      return {
        api: activity.dataCollection,
        columns: [
          {dataIndex: 'stage', title: 'Stage', scopedSlots: {customRender: 'stage'}},
          {dataIndex: 'form.title', title: 'Form'},
          {dataIndex: 'response.collected_response_count', title: 'Collected Response'},
          {dataIndex: 'action', title: 'Action'}
        ],
        dataCollectionStageOptions: [
          { value: 'enroll', label: 'Enroll' },
          { value: 'admitted', label: 'Admitted' },
          { value: 'left', label: 'Left' }
        ]
      }
    }
  }
</script>

<style scoped>

</style>

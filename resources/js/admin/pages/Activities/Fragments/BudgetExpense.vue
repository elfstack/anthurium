<template>
  <div>
    <a-row :gutter="[16,16]">
      <a-col :md="12">
        <a-card>
          <a-statistic
            title="Income"
            :value="2000.00"
            :value-style="{ color: '#3f8600' }"
            :precision="2">
            <template #suffix>
              <span>/ 2000.00</span>
            </template>
          </a-statistic>
        </a-card>
      </a-col>
      <a-col :md="12">
        <a-card>
          <a-statistic
            title="Expense"
            :value="1242.00"
            :value-style="{ color: '#cf1322' }"
            :precision="2">
            <template #suffix>
              <span>/ 2000.00</span>
            </template>
          </a-statistic>
        </a-card>
      </a-col>
    </a-row>
    <a-row :gutter="[16,16]">
      <a-col>
        <a-card>
          <a-list
            size="large"
            :pagination="listing.pagination"
            :data-source="data"
            :loading="loading">
            <a-list-item slot="renderItem" key="item.id" slot-scope="item, index">
              <a-list-item-meta>
                <a slot="title">{{ item.item }}</a>
                <span slot="description">{{ item.updated_at | moment('LLL') }}</span>
              </a-list-item-meta>
              <div :class="{ 'is-income' : isIncome(item) }" class="amount">
                <template v-if="item.actual">
                  <div>{{ isIncome(item) ? '+' : '-' }}{{ item.actual }}</div>
                  <div class="budget">{{ isIncome(item) ? '+' : '-' }}{{ item.budget }}</div>
                </template>
              </div>
            </a-list-item>
          </a-list>
        </a-card>
      </a-col>
    </a-row>
  </div>
</template>

<script>
  import budget from "../../../../api/admin/budget"
  import listing from "../../../../common/mixins/listing"
  import form from "../../../../common/mixins/form"

  export default {
    name: "BudgetExpense",
    mixins: [ form, listing ],
    data () {
      return {
        api: (paramBag) => budget.index(this.$route.params.id, paramBag),
        listing: {
          pagination: {
            onChange: this.handlePageChange,
            onShowSizeChange: this.handlePageSizeChange,
            showTotal: (total, range) => `${range[0]}-${range[1]} of ${total} records`,
            showSizeChanger: true
          },
          sorter: {},
          filters: {},
          keyword: ''
        }
      }
    },
    methods: {
      isIncome (budget) {
        return budget.type === 'income'
      }
    }
  }
</script>

<style scoped>
  .is-income {
    color: #52c141 !important;
  }

  .amount {
    color: #f5222d;
    text-align: right;
  }

  .budget {
    text-decoration: line-through;
    color: #636b6f;
    text-align: right;
  }
</style>

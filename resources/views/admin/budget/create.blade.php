    <div class="container-xl">

                <div class="card mb-0">

        <budget-form
            :action="modalParams.action"
            @update="updateBudgetList"
            :data="modalParams.data"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header" v-if="data">
                    <i class="fa fa-pencil"></i> {{ trans('admin.budget.actions.edit') }} @{{ data.name }}
                </div>

                <div class="card-header" v-else>
                    <i class="fa fa-plus"></i> {{ trans('admin.budget.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.budget.components.form-elements')
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>

            </form>

        </budget-form>

        </div>

        </div>


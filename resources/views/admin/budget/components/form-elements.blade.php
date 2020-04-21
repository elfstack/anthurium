<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.budget.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.budget.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('budget_category_id'), 'has-success': fields.budget_category_id && fields.budget_category_id.valid }">
    <label for="budget_category_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.budget.columns.budget_category_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect
            :class="{'form-control-danger': errors.has('budget_category_id'), 'form-control-success': fields.budget_category_id && fields.budget_category_id.valid}" id="budget_category_id" name="budget_category_id"
            :options="{{ $budgetCategory->toJson() }}"
            v-model="budgetSelected"
            @input="value => form.budget_category_id = value.id" v-validate="'required'"
            searchable close-on-select label="name" track-by="id" show-labels
            placeholder="Category">
        </multiselect>
        <div v-if="errors.has('budget_category_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('budget_category_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('budget'), 'has-success': fields.budget && fields.budget.valid }">
    <label for="budget" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.budget.columns.budget') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.budget" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('budget'), 'form-control-success': fields.budget && fields.budget.valid}" id="budget" name="budget" placeholder="{{ trans('admin.budget.columns.budget') }}">
        <div v-if="errors.has('budget')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('budget') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('expense'), 'has-success': fields.expense && fields.expense.valid }">
    <label for="expense" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.budget.columns.expense') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.expense" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('expense'), 'form-control-success': fields.expense && fields.expense.valid}" id="expense" name="expense" placeholder="{{ trans('admin.budget.columns.expense') }}">
        <div v-if="errors.has('expense')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('expense') }}</div>
    </div>
</div>




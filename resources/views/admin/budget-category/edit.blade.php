@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.budget-category.actions.edit', ['name' => $budgetCategory->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <budget-category-form
                :action="'{{ $budgetCategory->resource_url }}'"
                :data="{{ $budgetCategory->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.budget-category.actions.edit', ['name' => $budgetCategory->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.budget-category.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </budget-category-form>

        </div>
    
</div>

@endsection
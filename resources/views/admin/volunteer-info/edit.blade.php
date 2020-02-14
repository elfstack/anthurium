@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.volunteer-info.actions.edit', ['name' => $volunteerInfo->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <volunteer-info-form
                :action="'{{ $volunteerInfo->resource_url }}'"
                :data="{{ $volunteerInfo->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.volunteer-info.actions.edit', ['name' => $volunteerInfo->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.volunteer-info.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </volunteer-info-form>

        </div>
    
</div>

@endsection
@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.user.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">
        
        <user-form
            :action="'{{ url('admin/users') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                
                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.user.actions.create') }}
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="avatar-upload">
                                @include('brackets/admin-ui::admin.includes.avatar-uploader', [
                                    'mediaCollection' => app(\App\User::class)->getMediaCollection('avatar')
                                ])
                            </div>
                        </div>
                        <div class="col-md-8">
                            @include('admin.user.components.form-elements')
                        </div>
                    </div>
                </div>
                                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>
                
            </form>

        </user-form>

        </div>

        </div>

    
@endsection

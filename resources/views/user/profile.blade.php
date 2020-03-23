@extends('layouts.app')

@section('title', 'Profile')

@section('content')

    <div class="container-xl">
        <div class="mb-3">
            <ul class="nav nav-pills sticky-top">
              <li class="nav-item">
                <a class="nav-link active" href="/profile">Profile</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/security">Security</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/settings">Settings</a>
              </li>
            </ul>
        </div>

        <div class="card">

            <user-form
                :action="'{{ $user->resource_url }}'"
                :data="{{ $user->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-user"></i>Account Info
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="avatar-upload">
                                    @include('brackets/admin-ui::admin.includes.avatar-uploader', [
                                        'mediaCollection' => app(\App\User::class)->getMediaCollection('avatar'),
                                        'media' => $user->getThumbs200ForCollection('avatar')
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

        <div class="card">

            <volunteer-info-form
                :action="'{{ $user->resource_url.'/volunteer-info' }}'"
                :data="{{ $user->volunteerInfo ? $user->volunteerInfo->toJson() : 'null' }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-id-card"></i>Personal Information
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

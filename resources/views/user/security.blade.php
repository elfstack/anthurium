@extends('layouts.app')

@section('title', 'Profile')

@section('content')

    <div class="container-xl">
        <div class="mb-3">
            <ul class="nav nav-pills sticky-top">
              <li class="nav-item">
                <a class="nav-link" href="/profile">Profile</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="/security">Security</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/settings">Settings</a>
              </li>
            </ul>
        </div>

        <div class="card">


                    <div class="card-header">
                        <i class="fa fa-lock"></i>Recent Logins
                    </div>

                    <table class="table table-borderless table-striped">
                    @foreach ($recentLogins as $login)
                    <tr>
                    <td>{{ $login->logged_at }}</td>
                    <td>{{ $login->ip_address }}</td>
                    <td>{{ $login->user_agent }}</td>
                    </tr>
                    @endforeach
                    </table>

        </div>
        <div class="card">


                    <div class="card-header">
                        <i class="fa fa-lock"></i>Two-factor Authentication 
                    </div>

                    <div class="card-body">
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>

        </div>

    
</div>

@endsection

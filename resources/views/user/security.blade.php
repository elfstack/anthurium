@extends('layouts.app')

@section('title', 'Security')

@section('content')

    <view-security
        generated-key="{{ $secret }}"
        inline-template>
        <div class="container-xl">
            <div class="mb-3">
                <ul class="nav nav-pills">
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

                @if (Request::user()->has('otp'))
                    <div class="card-body">
                        <div class="alert alert-info">
                            2FA Enabled
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" @click="enable2FA">
                            <i class="fa fa-cancel"></i>
                            Disable 2FA
                        </button>
                    </div>
                @else
                    <div class="card-body">
                        <div class="alert alert-danger" role="alert">
                            Not fully implemented
                        </div>
                        <div class="alert alert-info" role="alert">
                            <p>For additional account security, you can enable two factor authentication.</p>
                            <p>When you enabled this feature, you need to enter a code generated by your authentication
                                app in additional to your credentials while login.</p>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <qrcode value="{{ $uri }}" :options="{ width: 200 }"></qrcode>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label>Key</label>
                                    <input class="form-control" :value="generatedKey"/>
                                </div>
                                <div class="form-group">
                                    <label>To confirm, enter the 6-digit code from app</label>
                                    <input class="form-control" v-model="otp"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-primary" @click="enable2FA">
                            <i class="fa fa-check"></i>
                            Enable 2FA
                        </button>
                    </div>

                @endif
            </div>
        </div>
    </view-security>
@endsection

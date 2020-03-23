@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="container-xl">
    <div class="mb-3">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link" href="/profile">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/security">Security</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="/settings">Settings</a>
          </li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-bell"></i>Notification
        </div>

        <div class="card-body">
            <div class="form-group">    
                <input class="form-check-input" type="checkbox" />
                <label class="form-check-label">Accept web notification</label>
            </div>
        </div>
    </div>
</div>
@endsection

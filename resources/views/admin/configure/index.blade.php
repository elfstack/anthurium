@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.configuration'))

@section('body')
<ul class="nav nav-tabs border-bottom-0">
  <li class="nav-item">
    <a class="nav-link active" href="#">System</a>
  </li>
</ul>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">System</h5>
    <p class="card-text">Clear Application Cache</p>
    <a href="/api/clear-cache/application" class="btn btn-primary">Clear</a>
    <p class="card-text">Clear View Cache</p>
    <a href="/api/clear-cache/view" class="btn btn-primary">Clear</a>
    <p class="card-text">Clear Config Cache</p>
    <a href="/api/clear-cache/config" class="btn btn-primary">Clear</a>
  </div>
</div>
@endsection

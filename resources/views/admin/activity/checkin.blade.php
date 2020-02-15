@extends('brackets/admin-ui::admin.layout.default')

@section('title', 'Check in '.$activity->name)

@section('body')
<div class="container-xl">
    <check-in
      title="{{ $activity->name }}"
      url="{{ getenv('APP_URL') }}"
      :activity-id="{{ $activity->id }}">
    </check-in>
</div>

@endsection

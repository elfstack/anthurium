@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <img class="rounded-circle mb-1" src="{{ Auth::user()->getFirstMediaUrl('avatar', 'thumb_150') }}"/>
                    <h3 class="card-title">{{ Auth::user()->name }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-8">
           <activity-list></activity-list> 
        </div>
    </div>
</div>
@endsection

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
            <h3 class="mb-3">Ongoing activities</h3>
            <h3 class="mb-3">Upcoming activities</h3>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Activity Name</h5>
                    <p class="mb-0">2020/02/21 12:30 - 2020/02/27 17:30</p>
                </div>
                <div class="card-footer d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="progress">
                          <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <span class="ml-2">12/20</span>
                </div>
            </div>

            <h3 class="mb-3">Past activities</h3>
        </div>
    </div>
</div>
@endsection

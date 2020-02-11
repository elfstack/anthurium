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
            <h3>Upcoming activities</h3>
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>

            <h3>Past activities</h3>
        </div>
    </div>
</div>
@endsection

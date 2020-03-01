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

            <div class="card">
                <div class="card-header">   
                    <h5 class="card-title">My Participations</h5>
                </div> 
                <div class="list-group list-group-flush">
                    @foreach($activitiesParticipated as $actPart)
                      <a class="list-group-item list-group-item-action flex-column align-items-start" href="/activity/{{ $actPart->id }}">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">{{ $actPart->name }}
</h5>
      <small>{{ $actPart->ends_at->diffInDays($actPart->starts_at) }} hours</small>
    </div>
    <small>{{ $actPart['starts_at'] }} - {{ $actPart['ends_at'] }}</small>
</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-8">
           <activity-list></activity-list> 
        </div>
    </div>
</div>
@endsection

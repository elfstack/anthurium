@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    @if(Auth::check() && Auth::user()->avatar_thumb_url)
                        <img src="{{ Auth::user()->avatar_thumb_url }}" class="avatar-photo">
                    @elseif(Auth::check() && Auth::user()->name)
                        <span class="avatar-initials avatar_150">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                    @else
                        <span class="avatar-initials avatar_150"><i class="fa fa-user"></i></span>
                    @endif
                    <h3 class="card-title">{{ Auth::user()->name }}</h3>
            <div class="card-body row text-center">
                <div class="col">
                    <div class="text-value-xl">{{ Auth::user()->activitiesParticipated()->count() }}</div>
                    <div class="text-uppercase text-muted small">Participation</div>
                </div>
                <div class="c-vr"></div>
                <div class="col">
                    <div class="text-value-xl">{{ Auth::user()->attendance()->count() }}</div>
                    <div class="text-uppercase text-muted small">Attended</div>
                </div>
                <div class="c-vr"></div>
                <div class="col">
                    <div class="text-value-xl">{{ Auth::user()->totalHours() }}</div>
                    <div class="text-uppercase text-muted small">Hours</div>
                </div>
            </div>

                </div>
            </div>

            <div class="card">
                <div class="card-header">   
                    <h5 class="card-title">My Participations</h5>
                </div> 
                <div class="list-group list-group-flush">
                    <a class="list-group-item">
                        Ongoing
                    </a>
                    @foreach($activitiesParticipatedOngoing as $actPart)
                      <a class="list-group-item list-group-item-action flex-column align-items-start" href="/activity/{{ $actPart->id }}">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">{{ $actPart->name }}</h5>
      <small>{{ $actPart->ends_at->diffInHours($actPart->starts_at) }} hours</small>
    </div>
    <small>{{ $actPart['starts_at'] }} - {{ $actPart['ends_at'] }}</small>
    @if (!Auth::user()->isCheckedIn($actPart))
    <p class="text-danger">Not checked in</p>
    @elseif (Auth::user()->isCheckedOut($actPart))
    <p class="text-success">Checked out</p>
    @else
    <a class="btn btn-warning btn-block rounded-0" href="/activity/{{ $actPart->id  }}/checkout">Checkout</a>
    @endif
</a>
                    @endforeach
                    <a class="list-group-item">
                        Upcoming
                    </a>
                    @foreach($activitiesParticipatedUpcoming as $actPart)
                      <a class="list-group-item list-group-item-action flex-column align-items-start" href="/activity/{{ $actPart->id }}">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">{{ $actPart->name }}
</h5>
      <small>{{ $actPart->ends_at->diffInHours($actPart->starts_at) }} hours</small>
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

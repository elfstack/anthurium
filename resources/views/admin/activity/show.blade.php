@extends('admin.activity.layout')

@section('title', trans('admin.activity.actions.edit', ['name' => $activity->name]))

@section('contents')
    <div
        class="{{ $activity->status == 'ongoing' ? 'bg-success' : ($activity->status == 'upcoming' ? 'bg-primary' : 'bg-secondary') }}"
        style="margin: 0 -30px -30px;padding: 30px;">


        <div class="container-xl">
            <h3>
                <span class="text-value text-uppercase badge-pill badge-light">{{ $activity->status }}</span>
                {{ $activity->name }}
            </h3>
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card text-primary">
                        <div class="card-body">
                            <div>Budget</div>
                            <div class="text-value">$1,342.00</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card text-primary">
                        <div class="card-body">
                            <div>Quota</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="text-value mr-3"><span>{{ $activity->quota }}</span></div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: {{ $activity->participantsPercentage() * 100 }}%"
                                             aria-valuenow="{{ $activity->participants()->count() }}" aria-valuemin="0"
                                             aria-valuemax="{{ $activity->quota }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card text-primary">
                        <div class="card-body">
                            <div>Attendance</div>
                            <div class="text-value">{{ $activity->attendedParticipantsPercentage() * 100}}%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <div>Location</div>
                            <div class="text-value text-uppercase">Location</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-7 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>Activity Description
                    </div>
                    <div class="card-body">
                        {!! $activity->content !!}
                    </div>
                    @include('admin.activity.fragments.participants')
                </div>
            </div>
            <div class="col-lg-5 col-xl-4">
                <div class="card text-primary bg-white">
                    <div class="card-body">
                        <div>Overall Participation</div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info" role="progressbar"
                                 style="width: {{ $activity->participantsPercentage() * (1 - $activity->attendedParticipantsPercentage() )* 100 }}%"
                                 aria-valuenow="{{ $activity->participants()->count() }}" aria-valuemin="0"
                                 aria-valuemax="{{ $activity->quota }}"></div>
                            <div class="progress-bar bg-success" role="progressbar"
                                 style="width: {{ $activity->participantsPercentage() * $activity->attendedParticipantsPercentage() * 100 }}%"
                                 aria-valuenow="{{ $activity->participants()->count() }}" aria-valuemin="0"
                                 aria-valuemax="{{ $activity->quota }}"></div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 0%"
                                 aria-valuenow="{{ $activity->participants()->count() }}" aria-valuemin="0"
                                 aria-valuemax="{{ $activity->quota }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

@endsection

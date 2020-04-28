@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.activity.actions.edit', ['name' => $activity->name]))

@section('body')

    <div class="card-header" style="margin: -30px -30px 0;">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link {{  Request::is('admin/activities/'.$activity->id) ? 'active' : null }}" href="{{ '/admin/activities/'.$activity->id }}">Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/activities/*/participants') ? 'active' : null }}" href="{{ '/admin/activities/'.$activity->id.'/participants' }}">Participants</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/activities/*/budgets') ? 'active' : null }}" href="{{ '/admin/activities/'.$activity->id.'/budgets' }}">Budgets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/activities/*/tasks') ? 'active' : null }}" href="{{ '/admin/activities/'.$activity->id.'/tasks' }}">Tasks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/activities/*/itinerary') ? 'active' : null }}" href="{{ '/admin/activities/'.$activity->id.'/itinerary' }}">Itinerary</a>
            </li>
        </ul>

        <div class="flex-md-fill">
        </div>
    </div>

    @yield('contents')
@endsection

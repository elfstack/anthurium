@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 info">
            <h1>{{ $activity->name }}</h1>
            <h3>Description</h3>
            {!! $activity->content !!}
<!-- TODO: change url -->
    <participant-listing
        :activity-id="{{ $activity->id }}"
        :url="'{{ url('admin/activities/'.$activity->id.'/participants') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        Participants 
                    </div>
                    <div class="card-body" v-cloak>
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">
                                            
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>

                                        <th is='sortable' :column="'user_id'">{{ trans('admin.participant.columns.user_id') }}</th>
                                        <th is='sortable' :column="'enrolled_at'">{{ trans('admin.participant.columns.enrolled_at') }}</th>
                                        <th is='sortable' :column="'attendance_id'">Arrived at</th>
                                        <th is='sortable' :column="'attendance_id'">Left at</th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="7">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/participants')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/admin/participants/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                            </span>

                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">


                                        <td>@{{ item.user.name }}</td>
                                        <td>@{{ item.enrolled_at | datetime }}</td>
                                        <td>@{{ item.attendance ? item.attendance.arrived_at : '' }}</td>
                                        <td>@{{ item.attendance ? item.attendance.left_at : '' }}</td>

                                    </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </participant-listing>
        </div>
        <div class="col-12 col-md-3 meta">
            <div class="card mb-3 text-primary">
                <div class="card-body d-flex justify-content-center">
                    <div class="start text-center pr-1 border-right">
                        <strong class="d-block"><small>STARTS</small></strong>{{ $activity->starts_at->toDateTimeString() }}
                    </div>
                    <div class="ends text-center pl-1">
                        <strong class="d-block"><small>ENDS</small></strong>{{ $activity->ends_at->toDateTimeString() }}
                    </div>
                </div>
            </div>

           <div class="card text-primary mb-3">
                <div class="card-body">
                    <div>Quota</div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="text-value mr-3"><span>{{ $activity->quota }}</span></div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm">
                                <div class="progress-bar" role="progressbar" style="width: {{ $activity->participantsPercentage() * 100 }}%" aria-valuenow="{{ $activity->participants()->count() }}" aria-valuemin="0" aria-valuemax="{{ $activity->quota }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <button-enroll
                :status="{{ $user_is_enrolled ? 'true' : 'false' }}"
                :activity="{{ $activity->toJson() }}"
            >
            </button-enroll>
        </div>
    </div>
</div>
@endsection

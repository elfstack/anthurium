@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.activity.actions.edit', ['name' => $activity->name]))

@section('body')
<div class="container-xl">
    <h3>{{ $activity->name }}</h3>
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
                                <div class="progress-bar" role="progressbar" style="width: {{ $activity->participantsPercentage() * 100 }}%" aria-valuenow="{{ $activity->participants()->count() }}" aria-valuemin="0" aria-valuemax="{{ $activity->quota }}"></div>
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
                    <div>Status</div>
                    <div class="text-value">ONGOING</div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-7 col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>Activitiy description
                </div>
                <div class="card-body">
                    {!! $activity->content !!}
                </div>
            </div>

    <participant-listing
        :activity-id="{{ $activity->id }}"
        :url="'{{ url('admin/activities/'.$activity->id.'/participants') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.participant.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/participants/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; Add Record Manually</a>
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
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>

                                        <th is='sortable' :column="'user_id'">{{ trans('admin.participant.columns.user_id') }}</th>
                                        <th is='sortable' :column="'enrolled_at'">{{ trans('admin.participant.columns.enrolled_at') }}</th>
                                        <th is='sortable' :column="'attendance_id'">Arrived at</th>
                                        <th is='sortable' :column="'attendance_id'">Left at</th>

                                        <th></th>
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
                                        <td class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>

                                        <td>@{{ item.user.name }}</td>
                                        <td>@{{ item.enrolled_at | datetime }}</td>
                                        <td>@{{ item.attendance ? item.attendance.arrived_at : '' }}</td>
                                        <td>@{{ item.attendance ? item.attendance.left_at : '' }}</td>
                                        
                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </div>
                                        </td>
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
                                <h3>No participants</h3>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </participant-listing>
        </div>
        <div class="col-lg-5 col-xl-4">
            <div class="card text-primary bg-white">
                <div class="card-body">
                    <div>Overall</div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $activity->participantsPercentage() * (1 - $activity->attendedParticipantsPercentage() )* 100 }}%" aria-valuenow="{{ $activity->participants()->count() }}" aria-valuemin="0" aria-valuemax="{{ $activity->quota }}"></div>
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $activity->participantsPercentage() * $activity->attendedParticipantsPercentage() * 100 }}%" aria-valuenow="{{ $activity->participants()->count() }}" aria-valuemin="0" aria-valuemax="{{ $activity->quota }}"></div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="{{ $activity->participants()->count() }}" aria-valuemin="0" aria-valuemax="{{ $activity->quota }}"></div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

@endsection

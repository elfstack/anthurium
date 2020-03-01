@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.admin-user.actions.index'))

@section('body')
<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="card bg-primary text-white">
            <div class="card-header text-white">
                <div class="btn-group float-right">
                    <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-settings"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
                <div>Volunteers</div>
                <div class="text-value">{{ $volunteer['total'] }}</div>
            </div>
            <div class="card-body row text-center">
                <div class="col">
                    <div class="text-value-xl">500+</div>
                    <div class="text-uppercase text-muted small">Active</div>
                </div>
                <div class="c-vr"></div>
                <div class="col">
                    <div class="text-value-xl">292</div>
                    <div class="text-uppercase text-muted small">Inactive</div>
                </div>
                <div class="c-vr"></div>
                <div class="col">
                    <div class="text-value-xl">292</div>
                    <div class="text-uppercase text-muted small">Left</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card bg-info text-white">
            <div class="card-header text-white">
                <div class="btn-group float-right">
                    <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-settings"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
                <div>Activities</div>
                <div class="text-value">{{ $volunteer['total'] }}</div>
            </div>
            <div class="card-body row text-center">
                <div class="col">
                    <div class="text-value-xl">500+</div>
                    <div class="text-uppercase text-muted small">Ongoing</div>
                </div>
                <div class="c-vr"></div>
                <div class="col">
                    <div class="text-value-xl">292</div>
                    <div class="text-uppercase text-muted small">Upcoming</div>
                </div>
                <div class="c-vr"></div>
                <div class="col">
                    <div class="text-value-xl">292</div>
                    <div class="text-uppercase text-muted small">Past</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card bg-warning text-white">
            <div class="card-header text-white">
                <div class="btn-group float-right">
                    <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-settings"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
                <div>Budgets</div>
                <div class="text-value">{{ $budget['annual'] }}</div>
            </div>
            <div class="card-body row text-center">
                @foreach ($budget['quarter'] as $qBudget) 
                <div class="col">
                    <div class="text-value-xl">{{ $qBudget['budget']}}</div>
                    <div class="text-uppercase text-muted small">{{ $qBudget['quarter'] }}</div>
                </div>
                @if (!$loop->last)
                    <div class="c-vr"></div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card bg-danger text-white">
            <div class="card-header text-white">
                <div class="btn-group float-right">
                    <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-settings"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
                <div>Article</div>
                <div class="text-value">{{ $volunteer['total'] }}</div>
            </div>
            <div class="card-body row text-center">
                <div class="col">
                    <div class="text-value-xl">{{ $article['posts'] }}</div>
                    <div class="text-uppercase text-muted small">Posts</div>
                </div>
                <div class="c-vr"></div>
                <div class="col">
                    <div class="text-value-xl">{{ $article['draft'] }}</div>
                    <div class="text-uppercase text-muted small">Draft</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

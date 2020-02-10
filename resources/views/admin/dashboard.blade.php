@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.admin-user.actions.index'))

@section('body')
<div class="row">
<div class="col-sm-6 col-lg-3">
<div class="card text-white bg-primary">
<div class="card-body pb-0">
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
<div class="text-value">9.823</div>
<div>Members online</div>
</div>
<div class="chart-wrapper mt-3 mx-3" style="height:70px;"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
<canvas class="chart chartjs-render-monitor" id="card-chart1" height="70" style="display: block;" width="233"></canvas>
</div>
</div>
</div>

<div class="col-sm-6 col-lg-3">
<div class="card text-white bg-info">
<div class="card-body pb-0">
<button class="btn btn-transparent p-0 float-right" type="button">
<i class="icon-location-pin"></i>
</button>
<div class="text-value">9.823</div>
<div>Members online</div>
</div>
<div class="chart-wrapper mt-3 mx-3" style="height:70px;"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
<canvas class="chart chartjs-render-monitor" id="card-chart2" height="70" style="display: block;" width="233"></canvas>
</div>
</div>
</div>

<div class="col-sm-6 col-lg-3">
<div class="card text-white bg-warning">
<div class="card-body pb-0">
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
<div class="text-value">9.823</div>
<div>Members online</div>
</div>
<div class="chart-wrapper mt-3" style="height:70px;"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
<canvas class="chart chartjs-render-monitor" id="card-chart3" height="70" style="display: block;" width="265"></canvas>
</div>
</div>
</div>

<div class="col-sm-6 col-lg-3">
<div class="card text-white bg-danger">
<div class="card-body pb-0">
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
<div class="text-value">9.823</div>
<div>Members online</div>
</div>
<div class="chart-wrapper mt-3 mx-3" style="height:70px;"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
<canvas class="chart chartjs-render-monitor" id="card-chart4" height="70" style="display: block;" width="233"></canvas>
</div>
</div>
</div>

</div>
@endsection

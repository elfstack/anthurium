<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">@lang('admin.sidebar.volunteer')</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/users') }}"><i class="nav-icon icon-user"></i>@lang('admin.user.title')</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/activities') }}"><i class="nav-icon icon-book-open"></i> {{ trans('admin.activity.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/attendances') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.attendance.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/participants') }}"><i class="nav-icon icon-magnet"></i> {{ trans('admin.participant.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}


            <li class="nav-title">@lang('admin.sidebar.configuration')</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/budget-categories') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.budget-category.title') }}</a></li>

            <li class="nav-title">@lang('admin.sidebar.manage')</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i>@lang('admin.admin-management')</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i>@lang('admin.configuration')</a></li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>

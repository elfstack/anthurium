<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">@lang('admin.sidebar.volunteer')</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/users') }}"><i class="nav-icon icon-user"></i>@lang('base.volunteers')</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/volunteer-infos') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.volunteer-info.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/activities') }}"><i class="nav-icon icon-book-open"></i> {{ trans('admin.activity.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">@lang('admin.manage')</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i>@lang('admin.admin-management')</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i>@lang('configuration')</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>

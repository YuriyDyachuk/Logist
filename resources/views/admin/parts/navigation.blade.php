<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">

            @if (Auth::guard("admin_users")->user())
            <div class="pull-left image">
                <img src="{{url('user_images/default-profile-image.jpg')}}" class="img-circle" alt="User Image">
            </div>


            <div class="pull-left info">
                <p>{{Auth::guard("admin_users")->user()->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> {{trans('all.online')}}</a>
            </div>
            @endif
        </div>
        <!-- search form -->
        @if (Auth::guard("admin_users")->user())
        <!--
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        -->
        @endif
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">{{trans('all.admin_panel')}}</li>
            @if (Auth::guard("admin_users")->user())
                <li><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i>  {{trans('all.home')}}</a></li>

                <li class="active treeview">
                    <a href="{{route('admin.users.type', [1])}}">
                        <i class="fa fa-user"></i> <span>{{trans('all.clients')}}</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('admin.users.role', 'client-person')}}"><i class="fa fa-users"></i> {{trans('all.persons')}}</a></li>
                        <li><a href="{{route('admin.users.role', 'client-company')}}"><i class="fa fa fa-building"></i> {{trans('all.companies')}}</a></li>
                        <li><a href="{{route('admin.users.type', 'client')}}"><i class="fa fa fa-globe"></i> {{trans('all.all')}}</a></li>
                    </ul>
                </li>

                <li class="active treeview">
                    <a href="{{route('admin.users.type', [2])}}">
                        <i class="fa fa-user"></i> <span>{{trans('all.logistic-partners')}}</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('admin.users.role', 'logistic-person')}}"><i class="fa fa-users"></i> {{trans('all.persons')}}</a></li>
                        <li><a href="{{route('admin.users.role', 'logistic-company')}}"><i class="fa fa-building"></i> {{trans('all.companies')}}</a></li>
                        <li><a href="{{route('admin.users.type', 'logistic')}}"><i class="fa fa-globe"></i> {{trans('all.all')}}</a></li>
                    </ul>
                </li>
                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-puzzle-piece"></i> <span>{{trans('all.adminstrating')}}</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('admin.users.requests')}}"><i class="fa fa-address-book-o"></i> {{trans('all.new_requests')}}</a></li>
                        <li><a href="{{route('translation-manager.index')}}"><i class="fa fa-address-book-o"></i> {{trans('all.translates')}}</a></li>
                        <li><a href="{{route('instructions.index')}}"><i class="fa fa-address-book-o"></i> {{trans('all.user_instructions')}}</a></li>
                    </ul>
                </li>

                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-list"></i> <span>{{trans('all.specializations')}}</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-list"></i> {{trans('all.specializations')}}</a></li>
                        <li><a href="#"><i class="fa fa-sitemap"></i> {{trans('all.categories_specializations')}}</a></li>
                        <li><a href="#"><i class="fa fa-file"></i> {{trans('all.docs_specializations')}}</a></li>
                    </ul>
                </li>


                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa fa-globe"></i> <span>{{trans('all.rides')}}</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-globe"></i> {{trans('all.all')}}</a></li>
                    </ul>
                </li>

            @else
                <li><a href="{{ url('/admin/login') }}">Login</a></li>
            @endif


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
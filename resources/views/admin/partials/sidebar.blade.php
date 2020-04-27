<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/assets/admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{$user->first_name}} {{$user->last_name}}</p>
                <a href="#" class="text-center">{{$user->roles->first()->display_name}}</a>
            </div>
        </div>

        <form action="/admin/search" method="get" class="sidebar-form">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit"  id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>

        <ul class="sidebar-menu">
            <li class="header">Overview</li>
            <li class="treeview {{Request::is('admin/dashboard') ? 'active': ''}}">
                <a href="/admin/dashboard">
                    <i class="fa fa-tachometer"></i>
                    <span>Dashboard</span>
                </a>
            </li>           
            <li class="header">Online Applications</li>
            @foreach($menu["types"] as $type )
                @if(Entrust::can($type['permission']))
                <li class="treeview {{Request::is('admin/application/'.strtolower($type['name']).'/*') ? 'active': ''}}">
                    <a href="#">
                        <i class="glyphicon {{$type['icon_class']}}"></i>
                        <span>{{$type["name"]}} Applications</span>
                        <i class="fa fa-angle-right pull-right"></i>
                        <small class="label pull-right bg-purple">
                            {{Auth::user()->applications()->{$type['scope']}()->count()}}
                        </small>
                    </a>
                    
                    <ul class="treeview-menu">
                    @foreach($menu["statuses"] as $status)
                        @if(Entrust::can('view-'.strtolower($status["name"]).'-'.strtolower($type["name"]).'-application'))
                        <li class="{{Request::is('admin/application/'.strtolower($type['name']).'/*/'.strtolower($status['name']).'/*') ? 'active':''}}">
                            <a href="#">
                                <i class="glyphicon {{$status['icon']}}  "></i>
                                @if($status["name"]=="Lead")
                                Partial Applications
                                @else
                                {{$status["name"]}} Applications
                                @endif
                                <small class="label pull-right bg-green">
                                    {{Auth::user()->applications()->{$type['scope']}()->{$status['scope']}()->count()}}
                                </small>
                            </a>
                        
                            <ul class="treeview-menu">
                            @foreach($menu["categories"] as $category)
                                <li class="Request::is('/admin/application/{{strtolower($type['name'])}}/{{strtolower($category['name'])}}/{{strtolower($status['name'])}}/index') 'active':''">
                                    <a href="/admin/application/{{strtolower($type['name'])}}/{{strtolower($category['name'])}}/{{strtolower($status['name'])}}/index">
                                        <i class="glyphicon glyphicon-record "></i>
                                            Category {{$category["name"]}}
                                        <small class="label pull-right bg-blue">
                                            {{Auth::user()->applications()->{$type['scope']}()
                                            ->{$category['scope']}()->{$status['scope']}()->count()
                                            }}
                                        </small>
                                    </a>
                                </li>
                            @endforeach      
                            </ul>
                        </li>
                        @endif
                    @endforeach
                    </ul>
                </li>
                @endif
            @endforeach

            <li class="header">Manage Platform</li>
            @if(Entrust::can('manage-staff'))
            <li class="treeview {{Request::is('admin/staff/*')? 'active': ''}}">
                <a href="#">
                    <i class="glyphicon glyphicon-user"></i>
                    <span>Manage Users</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::is('admin/staff/all')? 'active': ''}}"><a href="/admin/staff/all"><i class="glyphicon glyphicon-th-list"></i>View All Users</a></li>
                    <li class="{{Request::is('admin/staff/create')? 'active': ''}}"><a href="/admin/staff/create"><i class="glyphicon glyphicon-plus"></i>Add New User</a></li>
                    @if(Entrust::can('account-activitiy-logs'))
                    <li class="{{Request::is('admin/staff/activity-logs')? 'active': ''}}"><a href="/admin/staff/activity-logs"><i class="glyphicon glyphicon-list"></i>View Activity Logs</a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if(Entrust::can('manage-locations'))
            <li class="treeview {{Request::is('admin/location/*')? 'active': ''}}">
                <a href="#">
                    <i class="glyphicon glyphicon-map-marker"></i>
                    <span>Manage Locations</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::is('admin/location/all')? 'active': ''}}"><a href="/admin/location/all"><i class="glyphicon glyphicon-th-list"></i>View All Locations</a></li>
                    <li class="{{Request::is('admin/location/create')? 'active': ''}}"><a href="/admin/location/create"><i class="glyphicon glyphicon-plus"></i>Add New Location</a></li>
                </ul>
            </li>
            @endif


            @if(Entrust::can('manage-questions'))
            <li class="treeview {{Request::is('admin/question/*')? 'active': ''}}">
                <a href="#">
                    <i class="glyphicon glyphicon-question-sign"></i>
                    <span>Manage Questions</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::is('admin/question/all')? 'active': ''}}"><a href="/admin/question/all"><i class="glyphicon glyphicon-th-list"></i>View All Questions</a></li>
                    <li class="{{Request::is('admin/question/create')? 'active': ''}}"><a href="/admin/question/create"><i class="glyphicon glyphicon-plus"></i>Add New Question</a></li>
                </ul>
            </li>
            @endif

            @if(Entrust::can('manage-hospitals'))
            <li class="treeview {{Request::is('admin/hospital/*') ? 'active': ''}}">
                <a href="#">
                    <i class="glyphicon glyphicon-home"></i>
                    <span>Manage Hospitals</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @if(Entrust::can('view-hospitals'))
                        <li class="{{Request::is('admin/hospital/all') ? 'active': ''}}"><a href="/admin/hospital/all"><i class="glyphicon glyphicon-th-list "></i>View All Hospitals</a></li>
                    @endif    
                    @if(Entrust::can('create-hospitals'))
                        <li class="{{Request::is('admin/hospital/create') ? 'active': ''}}"><a href="/admin/hospital/create"><i class="glyphicon glyphicon-plus"></i>Add New Hospital</a></li>
                    @endif
                    @if(Entrust::can('update-hospitals'))
                        <li class="{{Request::is('admin/hospital/update/detail') ? 'active': ''}}"><a href="/admin/hospital/update/detail"><i class="glyphicon glyphicon-refresh"></i>Update Hospital</a></li>
                    @endif
                    @if(Entrust::can('import-hospitals'))
                        <li class="{{Request::is('admin/hospital/import/parent/hospitals') ? 'active': ''}}"><a href="/admin/hospital/import/parent/hospitals"><i class="fa fa-upload"></i>Import Hospitals</a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if(Entrust::can('create-psychometric-test'))
            <li class="treeview {{Request::is('admin/new-psychometric-test/*') ? 'active': ''}}">
                <a href="#">
                    <i class="glyphicon glyphicon-question-sign"></i>
                    <span>New Psychometric Test</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::is('admin/new-psychometric-test/create') ? 'active': ''}}"><a href="/admin/new-psychometric-test/create"><i class="glyphicon glyphicon-th-list "></i>Add New</a></li>
                </ul>
            </li>
            @endif

            @if(Entrust::can('manage-leads'))
            <li class="{{Request::is('admin/lead/create') ? 'active': ''}}">
                <a href="/admin/lead/create">
                    <i class="glyphicon glyphicon-plus"></i>Add New Lead
                </a>
            </li>
            @endif 

            @if(Entrust::can('manage-reports'))
            <li class="treeview {{Request::is('admin/report/*') ? 'active': ''}}">
                <a href="/admin/report/new">
                    <i class="glyphicon glyphicon-list-alt"></i>
                    <span>Manage Reports</span>
                </a>
            </li>
            @endif

            <li class="treeview {{Request::is('admin/import*') ? 'active': ''}}">
                <a href="/admin/import">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Import Data</span>
                </a>
            </li>

            @if(Entrust::can('manage-treatment-type'))
            <li class="treeview {{Request::is('admin/treatment-type/*') ? 'active': ''}}">
                <a href="#">
                    <i class="glyphicon glyphicon-edit"></i>
                    <span>Treatment Types</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::is('admin/treatment-type/all') ? 'active': ''}}">
                    <a href="/admin/treatment-type/all"><i class="glyphicon glyphicon-th-list "></i>View All Treatment Type</a>
                    </li>
                    <li class="{{Request::is('admin/treatment-type/create') ? 'active': ''}}">
                    <a href="/admin/treatment-type/create"><i class="glyphicon glyphicon-plus"></i>Add New Treatment Type</a>
                    </li>
                </ul>
            </li>
            @endif

            @if($user->hasRole('admin'))
            <li class="treeview {{Request::is('admin/manage-permission/*') ? 'active': ''}}">
                <a href="/admin/manage-permission/1">
                    <i class="glyphicon glyphicon-wrench"></i>
                    <span>Manage Permissions</span>
                </a>
            </li>
            @endif

            @if(Entrust::can('manage-charges'))
            <li class="treeview {{Request::is('admin/manage-charges*') ? 'active': ''}}">
                <a href="/admin/manage-charges">
                    <i class="glyphicon glyphicon-cog"></i>
                    <span>Manage Charges</span>
                </a>
            </li>
            @endif

            @if(Entrust::can('manage-products'))
            <li class="treeview {{Request::is('admin/product/*') ? 'active': ''}}">
                <a href="#">
                    <i class="glyphicon glyphicon-edit"></i>
                    <span>Manage Products</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::is('admin/product/all') ? 'active': ''}}"><a href="/admin/product/all"><i class="glyphicon glyphicon-th-list "></i>View All Product</a></li>
                    <li class="{{Request::is('admin/product/create') ? 'active': ''}}"><a href="/admin/product/create"><i class="glyphicon glyphicon-plus"></i>Add New Product</a></li>
                </ul>
            </li>
            @endif

            @if(Entrust::can('manage-dmi'))
            <li class="treeview {{Request::is('admin/application/dmi/*') ? 'active': ''}}">
                <a href="/admin/application/dmi/new">
                    <i class="fa fa-paper-plane"></i>
                    <span>Manage DMI</span>
                </a>
            </li>
            @endif
            <!-- <li class="{{Request::is('admin/analytics/*') ? 'active': ''}}">
                <a href="/admin/analytics/applications"><i class="fa fa-line-chart"></i>Analytics</a>
            </li> -->
            @if(Entrust::can('view-analytics'))
            <li class="treeview {{Request::is('admin/analytics/*') ? 'active': ''}}">
                <a href="#">
                    <i class="fa fa-line-chart"></i>
                    <span>Analytics</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::is('admin/analytics/summary') ? 'active': ''}}">
                        <a href="/admin/analytics/summary"><i class="glyphicon glyphicon-info-sign"></i>Summary</a>
                    </li>
                    <li class="{{Request::is('admin/analytics/summary?type=loan') ? 'active': ''}}">
                        <a href="/admin/analytics/summary?type=loan"><i class="glyphicon glyphicon-file"></i>Loan</a>
                    </li>
                    <li class="{{Request::is('admin/analytics/summary?type=card') ? 'active': ''}}">
                        <a href="/admin/analytics/summary?type=card"><i class="glyphicon glyphicon-credit-card"></i>Card</a>
                    </li>
                    <li class="{{Request::is('admin/analytics/mis/summary') ? 'active': ''}}">
                        <a href="/admin/analytics/mis/summary">
                        <i class="glyphicon glyphicon glyphicon-pushpin"></i>MIS Lead</a>
                    </li>
                </ul>
            </li>

            @endif
            @if(Entrust::can('import-data'))
            <!-- <li class="treeview {{Request::is('admin/application/import/*') ? 'active': ''}}">
                <a href="/admin/application/import/file">
                    <i class="fa fa-server"></i>
                    <span>Update Applications Data</span>
                </a>
            </li>
            <li class="treeview {{Request::is('testing/import-applications') ? 'active': ''}}">
                <a href="/testing/import-applications">
                    <i class="fa fa-cloud-upload"></i>
                    <span>Import Applications Data</span>
                </a>
            </li>
            <li class="treeview {{Request::is('admin/import/tranzcoms') ? 'active': ''}}">
                <a href="/admin/import/tranzcoms">
                    <i class="fa fa-cloud-upload"></i>
                    <span>Import Tranzcoms Data</span>
                </a>
            </li>
            <li class="treeview {{Request::is('admin/import-repayment-collections') ? 'active': ''}}">
                <a href="/admin/import-repayment-collections">
                    <i class="fa fa-upload"></i>
                    <span>Import Repayment Collections</span>
                </a>
            </li> -->
            <li class="treeview {{Request::is('admin/application/bulk-close') ? 'active': ''}}">
                <a href="/admin/application/bulk-close">
                    <i class="fa fa-upload"></i>
                    <span>Close Applications</span>
                </a>
            </li>
            @endif
            <!-- @if(Entrust::can('manage-turn-around-time'))
            <li class="treeview {{Request::is('admin/application/staff/statistics') ? 'active': ''}}">
                <a href="/admin/application/staff/statistics">
                    <i class="fa fa-clock-o"></i>
                    <span>Turn Around Time</span>
                </a>
            </li>
            @endif -->
            @if(Entrust::can('manage-todays-disbursement'))
            <li class="treeview {{Request::is('admin/report/todays/disbursement') ? 'active': ''}}">
                <a href="/admin/report/todays/disbursement">
                    <i class="fa fa-calendar-check-o"></i>
                    <span>Today's Disbursement</span>
                </a>
            </li>
            @endif

            @if(Entrust::can('view-master-report'))
            <li class="treeview {{Request::is('admin/report/*') ? 'active': ''}}">
                <a href="#">
                    <i class="fa fa-database"></i>
                    <span>Master Report</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @if(Entrust::can('view-overdue-report'))
                    <li class="treeview {{Request::is('admin/report/master/filter-od') ? 'active': ''}}">
                        <a href="/admin/report/master/filter-od">
                            <i class="fa fa-calendar-check-o"></i>
                            <span>Overdue Report</span>
                        </a>
                    </li>
                    @endif
                    <!-- <li class="treeview {{Request::is('admin/report/get/collection-data') ? 'active': ''}}">
                        <a href="/admin/report/get/collection-data">
                            <i class="fa fa-calendar-check-o"></i>
                            <span>Collection Report</span>
                        </a>
                    </li> -->
                    @if(Entrust::can('view-closure-report'))
                    <li class="treeview {{Request::is('admin/report/master/filter-closure') ? 'active': ''}}">
                        <a href="/admin/report/master/filter-closure">
                            <i class="fa fa-download"></i>
                            <span>Closure Report</span>
                        </a>
                    </li>
                    @endif
                    <!-- <li class="treeview {{Request::is('admin/report/download/enach') ? 'active': ''}}">
                        <a href="/admin/report/download/enach">
                            <i class="fa fa-download"></i>
                            <span>Download UMRN</span>
                        </a>
                    </li> -->
                    @if(Entrust::can('view-data-dump-report'))
                    <li class="treeview {{Request::is('admin/report/master/filter-data-dump') ? 'active': ''}}">
                        <a href="/admin/report/master/filter-data-dump">
                            <i class="fa fa-download"></i>
                            <span>Data Dump Report</span>
                        </a>
                    </li>
                    @endif

                    @if(Entrust::can('view-cibil-report'))
                    <li class="treeview {{Request::is('admin/report/master/filter-cibil-dump') ? 'active': ''}}">
                        <a href="/admin/report/master/filter-cibil-dump">
                            <i class="fa fa-download"></i>
                            <span>CIBIL Data Dump Report</span>
                        </a>
                    </li>
                    @endif

                    @if(Entrust::can('view-income-report'))
                    <li class="treeview {{Request::is('admin/report/master/filter-income-computation') ? 'active': ''}}">
                        <a href="/admin/report/master/filter-income-computation">
                            <i class="fa fa-download"></i>
                            <span>Income Computation Report</span>
                        </a>
                    </li>
                    @endif

                    @if(Entrust::can('view-emi-report'))
                    <li class="treeview {{Request::is('admin/applications/emi') ? 'active': ''}}">
                        <a href="/admin/applications/emi">
                            <i class="fa fa-calendar"></i>
                            <span>EMI Report</span>
                        </a>
                    </li>
                    @endif

                    @if(Entrust::can('view-log-report'))
                    <li class="treeview {{Request::is('admin/report/master/filter-application-status-log') ? 'active': ''}}">
                        <a href="/admin/report/master/filter-application-status-log">
                            <i class="fa fa-download"></i>
                            <span>Log Report</span>
                        </a>
                    </li>
                    @endif

                    @if(Entrust::can('view-approval-log-report'))
                    <li class="treeview {{Request::is('admin/report/master/filter-approval-log') ? 'active': ''}}">
                        <a href="/admin/report/master/filter-approval-log">
                            <i class="fa fa-download"></i>
                            <span>Approval Log Report</span>
                        </a>
                    </li>
                    @endif

                    @if(Entrust::can('view-penalty-report'))
                    <li class="treeview {{Request::is('admin/report/master/filter-penalty') ? 'active': ''}}">
                        <a href="/admin/report/master/filter-penalty">
                            <i class="fa fa-download"></i>
                            <span>Penalty Report</span>
                        </a>
                    </li>
                    @endif

                    @if(Entrust::can('view-cibil-report'))
                    <li class="treeview {{Request::is('admin/report/master/filter-cibil-log') ? 'active': ''}}">
                        <a href="/admin/report/master/filter-cibil-log">
                            <i class="fa fa-download"></i>
                            <span>CIBIL Log Report</span>
                        </a>
                    </li>
                    @endif

                </ul>
            </li>
            @endif
            <li class="treeview {{Request::is('admin/blog/*') ? 'active': ''}}">
                <a href="#">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    <span>Blogs</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview {{Request::is('admin/blog/create') ? 'active': ''}}">
                        <a href="/admin/blog/create">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <span>Add a Blog</span>
                        </a>
                    </li>
                    <li class="treeview {{Request::is('admin/blog/all') ? 'active': ''}}">
                        <a href="/admin/blog/all">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                            <span>View all blogs</span>
                        </a>
                    </li>
                    
                </ul>
            </li>
            
        </ul>
        <div style="color:#fff; text-align: center;">
            <a href="/admin/changelogs" >
                <span>Version : {{Config::get('version.Version')}}</span>
            </a>
        </div>
    </section>
    <!-- /.sidebar -->
</aside>

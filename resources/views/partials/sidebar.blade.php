<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box mt-3">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-lite-car.jpg') }}" alt="" height="80">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-lite-car.jpg') }}" alt="" height="80">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-lite-car.jpg') }}" alt="" height="80">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-lite-car.jpg') }}" alt="" height="80">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div class="dropdown sidebar-user m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center gap-2">
                <img class="rounded header-profile-user" src="assets/images/users/avatar-1.jpg" alt="Header Avatar">
                <span class="text-start">
                    <span class="d-block fw-medium sidebar-user-name-text">Anna Adame</span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                            class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                            class="align-middle">Online</span></span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Welcome Anna!</h6>
            <a class="dropdown-item" href="pages-profile.html"><i
                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Profile</span></a>
            <a class="dropdown-item" href="apps-chat.html"><i
                    class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Messages</span></a>
            <a class="dropdown-item" href="apps-tasks-kanban.html"><i
                    class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Taskboard</span></a>
            <a class="dropdown-item" href="pages-faqs.html"><i
                    class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Help</span></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="pages-profile.html"><i
                    class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance :
                    <b>$5971.67</b></span></a>
            <a class="dropdown-item" href="pages-profile-settings.html"><span
                    class="badge bg-success-subtle text-success mt-1 float-end">New</span><i
                    class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Settings</span></a>
            <a class="dropdown-item" href="auth-lockscreen-basic.html"><i
                    class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock
                    screen</span></a>
            <a class="dropdown-item" href="auth-logout-basic.html"><i
                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle"
                    data-key="t-logout">Logout</span></a>
        </div>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">


            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                
                {{-- Dashboard --}}
                @if(userCanAccessRoute('admin.dashboard') || userCanAccessRoute('manager.dashboard') || userCanAccessRoute('user.dashboard'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                @endif

                {{-- Users Management --}}
                @if(userCanAccessAny(['view-user', 'view-role', 'view-permission']))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span data-key="t-apps">Users Management</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            @if(userCanAccessRoute('users.index'))
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link" data-key="t-chat">Users</a>
                            </li>
                            @endif
                            @if(userCanAccessRoute('roles.index'))
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}" class="nav-link" data-key="t-chat">Roles</a>
                            </li>
                            @endif
                            @if(userCanAccessRoute('permissions.index'))
                            <li class="nav-item">
                                <a href="{{ route('permissions.index') }}" class="nav-link" data-key="t-chat">Permissions</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                {{-- Job Card --}}
                @if(userCanAccessRoute('job-card.index'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('job-card.index') }}">
                        <i class="ri-file-list-3-line"></i> <span data-key="t-widgets">Job Card</span>
                    </a>
                </li>
                @endif

                {{-- Customers --}}
                @if(userCanAccessRoute('customers.index'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('customers.index') }}">
                        <i class="ri-user-2-line"></i> <span data-key="t-widgets">Customers</span>
                    </a>
                </li>
                @endif

                {{-- Categories --}}
                @if(userCanAccessAny(['view-category', 'view-sub-category']))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarPages">
                        <i class="ri-folder-2-line"></i> <span data-key="t-pages">Categories</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPages">
                        <ul class="nav nav-sm flex-column">
                            @if(userCanAccessRoute('categories.index'))
                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}" class="nav-link"
                                    data-key="t-starter">Categories</a>
                            </li>
                            @endif
                            @if(userCanAccessRoute('sub-categories.index'))
                            <li class="nav-item">
                                <a href="{{ route('sub-categories.index') }}" class="nav-link" data-key="t-team">Sub
                                    Categories</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                {{-- Sales Persons --}}
                @if(userCanAccessRoute('sales-persons.index'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('sales-persons.index') }}">
                        <i class="ri-team-line"></i> <span data-key="t-widgets">Sales Persons</span>
                    </a>
                </li>
                @endif

                {{-- Car Manufactures --}}
                @if(userCanAccessRoute('car-manufactures.index'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('car-manufactures.index') }}">
                        <i class="ri-car-line"></i> <span data-key="t-widgets">Car Manufactures</span>
                    </a>
                </li>
                @endif

                {{-- Blog --}}
                @if(userCanAccessRoute('blog.index'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('blog.index') }}">
                        <i class="ri-article-line"></i> <span data-key="t-widgets">Blog</span>
                    </a>
                </li>
                @endif

                {{-- Products --}}
                @if(userCanAccessRoute('products.index'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('products.index') }}">
                        <i class="ri-store-2-line"></i> <span data-key="t-widgets">Products</span>
                    </a>
                </li>
                @endif

                {{-- Reports --}}
                @if(userCanAccessRoute('reports.index'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('reports.index') }}">
                        <i class="ri-bar-chart-2-line"></i> <span data-key="t-widgets">Report</span>
                    </a>
                </li>
                @endif

                {{-- Replacements --}}
                @if(userCanAccessRoute('replacements.index'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('replacements.index') }}">
                        <i class="ri-repeat-line"></i> <span data-key="t-widgets">Replacement</span>
                    </a>
                </li>
                @endif

                {{-- Contacts --}}
                @if(userCanAccessRoute('contacts.index'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('contacts.index') }}">
                        <i class="ri-contacts-book-line"></i> <span data-key="t-widgets">Contacts</span>
                    </a>
                </li>
                @endif

                {{-- Services --}}
                @if(userCanAccessRoute('services.index'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('services.index') }}">
                        <i class="ri-customer-service-2-line"></i> <span data-key="t-widgets">Services</span>
                    </a>
                </li>
                @endif
                @if(userCanAccessRoute('making-quotation.index'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('making-quotation.index') }}">
                        <i class="ri-file-text-line"></i> <span data-key="t-widgets">Making Quotation</span>
                    </a>
                </li> 
                @endif

                {{-- Workers --}}
                @if(userCanAccessRoute('workers.index'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('workers.index') }}">
                        <i class="ri-user-settings-line"></i> <span data-key="t-widgets">Workers</span>
                    </a>
                </li>
                @endif

                {{-- Works --}}
                @if(userCanAccessRoute('works.index'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('works.index') }}">
                        <i class="ri-tools-line"></i> <span data-key="t-widgets">Work</span>
                    </a>
                </li>
                @endif

                {{-- Making Quotation --}}
                





                {{-- <li class="nav-item">
                     <a class="nav-link menu-link" href="#sidebarCharts" data-bs-toggle="collapse"
                         role="button" aria-expanded="false" aria-controls="sidebarCharts">
                         <i class="ri-pie-chart-line"></i> <span data-key="t-charts">Charts</span>
                     </a>
                     <div class="collapse menu-dropdown" id="sidebarCharts">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="#sidebarApexcharts" class="nav-link" data-bs-toggle="collapse"
                                     role="button" aria-expanded="false" aria-controls="sidebarApexcharts"
                                     data-key="t-apexcharts">
                                     Apexcharts
                                 </a>
                                 <div class="collapse menu-dropdown" id="sidebarApexcharts">
                                     <ul class="nav nav-sm flex-column">
                                         <li class="nav-item">
                                             <a href="charts-apex-line.html" class="nav-link" data-key="t-line">
                                                 Line
                                             </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-area.html" class="nav-link" data-key="t-area">
                                                 Area
                                             </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-column.html" class="nav-link"
                                                 data-key="t-column">
                                                 Column </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-bar.html" class="nav-link" data-key="t-bar"> Bar
                                             </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-mixed.html" class="nav-link" data-key="t-mixed">
                                                 Mixed
                                             </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-timeline.html" class="nav-link"
                                                 data-key="t-timeline">
                                                 Timeline </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-range-area.html" class="nav-link"><span
                                                     data-key="t-range-area">Range Area</span> <span
                                                     class="badge badge-pill bg-success"
                                                     data-key="t-new">New</span></a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-funnel.html" class="nav-link"><span
                                                     data-key="t-funnel">Funnel</span> <span
                                                     class="badge badge-pill bg-success"
                                                     data-key="t-new">New</span></a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-candlestick.html" class="nav-link"
                                                 data-key="t-candlstick"> Candlstick </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-boxplot.html" class="nav-link"
                                                 data-key="t-boxplot">
                                                 Boxplot </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-bubble.html" class="nav-link"
                                                 data-key="t-bubble">
                                                 Bubble </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-scatter.html" class="nav-link"
                                                 data-key="t-scatter">
                                                 Scatter </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-heatmap.html" class="nav-link"
                                                 data-key="t-heatmap">
                                                 Heatmap </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-treemap.html" class="nav-link"
                                                 data-key="t-treemap">
                                                 Treemap </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-pie.html" class="nav-link" data-key="t-pie"> Pie
                                             </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-radialbar.html" class="nav-link"
                                                 data-key="t-radialbar"> Radialbar </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-radar.html" class="nav-link" data-key="t-radar">
                                                 Radar
                                             </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="charts-apex-polar.html" class="nav-link"
                                                 data-key="t-polar-area">
                                                 Polar Area </a>
                                         </li>
                                     </ul>
                                 </div>
                             </li>
                             <li class="nav-item">
                                 <a href="charts-chartjs.html" class="nav-link" data-key="t-chartjs"> Chartjs </a>
                             </li>
                             <li class="nav-item">
                                 <a href="charts-echarts.html" class="nav-link" data-key="t-echarts"> Echarts </a>
                             </li>
                         </ul>
                     </div>
                 </li> --}}
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>

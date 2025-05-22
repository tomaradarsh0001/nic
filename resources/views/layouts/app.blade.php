<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <!-- <meta name="csrf-token" content="content"> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/images/logo-icon.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/range.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">
    
  {{-- <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"> </script> --}} <!-- script moved to header by Nitin to resolve $ is not defined error for scrips not defined in footer -->
    <!-- Toaster CSS Added by Diwakar Sinha at 20-09-2024 -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
   
    <title>e-Dharti 2.0 | @yield('title')</title>
</head>

<body>
    @include('include.loader')

    <!--wrapper-->
    <div class="wrapper toggled">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text">e-Dharti 2.0</h4>
                </div>
                <div class="toggle-icon mobile-toggle"><i class='bx bx-menu'></i></div>

            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
            <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                    <ul>
                        <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}"><i class="bx bx-right-arrow-alt"></i>My Dashboard</a>
                        </li>
                        @haspermission('main.dashboard')
                        <li class="{{ request()->is('dashboard/main') ? 'active' : '' }}">
                            <a href="{{ route('dashboard.main') }}"><i class="bx bx-right-arrow-alt"></i>Dashboard</a>
                        </li>
                        @endhaspermission
                    </ul>
                </li>
                @haspermission('viewDetails')
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="fa-solid fa-file-pen"></i>
                        </div>
                        <div class="menu-title">MIS</div>
                    </a>
                    <ul>
                        @haspermission('add.single.property')
                            <li class="{{ request()->is('property-form') ? 'active' : '' }}"> <a
                                    href="{{ route('mis.index') }}"><i class="bx bx-right-arrow-alt"></i>Add Single Property</a>
                            </li>
                        @endhaspermission
                        @haspermission('add.multiple.property')
                        <li class="{{ request()->is('property-form-multiple') ? 'active' : '' }}"> <a
                                href="{{ route('mis.form.multiple') }}"><i class="bx bx-right-arrow-alt"></i>Add
                                Multiple Property</a>
                        </li>
                        @endhaspermission
                        @haspermission('create.flat')
                        <li class="{{ request()->is('flat-form') ? 'active' : '' }}"> <a
                                href="{{ route('create.flat.form') }}"><i class="bx bx-right-arrow-alt"></i>Add
                                Flat</a>
                        </li>
                        @endhaspermission
                        @if(auth()->user()->hasAnyPermission(['viewDetails','view.flat']))
                        <li> <a href="javascript:;" class="has-arrow submenu-parent"><i class="bx bx-right-arrow-alt"></i>View Details</a>
                            <ul>
                                @haspermission('viewDetails')
                                <li class="{{ request()->is('property-details') ? 'active' : '' }}"> <a
                                        href="{{ route('propertDetails') }}"><i class='bx bx-chevron-right'></i>Property Details</a>
                                </li>
                                @endhaspermission
                                @haspermission('view.flat')
                                <li class="{{ request()->is('flats') ? 'active' : '' }}"> <a
                                        href="{{ route('flats') }}"><i class='bx bx-chevron-right'></i>Flat Details</a>
                                </li>
                                @endhaspermission
                            </ul>
                        </li>
                        @endif
                    </ul>
                </li>
                @endhaspermission

                @haspermission('apply.application')
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bxs-file'></i></div>
                        <div class="menu-title">Application</div>
                    </a>
                    <ul>
                        <li class="{{ request()->is('application/new') ? 'active' : '' }}">
                            <a href="{{ route('new.application') }}"><i class="bx bx-right-arrow-alt"></i>New</a>
                        </li>
                        <li class="{{ request()->is('applications/draft') ? 'active' : '' }}"> <a
                                href="{{ route('draftApplications') }}"><i
                                    class="bx bx-right-arrow-alt"></i>Draft</a>
                        </li>
                        <li>
                            <a href="javascript:;" class="has-arrow submenu-parent"><i class="bx bx-right-arrow-alt"></i> History</a>
                            <ul>
                                <li class="{{ request()->is('applications/history/details') ? 'active' : '' }}"> <a href="{{route('applications.history.details')}}"><i class='bx bx-chevron-right'></i> Submitted Applications</a></li>
                                <li class="{{ request()->is('applications/history/withdraw') ? 'active' : '' }}"> <a href="{{route('applications.history.withdraw.details')}}"><i class='bx bx-chevron-right'></i> Withdrawn Applications</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                @endhaspermission


                @php
                    $hasAccess = Auth::user()->can('view.appointment') || Auth::user()->can('view.grievance');
                @endphp

                @if ($hasAccess)
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fas fa-users-cog"></i></div>
                            <div class="menu-title">Public Services</div>
                        </a>
                        <ul>
                            @can('view.appointment')
                            <li class="{{ request()->is('appointments*') ? 'active' : '' }}"> 
                                <a href="{{ route('appointments.index') }}"><i class="bx bx-right-arrow-alt"></i>Appointments</a>
                            </li>
                            @endcan
                            @can('view.grievance')
                            <li class="{{ request()->is('grievances*') ? 'active' : '' }}"> 
                                <a href="{{ route('grievance.index') }}"><i class="bx bx-right-arrow-alt"></i>Grievances</a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                
                @haspermission('view reports')
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="bx bx-message-square-edit"></i>
                        </div>
                        <div class="menu-title">Reports</div>
                    </a>
                    <ul>
                    <li class="{{ request()->is('reports') ? 'active' : '' }}"> <a
                                href="{{ route('reports.index') }}"><i class="bx bx-right-arrow-alt"></i>Filter Report</a>
                        </li>
                        {{-- <li class="{{ request()->is('tabular-record') ? 'active' : '' }}"> <a
                                href="{{ route('tabularRecord') }}"><i class="bx bx-right-arrow-alt"></i>Tabular
                                Record</a>
                        </li> --}}
                        <li class="{{ request()->is('detailed-report') ? 'active' : '' }}"> <a
                                href="{{ route('detailedReport') }}"><i class="bx bx-right-arrow-alt"></i>Detailed Report</a>
                        </li>
                        {{-- <li class="{{ request()->is('customize-report') ? 'active' : '' }}"> <a
                                href="{{ route('customizeReport') }}"><i class="bx bx-right-arrow-alt"></i>Customized
                                Report</a>
                        </li>--}}
                        
                    </ul>
                </li>
                @endhaspermission
                @if(auth()->user()->hasAnyPermission(['applicant.view.property.details','section.property.mis.update.request']))

                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="fa-solid fa-house-user"></i>
                        </div>
                        <div class="menu-title">Property Details</div>
                    </a>
                    <ul>
                      <!-- <li class="{{ request()->is('applicant/profile') ? 'active' : '' }}"> <a
                                href="{{ route('applicant.profile') }}"><i class="bx bx-right-arrow-alt"></i>Profile
                                {{ request()->is() }}</a>
                        </li>  -->
                        @can('applicant.view.property.details')
                        <li class="{{ request()->is('applicant/property/details') ? 'active' : '' }}"> <a
                                href="{{ route('applicant.properties') }}"><i
                                    class="bx bx-right-arrow-alt"></i>Property Details {{ request()->is() }}</a>
                        </li>
                        @endcan
                        @can('section.property.mis.update.request')
                        <li class="{{ request()->is('mis/update/request/list') ? 'active' : '' }}">
                            <a href="{{ route('misUpdateRequestList') }}"><i class="bx bx-right-arrow-alt"></i>Mis
                                Update Request {{ request()->is() }}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @can('create.demand')
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="fa-solid fa-coins"></i>
                        </div>
                        <div class="menu-title">Demand</div>
                    </a>
                    <ul>
                        <li class="{{ request()->is('demand') ? 'active' : '' }}"> <a
                                href="{{ route('createDemandView') }}"><i class="bx bx-right-arrow-alt"></i>Create Demand</a>
                        </li>
                        <li class="{{ request()->is('demandList') ? 'active' : '' }}"> <a
                                href="{{ route('demandList') }}"><i class="bx bx-right-arrow-alt"></i>Demand List</a>
                        </li>
                    </ul>
                </li>
                @endcan

                @can('miscellaneous')
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fa-solid fa-puzzle-piece"></i>
                            </div>
                            <div class="menu-title">Miscellaneous</div>
                        </a>
                        <ul>
                            @can('miscellaneous.property.transfer')
                                <li class="{{ request()->is('property-transfer') ? 'active' : '' }}"> <a
                                        href="{{ route('miscellaneous.property.transfer') }}"><i
                                            class="bx bx-right-arrow-alt"></i>Property Transfer</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                {{--<li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="bx bx-category"></i>
                        </div>
                        <div class="menu-title">MIS</div>
                    </a>
                    <ul>
                        <li class="{{ request()->is('property-form') ? 'active' : '' }}"> <a
                                href="{{ route('mis.index') }}"><i class="bx bx-right-arrow-alt"></i>Add Property</a>
                        </li>
                        @haspermission('add.multiple.property')
                        <li class="{{ request()->is('property-form-multiple') ? 'active' : '' }}"> <a
                                href="{{ route('mis.form.multiple') }}"><i class="bx bx-right-arrow-alt"></i>Add
                                Multiple Property</a>
                        </li>
                        @endhaspermission
                        @haspermission('create.flat')
                        <li class="{{ request()->is('flat-form') ? 'active' : '' }}"> <a
                                href="{{ route('create.flat.form') }}"><i class="bx bx-right-arrow-alt"></i>Add
                                Flat</a>
                        </li>
                        @endhaspermission
                        <li> <a href="javascript:;" class="has-arrow submenu-parent"><i class="bx bx-right-arrow-alt"></i>View Details</a>
                            <ul>
                                @haspermission('viewDetails')
                                <li class="{{ request()->is('property-details') ? 'active' : '' }}"> <a
                                        href="{{ route('propertDetails') }}"><i class='bx bx-chevron-right'></i> View Property Details</a>
                                </li>
                                @endhaspermission
                                @haspermission('view.flat')
                                <li class="{{ request()->is('flats') ? 'active' : '' }}"> <a
                                        href="{{ route('flats') }}"><i class='bx bx-chevron-right'></i> View Flat Details</a>
                                </li>
                                @endhaspermission
                                @can('applicant.view.property.details')
                                <li class="{{ request()->is('applicant/property/details') ? 'active' : '' }}"> <a
                                        href="{{ route('applicant.properties') }}"><i
                                            class="bx bx-chevron-right"></i>Property Details {{ request()->is() }}</a>
                                </li>
                                @endcan
                                @can('section.property.mis.update.request')
                                <li class="{{ request()->is('mis/update/request/list') ? 'active' : '' }}">
                                    <a href="{{ route('misUpdateRequestList') }}"><i class="bx bx-right-arrow-alt"></i>Mis
                                        Update Request {{ request()->is() }}</a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    </ul>
                </li> --}}
                
                <!-- <li class="{{ request()->is('/application/deed_of_apartment/fill_application_details') ? 'active' : '' }}">
                    <a href="{{ route('application.apartment.create') }}">
                        <div class="parent-icon"><i class='bx bxs-file'></i>
                        </div>
                        <div class="menu-title">Deed of Apartment</div>
                    </a>
                </li>
                <li class="menu-label">UI Elements</li>
                <li>
                    <a href="widgets.html">
                        <div class="parent-icon"><i class='bx bx-cookie'></i>
                        </div>
                        <div class="menu-title">Widgets</div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-cart'></i>
                        </div>
                        <div class="menu-title">eCommerce</div>
                    </a>
                    <ul>
                        <li> <a href="ecommerce-products.html"><i class="bx bx-right-arrow-alt"></i>Products</a>
                        </li>
                        <li> <a href="ecommerce-products-details.html"><i class="bx bx-right-arrow-alt"></i>Product
                                Details</a>
                        </li>
                        <li> <a href="ecommerce-add-new-products.html"><i class="bx bx-right-arrow-alt"></i>Add New
                                Products</a>
                        </li>
                        <li> <a href="ecommerce-orders.html"><i class="bx bx-right-arrow-alt"></i>Orders</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                        </div>
                        <div class="menu-title">Components</div>
                    </a>
                    <ul>
                        <li> <a href="component-alerts.html"><i class="bx bx-right-arrow-alt"></i>Alerts</a>
                        </li>
                        <li> <a href="component-accordions.html"><i class="bx bx-right-arrow-alt"></i>Accordions</a>
                        </li>
                        <li> <a href="component-badges.html"><i class="bx bx-right-arrow-alt"></i>Badges</a>
                        </li>
                        <li> <a href="component-buttons.html"><i class="bx bx-right-arrow-alt"></i>Buttons</a>
                        </li>
                        <li> <a href="component-cards.html"><i class="bx bx-right-arrow-alt"></i>Cards</a>
                        </li>
                        <li> <a href="component-carousels.html"><i class="bx bx-right-arrow-alt"></i>Carousels</a>
                        </li>
                        <li> <a href="component-list-groups.html"><i class="bx bx-right-arrow-alt"></i>List Groups</a>
                        </li>
                        <li> <a href="component-media-object.html"><i class="bx bx-right-arrow-alt"></i>Media
                                Objects</a>
                        </li>
                        <li> <a href="component-modals.html"><i class="bx bx-right-arrow-alt"></i>Modals</a>
                        </li>
                        <li> <a href="component-navs-tabs.html"><i class="bx bx-right-arrow-alt"></i>Navs & Tabs</a>
                        </li>
                        <li> <a href="component-navbar.html"><i class="bx bx-right-arrow-alt"></i>Navbar</a>
                        </li>
                        <li> <a href="component-paginations.html"><i class="bx bx-right-arrow-alt"></i>Pagination</a>
                        </li>
                        <li> <a href="component-popovers-tooltips.html"><i class="bx bx-right-arrow-alt"></i>Popovers
                                & Tooltips</a>
                        </li>
                        <li> <a href="component-progress-bars.html"><i class="bx bx-right-arrow-alt"></i>Progress</a>
                        </li>
                        <li> <a href="component-spinners.html"><i class="bx bx-right-arrow-alt"></i>Spinners</a>
                        </li>
                        <li> <a href="component-notifications.html"><i
                                    class="bx bx-right-arrow-alt"></i>Notifications</a>
                        </li>
                        <li> <a href="component-avtars-chips.html"><i class="bx bx-right-arrow-alt"></i>Avatrs &
                                Chips</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-repeat"></i>
                        </div>
                        <div class="menu-title">Content</div>
                    </a>
                    <ul>
                        <li> <a href="content-grid-system.html"><i class="bx bx-right-arrow-alt"></i>Grid System</a>
                        </li>
                        <li> <a href="content-typography.html"><i class="bx bx-right-arrow-alt"></i>Typography</a>
                        </li>
                        <li> <a href="content-text-utilities.html"><i class="bx bx-right-arrow-alt"></i>Text
                                Utilities</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"> <i class="bx bx-donate-blood"></i>
                        </div>
                        <div class="menu-title">Icons</div>
                    </a>
                    <ul>
                        <li> <a href="icons-line-icons.html"><i class="bx bx-right-arrow-alt"></i>Line Icons</a>
                        </li>
                        <li> <a href="icons-boxicons.html"><i class="bx bx-right-arrow-alt"></i>Boxicons</a>
                        </li>
                        <li> <a href="icons-feather-icons.html"><i class="bx bx-right-arrow-alt"></i>Feather Icons</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-label">Forms & Tables</li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                        </div>
                        <div class="menu-title">Forms</div>
                    </a>
                    <ul>
                        <li> <a href="form-elements.html"><i class="bx bx-right-arrow-alt"></i>Form Elements</a>
                        </li>
                        <li> <a href="form-input-group.html"><i class="bx bx-right-arrow-alt"></i>Input Groups</a>
                        </li>
                        <li> <a href="form-radios-and-checkboxes.html"><i class="bx bx-right-arrow-alt"></i>Radios &
                                Checkboxes</a>
                        </li>
                        <li> <a href="form-layouts.html"><i class="bx bx-right-arrow-alt"></i>Forms Layouts</a>
                        </li>
                        <li> <a href="form-validations.html"><i class="bx bx-right-arrow-alt"></i>Form Validation</a>
                        </li>
                        <li> <a href="form-wizard.html"><i class="bx bx-right-arrow-alt"></i>Form Wizard</a>
                        </li>
                        <li> <a href="form-text-editor.html"><i class="bx bx-right-arrow-alt"></i>Text Editor</a>
                        </li>
                        <li> <a href="form-file-upload.html"><i class="bx bx-right-arrow-alt"></i>File Upload</a>
                        </li>
                        <li> <a href="form-date-time-pickes.html"><i class="bx bx-right-arrow-alt"></i>Date
                                Pickers</a>
                        </li>
                        <li> <a href="form-select2.html"><i class="bx bx-right-arrow-alt"></i>Select2</a>
                        </li>
                        <li> <a href="form-repeater.html"><i class="bx bx-right-arrow-alt"></i>Form Repeater</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-grid-alt"></i>
                        </div>
                        <div class="menu-title">Tables</div>
                    </a>
                    <ul>
                        <li> <a href="table-basic-table.html"><i class="bx bx-right-arrow-alt"></i>Basic Table</a>
                        </li>
                        <li> <a href="table-datatable.html"><i class="bx bx-right-arrow-alt"></i>Data Table</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-label">Pages</li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-lock"></i>
                        </div>
                        <div class="menu-title">Authentication</div>
                    </a>
                    <ul>
                        <li><a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Basic</a>
                            <ul>
                                <li><a href="auth-basic-signin.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Sign In</a></li>
                                <li><a href="auth-basic-signup.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Sign Up</a></li>
                                <li><a href="auth-basic-forgot-password.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Forgot Password</a></li>
                                <li><a href="auth-basic-reset-password.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Reset Password</a></li>
                            </ul>
                        </li>
                        <li><a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Cover</a>
                            <ul>
                                <li><a href="auth-cover-signin.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Sign In</a></li>
                                <li><a href="auth-cover-signup.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Sign Up</a></li>
                                <li><a href="auth-cover-forgot-password.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Forgot Password</a></li>
                                <li><a href="auth-cover-reset-password.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Reset Password</a></li>
                            </ul>
                        </li>
                        <li><a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>With Header
                                Footer</a>
                            <ul>
                                <li><a href="auth-header-footer-signin.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Sign In</a></li>
                                <li><a href="auth-header-footer-signup.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Sign Up</a></li>
                                <li><a href="auth-header-footer-forgot-password.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Forgot Password</a></li>
                                <li><a href="auth-header-footer-reset-password.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Reset Password</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="user-profile.html">
                        <div class="parent-icon"><i class="bx bx-user-circle"></i>
                        </div>
                        <div class="menu-title">User Profile</div>
                    </a>
                </li>
                <li>
                    <a href="timeline.html">
                        <div class="parent-icon"> <i class="bx bx-video-recording"></i>
                        </div>
                        <div class="menu-title">Timeline</div>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-error"></i>
                        </div>
                        <div class="menu-title">Errors</div>
                    </a>
                    <ul>
                        <li> <a href="errors-404-error.html" target="_blank"><i class="bx bx-right-arrow-alt"></i>404
                                Error</a>
                        </li>
                        <li> <a href="errors-500-error.html" target="_blank"><i class="bx bx-right-arrow-alt"></i>500
                                Error</a>
                        </li>
                        <li> <a href="errors-coming-soon.html" target="_blank"><i
                                    class="bx bx-right-arrow-alt"></i>Coming Soon</a>
                        </li>
                        <li> <a href="error-blank-page.html" target="_blank"><i
                                    class="bx bx-right-arrow-alt"></i>Blank Page</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="faq.html">
                        <div class="parent-icon"><i class="bx bx-help-circle"></i>
                        </div>
                        <div class="menu-title">FAQ</div>
                    </a>
                </li>
                <li>
                    <a href="pricing-table.html">
                        <div class="parent-icon"><i class="bx bx-diamond"></i>
                        </div>
                        <div class="menu-title">Pricing</div>
                    </a>
                </li>
                <li class="menu-label">Charts & Maps</li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-line-chart"></i>
                        </div>
                        <div class="menu-title">Charts</div>
                    </a>
                    <ul>
                        <li> <a href="charts-apex-chart.html"><i class="bx bx-right-arrow-alt"></i>Apex</a>
                        </li>
                        <li> <a href="charts-chartjs.html"><i class="bx bx-right-arrow-alt"></i>Chartjs</a>
                        </li>
                        <li> <a href="charts-highcharts.html"><i class="bx bx-right-arrow-alt"></i>Highcharts</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-map-alt"></i>
                        </div>
                        <div class="menu-title">Maps</div>
                    </a>
                    <ul>
                        <li> <a href="map-google-maps.html"><i class="bx bx-right-arrow-alt"></i>Google Maps</a>
                        </li>
                        <li> <a href="map-vector-maps.html"><i class="bx bx-right-arrow-alt"></i>Vector Maps</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-label">Others</li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-menu"></i>
                        </div>
                        <div class="menu-title">Menu Levels</div>
                    </a>
                    <ul>
                        <li> <a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Level
                                One</a>
                            <ul>
                                <li> <a class="has-arrow" href="javascript:;"><i
                                            class="bx bx-right-arrow-alt"></i>Level Two</a>
                                    <ul>
                                        <li> <a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Level
                                                Three</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="https://codervent.com/rocker/documentation/index.html" target="_blank">
                        <div class="parent-icon"><i class="bx bx-folder"></i>
                        </div>
                        <div class="menu-title">Documentation</div>
                    </a>
                </li>
                <li>
                    <a href="https://themeforest.net/user/codervent" target="_blank">
                        <div class="parent-icon"><i class="bx bx-support"></i>
                        </div>
                        <div class="menu-title">Support</div>
                    </a>
                </li> -->
            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
        <!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mob-logo">
                        <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                    </div>
                    <div class="toggle-icon"><i class='bx bx-menu'></i></div>
                    <!-- <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                </div> -->
                    <!-- <div class="search-bar flex-grow-1">
                    <div class="position-relative search-bar-box">
                        <input type="text" class="form-control search-control"
                            placeholder="Type to search..."> <span
                            class="position-absolute top-50 search-show translate-middle-y"><i
                                class='bx bx-search'></i></span>
                            <span class="position-absolute top-50 search-close translate-middle-y"><i
                                    class='bx bx-x'></i></span>
                        </div>
                    </div> -->
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center">
                            <!-- <li class="nav-item mobile-search-icon">
                                <a class="nav-link" href="#"> <i class='bx bx-search'></i>
                                </a>
                            </li> -->
                            @haspermission('setting')
                            @include('layouts.settings')
                            @endhaspermission
                            <li class="d-none nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="alert-count">7</span>
                                    <i class='bx bx-bell'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Notifications</p>
                                            <p class="msg-header-clear ms-auto">Marks all as read</p>
                                        </div>
                                    </a>
                                    <div class="header-notifications-list">
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-primary text-primary"><i
                                                        class="bx bx-group"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Customers<span
                                                            class="msg-time float-end">14 Sec
                                                            ago</span></h6>
                                                    <p class="msg-info">5 new user registered</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-danger text-danger"><i
                                                        class="bx bx-cart-alt"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Orders <span class="msg-time float-end">2
                                                            min
                                                            ago</span></h6>
                                                    <p class="msg-info">You have recived new orders</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-success text-success"><i
                                                        class="bx bx-file"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">24 PDF File<span class="msg-time float-end">19
                                                            min
                                                            ago</span></h6>
                                                    <p class="msg-info">The pdf files generated</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-warning text-warning"><i
                                                        class="bx bx-send"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Time Response <span
                                                            class="msg-time float-end">28 min
                                                            ago</span></h6>
                                                    <p class="msg-info">5.1 min avarage time response</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-info text-info"><i
                                                        class="bx bx-home-circle"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Product Approved <span
                                                            class="msg-time float-end">2 hrs
                                                            ago</span>
                                                    </h6>
                                                    <p class="msg-info">Your new product has approved</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-danger text-danger"><i
                                                        class="bx bx-message-detail"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Comments <span class="msg-time float-end">4
                                                            hrs
                                                            ago</span></h6>
                                                    <p class="msg-info">New customer comments recived</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-success text-success"><i
                                                        class='bx bx-check-square'></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Your item is shipped <span
                                                            class="msg-time float-end">5 hrs
                                                            ago</span></h6>
                                                    <p class="msg-info">Successfully shipped your item</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-primary text-primary"><i
                                                        class='bx bx-user-pin'></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New 24 authors<span
                                                            class="msg-time float-end">1 day
                                                            ago</span></h6>
                                                    <p class="msg-info">24 new authors joined last week</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-warning text-warning"><i
                                                        class='bx bx-door-open'></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Defense Alerts <span
                                                            class="msg-time float-end">2 weeks
                                                            ago</span></h6>
                                                    <p class="msg-info">45% less alerts last 4 weeks</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer">View All Notifications</div>
                                    </a>
                                </div>
                            </li>
                            <li class="d-none nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="alert-count">8</span>
                                    <i class='bx bx-comment'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Messages</p>
                                            <p class="msg-header-clear ms-auto">Marks all as read</p>
                                        </div>
                                    </a>
                                    <div class="header-message-list">
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-1.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Daisy Anderson <span
                                                            class="msg-time float-end">5 sec
                                                            ago</span></h6>
                                                    <p class="msg-info">The standard chunk of lorem</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-2.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Althea Cabardo <span
                                                            class="msg-time float-end">14
                                                            sec ago</span></h6>
                                                    <p class="msg-info">Many desktop publishing packages</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-3.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Oscar Garner <span class="msg-time float-end">8
                                                            min
                                                            ago</span></h6>
                                                    <p class="msg-info">Various versions have evolved over</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-4.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Katherine Pechon <span
                                                            class="msg-time float-end">15
                                                            min ago</span></h6>
                                                    <p class="msg-info">Making this the first true generator</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-5.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Amelia Doe <span class="msg-time float-end">22
                                                            min
                                                            ago</span></h6>
                                                    <p class="msg-info">Duis aute irure dolor in reprehenderit</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-6.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Cristina Jhons <span
                                                            class="msg-time float-end">2 hrs
                                                            ago</span></h6>
                                                    <p class="msg-info">The passage is attributed to an unknown</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-7.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">James Caviness <span
                                                            class="msg-time float-end">4 hrs
                                                            ago</span></h6>
                                                    <p class="msg-info">The point of using Lorem</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-8.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Peter Costanzo <span
                                                            class="msg-time float-end">6 hrs
                                                            ago</span></h6>
                                                    <p class="msg-info">It was popularised in the 1960s</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-9.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">David Buckley <span
                                                            class="msg-time float-end">2 hrs
                                                            ago</span></h6>
                                                    <p class="msg-info">Various versions have evolved over</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-10.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Thomas Wheeler <span
                                                            class="msg-time float-end">2 days
                                                            ago</span></h6>
                                                    <p class="msg-info">If you are going to use a passage</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-11.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Johnny Seitz <span class="msg-time float-end">5
                                                            days
                                                            ago</span></h6>
                                                    <p class="msg-info">All the Lorem Ipsum generators</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer">View All Messages</div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('assets/images/avatars/avatar-1.png') }}" class="user-img"
                                alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0">{{ Auth::user()->name }}</p>
                                <p class="designattion mb-0">{{ Auth::user()->email }}</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        <i class='bx bx-log-out-circle'></i> <span>{{ __('Log Out') }}</span>
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!--end header -->


        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                @if (session('success'))
                <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                    <div class="text-white">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if (session('failure'))
                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                    <div class="text-white">{{ session('failure') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                    @foreach ($errors->all() as $error)
                    <div class="text-white">{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @yield('content')
            </div>
        </div>
        <!--end page wrapper -->



        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright © 2024. All right reserved.</p>
        </footer>
    </div>
    <!--end wrapper-->
    <div class="overlay"></div>


    <!--start switcher-->
    @canany(['calculate.conversion', 'calculate.landUseChange','calculate.unearnedIncrease'])
    <div class="switcher-wrapper">
        <div class="switcher-btn"> <!--<i class="fa-solid fa-screwdriver-wrench bx-spin"></i>-->
            <h6 class="charges_title"><i class='bx bx-info-circle'></i> Know the Charges</h6>
        </div>
        <div class="switcher-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 text-uppercase">Utilities</h5>
                <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
            </div>

            <hr />
            <div class="header-colors-indigators">

                <div class="row row-cols-auto g-3">
                    <div class="col">
                        <h5 class="utilities-title">Calculator <i class='bx bxs-calculator'></i></h5>
                    </div>
                    @can('calculate.conversion')
                    <div class="col">
                        <a href="{{ route('calculateConversionCharges') }}">
                            <span><i class='bx bx-chevron-right'></i> Conversion</span>
                        </a>
                    </div>
                    @endcan
                    @can('calculate.landUseChange')
                    <div class="col">
                        <a href="{{ route('calculateLandUseChangeCharges') }}">
                            <span><i class='bx bx-chevron-right'></i> Land Use Change</span>
                        </a>
                    </div>
                    @endcan
                    @can('calculate.unearnedIncrease')
                    <div class="col">
                        <a href="{{ route('calculateUnearnedIncrease') }}">
                            <span><i class='bx bx-chevron-right'></i> Unearned Increase</span>
                        </a>
                    </div>
                    @endcan
                </div>

            </div>
        </div>
    </div>
    @endcanany
    <!--end switcher-->


    <!-- Bootstrap JS -->

       <script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- Commented By Lalit on 09/18/2024 Duplicate we are already using jquery.dataTables.min.js that's why we commented jquery.dataTables.min.js  -->
    {{-- <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote-lite.min.js') }}"></script>
    <!-- Toast JS Added by Diwakar Sinha at 20-09-2024 -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        $(document).ready(function () {
            $('#myDataTable').DataTable();
        });
    </script>

    <script>
        $(document).ready(function () {
            var $alertElement = $('.alert');
            if ($alertElement.length) {
                setTimeout(function () {
                    $alertElement.fadeOut();
                }, 3000);
            }
               const spinnerOverlay = document.getElementById('spinnerOverlay');
               if(spinnerOverlay){
                spinnerOverlay.style.display = 'none';
               }
        });
    </script>

    @yield('footerScript')
</body>

</html>

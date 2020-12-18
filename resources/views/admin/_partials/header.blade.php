@inject('notificationController','App\Http\Controllers\NotificationController')
@php
    $notifications = $notificationController->getNotifications(8, 'desc');
@endphp
<header class="topbar"{{-- style="z-index: 9998"--}}>
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                @include('admin._partials.navigation')
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto mt-md-0">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                <!-- ============================================================== -->
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- Comment -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                        <ul>
                            <li>
                                <div class="drop-title">Notifications</div>
                            </li>
                            <li>
                                <div class="message-center" style="height: auto !important;">
                                    @foreach($notifications as $notification)
                                    <!-- Message -->
                                    <a href="{{ $notification->link }}" target="_blank">
                                        <div class="btn btn-danger btn-circle">
                                            <i class="fa fa-bell"></i>
                                        </div>
                                        <div class="mail-contnet">
                                            <h5>{{ $notification->title }}</h5>
                                            <span class="mail-desc">{{ $notification->detail }}</span>
                                            <span class="time">{{ $notification->created_at->format('Y-m-d h:i A') }}</span>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center" href="{{ route('notifications') }}">
                                    <strong>Check all notifications</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End Comment -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/6/67/User_Avatar.png" alt="user" class="profile-pic" /></a>
                    <div class="dropdown-menu dropdown-menu-right scale-up">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="https://upload.wikimedia.org/wikipedia/commons/6/67/User_Avatar.png" alt="user"></div>
                                    <div class="u-text">
                                        <h4>{{ auth()->user()->name }}</h4>
                                        <p class="text-muted">{{ auth()->user()->email }}</p>
                                        <a href="{{ route('profile') }}" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('profile') }}"><i class="ti-user"></i> My Profile</a></li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off"></i> Logout
                                </a>
                        </ul>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                <!-- ============================================================== -->
                <!-- Language -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>

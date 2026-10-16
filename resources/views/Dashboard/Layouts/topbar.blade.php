<div class="header">

    <style>
        /* hide template green circle beside logo */
        .header-left #toggle_btn {
            display: none !important;
        }
    </style>

    <div class="header-left active">
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{asset('assets/img/logo.png')}}" alt="prioisp">
        </a>
        <a href="{{ route('dashboard') }}" class="logo-small">
            <img src="{{asset('assets/img/logo-small.png')}}" alt="prioisp">
        </a>
        <a id="toggle_btn" href="javascript:void(0);"></a>
    </div>

    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <ul class="nav user-menu">

        <li class="nav-item">
            <a href="{{ route('support.tickets') }}" class="nav-link" title="Complaints">
                <i class="fas fa-headset" style="font-size:18px;color:#1a2942;"></i>
            </a>
        </li>

        <li class="nav-item dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <img src="{{asset('assets/img/icons/notification-bing.svg')}}" alt="img">
                @if(($dashNotifications ?? collect())->count() > 0)
                    <span class="badge rounded-pill">{{ $dashNotifications->count() }}</span>
                @endif
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notifications</span>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        @forelse(($dashNotifications ?? collect()) as $noti)
                            @php
                                $notiUrl = '#';
                                try {
                                    if (!empty($noti->Noti_Route) && \Illuminate\Support\Facades\Route::has($noti->Noti_Route)) {
                                        $notiUrl = route($noti->Noti_Route);
                                    }
                                } catch (\Throwable $e) {
                                    $notiUrl = '#';
                                }
                                $icon = match($noti->Noti_Type ?? 'info') {
                                    'danger' => 'fa-exclamation-circle text-danger',
                                    'warning' => 'fa-exclamation-triangle text-warning',
                                    'success' => 'fa-check-circle text-success',
                                    default => 'fa-info-circle text-info',
                                };
                            @endphp
                            <li class="notification-message">
                                <a href="{{ $notiUrl }}">
                                    <div class="media d-flex">
                                        <span class="avatar flex-shrink-0 d-flex align-items-center justify-content-center"
                                            style="width:40px;height:40px;border-radius:50%;background:#f1f5f9;">
                                            <i class="fas {{ $icon }}"></i>
                                        </span>
                                        <div class="media-body flex-grow-1">
                                            <p class="noti-details">
                                                <span class="noti-title">{{ $noti->Noti_Title }}</span>
                                                {{ $noti->Noti_Detail }}
                                            </p>
                                            <p class="noti-time"><span class="notification-time">{{ $noti->Noti_Time }}</span></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="notification-message">
                                <div class="media d-flex px-3 py-3">
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details text-muted mb-0">No notifications right now.</p>
                                    </div>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
                </div>
            </div>
        </li>

        <li class="nav-item topbar-user-actions">
            <div class="topbar-user-wrap">
                <span class="topbar-username">{{ session('user_name') ?? session('full_name') ?? 'User' }}</span>
                <a href="{{ route('logout') }}" class="topbar-logout js-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </li>
        <style>
            .header .user-menu {
                display: flex !important;
                align-items: center !important;
                flex-wrap: nowrap !important;
                gap: 18px;
                margin: 0;
            }
            .header .user-menu > li {
                display: flex !important;
                align-items: center !important;
                float: none !important;
                margin: 0 !important;
            }
            .header .user-menu > li > a.nav-link {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                height: 60px !important;
                width: 36px;
                padding: 0 !important;
                line-height: 1 !important;
            }
            .header .user-menu > li > a.nav-link .fa-headset {
                font-size: 18px;
                color: #1a2942;
            }
            /* Theme sets .user-menu.nav>li>a { height:60px } — keep logout off that selector */
            .header .user-menu .topbar-user-actions {
                display: flex !important;
                align-items: center !important;
                height: 60px !important;
                padding: 0 12px 0 0 !important;
            }
            .header .topbar-user-wrap {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                height: auto;
            }
            .header .topbar-username {
                color: #1a2942;
                font-size: 0.82rem;
                font-weight: 600;
                line-height: 1.2;
                white-space: nowrap;
            }
            .header .topbar-logout {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center;
                gap: 4px;
                height: 24px !important;
                min-height: 24px !important;
                max-height: 24px !important;
                line-height: 1 !important;
                padding: 0 9px !important;
                margin: 0 !important;
                border: 1px solid #fecaca !important;
                border-radius: 4px !important;
                background: #fef2f2 !important;
                color: #dc2626 !important;
                font-size: 0.72rem !important;
                font-weight: 600 !important;
                text-decoration: none !important;
                white-space: nowrap;
                box-sizing: border-box !important;
                transition: background .15s ease, border-color .15s ease, color .15s ease;
            }
            .header .topbar-logout i {
                font-size: 0.68rem !important;
                line-height: 1 !important;
                color: #dc2626 !important;
            }
            .header .topbar-logout:hover {
                background: #dc2626 !important;
                border-color: #dc2626 !important;
                color: #fff !important;
            }
            .header .topbar-logout:hover i {
                color: #fff !important;
            }
        </style>
    </ul>


    <div class="dropdown mobile-user-menu">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <span class="dropdown-item-text fw-semibold">{{ session('user_name') ?? session('full_name') ?? 'User' }}</span>
            <a class="dropdown-item js-logout" href="{{ route('logout') }}">Logout</a>
        </div>
    </div>

</div>

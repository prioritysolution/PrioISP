<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <style>
                #sidebar-menu ul > li > a > i.menu-fa,
                #sidebar-menu ul > li.submenu > a > i.menu-fa {
                    width: 22px;
                    min-width: 22px;
                    font-size: 15px;
                    line-height: 1;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    margin-right: 10px;
                    color: #637381;
                    vertical-align: middle;
                }

                #sidebar-menu ul > li > a.active > i.menu-fa,
                #sidebar-menu ul > li.active > a > i.menu-fa {
                    color: #00c4cc;
                }

                #sidebar-menu ul > li > a {
                    display: flex;
                    align-items: center;
                }
            </style>
            @php
                $menuIconMap = [
                    // parent / feather aliases from DB
                    'home' => 'fas fa-home',
                    'credit-card' => 'fas fa-credit-card',
                    'shield' => 'fas fa-shield-alt',
                    'file-text' => 'fas fa-file-alt',
                    'users' => 'fas fa-users',
                    'settings' => 'fas fa-cog',
                    'bar-chart' => 'fas fa-chart-bar',
                    'dashboard' => 'fas fa-tachometer-alt',

                    // by route
                    'generate.demand' => 'fas fa-bolt',
                    'admin.generate.demand' => 'fas fa-bolt',
                    'demand.collection' => 'fas fa-hand-holding-usd',
                    'admin.demand.collection' => 'fas fa-hand-holding-usd',
                    'rectify' => 'fas fa-edit',
                    'admin.rectify' => 'fas fa-edit',
                    'bill.print' => 'fas fa-print',
                    'admin.counter' => 'fas fa-store',
                    'admin.zone' => 'fas fa-map-marker-alt',
                    'admin.user.setup' => 'fas fa-user-cog',
                    'admin.package' => 'fas fa-box',
                    'admin.surrender' => 'fas fa-user-slash',
                    'admin.new.customer' => 'fas fa-users',
                    'admin.counterwisecollection' => 'fas fa-chart-pie',
                    'admin.commission.register' => 'fas fa-percent',
                    'admin.commission.register.counter' => 'fas fa-percentage',
                    'admin.commission.payout' => 'fas fa-money-check-alt',
                    'report.customer.register' => 'fas fa-address-book',
                    'customer.ledger' => 'fas fa-book',
                    'admin.customer.ledger' => 'fas fa-book',
                    'report.renewal.register' => 'fas fa-sync-alt',
                    'admin.report.renewal.register' => 'fas fa-sync-alt',
                    'report.collection.register' => 'fas fa-receipt',
                    'admin.report.collection.register' => 'fas fa-receipt',
                    'report.due.register' => 'fas fa-exclamation-circle',
                    'admin.report.due.register' => 'fas fa-exclamation-circle',
                    'report.commission.register' => 'fas fa-percent',

                    // by menu / submenu name
                    'Dashboard' => 'fas fa-tachometer-alt',
                    'Transactions' => 'fas fa-exchange-alt',
                    'Admin' => 'fas fa-user-shield',
                    'Reports' => 'fas fa-chart-bar',
                    'Generate Renewal' => 'fas fa-bolt',
                    'Payment Collection' => 'fas fa-hand-holding-usd',
                    'Rectify Collection' => 'fas fa-edit',
                    'Bill Print' => 'fas fa-print',
                    'Counter Setup' => 'fas fa-store',
                    'Zone Setup' => 'fas fa-map-marker-alt',
                    'User Setup' => 'fas fa-user-cog',
                    'Package Details' => 'fas fa-box',
                    'Customer Surrender' => 'fas fa-user-slash',
                    'Customers' => 'fas fa-users',
                    'Customer Register' => 'fas fa-address-book',
                    'Customer Ledger' => 'fas fa-book',
                    'Renewal Register' => 'fas fa-sync-alt',
                    'Collection Register' => 'fas fa-receipt',
                    'Due Register' => 'fas fa-exclamation-circle',
                    'Commission Register Zone' => 'fas fa-percent',
                    'Commission Register Counter' => 'fas fa-percentage',
                    'Commission Register' => 'fas fa-percent',
                    'Comision Payout' => 'fas fa-money-check-alt',
                    'Commission Payout' => 'fas fa-money-check-alt',
                    'Counter Wise Collection' => 'fas fa-chart-pie',
                ];

                $resolveMenuIcon = function ($icon, $route = null, $name = null) use ($menuIconMap) {
                    $icon = trim((string) $icon);
                    $route = trim((string) $route);
                    $name = trim((string) $name);

                    if ($icon !== '' && isset($menuIconMap[$icon])) {
                        return $menuIconMap[$icon];
                    }
                    if ($route !== '' && isset($menuIconMap[$route])) {
                        return $menuIconMap[$route];
                    }
                    if ($name !== '' && isset($menuIconMap[$name])) {
                        return $menuIconMap[$name];
                    }
                    if ($icon !== '' && str_contains($icon, 'fa-')) {
                        return $icon;
                    }

                    return 'fas fa-circle';
                };
            @endphp
            <ul>
                @foreach ($sidebarMenus as $menuId => $items)
                    @php
                        $parent = $items->first(fn($i) => is_null($i->SubMenu_Id)) ?? $items->first();
                        $subItems = $items->filter(fn($i) => !is_null($i->SubMenu_Id));
                        $parentIcon = $resolveMenuIcon($parent->Icon ?? '', $parent->Route ?? '', $parent->MnuName ?? '');
                    @endphp

                    @if ($subItems->isEmpty())
                        <li class="{{ request()->routeIs($parent->Route) ? 'active' : '' }}">
                            <a href="{{ $parent->Route ? route($parent->Route) : 'javascript:void(0);' }}">
                                <i class="menu-fa {{ $parentIcon }}"></i>
                                <span>{{ $parent->MnuName }}</span>
                            </a>
                        </li>
                    @else
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="menu-fa {{ $parentIcon }}"></i>
                                <span>{{ $parent->MnuName }}</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                @foreach ($subItems as $sub)
                                    <li>
                                        <a href="{{ $sub->Route ? route($sub->Route) : 'javascript:void(0);' }}"
                                            class="{{ $sub->Route && request()->routeIs($sub->Route) ? 'active' : '' }}">
                                            {{ $sub->SubMnuName }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

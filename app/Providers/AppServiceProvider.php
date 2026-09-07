<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('Dashboard.Layouts.sidebar', function ($view) {
            $isAdmin  = session('is_admin');
            $userId   = session('user_id');

            if (session('is_login')) {
                if ((int)$isAdmin === 1) {
                    $menus = collect(DB::select("CALL usp_GetMenus()"))
                        ->filter(fn($m) => $m->OnlyAdm == 1);
                } else {
                    // returns raw mst_menus columns, alias to match sidebar expectations
                    $rows  = DB::select("CALL usp_getUserMenus(?)", [$userId]);
                    $menus = collect($rows)->map(function ($m) {
                        return (object)[
                            'Sl'          => $m->Menu_Sl,
                            'Menu_Id'     => $m->Menu_Id,
                            'MnuName'     => $m->Menu_Name ?? '',
                            'SubMenu_Id'  => $m->SubMenu_Id,
                            'SubMnuName'  => $m->SubMenu_Name ?? '',
                            'Icon'        => $m->Icon ?? '',
                            'Route'       => $m->Route ?? '',
                            'OnlyAdm'     => $m->Is_Admin,
                        ];
                    });
                }

                $grouped = $menus->groupBy('Menu_Id')->map(fn($items) => $items->sortBy('SubMenu_Id'));

                $view->with('sidebarMenus', $grouped);
            } else {
                $view->with('sidebarMenus', collect());
            }
        });

        View::composer('Dashboard.Layouts.topbar', function ($view) {
            $notifications = collect();

            if (session('is_login')) {
                try {
                    $isAdmin = (int) session('is_admin') === 1 ? 1 : 0;
                    $counterId = (int) (session('counter_id') ?: 0);
                    $notifications = collect(DB::select(
                        'CALL usp_getDashboardNotifications(?,?,?)',
                        [$isAdmin, $counterId, 8]
                    ));
                } catch (\Throwable $e) {
                    $notifications = collect();
                }
            }

            $view->with('dashNotifications', $notifications);
        });
    }
}
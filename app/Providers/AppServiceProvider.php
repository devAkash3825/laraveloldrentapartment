<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use App\Http\Models\City;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
        Paginator::useBootstrap();

        view()->composer('admin.layouts.navbar', function ($view) {
            if (auth()->guard('admin')->check()) {
                $authId = auth()->guard('admin')->user()->id;
                $notifications = \App\Models\Notification::where('to_id', $authId)
                    ->where('to_user_type', 'A')
                    ->orderBy('CreatedOn', 'desc')
                    ->take(20)
                    ->get();
                $unreadCount = \App\Models\Notification::where('to_id', $authId)
                    ->where('to_user_type', 'A')
                    ->where('seen', 0)
                    ->count();
                $view->with(compact('notifications', 'unreadCount'));
            }
        });
    }
}

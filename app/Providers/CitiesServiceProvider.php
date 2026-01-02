<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\City;
use App\Models\State;
use App\Models\Source;
use Illuminate\Support\Facades\Schema;


class CitiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // $city = City::all();
        // $state = State::all();
        // $source = Source::all();
        // View::share([
        //     'city' => $city,
        //     'state' => $state,
        //     'source'=> $source
        // ]);
        // if ($this->app->runningInConsole()) {

        //     return;
        // }

        // if (\Schema::hasTable('city') && \Schema::hasTable('state') && \Schema::hasTable('source')) {
        //     $city = City::all();
        //     $state = State::all();
        //     $source = Source::all();

        //     View::share([
        //         'city' => $city,
        //         'state' => $state,
        //         'source'=> $source,
        //     ]);
        // }
        $city = [];
        $state = [];
        $source = [];

        // Check if the cities table existsp
        if (Schema::hasTable('city')) {
            $city = City::all();
        }

        // Check if the states table exists
        if (Schema::hasTable('state')) {
            $state = State::all();
        }

        // Check if the sources table exists
        if (Schema::hasTable('sources')) {
            $source = Source::all();
        }

        // Share the data with all views
        View::share([
            'city' => $city,
            'state' => $state,
            'source' => $source,
        ]);
    }
}

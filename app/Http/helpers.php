<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('isActiveRoute')) {
    function isActiveRoute($route, $output = 'active')
    {
        if (Route::currentRouteName() == $route) {
            return $output;
        }

        return '';
    }
}

if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = 'active')
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) {
                return $output;
            }
        }

        return '';
    }
}


if (!function_exists('isActiveRoutes')) {
    function isActiveRoutes(array $routes, $output = 'active')
    {
        return in_array(Route::currentRouteName(), $routes) ? $output : '';
    }
}

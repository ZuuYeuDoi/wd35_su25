<?php

namespace App\Providers;

use App\Models\Room;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CountRoomProvider extends ServiceProvider
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
    public function boot()
    {
        View::composer('layouts.partials.sidebar', function ($view) {
            $view->with('countRooms', Room::where('status', 1)->count());
        });
    }
}

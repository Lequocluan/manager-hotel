<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\NewsCategory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Contact;

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
        Paginator::useBootstrap();
        View::share('allCategories', NewsCategory::where('status', 1)->get());

        View::composer('admin.*', function ($view) {
        $unreadContacts = Contact::where('replied', false)
            ->where('replied', false)
            ->latest()
            ->take(5)
            ->get();

        $newBookings = Booking::where('status', 'pending')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
        $unreadCount = $unreadContacts->count();
        
        $totalNewBookings = $newBookings->count();
         $view->with(compact('unreadContacts', 'unreadCount', 'newBookings', 'totalNewBookings'));
    });
    }

}

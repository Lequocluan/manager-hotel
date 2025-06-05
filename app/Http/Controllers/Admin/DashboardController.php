<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function dashboard(){
        $title = "Admin -Trang chủ";
        $totalRevenue = Booking::where('status', 'pending')->sum('total_price');
        $totalBookings = Booking::count();
        $totalRoomTypes = RoomType::count();
        $totalRooms = Room::count();
        $totalStaffs = Admin::where('name', '!=', 'superadmin')->count();
        $monthlyEarnings = Booking::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
        ->where('status', 'pending')
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(function ($item) {
            return [$item->month => (float) $item->total];
        })
        ->toArray();

        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = $monthlyEarnings[$i] ?? 0;
        }
        return view("admin.home.dashboard", compact('title', 'totalRevenue','totalBookings','totalRoomTypes','totalRooms','totalStaffs', 'monthlyData'));
    }
}


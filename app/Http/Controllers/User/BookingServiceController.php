<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BookingService;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BookingServiceController extends Controller
{
    public function index()
    {
        $title = 'Danh sách dịch vụ đặt lịch';
        return view('user.booking_service.list', compact('title'));
    }

    public function create()
    {
        $title = 'Đặt lịch dịch vụ';
        $services = Service::where('status', 1)->get();
        return view('user.booking_service.add', compact('title', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'service_id' => 'required|exists:services,id',
        ]);

        BookingService::create([
            'booking_id' => $request->booking_id,
            'service_id' => $request->service_id,
        ]);

        Session::flash('success', 'Đặt lịch dịch vụ thành công!');
        return redirect()->route('booking-service.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookedRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Danh sách đặt phòng';
        $bookings = Booking::with('rooms')->orderByDesc('id')->paginate(15);
        return view('admin.booked_rooms.index', compact('title', 'bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Chi tiết đặt phòng';
        $booking = Booking::with([
            'rooms',
            'services',
        ])->findOrFail($id);
        return view('admin.booked_rooms.detail', compact('title', 'booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking =Booking::find($id);
        if(!$booking){
            abort('404');
        }
        try{
            $booking->services->delete();
            $booking->rooms->delete();
            $booking->delete();
            return response()->json(['success' => true, 'message' => 'Xóa đơn đặt phòng thành công.']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi xóa đơn phòng: ' . $e->getMessage()
            ]);
        }
    }
}

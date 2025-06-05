<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmation;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class BookedRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('xem-don-dat-phong');
        $title = 'Danh sách đơn đặt phòng';
        $query = Booking::with('rooms')->orderByDesc('id');

        if ($request->filled('booking_id')) {
            $query->where('id', $request->booking_id);
        }
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('room_name')) {
            $query->whereHas('rooms', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->room_name . '%');
            });
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('check_in_date')) {
            $query->whereDate('check_in_date', $request->check_in_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(15)->appends($request->query());
        $isSearching = $request->anyFilled(['name','phone','booking_id','room_name','status']);
        return view('admin.booked_rooms.index', compact('title', 'bookings', 'isSearching'));
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
        $this->authorize('sua-don-dat-phong');
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
    public function edit($id)
    {
        $booking = Booking::with(['services', 'rooms.roomType'])->findOrFail($id);

        $services = Service::all();
        $availableRooms = Room::whereDoesntHave('bookings', function ($query) use ($booking) {
            $query->where('id', '!=', $booking->id)
                ->where(function ($q) use ($booking) {
                    $q->whereBetween('check_in_date', [$booking->check_in_date, $booking->check_out_date])
                        ->orWhereBetween('check_out_date', [$booking->check_in_date, $booking->check_out_date]);
                });
        })->get();

        return view('admin.bookings.edit', compact('booking', 'services', 'availableRooms'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('sua-don-dat-phong');

    $booking = Booking::findOrFail($id);

    $validated = $request->validate([
        'status' => 'required|in:pending,confirmed,cancelled,completed',
        'payment_status' => 'required|boolean',
    ]);

    $oldStatus = $booking->status;
    $booking->status = $validated['status'];
    $booking->payment_status = $validated['payment_status'];
    $booking->save();

    if ($oldStatus !== 'confirmed' && $booking->status === 'confirmed') {
        try {
            Mail::to($booking->email)->send(new BookingConfirmation($booking));            
        } catch (\Exception $e) {
            Log::error("Không gửi được email xác nhận: " . $e->getMessage());
        }
    }

    return redirect()->route('booked-rooms.index')->with('success', 'Cập nhật đơn đặt phòng thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $this->authorize('xoa-don-dat-phong');
        $booking =Booking::find($id);
        if(!$booking){
            abort('404');
        }
        try{
        $booking->rooms()->detach();
        $booking->services()->detach();
            $booking->delete();
            return response()->json(['success' => true, 'message' => 'Xóa đơn đặt phòng thành công.']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi xóa đơn phòng: ' . $e->getMessage()
            ]);
        }
    }
    public function exportPdf($id)
    {
        $booking = Booking::with(['rooms.roomType', 'services'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.booked_rooms.invoice_pdf', compact('booking'));

        return $pdf->download('hoa-don-' . $booking->id . '.pdf');
    }
    public function print($id)
    {
        $booking = Booking::with(['rooms.roomType', 'services'])->findOrFail($id);
        return view('admin.booked_rooms.invoice_print', compact('booking'));
    }
}

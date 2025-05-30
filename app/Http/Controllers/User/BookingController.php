<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmation;
use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\BookingService;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    public function index()
    {
        //
    }

    public function start()
    {
        return view('user.booking.start');
    }

    public function step1(Request $request)
    {
        $validated = $request->validate([
            'checkin' => 'required|date|after:yesterday',
            'checkout' => 'required|date|after:checkin',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
        ]);
        $adults = (int)$validated['adults'];
        $children = (int)$validated['children'];

        if ($children > 2 * $adults) {
            return back()
                ->withErrors(['adults' => 'Vui lòng đảm bảo mỗi phòng có ít nhất 1 người lớn và tối đa 2 trẻ em.'])
                ->withInput();
        }

        Session::put('booking.step1', $validated);
        return redirect()->route('booking.selectRoom');
    }

    public function selectRoom()
    {
        $step1 = Session::get('booking.step1');
        $checkin = $step1['checkin'] ?? null;
        $checkout = $step1['checkout'] ?? null;

        if (!$checkin || !$checkout) {
            return redirect()->route('booking.start')
                ->with('error', 'Vui lòng chọn ngày nhận và trả phòng trước.');
        }

        $roomTypes = $this->getAvailableRoomTypes($checkin, $checkout);

        return view('user.booking.room_select', compact('roomTypes'));
    }



    public function step2(Request $request)
    {
        $data = $request->input('room_types', []);
        $validatedRoomTypes = [];

        foreach ($data as $roomTypeId => $info) {
            if (!isset($info['selected'])) continue;

            $quantity = isset($info['quantity']) ? (int)$info['quantity'] : 1;
            if ($quantity < 1) continue;

            $validatedRoomTypes[] = [
                'room_type_id' => (int)$roomTypeId,
                'quantity' => $quantity,
            ];
        }

        if (empty($validatedRoomTypes)) {
            return back()->withErrors(['Bạn phải chọn ít nhất 1 loại phòng'])->withInput();
        }

        // Lấy dữ liệu từ bước 1
        $step1 = Session::get('booking.step1');
        $checkin = $step1['checkin'] ?? null;
        $checkout = $step1['checkout'] ?? null;

        $totalAdults = $step1['adults'] ?? 0;
        $totalChildren = $step1['children'] ?? 0;

        $totalRoomsSelected = 0;

        foreach ($validatedRoomTypes as $item) {
            $roomType = RoomType::find($item['room_type_id']);
            if (!$roomType) continue;

            $quantity = $item['quantity'];
            $totalRoomsSelected += $quantity;

            if (!$this->checkRoomTypeAvailability($roomType->id, $quantity, $checkin, $checkout)) {
                return back()->withErrors(['Không đủ phòng cho loại: ' . $roomType->name])->withInput();
            }
        }

        // Tính tổng sức chứa tối đa của tất cả các phòng đã chọn
        $totalAdultCapacity = 0;
        $totalChildCapacity = 0;

        foreach ($validatedRoomTypes as $item) {
            $roomType = RoomType::find($item['room_type_id']);
            if (!$roomType) continue;

            $totalAdultCapacity += $roomType->max_adults * $item['quantity'];
            $totalChildCapacity += $roomType->max_children * $item['quantity'];
        }

        if ($totalAdults > $totalAdultCapacity || $totalChildren > $totalChildCapacity) {
            $errorMessage = "Không đủ phòng cho ";

            if ($totalAdults > $totalAdultCapacity) {
                $errorMessage .= "{$totalAdults} người lớn (tối đa {$totalAdultCapacity}). ";
            }

            if ($totalChildren > $totalChildCapacity) {
                $errorMessage .= "{$totalChildren} trẻ em (tối đa {$totalChildCapacity}). ";
            }

            $suggestion = "Bạn có thể chọn thêm phòng loại ";
            $suggestionOptions = [];

            foreach ($validatedRoomTypes as $item) {
                $roomType = RoomType::find($item['room_type_id']);
                if (!$roomType) continue;
                $suggestionOptions[] = $roomType->name;
            }

            $suggestion .= implode(", ", $suggestionOptions) . " hoặc giảm số người.";

            return back()
                ->withErrors([$errorMessage])
                ->with('suggestion', $suggestion)
                ->withInput();
        }



        // Lưu thông tin và chuyển tiếp
        Session::put('booking.step2', $validatedRoomTypes);
        return redirect()->route('booking.selectServices');
    }
                           
    public function selectServices()
    {
        $step1 = Session::get('booking.step1');
        $step2 = Session::get('booking.step2');

        if (!$step1 || !$step2) {
            return redirect()->route('booking.start')
                ->with('error', 'Vui lòng hoàn tất bước chọn ngày và phòng trước.');
        }   
        $services = Service::get()->where('status', 1);
        return view('user.booking.service', compact('services'));
    }

    public function step3(Request $request)
    {
        $services = $request->input('services', []);

        if (!is_array($services)) {
            $services = [];
        }

        Session::put('booking.step3', ['services' => $services]);

        return redirect()->route('booking.checkout');
    }

    public function checkout()
    {
        $step1 = Session::get('booking.step1');
        $step2 = Session::get('booking.step2');
        $step3 = Session::get('booking.step3');
        $services = $step3['services'] ?? [];

        if (!$step1 || !$step2) {
            return redirect()->route('booking.start')->with('error', 'Thông tin đặt phòng không hợp lệ.');
        }

        $nights = Carbon::parse($step1['checkout'])->diffInDays($step1['checkin']);

        $roomDetails = [];
        $totalRoomCost = 0;
        foreach ($step2 as $item) {
            $roomType = RoomType::find($item['room_type_id']);
            if (!$roomType) continue;

            $cost = $roomType->price * $item['quantity'] * $nights;
            $totalRoomCost += $cost;

            $roomDetails[] = [
                'roomType' => $roomType,
                'quantity' => $item['quantity'],
                'cost' => $cost
            ];
        }

        $serviceModels = Service::whereIn('id', $services)->get();
        $serviceCost = $serviceModels->sum('price');
        $total = $totalRoomCost + $serviceCost;

        return view('user.booking.checkout', compact('step1', 'step2', 'services', 'roomDetails', 'serviceModels', 'nights', 'totalRoomCost', 'serviceCost', 'total'));
    }

    public function confirm(Request $request)
    {
        $step1 = Session::get('booking.step1');
        $step2 = Session::get('booking.step2');
        $step3 = Session::get('booking.step3');

        if (!$step1 || !$step2) {
            return redirect()->route('booking.start')->with('error', 'Dữ liệu đặt phòng không hợp lệ.');
        }

        $checkin = Carbon::parse($step1['checkin']);
        $checkout = Carbon::parse($step1['checkout']);
        $numberOfNights = $checkout->diffInDays($checkin);

        $roomTotal = 0;
        foreach ($step2 as $item) {
            $roomType = RoomType::find($item['room_type_id']);
            $quantity = $item['quantity'];
            $roomTotal += $roomType->price * $quantity * $numberOfNights;
        }

        $serviceTotal = 0;
        $selectedServices = [];
        if (!empty($step3['services'])) {
            $services = Service::whereIn('id', $step3['services'])->get();
            foreach ($services as $service) {
                $serviceTotal += $service->price;
                $selectedServices[] = $service;
            }
        }

        $totalPrice = $roomTotal + $serviceTotal;

        $booking = Booking::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'check_in_date' => $step1['checkin'],
            'check_out_date' => $step1['checkout'],
            'notes' => $request->input('notes', ''),
            'status' => 'pending',
            'total_price' => $totalPrice,
            'payment_method' => 'cod',
        ]);

        $bookedRoomIds = BookingRoom::whereHas('booking', function ($query) use ($checkin, $checkout) {
            $query->where('check_in_date', '<', $checkout)
                ->where('check_out_date', '>', $checkin);
        })->pluck('room_id')->toArray();

        foreach ($step2 as $item) {
            $roomType = RoomType::find($item['room_type_id']);
            $quantity = $item['quantity'];
            $price = $roomType->price;

            $availableRooms = Room::where('room_type_id', $roomType->id)
                ->whereNotIn('id', $bookedRoomIds)
                ->take($quantity)
                ->get();

            foreach ($availableRooms as $room) {
                BookingRoom::create([
                    'booking_id' => $booking->id,
                    'room_id' => $room->id,
                    'price_per_night' => $price,
                    'number_of_nights' => $numberOfNights,
                ]);
            }

            $bookedRoomIds = array_merge($bookedRoomIds, $availableRooms->pluck('id')->toArray());
        }

        foreach ($selectedServices as $service) {
            BookingService::create([
                'booking_id' => $booking->id,
                'service_id' => $service->id,
            ]);
        }

        $booking = Booking::with([
            'rooms',
            'services'
        ])->find($booking->id);
        Mail::to($booking->email)->queue(new BookingConfirmation($booking));

        Session::forget(['booking.step1', 'booking.step2', 'booking.step3', 'booking.checkout']);

        return redirect()->route('booking.success')->with([
            'success' => 'Đặt phòng thành công!',
            'booking_id' => $booking->id,
            'adults' => $step1['adults'],
            'children' => $step1['children'],
        ]);
    }

    public function success(){
        $booking = Booking::latest()
        ->with(['rooms', 'services'])
        ->first();

    return view('user.booking.success', compact('booking'));
    }

    private function getAvailableRoomTypes($checkin, $checkout)
    {
        if (!$checkin || !$checkout) {
            return redirect()->route('booking.start');
        }
        $bookedRoomIds = BookingRoom::whereHas('booking', function ($query) use ($checkin, $checkout) {
            $query->where('check_in_date', '<', $checkout)
                  ->where('check_out_date', '>', $checkin);
        })->pluck('room_id')->toArray();

        return RoomType::where('status', 1)
            ->whereHas('rooms', function ($q) use ($bookedRoomIds) {
                if (!empty($bookedRoomIds)) {
                    $q->whereNotIn('id', $bookedRoomIds);
                }
            })
            ->with(['rooms' => function ($q) use ($bookedRoomIds) {
                if (!empty($bookedRoomIds)) {
                    $q->whereNotIn('id', $bookedRoomIds);
                }
            }])
            ->get();
    }

    private function checkRoomTypeAvailability($roomTypeId, $quantity, $checkin, $checkout)
    {
        $bookedRoomIds = BookingRoom::whereHas('booking', function ($query) use ($checkin, $checkout) {
            $query->where('check_in_date', '<', $checkout)
                ->where('check_out_date', '>', $checkin);
        })->pluck('room_id')->toArray();

        $availableRooms = Room::where('room_type_id', $roomTypeId)
            ->whereNotIn('id', $bookedRoomIds)
            ->count();

        return $availableRooms >= $quantity;
    }
}
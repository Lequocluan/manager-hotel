<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoomRequest;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Danh sách phòng';
        $rooms =Room::orderByDesc('id')->with('roomType')->paginate(15);
        return view('admin.rooms.list', compact('title', 'rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm phòng';
        $roomTypes = \App\Models\RoomType::all();
        return view('admin.rooms.add', compact('title', 'roomTypes'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomRequest $request)
    {
        Room::create([
            'name' => $request->name,
            'room_type_id' => $request->room_type_id,
            'description' => $request->description,
            'status' => $request->status,
        ]);
    
        return redirect()->route('rooms.index')->with('success', 'Thêm phòng thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $title = 'Chỉnh sửa phòng';
        $roomTypes = \App\Models\RoomType::all();
        return view('admin.rooms.edit', compact('title', 'room', 'roomTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomRequest $request, Room $room)
    {
        $room->update([
            'name' => $request->name,
            'room_type_id' => $request->room_type_id,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Cập nhật phòng thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        try {
            $room->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa phòng thành công.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi xóa phòng: ' . $e->getMessage()
            ]);
        }
    }

}

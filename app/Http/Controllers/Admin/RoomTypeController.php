<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoomTypeRequest;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Danh sách loại phòng';
        $roomTypes = RoomType::orderByDesc('id')->paginate(15);
        return view('admin.room_types.list', compact('title', 'roomTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm loại phòng';
        return view('admin.room_types.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomTypeRequest $request)
{
    $request->validate([
        'name' => 'required|unique:room_types,name',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'price' => 'required|numeric|min:0',
        'status' => 'required|boolean',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName(); 
        $destination = public_path('room_types'); 
        
        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }

        $file->move($destination, $filename); 
        $imagePath = 'room_types/' . $filename; 
    }

    RoomType::create([
        'name' => $request->name,
        'description' => $request->description,
        'image' => $imagePath,
        'price' => $request->price,
        'status' => $request->status,
    ]);

    return redirect()->route('room-types.index')->with('success', 'Loại phòng đã được thêm.');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //$this -> authorize('chinh-sua-loai-phong');
        $title = 'Chỉnh sửa loại phòng';
        $roomType = RoomType::find($id);
        if (!$roomType) {
            abort('404');
        }
        return view('admin.room_types.edit', compact('title', 'roomType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomTypeRequest $request, string $id)
    {
        //$this -> authorize('chinh-sua-loai-phong');
        try{
            $roomType = RoomType::find($id);
            if (!$roomType) {
                abort('404');
            }
            $request->validate([
                'name' => 'required|unique:room_types,name,' . $id,
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'price' => 'required|numeric|min:0',
                'status' => 'required|boolean',
            ]);

            if ($request->file('image')) {
                $file = $request->file('image');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = time() . '_' . Str::slug($originalName) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('room_types'), $filename);

                if ($roomType->image && file_exists(public_path($roomType->image))) {
                    unlink(public_path($roomType->image));
                }
                $roomType->image = 'room_types/' . $filename;
                $roomType->save();
            }

            $roomType->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'status' => $request->status,
            ]);

            return redirect()->route('room-types.index')->with('success', 'Loại phòng đã được cập nhật.');
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể cập nhật loại phòng này vì đã có phòng thuộc loại phòng này.'
                : 'Có lỗi khi cập nhật loại phòng này.' . $e->getMessage();
            return redirect()->back()->with('error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roomType = RoomType::find($id);
        if (!$roomType) {
            abort('404');
        }
        try {
            $roomType->delete();
            return response()->json(['success' => true, 'message' => 'Xóa loại phòng thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa loại phòng này vì đã có phòng thuộc loại phòng này.'
                : 'Có lỗi khi xóa loại phòng này.' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }
}

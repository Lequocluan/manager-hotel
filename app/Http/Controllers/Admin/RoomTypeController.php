<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoomTypeRequest;
use App\Models\RoomType;
use App\Models\RoomTypeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-loai-phong');
        $title = 'Danh sách loại phòng';
        $roomTypes = RoomType::orderByDesc('id')->paginate(15);
        return view('admin.room_types.list', compact('title', 'roomTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-loai-phong');
        $title = 'Thêm loại phòng';
        $roomType = new RoomType();
        return view('admin.room_types.add', compact('title', 'roomType'));
    }

    public function uploadTemp(Request $request)
    {
        if ($request->hasFile('filepond')) { 
            $file = $request->file('filepond');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'room_types/temp/';
            $file->move(public_path($path), $filename);

            return response()->json($path . $filename);
        }

        return response()->json(['error' => 'Không có file'], 400);
    }
    public function revertTemp(Request $request)
    {
        $filename = trim($request->getContent(), '"');
        if ($filename) {
            $fullPath = public_path($filename);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        return response()->noContent();
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomTypeRequest $request)
    {
        $this->authorize('them-loai-phong');
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
        if (!$request->input('uploaded_images')) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['uploaded_images' => 'Bạn phải tải lên ít nhất một ảnh chi tiết.']);
        }
        $roomType = RoomType::create([
            'name' => $request->name,
            'slug' => Helper::createSlug($request->name),
            'overview' => $request->overview,
            'description' => $request->description,
            'image' => $imagePath,
            'price' => $request->price,
            'bed_type' => $request->bed_type,
            'size' => $request->size,
            'status' => $request->status,
        ]);

        if ($request->input('uploaded_images')) {
            $uploadedImages = json_decode($request->input('uploaded_images'), true);
            if (is_array($uploadedImages)) {
                foreach ($uploadedImages as $path) {
                    $path = trim($path, '"');

                    $destinationDir = public_path('room_types/images');
                    if (!file_exists($destinationDir)) {
                        mkdir($destinationDir, 0777, true);
                    }

                    $filename = basename($path);
                    $tempPath = public_path($path);
                    $newPath = $destinationDir . '/' . $filename;
                    $newRelativePath = 'room_types/images/' . $filename;

                    if (file_exists($tempPath)) {
                        rename($tempPath, $newPath);
                    }

                    RoomTypeImage::create([
                        'room_type_id' => $roomType->id,
                        'image_path' => $newRelativePath
                    ]);
                }
            }
        }


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
        $this->authorize('sua-loai-phong');
        $title = 'Chỉnh sửa loại phòng';
        $roomType = RoomType::find($id);
        if (!$roomType) {
            abort('404');
        }
        return view('admin.room_types.edit', compact('title', 'roomType'));
    }

    public function removeExistingImage(Request $request)
    {
        $path = $request->input('path');
        $fullPath = public_path($path);

        if ($fullPath && file_exists($fullPath)) {
            unlink($fullPath);
        }

        RoomTypeImage::where('image_path', $path)->delete();

        return response()->json(['message' => 'Đã xóa ảnh']);
    }

    
    public function update(RoomTypeRequest $request, string $id)
    {
        $this->authorize('them-loai-phong');
        $roomType = RoomType::find($id);
        if (!$roomType) {
            abort(404);
        }

        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = time() . '_' . Str::slug($originalName) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('room_types'), $filename);

                if ($roomType->image && file_exists(public_path($roomType->image))) {
                    unlink(public_path($roomType->image));
                }

                $roomType->image = 'room_types/' . $filename;
            }

            $roomType->update([
                'name' => $request->name,
                'slug' => Helper::createSlug($request->name),
                'overview' => $request->overview,
                'description' => $request->description,
                'price' => $request->price,
                'bed_type' => $request->bed_type,
                'size' => $request->size,
                'status' => $request->status,
                'image' => $roomType->image ?? $roomType->getOriginal('image'),
            ]);

            $keptImages = json_decode($request->input('uploaded_images', '[]'), true);
            $oldImages = RoomTypeImage::where('room_type_id', $roomType->id)->get();
            foreach ($oldImages as $oldImage) {
                if (!in_array($oldImage->image_path, $keptImages)) {
                    if (file_exists(public_path($oldImage->image_path))) {
                        unlink(public_path($oldImage->image_path));
                    }
                    $oldImage->delete();
                }
            }

            foreach ($keptImages as $tempPathRaw) {
                $tempPath = trim($tempPathRaw, "\"");

                if (RoomTypeImage::where('room_type_id', $roomType->id)->where('image_path', $tempPath)->exists()) {
                    continue;
                }

                $tempFullPath = public_path($tempPath);
                if (file_exists($tempFullPath)) {
                    $filename = basename($tempPath);
                    $newPath = 'room_types/images/' . $filename;

                    rename($tempFullPath, public_path($newPath));

                    RoomTypeImage::create([
                        'room_type_id' => $roomType->id,
                        'image_path' => $newPath,
                    ]);
                }
            }


            DB::commit();
            return redirect()->route('room-types.index')->with('success', 'Loại phòng đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Lỗi cập nhật: ' . $e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-loai-phong');
        $roomType = RoomType::find($id);
        if (!$roomType) {
            abort('404');
        }
        try {
            if ($roomType->image && file_exists(public_path($roomType->image))) {
                unlink(public_path($roomType->image));
            }

            foreach ($roomType->images as $image) {
                if ($image->image_path && file_exists(public_path($image->image_path))) {
                    unlink(public_path($image->image_path));
                }
                $image->delete();
            }

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

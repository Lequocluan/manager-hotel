<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-dich-vu');
        $title = "Danh sách dịch vụ";
        $services = Service::orderByDesc('id')->paginate(15);
        return view('admin.services.list', compact('title', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-dich-vu');
        $title = "Thêm dịch vụ";
        return view('admin.services.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        $this->authorize('them-dich-vu');
        Service::create([
            'name' => $request->name,
            'unit' => $request->unit,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('services.index')->with('success', 'Thêm dịch vụ thành công!');
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
        $this->authorize('sua-dich-vu');
        $title = "Chỉnh sửa dịch vụ";
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('title', 'service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('sua-dich-vu');
        $service = Service::findOrFail($id);
        $service->update([
            'name' => $request->name,
            'unit' => $request->unit,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('services.index')->with('success', 'Cập nhật dịch vụ thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-dich-vu');
        $service = Service::findOrFail($id);
        try {
            $service->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa dịch vụ thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa dịch vụ:' . $e->getMessage()
            ]);
        }
    }
}

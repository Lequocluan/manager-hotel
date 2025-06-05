<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('xem-quyen');
        $query = Permission::query();

    if ($search = $request->input('search')) {
        $query->where('name', 'like', "%$search%");
    }
        $title = 'Danh sách quyền truy cập';
        /** @var \Illuminate\Pagination\LengthAwarePaginator $permissions */
        $permissions = $query->paginate(10);
        $permissions->withQueryString();
        return view('admin.permission.list', compact('title','permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-quyen');
        $title = 'Thêm mới quyền truy cập';
        return view('admin.permission.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('them-quyen');
        try {
            Permission::create([
                'name_permission' => $request->name_permission,
                'name' => Helper::createSlug($request->name_permission)
            ]);
            Session::flash('success', 'Thêm quyền thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi thêm quyền ' . $e->getMessage());
        }
        return redirect()->route('permissions.index');
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
        $this->authorize('sua-quyen');
        $permission = Permission::find($id);
        if (!$permission) abort(404);
        $title = 'Chỉnh sửa quyền ';
        return view('admin.permission.edit', compact('title', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('sua-quyen');
        try {
            $permission = Permission::find($id);
            if (!$permission) abort(404);
            $permission->update([
                'name_permission' => $request->name_permission,
                'name' => Helper::createSlug($request->name_permission)
            ]);
            Session::flash('success', 'Cập nhật quyền thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi chỉnh sửa quyền ' . $e->getMessage());
        }
        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-quyen');
        $permission = Permission::find($id);
        if (!$permission) abort(404);
        try {
            $permission->delete();
            return response()->json(['success' => true, 'message' => 'Xóa quyền thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa quyền vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa quyền: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }
}

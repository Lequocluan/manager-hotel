<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Jobs\MailAccountJob;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-nhan-vien');
        $title = 'Danh sách nhân viên';
        $managers = Admin::with('role')->orderByDesc('id')->paginate(15);
        return view('admin.manager.list', compact('title', 'managers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-nhan-vien');
        $title = 'Thêm mới nhân viên';
        $roles = Role::all();
        return view('admin.manager.create', compact('title', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        $this->authorize('them-nhan-vien');
        try {
            $rand = rand(100000, 999999);
            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($rand),
                'role_id' => $request->role_id,
            ]);
            Session::flash('success', 'Tạo nhân viên thành công');
            MailAccountJob::dispatch($admin, $rand)->delay(now()->addSecond(5));
            return redirect()->route('manager.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi tạo: ' . $e->getMessage());
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('sua-nhan-vien');
        $manager = Admin::findOrFail($id);
        $title = 'Chỉnh sửa người quản lý';
        $roles = Role::all();
        return view('admin.manager.edit', compact('title', 'manager', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, string $id)
    {
        $this->authorize('sua-nhan-vien');
        $manager = Admin::findOrFail($id);

        try {
            $manager->fill([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
                'role_id' => $request->role_id,
            ]);

            if ($request->password) {
                $manager->password = Hash::make($request->password);
            }

            $manager->save();

            $role = Role::findById($request->role_id);
            $manager->syncRoles([$role->name]); 

            Session::flash('success', 'Cập nhật nhân viên thành công');
            return redirect()->route('manager.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi chỉnh sửa: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-nhan-vien');
        $manager = Admin::find($id);
        if (!$manager) {
            abort(404);
        }
        if ($manager->hasRole('superadmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền xóa tài khoản Superadmin.'
            ]);
        }
        try {
            $manager->delete();
            return response()->json(['success' => true, 'message' => 'Xóa nhân viên thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa nhân viên vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa nhân viên: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }
}

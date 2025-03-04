<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Jobs\MailAccountJob;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $title = 'Danh sách nhân viên';
        $managers = Admin::orderByDesc('id')->paginate(15);
        return view('admin.manager.list', compact('title', 'managers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm mới nhân viên';
        return view('admin.manager.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        try {
            $rand = rand(100000, 999999);
            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($rand)
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
        
        $manager = Admin::findOrFail($id);
        $title = 'Chỉnh sửa người quản lý';
        return view('admin.manager.edit', compact('title', 'manager'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, string $id)
    {
        $manager = Admin::findOrFail($id);
        try {
            $manager->fill([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender
            ]);
            if ($request->password) {
                $manager->password = Hash::make($request->password);
            }
            $manager->save();
            Session::flash('success', 'Cập nhật nhân viên thành công');
            return redirect()->route('manager.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi chỉnh sửa: ' . $e->getMessage());
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $manager = Admin::find($id);
        if (!$manager) {
            abort('404');
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

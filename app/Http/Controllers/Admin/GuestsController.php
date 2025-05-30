<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GuestsRequest;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class GuestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Danh sách khách hàng';
        $guests = User::orderByDesc('id')->paginate(15);
        return view('admin.guests.list', compact('title', 'guests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm khách hàng';
        return view('admin.guests.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(GuestsRequest $request)
    {
        
        try {
            $rand = rand(100000, 999999);

            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/guests'), $filename);
                $avatarPath = '/uploads/guests/' . $filename;
            } else {
                $avatarPath = null;
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($rand),
                'avatar' => $avatarPath,
                'phone' => $request->phone,
                'identity_number' => $request->identity_number,
                'address' => $request->address,
                'token_reset_password' => Str::random(60),
                'token_duration' => now()->addMinutes(30)
            ]);
            Session::flash('success', 'Tạo khách hàng thành công');
            return redirect()->route('guests.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Chỉnh sửa khách hàng';
        $guest = User::findOrFail($id);
        return view('admin.guests.edit', compact('title', 'guest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuestsRequest $request, string $id)
    {

        try {
            $user = User::findOrFail($id);
            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    $avatarPath = public_path($user->avatar);
                    if (file_exists($avatarPath)) {
                        unlink($avatarPath);
                    }
                }
                $file = $request->file('avatar');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/guests'), $filename);
                $user->avatar = '/uploads/guests/' . $filename;
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->identity_number = $request->identity_number;
            $user->address = $request->address;
            $user->save();
            Session::flash('success', 'Cập nhật khách hàng thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi cập nhật: ' . $e->getMessage());
        }
        return redirect()->route('guests.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->avatar) {
                $avatarPath = public_path($user->avatar);
                if (file_exists($avatarPath)) {
                    unlink($avatarPath);
                }
            }
            $user->delete();
            Session::flash('success', 'Xóa khách hàng thành công');
            return response()->json([
                'success' => 'message',
                'message' => 'Xóa khách hàng thành công'
            ]);
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi xóa: ' . $e->getMessage());
            return response()->json([
                'success' => 'message',
                'message' => 'Có lỗi khi xóa: ' . $e->getMessage()
            ]);
        }
        return redirect()->route('guests.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
    use Spatie\Permission\Models\Role;
    use Spatie\Permission\Models\Permission;
/**
 * @method bool hasRole(string $role)
 */
    class RoleController extends Controller
    {
        public function index(Request $request)
        {
            $this->authorize('xem-vai-tro');
            $title = 'Danh sách các vai trò';
            $query = Role::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%$search%");
        }
            
        /** @var \Illuminate\Pagination\LengthAwarePaginator $roles */
            $roles = $query->paginate(10);
            $roles->withQueryString();
            return view('admin.role.list', compact('title', 'roles'));
        }
    public function create(Role $role)
    {
        $this->authorize('them-vai-tro');
        /** @var \App\Models\Admin $admin */
        $admin = auth('admin')->user();
        if (!$admin->hasRole('superadmin')) {
            abort(403);
        }
        $permissions = Permission::all()->filter(function ($permission) {
            return !str_contains($permission->name, 'quyen') &&
                !str_contains($permission->name, 'vai-tro');
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $groupedPermissions = [];
        foreach ($permissions as $permission) {
            $parts = explode('-', $permission->name);
            $groupKey = implode('-', array_slice($parts, 1)); 
            $groupedPermissions[$groupKey][] = $permission;
        }
        return view('admin.role.add', compact('groupedPermissions'));
    }
    public function store(Request $request)
    {
        $this->authorize('them-vai-tro');
        $request->validate(['name' => 'required|unique:roles']);
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return redirect()->route('roles.index')->with('success', 'Tạo role thành công.');
    }

    public function edit(Role $role)
    {
        $this->authorize('sua-vai-tro');

        /** @var \App\Models\Admin $admin */
        $admin = auth('admin')->user();
        if (!$admin->hasRole('superadmin')) {
            abort(403);
        }

        $permissions = Permission::all()->filter(function ($permission) {
            return !str_contains($permission->name, 'quyen') &&
                !str_contains($permission->name, 'vai-tro');
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $groupedPermissions = [];
        foreach ($permissions as $permission) {
            $parts = explode('-', $permission->name);
            $groupKey = implode('-', array_slice($parts, 1)); 
            $groupedPermissions[$groupKey][] = $permission;
        }

        return view('admin.role.edit', compact('role', 'groupedPermissions', 'rolePermissions'));
    }                                       

    public function update(Request $request, Role $role)
    {
    $this->authorize('sua-vai-tro');
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return redirect()->route('roles.index')->with('success', 'Cập nhật role thành công.');
    }

    public function destroy(Role $role)
    {
    $this->authorize('xoa-vai-tro');
        $role->delete();
        try {
            $role->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa role thành công.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi khi xóa role: ' . $e->getMessage()
            ]);
        }
    }
}

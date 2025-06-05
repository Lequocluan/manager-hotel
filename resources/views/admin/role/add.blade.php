@extends('admin.layout_admin.main')

@section('content')
<div class="container">
    <h2 class="mb-4">Tạo vai trò mới</h2>
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên vai trò</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Chọn quyền</label>

            @role('superadmin') 
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="selectAllPermissions">
                    <label class="form-check-label fw-bold" for="selectAllPermissions">Chọn tất cả quyền</label>
                </div>
            @endrole

            <div class="row">
                @foreach($groupedPermissions as $group => $permissions)
                    <div class="col-12 mb-2">
                        <strong class="text-uppercase">{{ str_replace('-', ' ', $group) }}</strong>
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input permission-checkbox"
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->name }}"
                                            id="permission{{ $permission->id }}"
                                            data-name="{{ $permission->name }}"
                                            @if(isset($rolePermissions) && in_array($permission->name, $rolePermissions)) checked @endif
                                        >
                                        <label class="form-check-label" for="permission{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-success">Lưu</button>
        </div>
    </form>
</div>
@endsection


@section('js')
    <script>
    document.getElementById('selectAllPermissions')?.addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        checkboxes.forEach(cb => {
            const name = cb.getAttribute('data-name');
            if (!name.startsWith('role.') && !name.startsWith('permission.')) {
                cb.checked = this.checked;
            }
        });
    });
</script>
@endsection
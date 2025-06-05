@extends('admin.layout_admin.main')

@section('content')
<div class="container-fluid px-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý Vai trò (Roles)</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Vai trò</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4 shadow-sm">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary text-white">
                <h6 class="m-0 font-weight-bold">
                    <a href="{{ route('roles.create') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Thêm vai trò
                    </a>
                </h6>
                <form method="GET" class="m-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm vai trò..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i> Tìm
                        </button>
                    </div>
                </form>
            </div>

            @if ($roles->count() > 0)
            <div class="table-responsive p-3">
                <table class="table table-hover align-middle text-center" id="dataTableRoles">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Tên vai trò</th>
                            <th>Quyền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ $roles->firstItem() + $key }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @if($role->permissions->count())
                                    <span class="badge bg-info text-dark" data-bs-toggle="tooltip" 
                                          title="{{ $role->permissions->pluck('name')->join(', ') }}">
                                        {{ Str::limit($role->permissions->pluck('name')->join(', '), 30) }}
                                    </span>
                                @else
                                    <span class="text-muted fst-italic">Chưa gán</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm" 
                                       data-bs-toggle="tooltip" title="Sửa vai trò">
                                        <i class="bi bi-pencil-square"></i> Sửa
                                    </a>

                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                                data-bs-toggle="tooltip" title="Xóa vai trò">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                @if (request('search'))
                    <p class="alert alert-warning text-center">Không tìm thấy vai trò nào khớp với từ khóa "{{ request('search') }}".</p>
                @else
                    <p class="alert alert-danger text-center">Chưa có vai trò nào trong hệ thống.</p>
                @endif
            @endif
        </div>

        <div class="d-flex justify-content-center">
            {{ $roles->links() }}
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('admin_asset/js/custom/delete.js') }}"></script>
@endsection

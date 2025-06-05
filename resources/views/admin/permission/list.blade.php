@extends('admin.layout_admin.main')

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách quyền</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Quyền</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <a href="{{ route('permissions.create') }}" class="btn btn-secondary">
                        <i class="fas fa-plus me-1"></i> Thêm quyền
                    </a>
                </h6>
                <form method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm quyền..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if ($permissions->count() > 0)
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>STT</th>
                            <th>Tên quyền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $key => $permission)
                        <tr>
                            <td>{{ $permissions-> firstItem() + $key }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-outline-primary btn-xs me-2" title="Chỉnh sửa quyền">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-xs delete-btn" title="Xóa quyền">
                                            <i class="fas fa-trash"></i>
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
                    <p class="alert alert-warning text-center">Không tìm thấy quyền nào khớp với từ khóa "{{ request('search') }}".</p>
                @else
                    <p class="alert alert-danger text-center">Chưa có quyền nào trong hệ thống.</p>
                @endif
            @endif

            <div class="d-flex justify-content-center mt-3">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('admin_asset/js/custom/delete.js') }}"></script>
@endsection

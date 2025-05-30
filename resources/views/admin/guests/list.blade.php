@extends('admin.layout_admin.main')

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách khách hàng</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Khách hàng</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <a href="{{ route('guests.create') }}" class="btn btn-secondary">
                        <i class="fas fa-plus me-1"></i> Thêm khách hàng
                    </a>
                </h6>
            </div>

            @if ($guests->count() > 0)
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th>STT</th>
                            <th>Họ tên</th>
                            <th>Ảnh đại diện</th>
                            <th>SĐT</th>
                            <th>Địa chỉ</th>
                            <th>Trạng thái</th>
                            <th>Xử lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guests as $key => $guest)
                        <tr>
                            <td>{{ $guests->firstItem() + $key }}</td>
                            <td>{{ $guest->name }}</td>
                            <td>
                                @if($guest->avatar)
                                    <img src="{{ $guest->avatar }}" alt="Avatar" width="50" class="img-thumbnail">
                                @else
                                    <span class="text-muted">Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ $guest->phone ?? '—' }}</td>
                            <td>{{ $guest->address ?? '—' }}</td>
                            <td>
                                @if ($guest->email_verified_at)
                                    <span class="badge bg-success">Đã xác minh</span>
                                @else
                                    <span class="badge bg-secondary text-white">Chưa xác minh</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('guests.edit', $guest->id) }}" class="btn btn-outline-primary btn-xs me-2" title="Edit">
                                        <i class="fas fa-edit" data-bs-toggle="tooltip" title="Chỉnh sửa"></i>
                                    </a>

                                    <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-xs delete-btn" title="Delete">
                                            <i class="fas fa-trash" data-bs-toggle="tooltip" title="Xóa"></i>
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
                <p class="alert alert-danger text-center">Chưa có khách hàng nào!</p>
            @endif
        </div>

        <div class="d-flex justify-content-center">
            {{ $guests->links() }}
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin_asset/js/custom/delete.js') }}"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@endsection

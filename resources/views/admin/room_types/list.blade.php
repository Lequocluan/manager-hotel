@extends('admin.layout_admin.main')

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách loại phòng</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Loại phòng</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <a href="{{ route('room-types.create') }}" class="btn btn-secondary">
                        <i class="fas fa-plus me-1"></i> Thêm loại phòng
                    </a>
                </h6>
            </div>

            @if ($roomTypes->count() > 0)
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th>Tên loại phòng</th>
                            <th>Giá (VNĐ)</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>
                            <th>Xử lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roomTypes as $key => $roomType)
                        <tr>
                            <td>{{ $roomTypes->firstItem() + $key }}</td>
                            <td>
                                @if ($roomType->image)
                                    <img src="/{{ $roomType->image }}" alt="Chưa cập nhật" height="30" width="30"/>
                                @else
                                    <img src="/room_types/default-room-type.png" alt="Chưa cập nhật" height="30" width="30" />
                                @endif
                            </td>
                            <td>{{ $roomType->name }}</td>
                            <td>{{ number_format($roomType->price) }}</td>
                            <td>{{ Str::limit($roomType->overview, 50) }}</td>
                            <td>
                                @if ($roomType->status == 1)
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-danger">Tạm ngưng</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('room-types.edit', $roomType->id) }}" class="btn btn-outline-primary btn-xs me-2" title="Edit">
                                        <i class="fas fa-edit" data-bs-toggle="tooltip" title="Chỉnh sửa loại phòng"></i>
                                    </a>

                                    <form action="{{ route('room-types.destroy', $roomType->id) }}" method="POST" class="delete-form">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-outline-danger btn-xs delete-btn" title="Delete">
                                            <i class="fas fa-trash" data-bs-toggle="tooltip" title="Xóa loại phòng"></i>
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
            <p class="alert alert-danger">Chưa có loại phòng nào!</p>
            @endif
        </div>

        <div class="d-flex justify-content-center">
            {{ $roomTypes->links() }}
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin_asset/js/custom/delete.js') }}"></script>
@endsection

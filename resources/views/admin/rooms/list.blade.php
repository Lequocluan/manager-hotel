@extends('admin.layout_admin.main')

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách phòng</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Phòng</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <a href="{{ route('rooms.create') }}" class="btn btn-secondary">
                        <i class="fas fa-plus me-1"></i> Thêm phòng
                    </a>
                </h6>
            </div>

            @if ($rooms->count() > 0)
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th>STT</th>
                            <th>Số phòng</th>
                            <th>Loại phòng</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>
                            <th>Xử lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $key => $room)
                        <tr>
                            <td>{{ $rooms->firstItem() + $key }}</td>
                            <td>{{ $room->name }}</td>
                            <td>{{ $room->roomType->name ?? 'Không xác định' }}</td>
                            <td>{{ Str::limit($room->description, 50) }}</td>
                            <td>
                                @if ($room->status == 0)
                                    <span class="badge bg-success">Trống</span>
                                @elseif ($room->status == 1)
                                    <span class="badge bg-warning text-dark">Đã đặt</span>
                                @elseif ($room->status == 2)
                                    <span class="badge bg-info text-dark">Đang dọn</span>
                                @else
                                    <span class="badge bg-secondary">Không rõ</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-outline-primary btn-xs me-2" title="Edit">
                                        <i class="fas fa-edit" data-bs-toggle="tooltip" title="Chỉnh sửa phòng"></i>
                                    </a>

                                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-xs delete-btn" title="Delete">
                                            <i class="fas fa-trash" data-bs-toggle="tooltip" title="Xóa phòng"></i>
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
                <p class="alert alert-danger text-center">Chưa có phòng nào!</p>
            @endif
        </div>

        <div class="d-flex justify-content-center">
            {{ $rooms->links() }}
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin_asset/js/custom/delete.js') }}"></script>
@endsection

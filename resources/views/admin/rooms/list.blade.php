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
            <form method="GET" action="{{ route('rooms.index') }}" class="row g-3 px-3 pt-3">
                <div class="col-md">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <a href="{{ route('rooms.create') }}" class="btn btn-secondary">
                            <i class="fas fa-plus me-1"></i> Thêm
                        </a>
                    </h6>
                </div>
                <div class="col-md">
                    <input type="text" name="name" class="form-control" placeholder="Tìm theo số phòng..." value="{{ request('name') }}">
                </div>

                <div class="col-md">
                    <select name="room_type_id" class="form-control tag-select">
                        <option value="">-- Tất cả loại phòng --</option>
                        @foreach ($roomTypes as $type)
                            <option value="{{ $type->id }}" {{ request('room_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md d-flex flex-wrap gap-2 justify-content-start">
                    <button type="submit" class="btn btn-primary flex-fill">Lọc</button>
                    <a href="{{ route('rooms.index') }}" class="btn btn-secondary flex-fill">Reset</a>
                </div>
            </form>
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
                            <td>{{ Str::limit($room->description, 50) ?? "Chưa có mô tả"}}</td>
                            <td>
                                @if ($room->status == 1)
                                    <span class="badge bg-secondary text-white">Ẩn</span>
                                @elseif ($room->status == 0)
                                    <span class="badge bg-success">Hiển thị</span>
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
                <p class="alert alert-danger text-center">Không có phòng nào!</p>
            @endif
        </div>

        <div class="d-flex justify-content-center">
            {{ $rooms->links() }}
        </div>
    </div>
</div>


@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin_asset/css/custom/custom.css') }}">
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin_asset/js/custom/delete.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.tag-select').select2({
            placeholder: "-- Chọn danh mục --",
            allowClear: true
        });
    });
</script>
@endsection
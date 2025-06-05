@extends('admin.layout_admin.main')

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách bài viết</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bài viết</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <form method="GET" action="{{ route('news.index') }}" class="row g-3 px-3 pt-3">
                <div class="col-md">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <a href="{{ route('news.create') }}" class="btn btn-secondary">
                            <i class="fas fa-plus me-1"></i> Thêm
                        </a>
                    </h6>
                </div>
                <div class="col-md">
                    <input type="text" name="title" class="form-control" placeholder="Tìm theo tiêu đề bài viết..." value="{{ request('title') }}">
                </div>

                <div class="col-md">
                    <select name="category_id" class="form-control tag-select">
                        <option value="">-- Tất cả danh mục --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                    <div class="col-md d-flex flex-wrap gap-2 justify-content-start">
                        <button type="submit" class="btn btn-primary flex-fill">Lọc</button>
                        <a href="{{ route('news.index') }}" class="btn btn-secondary flex-fill">Reset</a>
                    </div>
            </form>

            @if ($news->count() > 0)
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th>STT</th>
                            <th>Tiêu đề</th>
                            <th>Ảnh</th>
                            <th>Danh mục</th>
                            <th>Trạng thái</th>
                            <th>Xử lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $key => $item)
                        <tr>
                            <td>{{ $news->firstItem() + $key }}</td>
                            <td>{{ Str::limit($item->title, 50) }}</td>
                            <td>
                                @if($item->image)
                                    <img src="{{  $item->image }}" alt="Ảnh" width="60" class="img-thumbnail">
                                @else
                                    <span class="text-muted">Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ $item->newsCategories->name ?? 'Không xác định' }}</td>
                            <td>
                                @if ($item->status == 1)
                                    <span class="badge bg-success">Hiển thị</span>
                                @else
                                    <span class="badge bg-secondary text-white">Ẩn</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('news.edit', $item->id) }}" class="btn btn-outline-primary btn-xs me-2" title="Edit">
                                        <i class="fas fa-edit" data-bs-toggle="tooltip" title="Chỉnh sửa bài viết"></i>
                                    </a>

                                    <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-xs delete-btn" title="Delete">
                                            <i class="fas fa-trash" data-bs-toggle="tooltip" title="Xóa bài viết"></i>
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
                <p class="alert alert-danger text-center">Không có bài viết nào!</p>
            @endif
        </div>

        <div class="d-flex justify-content-center">
            {{ $news->links() }}
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

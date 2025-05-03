@extends('admin.layout_admin.main')

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
      </div>

    <!-- DataTable with Hover -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><a href="{{ route('manager.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i>
                Thêm nhân viên</a></h6>
            </div>
            @if ($managers->count() > 0)
            <div class="table-responsive p-3">
            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead class="thead-light">
                <tr>
                    <th>STT</th>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Giới tính</th>
                    <th>Xử lý</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($managers as $key => $manager)
                    <tr>
                        <td>{{ $managers->firstItem() + $key }}</td>
                        <td>
                            @if ($manager->avatar)
                            <img src="{{ $manager->avatar }}" alt="Chưa cập nhật" height="30" width="30" />
                            @else
                            <img src="/uploads/avatars/user.png" alt="Chưa cập nhật" height="30" width="30" />
                            @endif
                        </td>
                        <td>{{ $manager->name }}</td>
                        <td>{{ $manager->email }}</td>
                        <td>{{ $manager->phone ?? 'Chưa cập nhật' }}</td>
                        <td>
                            @if ($manager->gender == 1)
                            Nam
                            @elseif ($manager->gender == 2)
                            Nữ
                            @else
                            Chưa cập nhật
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('manager.edit', $manager->id) }}" class="btn btn-outline-primary btn-xs me-2" title="Edit"><i class="fas fa-edit" data-bs-toggle="tooltip" title="Chỉnh sửa nhân viên"></i></a>
                            
                                <form action="{{ route('manager.destroy', $manager->id) }}" method="POST" class="delete-form">
                                    @method('DELETE')
                                    @csrf
                                    <button type="button" title="Delete" class="btn btn-outline-danger btn-xs delete-btn"><i class="fas fa-trash" data-bs-toggle="tooltip" title="Xóa nhân viên"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            @else
            <p class="alert alert-danger">Chưa có nhân viên nào!</p>
            @endif
        </div>
        <div class="d-flex justify-content-center ">
            {{ $managers->links() }}
        </div>
    </div>

</div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin_asset/js/custom/delete.js') }}"></script>
@endsection
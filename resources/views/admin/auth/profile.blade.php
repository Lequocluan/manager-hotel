@extends('admin.layout_admin.main')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header text-center">
                        <h4>Thông Tin Quản Trị Viên</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="position-relative d-inline-block">
                                    <img id="avatar_user"
                                         src="{{ Auth::guard('admin')->user()->avatar ? Auth::guard('admin')->user()->avatar : '/admin_asset/img/boy.png' }}" 
                                         alt="User Avatar" 
                                         class="rounded-circle img-fluid border"
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                    <div class="camera-icon position-absolute" style="bottom: 0; right: 10px;">
                                        <i class="fa fa-camera text-white bg-dark p-2 rounded-circle"
                                           style="cursor: pointer;"
                                           title="Thay đổi ảnh"
                                           onclick="document.getElementById('avatar_change').click();"></i>
                                    </div>
                                </div>
                                <form id="avatar-form" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="avatar" id="avatar_change" class="d-none" accept="image/*">
                                </form>
                                <h5 class="mt-2">{{ Auth::guard('admin')->user()->name }}</h5>
                                <span class="badge bg-success">Quản trị viên</span>
                            </div>

                            <div class="col-md-8">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Email:</strong> {{ Auth::guard('admin')->user()->email }}</li>
                                    <li class="list-group-item"><strong>Số điện thoại:</strong> {{ Auth::guard('admin')->user()->phone ?? 'Chưa cập nhật' }}</li>
                                    <li class="list-group-item"><strong>Địa chỉ:</strong> {{ Auth::guard('admin')->user()->address ?? 'Chưa cập nhật' }}</li>
                                    <li class="list-group-item"><strong>Giới tính:</strong> {{ auth()->guard('admin')->user()->gender == 1 ? 'Nam' : 'Nữ' }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <a class="btn btn-outline-primary" href="{{ route('admin.edit-account') }}">
                                <i class="fas fa-user-edit"></i> Chỉnh sửa tài khoản
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('admin_asset/js/custom/update-avatar.js') }}"></script>
@endsection

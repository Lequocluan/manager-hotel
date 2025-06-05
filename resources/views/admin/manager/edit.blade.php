@extends('admin.layout_admin.main')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title fs-5">
                    <a href="{{ route('manager.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase">Chỉnh sửa nhân viên</span>
                    <span class="text-primary">"{{ $manager->name }}"</span>
                </p>
            </div>

            <div class="card-body">
                <form action="{{ route('manager.update', $manager->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Tên nhân viên -->
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Tên nhân viên <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $manager->name }}"
                                class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $manager->email }}"
                                class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Giới tính -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Giới tính</label>
                            <div class="d-flex gap-3 pt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="1"
                                        @checked($manager->gender == 1)>
                                    <label class="form-check-label" for="male">Nam</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="2"
                                        @checked($manager->gender == 2)>
                                    <label class="form-check-label" for="female">Nữ</label>
                                </div>
                            </div>
                            @error('gender')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Vai trò -->
                        <div class="mb-3 col-md-4">
                            <label for="role_id" class="form-label">Chức vụ <span class="text-danger">*</span></label>
                            <select name="role_id" id="role_id"
                                class="form-select tag-select w-100 @error('role_id') is-invalid @enderror">
                                <option value="">-- Chọn chức vụ --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $manager->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- Số điện thoại -->
                        <div class="mb-3 col-md-4">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="number" value="{{ $manager->phone }}"
                                class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                                placeholder="Nhập số điện thoại">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mật khẩu -->
                        <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="text" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Để trống nếu không đổi" autocomplete="off">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Xác nhận mật khẩu -->
                        <div class="mb-3 col-md-6">
                            <label for="confirm" class="form-label">Xác nhận mật khẩu</label>
                            <input type="text" class="form-control" id="confirm" name="password_confirmation"
                                placeholder="Nhập lại mật khẩu mới" autocomplete="off">
                        </div>

                        <!-- Địa chỉ -->
                        <div class="mb-3 col-12">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" value="{{ $manager->address }}"
                                class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                placeholder="Nhập địa chỉ">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin_asset/css/custom/custom.css') }}">
    <style>
        /* Fix Select2 khi ở trong col nhỏ */
        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function () {
            $('.tag-select').select2({
                placeholder: "Chọn chức vụ"
            });
        });
    </script>
@endsection

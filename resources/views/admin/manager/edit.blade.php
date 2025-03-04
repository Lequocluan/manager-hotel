@extends('admin.layout_admin.main')
@section('content')
    <div class="container-fluil">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('manager.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa nhân viên</span>
                    <span class="text-primary">"{{ $manager->name }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('manager.update', $manager->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Tên nhân viên <span
                                    class="text-danger">*</span></label>
                            <input type="text" value="{{ $manager->name }}"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                aria-describedby="emailHelp" name="name">
                            @error('name')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $manager->email }}"
                                class="form-control @error('email') is-invalid @enderror" id="email"
                                aria-describedby="emailHelp" name="email">
                            @error('email')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <div class="form-group">
                                <label for="gender">Giới tính</label>
                                <div>
                                    <input type="radio" id="male" name="gender" value="1"
                                        @if ($manager->gender == 1) checked @endif>
                                    <label for="male">Nam</label>
                                    <input type="radio" id="female" name="gender" value="2"
                                        @if ($manager->gender == 2) checked @endif>
                                    <label for="female">Nữ</label>
                                </div>
                                @error('gender')
                                    <div class="message-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="phone" class="form-label">Số điện thoại </label>
                            <input type="number" value="{{ $manager->phone }}" placeholder="Nhập số điện thoại"
                                class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone">
                            @error('phone')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="text" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Nhập mật khẩu">
                            @error('password')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="confirm" class="form-label">Xác nhận mật khẩu</label>
                            <input type="text" class="form-control" id="confirm" name="password_confirmation"
                                placeholder="Nhập xác nhận mật khẩu">
                        </div>
                        <div class="mb-3 col-12">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" value="{{ $manager->address }}" class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                placeholder="Nhập địa chỉ">
                            @error('address')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
@endsection
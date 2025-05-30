@extends('admin.layout_admin.main')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('room-types.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle me-2" title="Quay lại">
            <i class="fas fa-arrow-left"></i> 
        </a>
        <h2 class="m-0">Thêm loại phòng</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('room-types.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-bold">Tên loại phòng</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên loại phòng">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="price" class="form-label fw-bold">Giá (VNĐ)</label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Nhập giá phòng">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="size" class="form-label fw-bold">Diện tích phòng <span style="font-style: italic;">(m<sup>2</sup>)</span></label>
                                <input type="number" name="size" class="form-control @error('size') is-invalid @enderror" placeholder="Nhập diện tích phòng">
                                @error('size')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="overview" class="form-label fw-bold">Mô tả</label>
                        <textarea name="overview" rows="2" class="form-control @error('overview') is-invalid @enderror" rows="3" placeholder="Nhập mô tả về loại phòng..."></textarea>
                        @error('overview')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="max_adults" class="form-label fw-bold">Số người lớn tối đa</label>
                                <input value="{{ old('max_adults', 2) }}" readonly type="number" name="max_adults" class="form-control @error('max_adults') is-invalid @enderror">
                                @error('max_adults')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="max_children" class="form-label fw-bold">Số trẻ em tối đa</label>
                                <input readonly value="{{ old('max_children', 2) }}" type="number" name="max_children" class="form-control @error('max_children') is-invalid @enderror">
                                @error('max_children')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="col-md-4">
                                <label for="bed_type" class="form-label fw-bold">Loại giường</label>
                                <select name="bed_type" class="form-control @error('bed_type') is-invalid @enderror">
                                    <option value="">-- Chọn loại giường --</option>
                                    <option value="Single (1m x 2m)">Giường đơn (1m x 2m)</option>
                                    <option value="Twin (1.2m x 2m)">Giường đôi nhỏ - Twin (1.2m x 2m)</option>
                                    <option value="Double (1.4m x 2m)">Giường đôi tiêu chuẩn - Double (1.4m x 2m)</option>
                                    <option value="Queen (1.6m x 2m)">Queen bed (1.6m x 2m)</option>
                                    <option value="King (1.8m x 2m)">King bed (1.8m x 2m)</option>
                                    <option value="Super King (2m x 2m)">Super King (2m x 2m)</option>
                                </select>
                                @error('bed_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Mô tả chi tiết</label>
                    <textarea name="description" rows="3" id="descriptionEditor" @error('description') is-invalid @enderror></textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label fw-bold">Hình ảnh mô tả</label>
                        <input type="file" id="imageUpload">
                        <input type="hidden" name="uploaded_images" id="uploadedImages">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="image" class="form-label fw-bold">Hình ảnh</label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold">Trạng thái</label>
                                <select name="status" class="form-control">
                                    <option value="1" selected>Hoạt động</option>
                                    <option value="0">Tạm ngưng</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <script>
                    document.querySelector('form').addEventListener('submit', function () {
                        const files = document.querySelector('#imageUpload').files;
                        console.log("Files selected:", files);
                    });
                </script>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Thêm mới</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('admin_asset/css/froala/froala_editor.pkgd.min.css') }}">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <style>
        .filepond--list {
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
        }

        .filepond--item {
            width: 80px !important; 
            margin-right: 5px!important;  
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('admin_asset/js/froala/froala_editor.pkgd.min.js') }}"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script>
        new FroalaEditor('#descriptionEditor', { 
            placeholderText: 'Nhập mô tả chi tiết về loại phòng...'
        });

        FilePond.registerPlugin(FilePondPluginImagePreview);

        FilePond.setOptions({
            server: {
                process: '/admin/room-types/upload-temp',
                revert: '/admin/room-types/revert-temp',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }
        });

        
        const pond = FilePond.create(document.querySelector('#imageUpload'), {
            allowMultiple: true,
            maxFiles: 5,
            acceptedFileTypes: ['image/*'],
            stylePanelLayout: 'compact',
            styleItemPanelAspectRatio: 1, 
            imagePreviewHeight: 100, 
            server: {
                process: {
                    url: '/admin/room-types/upload-temp',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    onload: (response) => {
                        const list = JSON.parse(document.getElementById('uploadedImages').value || '[]');
                        list.push(response);
                        document.getElementById('uploadedImages').value = JSON.stringify(list);
                        return response;  
                    }
                },
                revert: (uniqueId, load) => {
                    fetch('/admin/room-types/revert-temp', {
                        method: 'POST', 
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'text/plain'
                        },
                        body: uniqueId
                    }).then(() => {
                        const uploadedInput = document.getElementById('uploadedImages');
                        let list = JSON.parse(uploadedInput.value || '[]');
                        list = list.filter(path => path !== uniqueId);
                        uploadedInput.value = JSON.stringify(list);

                        load();
                    });
                }
            }
        });
    </script>

@endsection
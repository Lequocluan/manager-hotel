@extends('admin.layout_admin.main')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('room-types.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle me-2" title="Quay lại">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="m-0">Chỉnh sửa loại phòng</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('room-types.update', $roomType->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-bold">Tên loại phòng</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $roomType->name) }}" placeholder="Nhập tên loại phòng">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label fw-bold">Giá (VNĐ)</label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price', $roomType->price) }}" placeholder="Nhập giá phòng">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="overview" class="form-label fw-bold">Mô tả</label>
                        <textarea name="overview" class="form-control @error('overview') is-invalid @enderror" rows="3" placeholder="Nhập mô tả về loại phòng...">{{ old('overview', $roomType->overview) }}</textarea>
                        @error('overview')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label fw-bold">Mô tả chi tiết</label>
                        <textarea name="description" id="descriptionEditor" class="@error('description') is-invalid @enderror">{{ old('description', $roomType->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="imageUpload" class="form-label fw-bold">Hình ảnh mô tả</label>
                        <input type="file" id="imageUpload" multiple >
                        <input type="hidden" name="uploaded_images" id="uploadedImages" >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label fw-bold">Hình ảnh</label>
                        <input type="file" name="image" id="imageInput" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($roomType->image)
                            <div class="mt-2">
                                <img src="{{ asset($roomType->image) }}" alt="Hình ảnh loại phòng" class="img-thumbnail" style="max-width: 100px;">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label fw-bold">Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $roomType->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ $roomType->status == 0 ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
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
    <link rel="stylesheet" href="{{ asset('admin_asset/css/custom/custom.css') }}">
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

        const existingImages = {!! json_encode($roomType->images->map(function($img) {
            return [
                'source' => asset($img->image_path),
                'type' => 'local'
            ];
        })) !!};

        const pond = FilePond.create(document.querySelector('#imageUpload'), {
            allowMultiple: true,
            maxFiles: 5,
            acceptedFileTypes: ['image/*'],
            stylePanelLayout: 'compact',
            styleItemPanelAspectRatio: 1,
            imagePreviewHeight: 100,
            files: existingImages,

            server: {
                process: {
                    url: '/admin/room-types/upload-temp',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    onload: (response) => {
                    let list = JSON.parse(document.getElementById('uploadedImages').value || '[]');

                    try {
                        let parsed = JSON.parse(response); 
                        list.push(parsed);
                    } catch (e) {
                        list.push(response);
                    }

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
                },
                remove: (source, load, error, metadata) => {
                    fetch('/admin/room-types/remove-existing-image', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ path: metadata.path })
                    }).then(() => {
                        const uploadedInput = document.getElementById('uploadedImages');
                        let list = JSON.parse(uploadedInput.value || '[]');
                        list = list.filter(path => path !== metadata.path);
                        uploadedInput.value = JSON.stringify(list);
                        load();
                    });
                }
            }
        });
    </script>
@endsection

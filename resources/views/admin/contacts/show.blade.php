@extends('admin.layout_admin.main')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="text-center text-primary fw-bold">Chi tiết liên hệ khách hàng</h2>
        <p class="text-center text-muted">Từ khách hàng gửi qua hệ thống liên hệ của Havana Hotel Nha Trang</p>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-person-circle text-secondary me-2"></i>
                <strong>{{ $contact->name }}</strong> ({{ $contact->email }})
            </div>
            <small class="text-muted"><i class="bi bi-clock"></i> {{ $contact->created_at->format('d/m/Y H:i') }}</small>
        </div>
        <div class="card-body">
            <p><i class="bi bi-telephone text-secondary"></i> <strong>Số điện thoại:</strong> {{ $contact->phone ?? 'Không có' }}</p>
            <p><i class="bi bi-tag text-secondary"></i> <strong>Chủ đề:</strong> {{ $contact->subject ?? 'Không có' }}</p>
            <hr>
            <p><strong>Nội dung khách gửi:</strong></p>
            <div class="bg-light p-3 rounded border">
                {{ $contact->message }}
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-success">Gửi phản hồi cho khách hàng</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.contacts.reply', $contact->id) }}">
                @csrf
                <div class="form-floating mb-4">
                    <!-- textarea sẽ được Froala biến thành WYSIWYG editor -->
                    <textarea name="reply_message" id="froala-editor" class="form-control" rows="5" required>
                        {{ old('reply_message') }}
                    </textarea>

                </div>
                <div class="text-end">
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-arrow-left-circle"></i> Trở về
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send-check"></i> Gửi phản hồi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('css')
<!-- Froala Editor CSS -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@4.1.4/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

@endsection
@section('js')
<!-- Froala Editor JS -->
<script src="https://cdn.jsdelivr.net/npm/froala-editor@4.1.4/js/froala_editor.pkgd.min.js"></script>

    <script>
        new FroalaEditor('#froala-editor', {
        heightMin: 200,
        toolbarSticky: false,
        toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', '|', 'formatOL', 'formatUL', '|', 'insertLink', 'insertImage', 'undo', 'redo'],
        imageUpload: false,
        fileUpload: false
    });
    </script>
@endsection

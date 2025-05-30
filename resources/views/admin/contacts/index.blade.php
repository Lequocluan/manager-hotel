@extends('admin.layout_admin.main')

@section('content')
<div class="container">
    <h4>Danh sách liên hệ</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th>Chủ đề</th>
                <th>Ngày gửi</th>
                <th>Phản hồi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->subject }}</td>
                <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                <td class="text-center">
                    @if($contact->replied)
                        <span class="badge badge-success">Đã phản hồi</span>
                    @else
                        <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-sm btn-info">Trả lời</a>
                    @endif
                    <form action="{{ route('contact.destroy', $contact->id) }}" method="POST" class="delete-form">
                        @method('DELETE')
                        @csrf
                        <button type="button" class="btn btn-outline-danger btn-xs delete-btn" title="Delete">
                            <i class="fas fa-trash" data-bs-toggle="tooltip" title="Xóa"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin_asset/js/custom/delete.js') }}"></script>
@endsection
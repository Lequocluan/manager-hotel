@extends('admin.layout_admin.main')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách liên hệ</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <form method="GET">
                <div class="row p-3 py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-md-6">
                        <h6 class="m-0 font-weight-bold text-primary">Danh sách liên hệ</h6>

                    </div>
                    <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="replied" class="form-control" id="replied">
                                    <option value="">-- Tất cả trạng thái --</option>
                                    <option value="1" {{ request('replied') == '1' ? 'selected' : '' }}>Đã phản hồi</option>
                                    <option value="0" {{ request('replied') == '0' ? 'selected' : '' }}>Chưa phản hồi</option>
                                </select>
                                <label for="replied" hidden>Trạng thái phản hồi</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control"
                                    placeholder="Tìm theo tên, email, hoặc chủ đề..." value="{{ request('keyword') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Lọc kết quả
                                </button>
                            </div>
                        </div>

                    </div>
                    </div>

                </div>
            </form>

            @if ($contacts->count() > 0)
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Chủ đề</th>
                            <th>Ngày gửi</th>
                            <th>Phản hồi</th>
                            <th>Xử lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $key => $contact)
                        <tr>
                            <td>{{ $contacts->firstItem() + $key }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->subject }}</td>
                            <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($contact->replied)
                                    <span class="badge bg-success"><i class="fas fa-check"></i> Đã phản hồi</span>
                                @else
                                    <span class="badge bg-secondary text-white">Chưa phản hồi</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if(!$contact->replied)
                                        <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-outline-info btn-xs me-2" title="Phản hồi">
                                            <i class="fas fa-reply"></i>
                                        </a>
                                    @endif

                                    <form action="{{ route('contact.destroy', $contact->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-xs delete-btn" title="Xóa">
                                            <i class="fas fa-trash" data-bs-toggle="tooltip" title="Xóa liên hệ"></i>
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
                <p class="alert alert-warning text-center m-3">Chưa có liên hệ nào!</p>
            @endif
        </div>

        <div class="d-flex justify-content-center">
            {{ $contacts->links() }}
        </div>
    </div>

</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin_asset/js/custom/delete.js') }}"></script>
@endsection

@extends('user.layout_user.main')

@section('content')
<div class="container py-5">
    <h3>Đặt phòng ngay</h3>
    <form action="{{ route('booking.step1') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label>Chọn ngày 📅</label>
                <input type="text" id="dateRange" class="form-control" placeholder="Chọn ngày nhận và trả phòng" autocomplete="off">
                <!-- Hidden fields để gửi dữ liệu -->
                <input type="hidden" name="checkin" id="checkin">
                <input type="hidden" name="checkout" id="checkout">
                
                <div class="invalid-feedback" id="dateRangeError">
                    Ngày nhận phòng và trả phòng phải khác nhau.
                </div>
            </div>
            <div class="col-md-3">
                <label>Người lớn 👤</label>
                <input type="number" name="adults" class="form-control @error('adults') is-invalid @enderror" min="1" value="{{ old('adults', 1) }}">
                @error('adults')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label>Trẻ em 👶</label>
                <input type="number" name="children" class="form-control @error('children') is-invalid @enderror" min="0" value="{{ old('children', 0) }}">
                @error('children')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mt-3 text-end">
                <button class="btn btn-primary">Tìm phòng</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('css')
<!-- flatpickr CSS -->
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lấy ngày hôm nay và ngày hôm sau
        const today = new Date();
        const tomorrow = new Date();
        tomorrow.setDate(today.getDate() + 1);

        // Gán sẵn vào các input ẩn
        document.getElementById('checkin').value = today.toISOString().split('T')[0];
        document.getElementById('checkout').value = tomorrow.toISOString().split('T')[0];

        flatpickr("#dateRange", {
            mode: "range",
            dateFormat: "d-m-Y",
            minDate: "today",
            defaultDate: [today, tomorrow],
            locale: {
                rangeSeparator: " đến "
            },
            showMonths: 2,
            onChange: function(selectedDates, dateStr, instance) {
                const dateRangeInput = document.getElementById("dateRange");
                const errorMsg = document.getElementById("dateRangeError");

                if (selectedDates.length === 2) {
                    const checkin = selectedDates[0];
                    const checkout = selectedDates[1];

                    if (checkin.toDateString() === checkout.toDateString()) {
                        // Hiển thị lỗi
                        dateRangeInput.classList.add("is-invalid");
                        errorMsg.style.display = "block";

                        // Xóa dữ liệu và reset flatpickr
                        instance.clear();
                        document.getElementById('checkin').value = "";
                        document.getElementById('checkout').value = "";
                    } else {
                        // Ẩn lỗi nếu hợp lệ
                        dateRangeInput.classList.remove("is-invalid");
                        errorMsg.style.display = "none";

                        document.getElementById('checkin').value = instance.formatDate(checkin, "Y-m-d");
                        document.getElementById('checkout').value = instance.formatDate(checkout, "Y-m-d");
                    }
                }
            }
        });
    });
</script>
@endsection


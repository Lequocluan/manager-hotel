@extends('user.layout_user.main')

@section('content')

    <section class="rooms-section spad">
        <div class="container">
            <div class="row">
                @foreach ($roomTypes as $roomType)
                    <div class="col-lg-4 col-md-6">
                        <div class="room-item">
                                <img src="{{ asset($roomType->image) }}" class="img-fluid" alt="Ảnh loại phòng">
                            <div class="ri-text">
                                <h5 class="text-capitalize">{{ $roomType->name }}</h5>
                                <h3>{{ number_format($roomType->price) }}VNĐ<span>/đêm</span></h3>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Diện tích:</td>
                                            <td>{{ $roomType->size }} m<sup>2</sup></td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Giường</td>
                                            <td>{{ $roomType->bed_type }}</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Số người tối đa:</td>
                                            <td>{{ $roomType->max_adults }} người lớn, {{ $roomType->max_children }} trẻ em</td>
                                        </tr>
                                    </tbody>
                                </table>    
                                <a href="{{ route('roomtype.detail', ['slug' => $roomType->slug]) }}" class="primary-btn">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    
                @endforeach
                <div class="col-lg-12">
                    <div class="room-pagination">
                        {{ $roomTypes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
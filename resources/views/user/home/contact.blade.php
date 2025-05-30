@extends('user.layout_user.main')
@section('content')

<!-- Contact Section Begin -->
    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="contact-text">
                        <h2>Liên hệ với chúng tôi</h2>
                        <p>Chúng tôi luôn sẵn lòng lắng nghe và hỗ trợ bạn. Đừng ngần ngại liên hệ nếu bạn cần bất kỳ sự giúp đỡ nào.</p>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="c-o">Địa chỉ:</td>
                                    <td>38 Trần Phú, Lộc Thọ, Nha Trang, Khánh Hòa</td>
                                </tr>
                                <tr>
                                    <td class="c-o">Email:</td>
                                    <td>info@havanahotel.vn</td>
                                </tr>
                                <tr>
                                    <td class="c-o">Hotline:</td>
                                    <td>(+84) 948338800</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <form action="{{ route('contact.send') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="name" placeholder="Nhập tên của bạn" required>
                            </div>
                            <div class="col-lg-6">
                                <input type="email" name="email" placeholder="Nhập email của bạn" required>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="phone" placeholder="Nhập sđt của bạn">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="subject" placeholder="Nhập tiêu đề của bạn">
                            </div>
                            <div class="col-lg-12">
                                <textarea name="message" placeholder="Nội dung tin nhắn bạn muốn gửi..." required></textarea>
                                <div class="text-center mt-3">
                                    <button type="submit">Gửi tin nhắn</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4843.378648163862!2d109.19326707593542!3d12.243396088009021!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31706778fd8c5dff%3A0xd3c343b165958165!2sKh%C3%A1ch%20s%E1%BA%A1n%20Havana%20Nha%20Trang!5e1!3m2!1svi!2sus!4v1748527945602!5m2!1svi!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->


@endsection
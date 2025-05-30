
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="fa fa-close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>

    <footer class="footer-section">
        <div class="container">
            <div class="footer-text">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ft-about text-center">
                            <div class="logo">
                                <a href="{{ route('home') }}">
                                    <img src="https://havanahotel.vn/storage/logo-mini.png" alt="">
                                </a>
                            </div>
                            <p>Công ty cổ phần Hải Vân Nam Nha Trang</p>
                            <div class="fa-social">
                                <a target="_blank" href="https://www.facebook.com/havananhatranghotel"><i class="fa fa-facebook-f"></i></a>
                                <a target="_blank" href="https://x.com/Havananhatrang"><i class="fa fa-twitter"></i></a>
                                <a target="_blank" href="https://www.instagram.com/havananhatrang"><i class="fa fa-instagram"></i></a>
                                <a target="_blank" href="https://www.youtube.com/@havananhatranghotel"><i class="fa fa-youtube"></i></a>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-contact">
                            <h6>Contact Us</h6>
                            <ul>
                                <li>(+84) 948338800</li>
                                <li> info@havanahotel.vn</li>
                                <li>38 Trần Phú, Phường Lộc Thọ, Thành phố Nha Trang, Việt Nam</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-newslatter">
                            <h6>Tin tức và ưu đãi mới</h6>
                            <p>Nhập email để nhận tin tức và ưu đãi mới nhất của chúng tôi.</p>
                            <form action="#" class="fn-form">
                                <input type="text" placeholder="Email">
                                <button type="submit"><i class="fa fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <ul>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Terms of use</a></li>
                            <li><a href="#">Privacy</a></li>
                            <li><a href="#">Environmental Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-5">
                        <div class="co-text"><p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> Copyright by <a href="mailto:quocluan15102003@gmail.com" style="color: inherit;">Lê Quốc Luân</a></p></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="csssctop">
            <a href="/"><i class="fa fa-angle-up"></i></a>
        </div>
    </footer>

    @section('css')
    <style>
        .csssctop {
    position: fixed !important;
    bottom: 20px !important;
    right: 20px !important;
    z-index: 999 !important;
    background-color: #333 !important;
    color: #fff !important;
    padding: 10px 12px !important;
    border-radius: 50% !important;
    text-align: center !important;
    display: none; /* Ẩn ban đầu, hiện khi cuộn xuống */
    cursor: pointer;
    transition: all 0.3s ease;
}


.csssctop:hover {
    background-color: #555 important;
}

    </style>
    @endsection

    @section('js')
    <script>
    window.addEventListener('scroll', function () {
    const scrollBtn = document.querySelector('.csssctop');
    if (window.scrollY > 100) {
        scrollBtn.style.display = 'block';
    } else {
        scrollBtn.style.display = 'none';
    }
});

document.querySelector('.csssctop').addEventListener('click', function (e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

</script>

    @endsection
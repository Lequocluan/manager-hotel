<script src="/admin_asset/vendor/jquery/jquery.min.js"></script>
<script src="/admin_asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/admin_asset/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="/admin_asset/js/ruang-admin.min.js"></script>
<script src="/admin_asset/vendor/chart.js/Chart.min.js"></script>
<script src="/admin_asset/js/demo/chart-area-demo.js"></script>  
<script src="{{ asset("admin_asset/js/toastr.min.js") }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{!! Toastr::message() !!}
<script>
    @if (Session::has('success'))
        toastr.success("{{ Session::get('success') }}", "Thành công");
    @endif
    @if (Session::has('error'))
        toastr.error("{{ Session::get('error') }}", "Thất bại");
    @endif
</script>


  @routes
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="/admin_asset/img/logo.png" rel="icon">
  <title>{{ $title ?? "admin" }} | Trang quản trị khách sạn Havana</title>
  <link href="/admin_asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="/admin_asset/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="/admin_asset/css/ruang-admin.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset("admin_asset/css/toastr.min.css") }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
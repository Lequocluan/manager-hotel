<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.layout_user.headonly')
    @yield('css')
</head>
    @include('user.layout_user.header')
    @yield('content')
    @include('user.layout_user.footer')
    @include('user.layout_user.script')
    @yield('js')

</html>
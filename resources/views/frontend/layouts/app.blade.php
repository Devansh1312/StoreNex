<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/SystemSetting/StoreNex.png') }}">
        {{-- <title>Dashboard</title> --}}
        <!-- Site Title -->
        <title>StoreNex</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
      @include('frontend.layouts.header') 
      @yield('content') {{-- @include('frontend.layouts.deals') --}} 
      @include('frontend.layouts.footer') 
    </body>
</html>
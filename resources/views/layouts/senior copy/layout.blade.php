<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.superadmin.includes.compatibility')
    <meta name="description" content="">
    <title> Family owner </title>
    @include('layouts.superadmin.includes.style')
</head>

<body>

    <div class="page-box">
        @include('layouts.superadmin.includes.sidebar')
        <div class="main-content">
            @include('layouts.superadmin.includes.header')
            @yield('content')
        </div>
    </div>

    @include('layouts.superadmin.includes.scripts')
</body>
</html>

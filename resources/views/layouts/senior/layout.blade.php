<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.senior.includes.compatibility')
    <meta name="description" content="">
    <title> Family owner </title>
    @include('layouts.senior.includes.style')
</head>

<body>

    <div class="page-box">
        @include('layouts.senior.includes.sidebar')
        <div class="main-content">
            @include('layouts.senior.includes.header')
            @yield('content')
        </div>
    </div>

    @include('layouts.senior.includes.scripts')
</body>
</html>

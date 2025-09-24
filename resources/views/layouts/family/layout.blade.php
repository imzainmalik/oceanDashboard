<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.family.includes.compatibility')
    <meta name="description" content="">
    <title> Family Member </title>
    @include('layouts.family.includes.style')
</head>

<body>

    <div class="page-box">
        @include('layouts.family.includes.sidebar')
        <div class="main-content">
            @include('layouts.family.includes.header')
            @yield('content')
        </div>
    </div>

    @include('layouts.family.includes.scripts')
</body>
</html>

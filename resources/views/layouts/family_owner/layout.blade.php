<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.family_owner.includes.compatibility')
    <meta name="description" content="">
    <title> Family owner </title>
    @include('layouts.family_owner.includes.style')
</head>

<body>

    <div class="page-box">
        @include('layouts.family_owner.includes.sidebar')
        <div class="main-content">
            @include('layouts.family_owner.includes.header')
            @yield('content')
        </div>
    </div>

    @include('layouts.family_owner.includes.scripts')
</body>
</html>

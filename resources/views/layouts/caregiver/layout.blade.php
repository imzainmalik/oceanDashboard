<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.caregiver.includes.compatibility')
    <meta name="description" content="">
    <title> CAREGIVER </title>
    @include('layouts.caregiver.includes.style')
</head>

<body>

    <div class="page-box">
        
        @include('layouts.caregiver.includes.sidebar')
        <div class="main-content">
            @include('layouts.caregiver.includes.header')
            @yield('content')
        </div>

    </div>

    @include('layouts.caregiver.includes.scripts')

</body>

</html>

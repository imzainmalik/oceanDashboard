{{-- @dd(auth()->user()); --}}

<meta name="theme-color" content="#6777ef"/>
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
<link rel="manifest" href="{{ asset('manifest.json') }}">


@if (auth()->user()->role->id == 5)
    @include('layouts.caregiver.layout')
@elseif(auth()->user()->role->id == 1)
    @include('layouts.superadmin.layout')
@elseif(auth()->user()->role->id == 2)
    @include('layouts.senior.layout')
@elseif(auth()->user()->role->id == 3)
    @include('layouts.family.layout')
@elseif(auth()->user()->role->id == 4)
    @include('layouts.family_owner.layout')
@endif

<script src="{{ asset('sw.js') }}"></script>
<script>
   if ("serviceWorker" in navigator) {
      // Register a service worker hosted at the root of the
      // site using the default scope.
      navigator.serviceWorker.register("/sw.js").then(
      (registration) => {
         console.log("Service worker registration succeeded:", registration);
      },
      (error) => {
         console.error(`Service worker registration failed: ${error}`);
      },
    );
  } else {
     console.error("Service workers are not supported.");
  }
</script>
 
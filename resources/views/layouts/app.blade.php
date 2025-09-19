



{{-- @dd(auth()->user()); --}}
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




















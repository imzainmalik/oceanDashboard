<link rel="stylesheet" href="{{ asset('caregiver/assets/css/layout.css')}}">
<link rel="stylesheet" href="{{ asset('caregiver/assets/css/style.css')}}">
<link rel="stylesheet" href="{{ asset('caregiver/assets/css/responsive.css')}}">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
 


<div class="loginWrap" bis_skin_checked="1">
        <div class="row" bis_skin_checked="1">
            <div class="col-lg-6 col-md-3" bis_skin_checked="1">
                <a href="javascript:;" class="loginLogo"><img src="{{asset('caregiver/assets/images/login-logo.png')}}" alt=""></a>
            </div>
            <div class="col-lg-6 col-md-7" bis_skin_checked="1">
                <div class="loginpage" bis_skin_checked="1">
                    <div class="loginContent signup" bis_skin_checked="1">
                        <div class="top" bis_skin_checked="1">
                            <h6> Sign up now to start your free trial. </h6>
                            <p>Already have an account? <a href="{{route('login')}}">Sign in </a></p>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf 
                            <div class="form" bis_skin_checked="1">
                                <div class="row gx-md-2" bis_skin_checked="1">
                                    <div class="col-md-6" bis_skin_checked="1">
                                        <div class="field" bis_skin_checked="1">
                                            <input class="form-control @error('f_name') is-invalid @enderror" name="f_name" value="{{ old('f_name') }}" required placeholder="">
                                            <label for="First Name" class="floating-label">First Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6" bis_skin_checked="1">
                                        <div class="field" bis_skin_checked="1">
                                            <input class="form-control @error('l_name') is-invalid @enderror" name="l_name" value="{{ old('l_name') }}" required placeholder="">
                                            <label for="Last Name" class="floating-label">Last Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6" bis_skin_checked="1">
                                        <div class="field" bis_skin_checked="1">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="">
                                            <label class="floating-label">Email</label>
                                        </div>
                                    </div>  
                                    <div class="col-md-6" bis_skin_checked="1">
                                        <div class="field" bis_skin_checked="1">
                                            <input type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" requiredplaceholder="">
                                            <label class="floating-label">Mobile</label>
                                        </div>
                                    </div>
    
                                    <div class="col-md-6" bis_skin_checked="1">
                                        <div class="field" bis_skin_checked="1">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" requiredplaceholder="">
                                            <label class="floating-label">Password</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6" bis_skin_checked="1">
                                        <div class="field" bis_skin_checked="1">
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" 
                                            value="{{ old('cnfrm_password') }}" required placeholder="">
                                            <label class="floating-label">Confirm Password</label>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="btn-form" bis_skin_checked="1">
                                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                                </div>

                                <div class="fCheckbox" bis_skin_checked="1">
                                    <label><input required type="checkbox"> I agree to the <a href="javascript:;">Master Subscription
                                            Agreement</a>.</label>
                                </div>
    
                                <p class="fCon">By registering, you agree to the processing of your personal data by
                                    Salesforce as described in the Privacy Statement.</p>
    
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
@if ($errors->any())
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
     Swal.fire({
            title: 'Error!',
            html: `<ul style="text-align:left;"> 
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>`,
            icon: 'error',
            confirmButtonText: 'Ok'
        })
</script>
@endif 
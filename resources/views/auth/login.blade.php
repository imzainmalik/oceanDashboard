<link rel="stylesheet" href="{{ asset('caregiver/assets/css/layout.css') }}">
<link rel="stylesheet" href="{{ asset('caregiver/assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('caregiver/assets/css/responsive.css') }}">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
 
 <style>
     .is-invalid{
         border-color: red;
     }
 </style>
<div class="loginWrap" bis_skin_checked="1">
    <div class="row" bis_skin_checked="1">
        <div class="col-lg-6 col-md-3" bis_skin_checked="1">
            <a href="javascript:;" class="loginLogo">
                <img src="{{ asset('caregiver/assets/images/login-logo.png') }}" alt="">
            </a>
        </div>
        <div class="col-lg-6 col-md-7" bis_skin_checked="1">
                <div class="loginpage" bis_skin_checked="1">
                    <div class="loginContent" bis_skin_checked="1">

                        <div class="top" bis_skin_checked="1">
                            <h6> Login </h6>
                            <p>New user? <a href="{{route('register')}}">Create an acount </a></p>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form" bis_skin_checked="1">
                                <div class="field" bis_skin_checked="1">
                                    <input id="email" type="email" 
                                        name="email" value="{{ old('email') }}" required autocomplete="email" class="@error('email') is-invalid @enderror form-control" placeholder="">
                                    <label for="name" class="floating-label">Email address</label>
                                    
                                </div>
                                <div class="field" bis_skin_checked="1">
                                    <input id="password" type="password" class="@error('password') is-invalid @enderror form-control"
                                        name="password" required autocomplete="current-password" placeholder="Password">
                                    <label class="floating-label">Password</label>
                                    <span toggle="#password-field" class="fa fa-eye field-icon toggle-password"></span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="btns" bis_skin_checked="1">
                                    @if (Route::has('password.request')) 
                                     <a href="{{ route('password.request') }}" class="forgotPass">Forgot password?</a>
                                    @endif
                                   
                                    <div class="btn-form" bis_skin_checked="1">
                                        <button type="submit" class="btn btn-primary">Sign In</button>
                                    </div>
                                </div> 

                                <div class="orBorder" bis_skin_checked="1">
                                    <p>or</p>
                                </div>
    
                                <div class="socialbtns" bis_skin_checked="1">
                                    <a href="javascript:;" class="btnSocial"><img src="{{asset('caregiver/assets/images/google-icon.svg')}}" alt=""> Google</a>
                                    <a href="javascript:;" class="btnSocial"><img src="{{asset('caregiver/assets/images/fb-icon.svg')}}" alt="">
                                        Facebook</a>
                                </div>
    
                                <p class="fCon"> Protected by reCAPTCHA and subject to the <a href="javascript:;">Cuboid
                                        Privacy Policy</a> and <a href="javascript:;">Terms of Service.</a></p>
    
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>
@error('email')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
     Swal.fire({
            title: 'Error!',
            text: '{{ $message }}',
            icon: 'error',
            confirmButtonText: 'Ok'
        })
</script>
 @enderror
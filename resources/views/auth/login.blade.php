@include('layouts.header')
<script src="{{asset('pluto/js/addJs/sweetAlert.js')}}"></script>
{{-- <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script type="text/javascript" charset="utf8" src="{{asset('pluto/js/addJs/jquery-3.6.0.min.js')}}"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background-size: cover;
            position: relative;
            background-image: url('image/updateds.jpg');
        }
        
                  
        input::placeholder {
            text-align: left;
            font-size: 16px; 
        }

      
        input:focus::placeholder {
            text-align: left;
            font-size: 12px; 
            color: blue; 
            transform: translateY(-10px); 
            transition: transform 0.3s, font-size 0.4s;
        }
        .input-group-prepend {
            position: relative;
        }

        .input-group-text {
            background-color: white; 
            transition: background-color 0.3s;
        }

        .input-group-prepend:focus-within .input-group-text {
            background-color: rgb(13, 143, 57); 
            color:white;
        }

        .eye-icon {
            position: relative;
            cursor: pointer;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            padding: 0.375rem 0.75rem;
            margin-bottom: 0;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            text-align: center;
            white-space: nowrap;
            background-color: white;
            border: 1px solid #ced4da;
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
            border-top-left-radius: 0px;
            border-bottom-left-radius: 0px;
        }

        .password-hide {
            -webkit-text-security: disc; 
            text-security: disc; 
        }

        .password-show {
            -webkit-text-security: none; 
            text-security: none;
        }
        .red-text {
            color: red;
        }
    </style>
   @if(session('swal') === 'invalid_credentials')
        <script>    
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Login Failed',
                    text: 'Your username or password is incorrect. Please try again.',
                    icon: 'error',
                    width: '500px',
                    customClass: {
                            title: 'red-text' 
                        }
                });
            });
        </script>
        @endif

        @if(session('swal') === 'warning')
        <script>    
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Your Account is Inactive',
                    text: 'Please Contact Admin to Active your Account.',
                    icon: 'error',
                    width: '500px',
                    customClass: {
                            title: 'red-text' 
                        }
                });
            });
        </script>
        @endif


    <div class="container">
        
        <div class="center verticle_center full_height">
           <div class="login_section" style="box-shadow: 0px 0px 15px 1.5px #747f8a !important;min-height:50px;height:80% !important;max-width:100% !important; width:350px !important; border-radius: 0px;background-color: rgba(255, 255, 255, 0.877) !important">
            <div class="logo_login">
                 <div class="center" style="margin-top:-40px">
                    <img width="300"  src="{{ asset('image/logo2.png') }}" alt="#" />
                 </div>
              </div>
              
              <div class="login_form" >
                 <form method="POST" action="{{ route('login') }}">
                     @csrf
                    <fieldset>
                        <div class="row mb-3">
                            <div class="col-md-12" style="margin-top:-55px;">
                                <div class="d-flex">
                                    <div class="input-group input-group-prepend">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="icon-addon"><i class="fa fa-envelope"></i></span>
                                        </div>
                                        <input style="height: 40px;" id="username" type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                               
                                    </div>
                                </div>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="d-flex">
                                    <div class="input-group input-group-prepend">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="password-icon-addon"><i class="fa fa-lock"></i></span>
                                        </div>
                                        <input style="height: 40px;" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                                        <span class="eye-icon"><i class="fa fa-eye-slash" id="togglePassword"></i></span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <script>
                        
                            $(document).ready(function() {
                                $("#togglePassword").click(function() {
                                    var passwordInput = $("#password");
                                    var eyeIcon = $("#togglePassword");

                                    if (passwordInput.attr("type") === "password") {
                                        passwordInput.attr("type", "text");
                                        eyeIcon.removeClass("fa-eye-slash");
                                        eyeIcon.addClass("fa-eye");
                                    } else {
                                        passwordInput.attr("type", "password");
                                        eyeIcon.removeClass("fa-eye");
                                        eyeIcon.addClass("fa-eye-slash");
                                    }
                                });
                            });
                        </script>
                        

                     <div class="row mb-3">
                         {{-- @if (Route::has('password.request'))
                             <a class="btn btn-link" href="{{ route('password.request') }}">
                                 {{ __('Forgot Your Password?') }}
                             </a>
                         @endif --}}
                     </div>
                     <div class="row mb-3" >
                         <div class="col-md-6">
                             <button type="submit" class="main_bt" style="min-width: 250px !important;border-radius:0% !important">
                                 {{ __('Login') }}
                             </button> 
                         </div>
                     </div>
                   
                     <div class="row mb-0">
                         @if (Route::has('register'))
                             <a href="{{ route('register') }}" style="color:rgba(255, 255, 255, 0.7) !important;" class="ml-4 text-sm">-</a>
                         @endif
                     </div>
                    </fieldset>
                 </form>
              </div>
           </div>
        </div>
     </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#username, #password").focus(function () {
                $(".icon-background").addClass("active");
            });
    
            $("#username, #password").blur(function () {
                $(".icon-background").removeClass("active");
            });
        });
    </script>
  
    
    
    
    



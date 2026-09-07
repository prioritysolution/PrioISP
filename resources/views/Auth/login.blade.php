@extends('Auth.Layout.layout')
@section('section')
    <div class="login-userset">
        <div class="login-logo">
            <img src="{{asset('assets/img/logo.png')}}" alt="img" />
        </div>
        <div class="login-userheading">
            <h3>Sign In</h3>
            <h4>Please login to your account</h4>
        </div>
        <div class="form-login">
            <label>Username</label>
            <div class="form-addons">
                <input type="text" id="user_name" name="user_name" placeholder="Enter your username" />
                <img src="{{asset('assets/img/icons/mail.svg')}}" alt="img" />
            </div>
        </div>
        <div class="form-login">
            <label>Password</label>
            <div class="pass-group">
                <input type="password" id="user_pass" name="user_pass" class="pass-input" placeholder="Enter your password" />
                <span class="fas toggle-password fa-eye-slash"></span>
            </div>
        </div>
        <div class="form-login">
            <a class="btn btn-login" onclick="proc_login()">Sign In</a>
        </div>
        {{-- <div class="form-login">
            <div class="alreadyuser" style="text-align: center;">
                <h4>
                    Don't have an account? <a href="{{route('signup')}}" class="hover-a">Sign Up</a>
                </h4>
            </div>
        </div> --}}

    </div>
@endsection
@push('script')
    <script src="{{asset('assets/js/auth/proc_auth.js')}}"></script>
@endpush
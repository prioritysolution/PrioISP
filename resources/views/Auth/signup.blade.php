@extends('Auth.Layout.layout')
@section('section')
    <div class="login-userset">
        <div class="login-logo">
            <img src="{{ asset('assets/img/logo.png') }}" alt="img" />
        </div>
        <div class="login-userheading">
            <h3>Sign Up</h3>
            <h4>Create your account</h4>
        </div>
        <div class="form-login">
            <label>Full Name</label>
            <div class="form-addons">
                <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" />
                <img src="{{ asset('assets/img/icons/users1.svg') }}" alt="img" />
            </div>
        </div>
        <div class="form-login">
            <label>Username</label>
            <div class="form-addons">
                <input type="text" id="user_name" name="user_name" placeholder="Enter your username" />
                <img src="{{ asset('assets/img/icons/mail.svg') }}" alt="img" />
            </div>
        </div>
        <div class="form-login">
            <label>Password</label>
            <div class="pass-group">
                <input type="password" id="user_pass" name="user_pass" class="pass-input"
                    placeholder="Enter your password" />
                <span class="fas toggle-password fa-eye-slash"></span>
            </div>
        </div>
        <div class="form-login">
            <label>Counter</label>
            <div class="form-addons">
                <select id="counter_id" name="counter_id" class="form-control">
                    <option value="">-- Select Counter --</option>
                    @foreach ($counters as $counter)
                        <option value="{{ $counter->Id }}">{{ $counter->Name }}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="form-login">
            <a class="btn btn-login" onclick="proc_signup()">Sign Up</a>
        </div>
        <div class="form-login">
            <div class="alreadyuser" style="text-align: center;">
                <h4>
                    Already have an account? <a href="{{ route('login') }}" class="hover-a">Sign In</a>
                </h4>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/auth/proc_auth.js') }}"></script>
@endpush

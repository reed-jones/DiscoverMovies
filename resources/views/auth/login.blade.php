@extends('layouts.movieAppPublic')

@section('content')

<div class="card login">
    <div class="panel">
        <div class="panel-header">Login</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email"">E-Mail Address</label>
                    <input id="email" type="email" class="text-input" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="text-input" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label class="checkbox">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>

                    {{-- Not Yet Implimented! --}}
                    {{-- <a class="forgot-pass-btn" href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a> --}}
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

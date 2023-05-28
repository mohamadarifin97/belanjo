@extends('layouts.app')

@section('content')
    <div class="card card-lg py-4">
        <div class="card-header text-center">
            <i class='icon ion-ios-locked-outline'></i>
        </div>

        <div class="card-body login-card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="row mb-3 justify-content-center">
                    <div class="col-md-10">
                        <input id="username" type="text"
                            class="form-control login-input @error('username') is-invalid @enderror" name="username"
                            value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Username">

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 justify-content-center">
                    <div class="col-md-10">
                        <input id="password" type="password"
                            class="form-control login-input @error('password') is-invalid @enderror" name="password"
                            required autocomplete="current-password" placeholder="Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row submit-div justify-content-center">
                    <div class="col-md-8 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

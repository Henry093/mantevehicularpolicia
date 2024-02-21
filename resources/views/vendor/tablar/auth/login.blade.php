@extends('tablar::auth.layout')
@section('title', __('validation.Login'))

@section('content')
<div class="container-fluid p-0" style="background-image: url('{{ asset('images/portada.jpg') }}'); background-size: cover; background-position: center; height: 100vh;">
    <div class="container container-tight py-4">
        <div class="text-center mb-1 mt-5">
            <a href="" class="navbar-brand navbar-brand-autodark">
                <img src="{{asset(config('tablar.auth_logo.img.path','assets/logo.svg'))}}" height="100"alt="">
            </a>
        </div>
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">@lang('Login to your account')</h2>
                <form action="{{route('login')}}" method="post" autocomplete="off" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">@lang('Email address')</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                               placeholder="@lang('your@email.com')"
                               autocomplete="off">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            @lang('Password')
                            <span class="form-label-description">
                    <a href="{{route('password.request')}}">@lang('I forgot password')</a>
                  </span>
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="@lang('Your password')"
                                   autocomplete="off">
                            <span class="input-group-text">
                    <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                           stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                           stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12"
                                                                                                              cy="12"
                                                                                                              r="2"/><path
                              d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/></svg>
                    </a>
                  </span>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input"/>
                            <span class="form-check-label">@lang('Remember me on this device')</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">@lang('Sign in')</button>
                    </div>
                </form>
            </div>
            <div class="hr-text">@lang('Report')</div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <a href="{{ route('reclamo.indexPublic') }} " class="btn btn-outline-danger  w-100 
                                {{request()->routeIs('reclamo.indexPublic') ? 'active' : ''}}">
                            
                            @lang('Register a claim')
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="text-center text-muted mt-3">
            @lang('Do not have account yet?')' <a href="{{route('register')}}" tabindex="-1">@lang('Sign up')</a>
        </div> --}}
    </div>
</div>
@endsection

@extends('layouts.auth')

@section('title') Login @endsection

@section('content')
    <div class="page page-center">
        <div class="container-tight py-4">
            <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark">
                    <img src="{{ asset('img/logo.svg') }}" alt="">
                </a>
            </div>
            {!! Form::open(['url' => route('login'), 'method' => 'post', 'class' => 'card card-md', 'autocomplete' => 'off']) !!}
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Login to your account</h2>
                    @include('partials.messages')
                    <div class="mb-3">
                        {!! Form::label('email', 'E-Mail/UserName', ['class' => 'form-label']) !!}
                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email or UserName']) !!}
                        @if ($errors->has('email'))
                            <div class="text-danger">
                                <p>{{ $errors->first('email') }}</p>
                            </div>
                        @endif                
                    </div>
                    <div class="mb-2">
                        {!! Form::label('password', 'Password', ['class' => 'form-label']) !!}
                        <div class="input-group input-group-flat">
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'autocomplete' => 'off']) !!}
                        </div>
                        @if ($errors->has('password'))
                            <div class="text-danger">
                                <p>{{ $errors->first('password') }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="mb-2">
                        <label class="form-check">
                            <input type="checkbox" name="rememberme" class="form-check-input" value="1" />
                            <span class="form-check-label">Remember me on this device</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        {!! Form::submit('Login', ['class' => 'btn btn-warning w-100']) !!}
                         <a href="/su/forgot-password" class="mt-3" type="submit">Forgot Password</a>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
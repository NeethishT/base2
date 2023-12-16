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
            {!! Form::open(['url' => route('reset.resetlink'), 'method' => 'post', 'class' => 'card card-md', 'autocomplete' => 'off']) !!}
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Reset Your Password</h2>
                    @include('partials.messages')
                    <div class="mb-3">
                        {!! Form::label('email', 'E-Mail Address', ['class' => 'form-label']) !!}
                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email']) !!}
                        @if ($errors->has('email'))
                            <div class="text-danger">
                                <p>{{ $errors->first('email') }}</p>
                            </div>
                        @endif                
                    </div>
                    <div class="form-footer">
                        {!! Form::submit('Submit', ['class' => 'btn btn-warning w-100']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
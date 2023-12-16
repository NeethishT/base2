@extends('layouts.auth')

@section('title') Password Reset @endsection

@section('content')
<main class="login-form">
  <div class="page page-center">
        <div class="container-tight py-4">
            <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark">
                    <img src="{{ asset('img/logo.svg') }}" alt="">
                </a>
            </div>
              <form action="{{ route('reset.submit') }}" class = "card card-md" method="get" autocomplete ="off">
                          @csrf
                          <input type="hidden" name="token" value="{{ $token }}">
  
                          <div class="card-body">
                            <div> 
                               <label for="email_address" class="form-label">E-Mail Address</label>
                              <div class="mb-3">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                            </div>
                             <div> 
                               <label for="password" class="form-label">Password</label>
                              <div class="mb-3">
                                  <input type="password" id="password" class="form-control" name="password" required autofocus>
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                                </div>
                            </div>
                             <div> 
                               <label for="password-confirm" class="form-label">Confirm Password</label>
                              <div class="mb-3">
                                  <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
                                  @if ($errors->has('password_confirmation'))
                                      <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                  @endif
                              </div>
                            </div>
 <div class="text-center">
                              <button type="submit" class="btn btn-warning">
                                  Reset Password
                              </button>
                          </div>
                             
                          </div>
  
                     
  
                         
                      </form>
                        
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection
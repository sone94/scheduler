@extends('layouts.master')

@section('content')
<meta name="csrf-token" content="{!! csrf_token() !!}">
<div class="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                      
                        <form id="register-form" class="form" action="{{ action('UserController@registration') }}" method="post">
                            <h3 class="text-center text-info">Register</h3>
                            <div class="alert alert-success d-none mt-3" id="successRegister" role="alert">
                                <p>You have been successfully registrated. Click <a href="{{route('/')}}">Here</a> to go back to login page.</p>
                            </div>
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control">
                                <span id="userError" class="errorSpan"></span>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                                <span class="errorSpan" id="passwordError"></span>
                            </div>
                            <div class="form-group text-center">
                              <input type="submit" name="submit" class="btn btn-info btn-md" value="Register">
                            </div>
                                                    
                            <br/>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
  <script src="{{ asset('assets/js/auth/register.js') }}"></script>
@endsection
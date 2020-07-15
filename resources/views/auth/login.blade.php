@extends('layouts.master')

@section('content')
<meta name="csrf-token" content="{!! csrf_token() !!}">
<div class="login">
        <h2 class="text-center text-white pt-5">Scheduler</h2>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                      
                        <form id="login-form" class="form" action="{{ action('UserController@authenticate') }}" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="alert alert-danger d-none mt-3" id="errorLogin" role="alert">
                            </div>
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group text-center">
                              <input type="submit" name="submit" class="btn btn-info btn-md" value="Login">
                            </div>
                            
                            <div  class="text-center text-info">
                              <a href="{{ route('register') }}">Don't have account? Register</a>
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
  <script type="text/javascript">
    var $dashboardURL = "{{route('dashboard')}}";
  </script>
  <script src="{{ asset('assets/js/auth/login.js') }}"></script>
@endsection
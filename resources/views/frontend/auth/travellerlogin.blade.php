@extends('frontend.layouts.master-new')
@section('title') Traveller Login Area | {{ $siteTitle }}@endsection
@section('content')

<section class="main-content">
        <div class="login-page">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                @include('includes.partials.messages')
              
                <div class="form-wrapper">
                  
                  <div class="login-wrapper">
                    <div class="light-block">
                      <div class="title">
                        <h3>Login</h3>
                      </div>
                      <div class="login-form">
                      {!! Form::open(['url' => 'login', 'class'=>'form-btm-outline']) !!}
                        {{-- <form class="form-btm-outline" method="post" action="{{url('/login')}}"> --}}
                          <div class="form-group">
                            <div class="input-group">
                              <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user-o"></i></span>
                               <input class="form-control" name="email" id="exampleInputEmail1" placeholder="Email" type="email">
                        
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="input-group">
                              <span class="input-group-addon" id="basic-addon1"><i class="fa fa-lock"></i></span>
                              <input class="form-control" name="password" id="exampleInputPassword1" placeholder="Password" type="password">
                        
                            </div>
                          </div>
                          <div class="btn-grp">
                            <input class="btn btn-default" value="Login" type="submit">
                            <a href="{{url('/register')}}" class="btn btn-default register-btn">Register</a>
                          </div>

                          {!! Form::close() !!}
                        </form>
                        
                      </div>
                      <div class="login-footer">
                        <p>forgot your password? <a href="#">click here</a></p>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    
    </section>
@endsection
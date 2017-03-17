@extends('frontend.layouts.master-new')
@section('title') Traveller Login Area | {{ $siteTitle }}@endsection
@section('content')

<section class="main-content">
        <div class="register-page">
          <div class="container">
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                @include('includes.partials.messages')
              
                <div class="form-wrapper">
                  
                  <div class="register-wrapper">
                    <div class="light-block">
                      <div class="title">
                        <h3>Register</h3>
                      </div>
                      <div class="register-form">
                      {!! Form::open(['url' => 'login', 'class'=>'']) !!}
                        {{-- <form class="" method="post" action="{{url('/login')}}"> --}}
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>First Name</label>
                              <input type="text" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Middle Name</label>
                              <input type="text" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Last Name</label>
                              <input type="text" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Email</label>
                              <input type="email" class="form-control">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Address</label>
                              <input type="text" class="form-control">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>State</label>
                              <input type="text" class="form-control">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Country</label>
                              <input type="text" class="form-control">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Phone Type</label>
                              <input type="text" class="form-control">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Phone Number</label>
                              <input type="text" class="form-control">
                            </div>
                          </div>


                        </div>
                          
                          <div class="btn-grp">
                            <a href="register.html" class="btn btn-default register-btn">Register</a>
                          </div>

                          {!! Form::close() !!}
                        </form>
                        
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
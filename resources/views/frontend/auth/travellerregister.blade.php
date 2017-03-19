@extends('frontend.layouts.master-new')
@section('title') Traveller Register Area | {{ $siteTitle }}@endsection
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
                      {!! Form::open(['url' => '/register', 'class'=>'customerRegisterForm']) !!}
                        {{-- <form class="" method="post" action="{{url('/login')}}"> --}}
                        <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                              <label>Title</label>
                              {!! Form::select('title', [''=>'-- Choose Title -- ', 'MR'=>'Mr', 'MRS'=>'Mrs', 'MS'=>'Ms'], null, ['class'=>'SlectBox form-control' ]) !!}
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>First Name</label>
                              {!! Form::text('fname',null,['class'=>'form-control', 'placeholder'=>'Enter First Name']) !!}
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Middle Name</label>
                              {!! Form::text('mname',null,['class'=>'form-control', 'placeholder'=>'Enter Middle Name']) !!}
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Last Name</label>
                              {!! Form::text('lname',null,['class'=>'form-control', 'placeholder'=>'Enter Last Name']) !!}
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Email</label>
                              {!! Form::email('email',null,['class'=>'form-control', 'placeholder'=>'Enter Email']) !!}
                            </div>
                          </div>
                          
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Password</label>
                              {!! Form::input('password', 'password', null,['class'=>'form-control', 'placeholder'=>'Enter Password','id'=> 'password']) !!}
                            </div>
                          </div>
                          
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Confirm Password</label>
                              {!! Form::input('password', 'password_confirmation',null,['class'=>'form-control', 'placeholder'=>'Confirm Password']) !!}
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Address</label>
                              {!! Form::text('address',null,['class'=>'form-control', 'placeholder'=>'Enter Address']) !!}
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Country</label>
                              {!! Form::select('country', [], null , ['class'=>'form-control country', 'id'=>'country']) !!}
                              {{-- <select name="country" id="country" class="form-control" onchange="print_state('state',this.selectedIndex);">
                              </select> --}}
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>State</label>
                              {!! Form::select('state', [], null , ['class'=>'form-control state', 'id'=>'state']) !!}
                             {{--  <select name="state" id="state" class="form-control" >

                              </select> --}}
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Phone Type</label>
                              {!! Form::select('phone_type', [''=>'-- Select Phone Type --', 'Mobile'=>'Mobile', 'Home'=>'Home', 'Office'=>'Office'], null , ['class'=>'SlectBox form-control']) !!}
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Phone Number</label>
                              {!! Form::text('phone_number',null,['class'=>'form-control', 'placeholder'=>'Enter Phone Number']) !!}
                            </div>
                          </div>


                        </div>
                          
                          <div class="btn-grp">
                            <button class="btn btn-default register-btn">Register</button>
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

<script language="javascript">
  print_country("country","-- Select Country --");
  $("#state").append(new Option("-- Select State --", ""));

  $(document).on('change', '.country', function(){
    // $('#state').removeClass('state');
    print_state('state',this.selectedIndex);
    // $('#state').addClass('state');
  })
</script>
@endsection
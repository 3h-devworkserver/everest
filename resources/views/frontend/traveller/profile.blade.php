@extends('frontend.layouts.master-new')
@section('title') Traveller Profile | {{ $siteTitle }}@endsection
@section('meta_title'){{ $meta_title }}@endsection
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection

@section('content')

<section class="main-content dashboard-wrapper">

  @include('frontend.traveller.includes.navbar')

  <div class="profile">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist" id="myTab">
              <li role="presentation" class="active"><a href="#a" aria-controls="a" role="tab" data-toggle="tab">Edit Profile</a></li>
              <li role="presentation"><a href="#b" aria-controls="b" role="tab" data-toggle="tab">Change Profile Picture</a></li>
              <li role="presentation"><a href="#c" aria-controls="c" role="tab" data-toggle="tab">Change Password</a></li>
              <li role="presentation"><a href="#d" aria-controls="d" role="tab" data-toggle="tab">Passport Image</a></li>
              
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              @include('includes.partials.messages')
              <div role="tabpanel" class="tab-pane active" id="a">
                <h4>Change Your Profile Informations</h4>
                <hr>
                {!! Form::model($profile, ['url'=>'traveller/profile/info', 'class'=>'travellerProfileForm']) !!}
                  <div class="form-group">
                    <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <label>Title <em>*</em></label>
                        {!! Form::select('title', [''=>'Title', 'MR'=>'Mr', 'MRS'=>'Mrs', 'MS'=>'Ms'], null, ['class'=>'profileSelect form-control' ]) !!} 
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <label>First Name <em>*</em></label> 
                        {!! Form::text('fname',null, ['placeholder'=>'Your First Name', 'class'=>'form-control','required']) !!}                   
                        {{-- <input class="form-control" type="text" placeholder="Your First Name"> --}}
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <label>Middle Name</label> 
                        {!! Form::text('mname',null, ['placeholder'=>'Your Middle Name', 'class'=>'form-control']) !!}                   
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <label>Last Name <em>*</em></label>
                        {!! Form::text('lname',null, ['placeholder'=>'Your Last Name', 'class'=>'form-control','required']) !!}                   
                        {{-- <input class="form-control" type="text" placeholder="Your Last Name"> --}}
                      </div>
                      
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6 col-sm-12">
                        <label>Birth Date <em>*</em></label>                    
                        <div class="row">
                          <div class="col-md-4 col-sm-4">
                            <select name="dob_year" class="form-control profileSelect" required >
                              <option value="">YEAR</option>
                              <?php $j = date('Y'); ?>
                              @while($j != 1900 )
                              @if($j == $profile->dob_year)
                                  <option value"{{$j}}" selected>{{$j}}</option>
                              @else
                                  <option value"{{$j}}" >{{$j}}</option>
                              @endif
                                  <?php $j--; ?>
                              @endwhile
                          </select>
                          </div>

                          <div class="col-md-4 col-sm-4">
                            {!! Form::select('dob_month', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'profileSelect form-control','required' ]) !!}
                          </div>
                          
                          <div class="col-md-4 col-sm-4">
                            <select name="dob_day" class="daypicker form-control profileSelect" required >
                              <option value="">DD</option>
                              <?php $j = 1 ; ?>
                              @while($j != 32 )
                              @if($j == $profile->dob_day)
                                  <option value"{{$j}}" selected>{{$j}}</option>
                              @else
                                  <option value"{{$j}}" >{{$j}}</option>
                              @endif
                                  <?php $j++; ?>
                              @endwhile
                            </select>
                          </div>
                        </div>
                        
                      </div>
                      <div class="col-md-6 col-sm-12">
                        <label>I am <em>*</em></label>  
                        <div class="gender-block">
                          <div class="radio">
                            <label>
                              <input name="gender" id="optionsRadios1" value="male" type="radio" @if($profile->gender == 'male' || empty($profile->gender) ) checked @endif>
                              Male
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input name="gender" id="optionsRadios2" value="female" type="radio" @if($profile->gender == 'female') checked @endif>
                              Female
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input name="gender" id="optionsRadios3" value="other" type="radio" @if($profile->gender == 'other') checked @endif>
                              Other
                            </label>
                          </div>
                        </div>
                        
                      </div>
                      
                    </div>
                  </div>

                  
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <label>Where You Live</label> 
                        {!! Form::text('address',null, ['placeholder'=>'Your Address', 'class'=>'form-control']) !!}                   
                        {{-- <input class="form-control" type="text" placeholder="e.g. Paris, France / Brooklyn, NY / Chicago, IL"> --}}
                        
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <label>Email Address <em>*</em></label>  
                        {!! Form::email('email',null, ['placeholder'=>'Your Email Address', 'class'=>'form-control', 'required']) !!}                   
                      </div>
                      
                      
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                     
                      <div class="col-md-6 col-sm-6">
                        <label>Contact Number <em>*</em></label> 
                        {!! Form::text('phone',null, ['placeholder'=>'Your Contact Number', 'class'=>'form-control', 'required']) !!}                   
                      </div>
                      <!--
                      <div class="col-md-6">
                        <label>Emergency Contact Number <em>*</em></label>  
                        <input class="form-control" type="text" placeholder="Your Contact Number">
                        
                      </div> -->
                      
                    </div>
                  </div>
                  <input type="submit" class="btn btn-danger" value="Update Profile">
                {!! Form::close() !!}
              </div>

              <div role="tabpanel" class="tab-pane" id="b">
                <h4>Change Your Profile Picture</h4>
                <hr>
                {!! Form::open(['url'=>'traveller/profile/image', 'method'=>'patch', 'files'=>true]) !!}
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4">

                        <div class="profile-block ">
                          <div class="profile-picture">
                            @if(!empty($profile->profile_pic))
                              <div class="profile-bg" style="background-image:url({{asset('images/user/profile/'.$profile->profile_pic)}});"></div>
                            @else
                              <div class="profile-bg @if(empty($profile->profile_pic)) display-none @endif" ></div>
                            @endif
                              <span class="btn btn-default btn-file profileImg @if(!empty($profile->profile_pic)) display-none @endif">
                                <i class="fa fa-image"></i>Browse
                                
                              </span>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-8">
                        <p>
                          Clear frontal face photos are an important way for hosts and guests to learn about each other. It’s not much fun to host a landscape! Please upload a photo that clearly shows your face. 
                        </p>
                        <div class="btn-grp">
                          <span class="btn btn-default btn-file profile-img @if(empty($profile->profile_pic)) display-none @endif">
                            <i class="fa fa-image"></i>Browse
                            <input type="file" name="upload" class="profileImage" onchange="travellerReadURL(this)" >
                          </span>
                          <!--
                          <span class="btn btn-default btn-file">
                            <i class="fa fa-image"></i>
                            Upload Picture
                            <input type="file" name="upload" onchange="travellerReadURL(this)">
                          </span>
                          -->
                          <div class="msg display-none"><span class="text-danger">File should be less than 500KB</span></div>
                          <input type="submit" class="btn btn-danger" value="Save">
                          
                        </div>
                      </div>
                    </div>
                  </div>
                {!! Form::close() !!}
              </div>

              <div role="tabpanel" class="tab-pane" id="c">
                <h4>Change Your Password</h4>
                <hr>
                {!! Form::model($profile, ['url'=>'traveller/profile/password', 'class'=>'travellerPaswordForm']) !!}
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Email Address</label>
                        {!! Form::email('email',null, ['placeholder'=>'Your Email Address', 'class'=>'form-control', 'disabled']) !!}                   
                      </div>
                      
                      <div class="col-md-6">
                        <label>Old Password</label>
                        {!! Form::input('password', 'old_password', null,['class'=>'form-control', 'placeholder'=>'Your Old Password']) !!}
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>New Password</label>
                        {!! Form::input('password', 'password', null,['class'=>'form-control', 'placeholder'=>'Your New Password','id'=> 'password']) !!}
                      </div>
                      <div class="col-md-6">
                        <label>Confirm Password</label>
                        {!! Form::input('password', 'password_confirmation',null,['class'=>'form-control', 'placeholder'=>'Confirm Password']) !!}
                      </div>
                      
                    </div>
                  </div>

                  <input type="submit" class="btn btn-danger" value="Update Password">
                {!! Form::close() !!}
              </div>

              <div role="tabpanel" class="tab-pane" id="d">
                <h4>Passport Info</h4>
                <hr>
                {!! Form::model($profile, ['url'=>'traveller/profile/passport', 'class'=>'travellerPassportForm', 'method'=>'patch', 'files'=>true]) !!}
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Document Type</label>
                        {!! Form::select('document_type',['passport' => 'Passport', 'id-card'=> 'ID Card', 'birth-certificate'=>'Birth Certificate'], null, ['class'=>'form-control SlectBox', 'required']) !!}
                      </div>
                      <div class="col-md-6">
                        <label>Document Number <em>*</em></label>
                        {!! Form::text('document_no',null, ['placeholder'=>'Your Passport Number', 'class'=>'form-control', 'required']) !!}                   
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      
                      <div class="col-md-6">
                        <label>Issue Date <em>*</em></label>

                        <div class="row">
                          <div class="col-md-4 col-sm-4">
                            <select name="issue_year" class="form-control profileSelect" required >
                              <option value="">YEAR</option>
                              <?php $j = date('Y'); ?>
                              @while($j != 1900 )
                              @if($j == $profile->issue_year)
                                  <option value"{{$j}}" selected>{{$j}}</option>
                              @else
                                  <option value"{{$j}}" >{{$j}}</option>
                              @endif
                                  <?php $j--; ?>
                              @endwhile
                          </select>
                          </div>

                          <div class="col-md-4 col-sm-4">
                            {!! Form::select('issue_month', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'profileSelect form-control','required' ]) !!}
                          </div>
                          
                          <div class="col-md-4 col-sm-4">
                            <select name="issue_day" class="daypicker form-control profileSelect" required >
                              <option value="">DD</option>
                              <?php $j = 1 ; ?>
                              @while($j != 32 )
                              @if($j == $profile->issue_day)
                                  <option value"{{$j}}" selected>{{$j}}</option>
                              @else
                                  <option value"{{$j}}" >{{$j}}</option>
                              @endif
                                  <?php $j++; ?>
                              @endwhile
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <label>Expiry Date <em>*</em></label>

                        <div class="row">
                          <div class="col-md-4 col-sm-4">
                            <select name="exp_year" class="form-control profileSelect" required >
                              <option value="">YEAR</option>
                              <?php $j = date('Y'); ?>
                              @while($j != 1900 )
                              @if($j == $profile->exp_year)
                                  <option value"{{$j}}" selected>{{$j}}</option>
                              @else
                                  <option value"{{$j}}" >{{$j}}</option>
                              @endif
                                  <?php $j--; ?>
                              @endwhile
                          </select>
                          </div>

                          <div class="col-md-4 col-sm-4">
                            {!! Form::select('exp_month', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'profileSelect form-control','required' ]) !!}
                          </div>
                          
                          <div class="col-md-4 col-sm-4">
                            <select name="exp_day" class="daypicker form-control profileSelect" required >
                              <option value="">DD</option>
                              <?php $j = 1 ; ?>
                              @while($j != 32 )
                              @if($j == $profile->exp_day)
                                  <option value"{{$j}}" selected>{{$j}}</option>
                              @else
                                  <option value"{{$j}}" >{{$j}}</option>
                              @endif
                                  <?php $j++; ?>
                              @endwhile
                            </select>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                      <span class="btn btn-default btn-file passport-img @if(!empty($profile->document_img)) display-none @endif">
                        <i class="fa fa-image"></i>Browse
                        
                      </span>
                      <!--
                        <span class="btn btn-default btn-file passport-img">
                          <i class="fa fa-image"></i>
                          Upload Picture
                          <input type="file" name="passport_img" onchange="documentReadURL(this)">
                        </span> -->

                        @if(!empty($profile->document_img))
                          <img id="documentPreview" class="" src="{{url('images/user/document/'.$profile->document_img)}}" alt="Image Preview">
                        @else
                         <img id="documentPreview" class="display-none" src="" alt="Image Preview">
                        @endif
                      <p class="help-block msgPassport">
                        Image should be less than 500KB
                      </p>
                      </div>
                      
                    </div>
                  </div>
                  <div class="btn-grp">
                    <span class="btn btn-default btn-file btn-passport @if(empty($profile->document_img)) display-none @endif">
                      <i class="fa fa-image"></i>Browse
                      <input type="file" class="passportImg" name="passport_img" onchange="documentReadURL(this)" >
                    </span>
                    <input type="submit" class="btn btn-danger" value="Save">
                  </div>
                {!! Form::close() !!}
              </div>
              
            </div>

          </div>
        </div>
        
      </div>
    </div>
  </div>
  
</section>
@endsection
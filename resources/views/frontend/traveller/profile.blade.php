@extends('frontend.layouts.master-new')
@section('title') Traveller Profile | {{ $siteTitle }}@endsection
@section('content')

<section class="main-content dashboard-wrapper">

  @include('frontend.traveller.includes.navbar')

  <div class="profile">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#a" aria-controls="a" role="tab" data-toggle="tab">Edit Profile</a></li>
              <li role="presentation"><a href="#b" aria-controls="b" role="tab" data-toggle="tab">Change Profile Picture</a></li>
              <li role="presentation"><a href="#c" aria-controls="c" role="tab" data-toggle="tab">Change Password</a></li>
              
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="a">
                <h4>Change Your Profile Informations</h4>
                <hr>
                <form action="#">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>First Name <em>*</em></label>                    
                        <input class="form-control" type="text" placeholder="Your First Name">
                        
                      </div>
                      <div class="col-md-6">
                        <label>Last Name <em>*</em></label>                    
                        <input class="form-control" type="text" placeholder="Your Last Name">
                        
                      </div>
                      
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Birth Date <em>*</em></label>                    
                        <div class="row">
                          <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Month">
                          </div>
                          <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Date">
                          </div>
                          <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Year">
                          </div>
                        </div>
                        
                      </div>
                      <div class="col-md-6">
                        <label>I am <em>*</em></label>  
                        <div class="gender-block">
                          <div class="radio">
                            <label>
                              <input name="optionsRadios" id="optionsRadios1" value="option1" type="radio">
                              Male
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input name="optionsRadios" id="optionsRadios2" value="option2" type="radio">
                              Female
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input name="optionsRadios" id="optionsRadios3" value="option3" type="radio">
                              Other
                            </label>
                          </div>
                        </div>
                        
                      </div>
                      
                    </div>
                  </div>

                  
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Where You Live</label>                    
                        <input class="form-control" type="text" placeholder="e.g. Paris, France / Brooklyn, NY / Chicago, IL">
                        
                      </div>
                      <div class="col-md-6">
                        <label>Email Address <em>*</em></label>                    
                        <input class="form-control" type="email" placeholder="Your Email Address">                                
                      </div>
                      
                      
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                     
                      <div class="col-md-6">
                        <label>Contact Number <em>*</em></label>  
                        <input class="form-control" type="text" placeholder="Your Contact Number">
                        
                      </div>
                      <div class="col-md-6">
                        <label>Emergency Contact Number <em>*</em></label>  
                        <input class="form-control" type="text" placeholder="Your Contact Number">
                        
                      </div>
                      
                    </div>
                  </div>
                  
                  
                  <input type="submit" class="btn btn-danger" value="Update Profile">
                  
                  
                  
                </form>
              </div>
              <div role="tabpanel" class="tab-pane" id="b">
                <h4>Change Your Profile Picture</h4>
                <hr>
                <form action="#">
                  <div class="form-group">
                    <div class="col-md-4">
                      <div class="profile-block">
                        <div class="profile-picture">
                          <div class="profile-bg" style="background-image:url('images/mountain-biking.jpg');"></div>
                          
                        </div>
                        

                        
                      </div>
                    </div>
                    <div class="col-md-8">
                      <p>
                        Clear frontal face photos are an important way for hosts and guests to learn about each other. It’s not much fun to host a landscape! Please upload a photo that clearly shows your face. 
                      </p>
                      <div class="btn-grp">
                        <span class="btn btn-default btn-file">
                          <i class="fa fa-image"></i>
                          Upload Picture
                          <input type="file">
                        </span>
                        <input type="submit" class="btn btn-danger" value="Save">
                        
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div role="tabpanel" class="tab-pane" id="c">
                <h4>Change Your Password</h4>
                <hr>
                <form action="#">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Email Address</label>
                        <input class="form-control" disabled type="email" placeholder="" value="example@demo.com">                                
                      </div>
                      
                      <div class="col-md-6">
                        <label>Old Password</label>
                        <input class="form-control" type="password" placeholder="Your Old Password">                                
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>New Password</label>
                        <input class="form-control" type="password" placeholder="Your New Password">                                
                      </div>
                      <div class="col-md-6">
                        <label>Confirm Password</label>
                        <input class="form-control" type="password" placeholder="Confirm Password">                               
                      </div>
                      
                    </div>
                  </div>

                  <input type="submit" class="btn btn-danger" value="Update Password">
                </form>
              </div>
              
            </div>

          </div>
        </div>
        
      </div>
    </div>
  </div>
  
</section>
@endsection
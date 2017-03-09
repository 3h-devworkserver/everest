@extends('frontend.layouts.master-new')
@section('title') Traveller Dashboard | {{ $siteTitle }}@endsection
@section('content')

<section class="main-content dashboard-wrapper">
  
  @include('frontend.traveller.includes.navbar')

  <div class="dashboard">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-3">
          <div class="profile-block">
            <div class="profile-picture">
              <div class="profile-bg" style="background-image:url({{asset('images/new/mountain-biking.jpg')}})"></div>
              <div class="profile-img" style="background-image:url('images/mountain-biking.jpg');"></div>
            </div>
            <div class="profile-desc text-center">
              <h3>Caroline Belfort</h3>
              <h5>Kusunti,Jawlakhel</h5>
            </div>

            <div class="profile-footer text-center">
              <a href="#" class="btn btn-default">view profile</a>
            </div>
          </div>
        </div>
        <div class="col-md-9 col-sm-9">
          <div class="user-activity">
            
            <h3>Package Purchased</h3>            
            
            <article class="activity-wrap">
              <div class="row">
                <div class="col-md-2">
                  <figure>
                    <img src="{{asset('images/new/valentines.png')}}" alt="">
                    
                  </figure>
                </div>
                <div class="col-md-10">
                  <h4>Pokhara Calling</h4>
                  <div class="meta-activity">
                    <ul class="list-unstyled list-inline">
                      <li> <i class="fa fa-tag"></i>Valentine Package</li>
                      <li>
                        <i class="fa fa-clock-o"></i> 10 Feb 2017
                      </li>
                    </ul>
                  </div>
                  <p>
                    Surprise your Valentine with a get away to romantic Pokhara, where our Valentine’s Day package has been designed to inspire romance, without damaging your wallet too deep.
                  </p>
                  
                </div>
              </div>
            </article>
            <article class="activity-wrap">
              <div class="row">
                <div class="col-md-2">
                  <figure>
                    <img src="{{asset('images/new/inside_everest_trekking_small_1.jpg')}}" alt="">
                    
                  </figure>
                </div>
                <div class="col-md-10">
                  <h4>Trekking in the Everest region</h4>
                  <div class="meta-activity">
                    <ul class="list-unstyled list-inline">
                      <li> <i class="fa fa-tag"></i>Trekking Package</li>
                      <li>
                        <i class="fa fa-clock-o"></i> 28 Jan 2017
                      </li>
                    </ul>
                  </div>
                  <p>
                    When Everest comes calling they say there is no stopping oneself. There are numerous mountaineering options in Nepal. Eight of the 14 mountains over 8,000 meters high are located in 
                  </p>
                  
                </div>
              </div>
            </article>

            <article class="activity-wrap">
              <div class="row">
                <div class="col-md-2">
                  <figure>
                    <img src="{{asset('images/new/paragliding.jpg')}}" alt="">
                    
                  </figure>
                </div>
                <div class="col-md-10">
                  <h4>Paragliding</h4>
                  <div class="meta-activity">
                    <ul class="list-unstyled list-inline">
                      <li> <i class="fa fa-tag"></i>Trekking Package</li>
                      <li>
                        <i class="fa fa-clock-o"></i> 28 Jan 2017
                      </li>
                    </ul>
                  </div>
                  <p>
                    When Everest comes calling they say there is no stopping oneself. There are numerous mountaineering options in Nepal. Eight of the 14 mountains over 8,000 meters high are located in 
                  </p>
                  
                </div>
              </div>
            </article>

            <h3>Flight Booking</h3>           
            
            <article class="activity-wrap">
              <div class="row">
                <div class="col-md-2">
                  <figure>
                    <img src="{{asset('images/new/buddha-air-logo.png')}}" alt="">
                    
                  </figure>
                </div>
                <div class="col-md-10">
                  <h4>Indianapolis to Paris</h4>
                  <div class="meta-activity">
                    <ul class="list-unstyled list-inline">
                      <li> <i class="fa fa-tag"></i>Oneway Flight</li>
                      <li>
                        <i class="fa fa-clock-o"></i> 10 Feb 2017
                      </li>
                    </ul>
                  </div>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae, nisi perferendis dolorem saepe laboriosam. Itaque quo, esse earum ducimus repellendus iusto aperiam quam minus quos dicta 
                  </p>
                  
                </div>
              </div>
            </article>
            <article class="activity-wrap">
              <div class="row">
                <div class="col-md-2">
                  <figure>
                    <img src="{{asset('images/new/buddha-air-logo.png')}}" alt="">
                    
                  </figure>
                </div>
                <div class="col-md-10">
                  <h4>Indianapolis to Paris</h4>
                  <div class="meta-activity">
                    <ul class="list-unstyled list-inline">
                      <li> <i class="fa fa-tag"></i>Round Trips</li>
                      <li>
                        <i class="fa fa-clock-o"></i> 28 Jan 2017
                      </li>
                    </ul>
                  </div>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae, nisi perferendis dolorem saepe laboriosam. Itaque quo, esse earum ducimus repellendus iusto aperiam quam minus quos dicta 
                  </p>
                  
                </div>
              </div>
            </article>

            <article class="activity-wrap">
              <div class="row">
                <div class="col-md-2">
                  <figure>
                    <img src="{{asset('images/new/buddha-air-logo.png')}}" alt="">
                    
                  </figure>
                </div>
                <div class="col-md-10">
                  <h4>Indianapolis to Paris</h4>
                  <div class="meta-activity">
                    <ul class="list-unstyled list-inline">
                      <li> <i class="fa fa-tag"></i>Twoway Flight</li>
                      <li>
                        <i class="fa fa-clock-o"></i> 28 Jan 2017
                      </li>
                    </ul>
                  </div>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae, nisi perferendis dolorem saepe laboriosam. Itaque quo, esse earum ducimus repellendus iusto aperiam quam minus quos dicta 
                  </p>
                  
                </div>
              </div>
            </article>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
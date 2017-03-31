@extends('frontend.layouts.master-new')
@section('title') Traveller Dashboard | {{ $siteTitle }}@endsection
@section('meta_title'){{ $meta_title }}@endsection
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection

@section('content')

<section class="main-content dashboard-wrapper">
  
  @include('frontend.traveller.includes.navbar')

  <div class="dashboard">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-5">
          <div class="profile-block">
            <div class="profile-picture">
              @if(!empty($user->profile->profile_pic))
                <div class="profile-bg" style="background-image:url({{asset('images/user/profile/'.$user->profile->profile_pic)}})"></div>
              @else
                <div class="profile-bg" style="background-image:url({{asset('images/new/mountain-biking.jpg')}})"></div>
              @endif
              @if(!empty($user->profile->profile_pic))
                <div class="profile-img" style="background-image:url({{asset('images/user/profile/'.$user->profile->profile_pic)}});"></div>
              @else
                <div class="profile-img" style="background-image:url()}});"></div>
              @endif
            </div>
            <div class="profile-desc text-center">
              <h3>{{$user->profile->fname}} {{$user->profile->mname}} {{$user->profile->lname}}</h3>
                    <h5>{{$user->profile->address}} @if($user->profile->city), {{$user->profile->city}} @endif @if($user->profile->state), {{$user->profile->state}} @endif </h5>
            </div>

            <div class="profile-footer text-center">
              <a href="{{url('traveller/profile')}}" class="btn btn-default">view profile</a>
            </div>
          </div>
        </div>
        <div class="col-md-9 col-sm-7">
          @include('includes.partials.messages')

          <div class="user-activity">
          
          @if(count($user->userPackageBookingsLimit) != 0)
            <h3>Package Purchased</h3>         

            @foreach($user->userPackageBookingsLimit as $booking)
              <?php $pack = $booking->packageBooking->package; ?>
            <article class="activity-wrap">
              <div class="row">
                <div class="col-md-2 col-sm-3">
                  <figure>
                    <a href="{{url('/package/'.$pack->slug)}}"><img src="{{asset('images/packages-new/'.$pack->feat_img)}}" alt=""></a>
                    
                  </figure>
                </div>
                <div class="col-md-8 col-sm-9">
                  <h4><a href="{{url('/package/'.$pack->slug)}}">{{title_case($pack->title)}}</a></h4>
                  <div class="meta-activity">
                    <ul class="list-unstyled list-inline">
                      <li> <i class="fa fa-tag"></i>
                      <?php $i = 1; ?>
                        @foreach($pack->packageCategory as $cat)
                          @if($i == 1)
                            {{$cat->title}}
                          @else
                            , {{$cat->title}}
                          @endif
                          <?php $i++; ?>
                        @endforeach
                      </li>
                      <li>
                        <i class="fa fa-clock-o"></i> Purchased On: {{Carbon\Carbon::parse($booking->purchased_at)->format('d M Y')}} 
                      </li>
                      <li>
                        <i class="fa fa-money"></i>
                          {{$booking->packageBooking->total_amount}} 
                      </li>
                    </ul>
                  </div>
                  <p>
                    {!! $pack->description!!}
                  </p>
                  
                </div>
                <div class="col-md-2 text-right">
                  <div class="action">
                    <a href="{{url('/traveller/purchase/'.$booking->id.'/detail')}}" target="_blank">
                      <i class="fa fa-eye"></i>
                    </a>
                  </div>
                </div>
              </div>
            </article>
            @endforeach
          @endif

          @if(count($user->userFlightBookingsLimit) != 0)

            <h3>Flight Booking</h3>           
            @foreach($user->userFlightBookingsLimit as $booking)
            <?php 
              $flight = $booking->flightReservation;
            ?>
            <article class="activity-wrap">
              <div class="row">
                <div class="col-md-2">
                  <figure>
                    <img src="{{asset('images/upeverest-logo.png')}}" alt="">
                    
                  </figure>
                </div>
                <div class="col-md-8">
                  <h4>{{title_case($flight->departure)}} to {{title_case($flight->arrival)}}</h4>
                  <div class="meta-activity">
                    <ul class="list-unstyled list-inline">
                      <li> <i class="fa fa-tag"></i>@if($flight->return_type == 'R') Round Trip Flight @else One Way Flight @endif </li>
                      <li>
                        <i class="fa fa-clock-o"></i> Purchased On: {{Carbon\Carbon::parse($booking->purchased_at)->format('d M Y')}}
                      </li>
                      <li>
                        <i class="fa fa-money"></i>
                          {{$flight->total_amount}} 
                      </li>
                    </ul>
                  </div>
                  <p>
                  </p>
                  
                </div>
                <div class="col-md-2 text-right">
                  <div class="action">
                    <a href="{{url('/traveller/purchase/'.$booking->id.'/detail')}}" target="_blank">
                      <i class="fa fa-eye"></i>
                    </a>
                  </div>
                </div>
              </div>
            </article>
            @endforeach
          @endif


          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
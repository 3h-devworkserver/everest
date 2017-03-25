@extends('frontend.layouts.master-new')
@section('title'){{ $meta_title }}@endsection
<!--@section('meta_title'){{ $meta_title }}@endsection-->
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection

@section('extra')
<link rel="stylesheet" href="{{asset('flexslider/flexslider.css')}}">
<script src="https://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="{{asset('js/gmaps.js')}}"></script>
@endsection

@section('extra-btm')
<script type="text/javascript" src="{{asset('flexslider/jquery.flexslider.js')}}"></script>
@endsection



@section('content')
{{-- <section class="banner bg-wrap {!! $page->image !!}" style="background-image: url({!! url().'/images/'.$page->image !!});">
    <div class="container"></div>
</section> --}}
{{-- @include('frontend.includes.new.search') --}}
<div class="main-content">
    <div class="container">
        <?php
        // echo list_breadcrumbs($page->slug, $page->title);
        ?>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to("") }}">Home</a></li>
            <!--  <li><a href="#">Everest</a></li> -->
            <li><a href="{{url('/trekking')}}">{{$page->title}}</a></li>
            <li class="active">{{$package->title}}</li>
        </ol> 
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <div class="page-header bold_page-header">
                    <h2>{{$package->title}}</h2>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="share_and_adds text-right">
                    @include('frontend.includes.sharethis')


                </div><!--share and adds-->
            </div>
        </div>
        <!--row-->
        <div class="package">
            <div class="row">
                <div class="col-md-5 col-sm-7">
                    <p>@if($package->duration != 0 ){{($package->duration)-1}} NIGHTS/ @endif{{$package->duration}} DAYS</p>
                    <h3>From USD {{$package->price}} <small>PER PERSON</small></h3>
                </div>
                <div class="col-md-7 col-sm-5 btn-box">
                    <a href="#" class="btn btn-default btn-enquiry">ENQUIRY</a>
                    <a href="#datePrice" class="btn btn-default">BOOK NOW</a>
                </div>
            </div>
        </div>

     <!--   <div class="customer-review">
            <div class="row">
                <div class="col-md-12">
                    <h3>customer review</h3>
                    <span>
                        <img src="{{asset('images/new/icon~star.png')}}" alt="">
                        <img src="{{asset('images/new/icon~star.png')}}" alt="">
                        <img src="{{asset('images/new/icon~star.png')}}" alt="">
                        <img src="{{asset('images/new/icon~star.png')}}" alt="">
                        <img src="{{asset('images/new/icon~star.png')}}" alt="">
                        {{-- <img src="images/icon~star.png" alt=""> --}}
                        {{-- <img src="images/icon~star.png" alt=""> --}}
                        {{-- <img src="images/icon~star.png" alt=""> --}}
                        {{-- <img src="images/icon~star.png" alt=""> --}}
                    </span>
                </div>
            </div>
        </div> -->

        <div class="package-detail">
            @if( (!empty($package->duration)) || (!empty($package->trek_period)) || (!empty($package->trek_type)) ||(!empty($package->trek_st_end)) || (!empty($package->altitude))|| (!empty($package->warning)) || (!empty($package->best_period)) || (!empty($package->flight)) || (!empty(count($package->galleryRotatorsDefault))) )
            <div class="package-block">
                <div class="row">
                    @if( (!empty($package->duration)) || (!empty($package->trek_period)) || (!empty($package->trek_type)) || (!empty($package->trek_st_end))|| (!empty($package->altitude)) || (!empty($package->warning)) || (!empty($package->best_period)) && (!empty($package->flight)) )
                    <div class="col-md-6 col-sm-6">
                        <div class="row">
                            @if(!empty($package->duration))
                            <div class="col-md-4 col-sm-4">
                                <div class="box">
                                    <img src="{{asset('images/new/icon~duration.png')}}" alt="">
                                    <p>Duration :
                                        <span>{{$package->duration}} Days</span>
                                    </p>
                                </div>
                            </div>
                            @endif
                            @if(!empty($package->trek_period))
                            <div class="col-md-4 col-sm-4">
                                <div class="box">
                                    <img src="{{asset('images/new/icon_trek.png')}}" alt="">
                                    <p>Trek Period :
                                        <span>{{$package->trek_period}} Days</span>
                                    </p>
                                </div>
                            </div>
                            @endif
                            @if(!empty($package->trek_type))
                            <div class="col-md-4 col-sm-4">
                                <div class="box">
                                    <div class="trek-type">
                                        <span id="difficult"></span>
                                        <span id="hard"></span>
                                        <span id="medium"></span>
                                        <span id="easy" class="selected"></span>
                                    </div>
                                    <p>Trek Type :
                                        @if($package->trek_type == 1)
                                        <span>Easy</span>
                                        @elseif($package->trek_type == 2)
                                        <span>Moderate</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @endif

                            @if(!empty($package->trek_st_end))
                            <div class="col-md-4 col-sm-4">
                                <div class="box">
                                    <img src="{{asset('images/new/icon~trek%20start%20point.png')}}" alt="">
                                    <p>Trek Start &amp; End Point:
                                        <span>{{$package->trek_st_end}}</span>
                                    </p>
                                </div>
                            </div>
                            @endif

                            @if(!empty($package->altitude))
                            <div class="col-md-4 col-sm-4">
                                <div class="box">
                                    <img src="{{asset('images/new/icon_highest_altitude.png')}}" alt="">
                                    <p>Highest Altitude :
                                        <span>{{$package->altitude}}m</span>
                                    </p>
                                </div>
                            </div>
                            @endif

                            @if(!empty($package->warning))
                            <div class="col-md-4 col-sm-4">
                                <div class="box">
                                    <img src="{{asset('images/new/icon~warning.png')}}" alt="">
                                    <p>Warning :
                                        <span>{{$package->warning}}</span>
                                    </p>
                                </div>
                            </div>
                            @endif

                            @if(!empty($package->best_period))
                            <div class="col-md-4 col-sm-4">
                                <div class="box">
                                    <img src="{{asset('images/new/icon~best%20period.png')}}" alt="">
                                    <p>Best Period :
                                        <span>{{$package->best_period}}</span>
                                    </p>
                                </div>
                            </div>
                            @endif

                            @if(!empty($package->flight))
                            <div class="col-md-4 col-sm-4">
                                <div class="box">
                                    <img src="{{asset('images/new/icon~plane%202.png')}}" alt="">
                                    <p>Flights :
                                        <span>{{$package->flight}}</span>
                                    </p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if(!empty(count($package->galleryRotatorsDefault)))
                    <div class="col-md-6 col-sm-6">
                        <!-- Place somewhere in the <body> of your page -->
                        <div id="slider" class="flexslider">
                          <ul class="slides">
                              @if(!empty(count($package->galleryRotatorsDefault)))
                              <li>
                                <div class="bg-wrap thumb-slider" style="background-image:url({{asset('images/packages-new/rotator/'.$package->galleryRotatorsDefault[0]->image)}});"></div>
                            </li>
                            @endif
                            @foreach($package->galleryRotators as $rotator)
                            @if($rotator->id != $package->galleryRotatorsDefault[0]->id )
                            <li>
                              <div class="bg-wrap thumb-slider" style="background-image:url({{asset('images/packages-new/rotator/'.$rotator->image)}});"></div>
                          </li>
                          @endif
                          @endforeach

                          <!-- items mirrored twice, total of 12 -->
                      </ul>
                  </div>
                  <div id="carousel" class="flexslider">
                      <ul class="slides">
                        @if(!empty(count($package->galleryRotatorsDefault)))
                        <li>
                            <div class="bg-wrap thumb-slider" style="background-image:url({{asset('images/packages-new/rotator/'.$package->galleryRotatorsDefault[0]->image)}});"></div>
                        </li>
                        @endif
                        @foreach($package->galleryRotators as $rotator)
                        @if($rotator->id != $package->galleryRotatorsDefault[0]->id )
                        <li>
                          <div class="bg-wrap thumb-slider" style="background-image:url({{asset('images/packages-new/rotator/'.$rotator->image)}});"></div>
                      </li>
                      @endif
                      @endforeach
                      <!-- items mirrored twice, total of 12 -->
                  </ul>
              </div>
          </div>
          @endif
      </div>

  </div>
  @endif
  
  <?php $max=0; ?>
  @if(!empty(count($package->itinerarys)))
  <?php 
  $max = \DB::table('package_itinerary')->where('package_id', $package->id)->max('walk_it');
  ?>
  @endif

  @if( (!empty($package->short_desc)) || ($max != 0) )
  <div class="package-block package-short-info">
    <div class="row">
        @if(!empty($package->short_desc))
        <div class="col-md-8 col-sm-8">
            <div class="row">
                {!! $package->short_desc  !!}
            </div>

        </div>
        @endif

        @if(!empty(count($package->itinerarys)))
        <?php 
        $max = \DB::table('package_itinerary')->where('package_id', $package->id)->max('walk_it');
        ?>
        @if($max != 0)
        <div class="col-md-4 col-sm-4 walk-profile">
            <h2 class="block-info-title">
                Walk profile
            </h2>

            @foreach($package->itinerarys as $itinerary)
            @if($itinerary->walk_it != 0)
            <div class="progress-wrap">
                <div class="progress-content">
                    <p>Day {{$itinerary->day_it}}: {{$itinerary->walk_it}} km</p>
                </div>
                <div class="progress-content">
                    <div class="progress">
                        <?php 
                        $avg = ($itinerary->walk_it / $max)*100 ;
                        ?>
                        <div class="progress-bar" role="progressbar" aria-valuenow="{{$avg}}" valuemin="0" aria-valuemax="100" style="width: {{$avg}}%;">
                            <span class="sr-only">{{$avg}}% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            {{-- @endif --}}

        </div>
        @endif
        @endif
    </div>
</div>
@endif

{{-- @if( (!empty($package->long_desc)) || (!empty($package->map_image)) || ((!empty($package->latitude)) && (!empty($package->longitude))) || (!empty(count($package->itinerarys))) || (!empty(($package->galleryLists))) || (!empty(count($package->optionsAccomodation))) || (!empty(count($package->optionsExpert))) || (count($package->datesPrices) != 0 ) ) --}}
<div class="package-block package-full-desc">
    @if( (!empty($package->long_desc)) || (!empty($package->map_image)) || ((!empty($package->latitude)) && (!empty($package->longitude))) )
    <div class="row">
        @if( (!empty($package->long_desc)) )
        <div class="col-md-6 col-sm-6">
            {!! $package->long_desc !!}
        </div>
        @endif
        @if( (!empty($package->map_image)) || ((!empty($package->latitude)) && (!empty($package->longitude))) )
        <div class="col-md-6 col-sm-6">
            <div class="panel panel-default map">
              <div class="panel-heading">
                <h2>Map</h2>
            </div>
            <div class="panel-body">
                @if(!empty($package->map_image))
                <div class="bg-wrap map-area" style="background-image: url({{asset('images/packages-new/maps/'.$package->map_image)}})"></div>
                @else
                @if((!empty($package->latitude)) && (!empty($package->longitude)))
                <div class="map-area" id="map" style="height:560px;">

                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
    @endif

</div>
@endif

@if(!empty(count($package->itinerarys)))
<div class="itinerary">
    <div class="row">
        <div class="col-md-12">
            <div class="sub-title">
                <h2>ITINERARY</h2>
            </div>

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
             <?php $i =1; ?>
             @foreach($package->itinerarys as $itinerary)
             <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading{{$i}}">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$i}}" aria-expanded="false" aria-controls="{{$i}}">
                      + Day {{$itinerary->day_it}}: {{$itinerary->title_it}}
                  </a>
              </h4>
          </div>
          <div id="{{$i}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$i}}">
              <div class="panel-body">
                  {!! $itinerary->content_it !!}
              </div>
          </div>
      </div>
      <?php $i++; ?>
      @endforeach

  </div>

</div>
</div>
</div>

@endif

@if(!empty(count($package->galleryLists)))
<div class="gallery">
    <div class="row">



        <?php $i=1 ?>
        @foreach($package->galleryLists as $list)

        <div class="col-md-4 col-sm-4">
          <a class="group1" href="{{asset('images/packages-new/gallerylist/'. $list->image)}}"><div class="bg-wrap" style="background-image: url({{asset('images/packages-new/gallerylist/'. $list->image)}})"></div></a>
      </div>
      <?php 
      if($i++ >=3){
        break;
    }
    ?>
    @endforeach
    <div id="more-lists">

    </div>
       <!-- <div class="col-md-4 col-sm-4">
            <img alt="" src="images/home_body_small_1.jpg">
        </div>
        <div class="col-md-4 col-sm-4">
            <img alt="" src="images/home_body_small_2.jpg">
        </div> -->

    </div>
    @if((count($package->galleryLists)) > 3)
    <a class="btn btn-default" data-id ="{{$package->id}}" id ="add-lists">MORE PICS <i aria-hidden="true" class="fa fa-angle-down"></i></a>
    @endif
</div>
@endif

{{-- @if((!empty(count($package->optionsAccomodation))) || (!empty(count($package->optionsExpert)))) --}}
@if((!empty(count($package->options))) )
<div class="further-detail">
    <div class="row">
        @foreach($package->options as $option)
        <div class="col-md-6 col-sm-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                 <!-- <h2>Accommodation details</h2>  -->
                 <h2>{{$option->type_name}}</h2> 
             </div>
             <div class="panel-body accomodationHeight">
                <h5>{{$option->name}}<small>@if(!empty($option->designation))({{$option->designation}})@endif</small></h5>
                {!! $option->content !!}

            </div>
        </div>
    </div>
    @endforeach

<?php /* ?>
    @if(!empty(count($package->optionsExpert)))
    <div class="col-md-6 col-sm-6">
        <div class="panel panel-default">
          <div class="panel-heading">
          <!--  <h2>Expert Advice</h2> -->
            <h2>{{$package->optionsExpert[0]->type_name}}</h2> 
        </div>
        <div class="panel-body expertHeight">

            <div id="myCarousel" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                  <?php $j = 0; ?>
                  @foreach ($package->optionsExpert as $expert)
                  <li data-target="#myCarousel" data-slide-to="{{$j}}" @if($i == 0) class="active" @endif ></li>
                  <?php $j++; ?>
                  @endforeach
              </ol>

              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">

                <?php 
                $i = 0;
                ?>
                @foreach ($package->optionsExpert as $expert)
                <div class="item @if($i == 0) active @endif">
                 <h5>{{$expert->name}} <small>@if(!empty($expert->designation))({{$expert->designation}})@endif</small></h5>

                 {!! $expert->content !!}
             </div>
             <?php $i++; ?>
             @endforeach

         </div>


     </div>
 </div>
</div>
</div>
@endif
<?php */ ?>

</div>

</div>
@endif

@if(count($package->datesPrices) != 0 )
<div class="datePrice" id="datePrice">
    <h3>Dates & Prices</h3>
    @if(!empty($package->datesPrices[0]->description))<p> {{$package->datesPrices[0]->description}}</p> @endif
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th>Date</th>
                <th>Trip Status</th>
                <th>Price</th>
                <th>&nbsp;</th>
            </tr>
            @foreach($package->datesPrices as $datePrice)
            <tr>
                <td>{{$datePrice->daterange}} <p><small>{{$datePrice->short_description}}</small></p></td>
                <td>{{$datePrice->status}}</td>
                <td>USD {{$datePrice->price}}</td>
                @if($datePrice->status == 'Limited Availability')
                <td><a href="{{url('package/'.$package->slug.'/'.$datePrice->id.'/booking-step1')}}" class="btn btn-danger">Book Now</a></td>
                @elseif($datePrice->status == 'Available')
                <td><a href="{{url('package/'.$package->slug.'/'.$datePrice->id.'/booking-step1')}}" class="btn btn-danger">Book Now </a></td>
                @elseif($datePrice->status == 'Already Booked')
                <td><a href="#" data-toggle="modal" data-dateprice-id="{{$datePrice->id}}" data-target="#package-contact" class="btn btn-danger click-contact-btn">Contact Us </a> </td>
                @endif
            </tr>

            @endforeach
        </table>
    </div>
</div>
@endif

<!-- Modal -->
<div class="modal fade" id="package-contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body">
        <div class="form-wrapper" >

         <form action="javascript:;" id="package-contactform" method="post" name="package-contactform">
          <div class="form-group">
            <label>Your Full Name<em>*</em></label>
            <input type="text" class="form-control" name="fullname" >
        </div>
        <div class="form-group">
            <label>Your Contact No<em>*</em></label>
            <input type="text" class="form-control" name="contact" >
        </div>
        <div class="form-group">
            <label>Email address<em>*</em></label>
            <input type="email" class="form-control" name="email" >
        </div>
        <div class="form-group">
            <label>Message<em>*</em></label>
            <textarea name="message" class="form-control" rows="5"></textarea>
        </div>

        <div class="form-group">
            <div class="g-recaptcha" data-sitekey="6Lf0rREUAAAAAO5M0da7ZHf9Qu9r9vhSV_K8Fza6"></div>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-danger" value="Submit">
          <div class="loading hide">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
    </div>

    <input type="hidden" name="_token" class="token" value="{{csrf_token()}}">
    <input type="hidden" name="dateprice" class="dateprice" value="">

</form> 

</div>


</div>

</div>
</div>
</div>
<!-- end of modal -->

<div class="package package-style-2 text-center">
    <div class="row">                   
        <div class="col-md-12 col-sm-12">
            <a href="#" class="btn btn-default btn-enquiry">ENQUIRY</a>
            <!-- <a href="{{url('package/'.$package->slug.'/booking-step1')}}" class="btn btn-default">BOOK NOW</a>-->
            <p>{!! $package->short_desc2 !!}</p>
            <!-- <p> 
                This tour spends 3 nights in standard hotels and 12 nights in <br />mountain lodges (teahouses). 
            </p> -->
        </div>
    </div>
</div>
</div>

</div>

<!--
<div class="package-review">

    <div class="review-page-title">
        <div class="row">
            <div class="col-md-12">
                <h2 class="pull-left">Review</h2>
                <a href="#" class="pull-right">Write Review</a>
            </div>

        </div>
    </div>

    <div class="review-rating-block">
        <div class="row">
            <div class="col-md-8 col-sm-8 rating">
                <h5 class="pull-left">Overall Score</h5>
                <span class="pull-left">                                    
                    <img src="{{asset('images/new/icon~star.png')}}" alt="">
                    <img src="{{asset('images/new/icon~star.png')}}" alt="">
                    <img src="{{asset('images/new/icon~star.png')}}" alt="">
                    <img src="{{asset('images/new/icon~star.png')}}" alt="">
                    <img src="{{asset('images/new/icon~star.png')}}" alt="">

                </span>
            </div>
            <div class="col-md-4 col-sm-4 text-right">
                <h5>Total Review : <span>16</span></h5>
            </div>
        </div>
    </div>  

    <div class="package-review-list">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="thumbnail">
                    <h2>classic everest</h2>
                    <span class="stars">                                    
                        <img src="{{asset('images/new/icon~star.png')}}" alt="">
                        <img src="{{asset('images/new/icon~star.png')}}" alt="">
                        <img src="{{asset('images/new/icon~star.png')}}" alt="">
                        <img src="{{asset('images/new/icon~star.png')}}" alt="">
                        <img src="{{asset('images/new/icon~star.png')}}" alt="">
                        
                    </span>
                    <div class="auth-wrap"> 
                        <div class="user-info">
                            <h3 class="user">Andrew Smith</h3>
                            <h4 class="user-country">USA</h3>
                            </div>  
                            <div class="date">  
                                <p>Written on July 2016</p>
                            </div>
                        </div>
                        <div class="review-desc">
                            <p>
                                For many people trekking in the Himalayas can be very strenuous because of the high altitude. Other reasons may be time constraints. This does not mean that you cannot see the Himalayas, the Sherpa culture, the fluttering prayer flags, mani's and prayer stone walls at close range. This Glimpse of Everest trek would be ideal for such visitors.
                            </p>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="thumbnail">
                        <h2>classic everest</h2>
                        <span class="stars">                                    
                            <img src="{{asset('images/new/icon~star.png')}}" alt="">
                            <img src="{{asset('images/new/icon~star.png')}}" alt="">
                            <img src="{{asset('images/new/icon~star.png')}}" alt="">
                            <img src="{{asset('images/new/icon~star.png')}}" alt="">
                            <img src="{{asset('images/new/icon~star.png')}}" alt="">

                        </span>
                        <div class="auth-wrap"> 
                            <div class="user-info">
                                <h3 class="user">Andrew Smith</h3>
                                <h4 class="user-country">USA</h3>
                                </div>  
                                <div class="date">  
                                    <p>Written on July 2016</p>
                                </div>
                            </div>
                            <div class="review-desc">
                                <p>
                                    For many people trekking in the Himalayas can be very strenuous because of the high altitude. Other reasons may be time constraints. This does not mean that you cannot see the Himalayas, the Sherpa culture, the fluttering prayer flags, mani's and prayer stone walls at close range. This Glimpse of Everest trek would be ideal for such visitors.
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="thumbnail">
                            <h2>classic everest</h2>
                            <span class="stars">                                    
                                <img src="{{asset('images/new/icon~star.png')}}" alt="">
                                <img src="{{asset('images/new/icon~star.png')}}" alt="">
                                <img src="{{asset('images/new/icon~star.png')}}" alt="">
                                <img src="{{asset('images/new/icon~star.png')}}" alt="">
                                <img src="{{asset('images/new/icon~star.png')}}" alt="">

                            </span>
                            <div class="auth-wrap"> 
                                <div class="user-info">
                                    <h3 class="user">Andrew Smith</h3>
                                    <h4 class="user-country">USA</h3>
                                    </div>  
                                    <div class="date">  
                                        <p>Written on July 2016</p>
                                    </div>
                                </div>
                                <div class="review-desc">
                                    <p>
                                        For many people trekking in the Himalayas can be very strenuous because of the high altitude. Other reasons may be time constraints. This does not mean that you cannot see the Himalayas, the Sherpa culture, the fluttering prayer flags, mani's and prayer stone walls at close range. This Glimpse of Everest trek would be ideal for such visitors.
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="thumbnail">
                                <h2>classic everest</h2>
                                <span class="stars">                                    
                                    <img src="{{asset('images/new/icon~star.png')}}" alt="">
                                    <img src="{{asset('images/new/icon~star.png')}}" alt="">
                                    <img src="{{asset('images/new/icon~star.png')}}" alt="">
                                    <img src="{{asset('images/new/icon~star.png')}}" alt="">
                                    <img src="{{asset('images/new/icon~star.png')}}" alt="">

                                </span>
                                <div class="auth-wrap"> 
                                    <div class="user-info">
                                        <h3 class="user">Andrew Smith</h3>
                                        <h4 class="user-country">USA</h3>
                                        </div>  
                                        <div class="date">  
                                            <p>Written on July 2016</p>
                                        </div>
                                    </div>
                                    <div class="review-desc">
                                        <p>
                                            For many people trekking in the Himalayas can be very strenuous because of the high altitude. Other reasons may be time constraints. This does not mean that you cannot see the Himalayas, the Sherpa culture, the fluttering prayer flags, mani's and prayer stone walls at close range. This Glimpse of Everest trek would be ideal for such visitors.
                                        </p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  -->

                </div>
            </div>
        </div><!--Container -->

        <div class="divider"></div>
        @include('frontend.includes.new.essential')


        <?php $video = \DB::table('p_videos')->where('pages_id', 'LIKE', '%' . $page->id . '%')->get(); ?>

        <?php
        foreach ($video as $v) {
            $link = parse_vimeo($v->video);
            $video_link = "http://player.vimeo.com/video/" . $link;
            ?>

            <div class="video">

                <iframe src=" {{$video_link}}" height="100%" width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

            </div>
            <!-- <div class="divider"></div> -->
            <?php } ?>


            @include('frontend.includes.new.members')

        </div>
        <script>


            $(document).ready(function () {
                $('.readmore').click(function () {
                    $('.short_content').css('height','auto');
                    $(this).hide();
                });

                 // var height1 = $('.accomodationHeight').height();
                 // var height2 = $('.expertHeight').height();
                 // if (height1 >= height2) {
                 //    $('.expertHeight').height(height1);
                 // }else{
                 //    $('.accomodationHeight').height(height2);
                 // }
                 // alert(height1 + ' '+ height2);
             });



            $(document).ready(function(){

                $('html, body').animate({
       //scrollTop: $('.alert').offset().top
   }, 200);

            });

        </script>

        <script>

            $(document).ready(function(){
                var success_id = $('#successMessage');
                if(!success_id.length){
                    return;
                }
                $('html, body').animate({
                 scrollTop: success_id.offset().top
             }, 2000);

            });




              //   var text = $('#complete'),
              //   btn = $('#more'),
              //   h = text[0].scrollHeight; 

              //   if(h > 120) {
              //       btn.addClass('less');

              //   }

              //   btn.click(function(e) 
              //   {
              //     e.stopPropagation();

              //     if (btn.hasClass('less')) {
              //         btn.removeClass('less');
              //         btn.addClass('more');
              //         btn.text('Show less');

              //         text.animate({'height': h});
              //     } else {
              //         btn.addClass('less');
              //         btn.removeClass('more');
              //         btn.text('Show more');
              //         text.animate({'height': '200px'});
              //     }  
              // });

</script>

<script>
    var lat = '@if(!empty($package->latitude)){{ $package->latitude}} @endif';
    var lon = '@if(!empty($package->longitude)){{ $package->longitude}} @endif';
    var address = '@if(!empty($package->map_address)){{ $package->map_address}} @endif';
    $(document).ready(function(){

        var test =$('.map .panel-body').height();
        $('.map-area').css('height', test);
    // alert(test);
// var lat= 27.679644,
// var lat= $('.lat').val()
// var lon= 85.3214,
// var lon= $('.lon').val()
// var address= address
map = new GMaps({
  div: '#map',
  zoom: 18,
  lat: lat,
  // lat: 27.699440,
  lng: lon,
  // lng: 85.312533,
});
map.addMarker({
    // lat: 27.699440,
    lat: lat,
  // lng: 85.312533,
  lng: lon,
  title: address
});
});
</script>

<script>
    $(window).load(function() {
  // The slider being synced must be initialized first
  $('#carousel').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    // itemWidth: 210,
    itemWidth: 180,
    itemMargin: 5,
    asNavFor: '#slider'
});

  $('#slider').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    sync: "#carousel"
});
});

</script>


@stop

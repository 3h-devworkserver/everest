@extends('frontend.layouts.master-new')
@section('title'){{ $meta_title }}@endsection
<!--@section('meta_title'){{ $meta_title }}@endsection-->
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection

@section('extra')
    <link rel="stylesheet" href="{{asset('flexslider/flexslider.css')}}">
@endsection

@section('extra-btm')
<script type="text/javascript" src="{{asset('flexslider/jquery.flexslider.js')}}"></script>
@endsection



@section('content')

<?php 
    $date1 = new DateTime('2017-02-5');
    $date2 = new DateTime('2017-03-14');
    $now = new DateTime();
$valen = 'false';
    if( ($date1 <= $now) && ($date2 >= $now)  ){
        $valen = 'true';
    }

 ?>

<section class="banner" style="background-image: url({{asset('images/valentines.jpg')}});">
    {{-- <div class="container"></div> --}}
</section>
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
        <!-- <div class="valentine-banner">
        	<div class="row">
        	<div class="col-md-12">
        		<img src="{{asset('images/valentines.jpg')}}" alt="Valentine's Special">
        	</div>
        	</div>
        </div> -->
        <div class="package">
            <div class="row">
                <div class="col-md-5 col-sm-7">
                    <p>@if($package->duration != 0 ){{($package->duration)-1}} NIGHTS/ @endif{{$package->duration}} DAYS</p>
                    <h3>NPR {{$package->price}} <small>PER COUPLE</small></h3>
                </div>
                <div class="col-md-7 col-sm-5 btn-box">
                @if($valentinesShow == 'true')
                <a class="btn btn-default btn-enquiry" data-toggle="modal" data-target="#valentine-promo">GET YOUR PROMO CODE</a>
                @endif

                @if($valentinesShow == 'true')
                  @if($valen == 'false')
                  <a class="btn btn-default" data-toggle="modal" data-target="#valentine-promo">BOOK NOW</a>
                  @else
                    <a href="{{url('package/'.$package->slug.'/'.$package->datesPrices[0]->id.'/valentines-booking')}}" class="btn btn-default" @if($valentinesShow == 'false') disabled @endif>BOOK NOW</a>
                  @endif
               @endif
                </div>
            </div>
        </div>


      @if($valentinesShow == 'false')
        <div class="bookingClose">
            <div class="alert alert-danger">
                All the packages are sold out.
            </div>
        </div>
      @else
      <div class="packageCount">
            <h3>
                ONLY {{14 - $count}} SEAT LEFT
            </h3>
        </div>
      @endif

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
   <div class="package-detail valentines">     
        @if( (!empty($package->short_desc)) || (!empty(count($package->optionsAccomodation))) )
            <div class="package-block package-short-info">
                <div class="row">
                @if(!empty($package->short_desc))
                    <div class="col-md-7 col-sm-8">
                        <div class="row">
                        {!! $package->short_desc  !!}
                        </div>
                    </div>
                @endif
                @if(!empty(count($package->optionsAccomodation)))
        <div class="col-md-5 col-sm-4 package-full-desc">
             <div class="further-detail"> 
            <div class="panel panel-default">
              <div class="panel-heading">
                <!-- <h2>Accommodation details</h2>  -->
                <h2>{{$package->optionsAccomodation[0]->type_name}}</h2>
            </div>
            <div class="panel-body">
                <h5>{{$package->optionsAccomodation[0]->name}}</h5>
                {!! $package->optionsAccomodation[0]->content !!}

            </div>
       </div> 
    </div>
   </div>  
    @endif
       
</div>
</div>
@endif

{{-- @if( (!empty($package->long_desc)) || (!empty($package->map_image)) || ((!empty($package->latitude)) && (!empty($package->longitude))) || (!empty(count($package->itinerarys))) || (!empty(($package->galleryLists))) || (!empty(count($package->optionsAccomodation))) || (!empty(count($package->optionsExpert))) || (count($package->datesPrices) != 0 ) ) --}}

<div class="package-block package-full-desc">
@if( (!empty($package->long_desc)) )
    <div class="row">
        <div class="col-md-12 col-sm-12">
        {!! $package->long_desc !!}
        </div>
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
            if($i++ >=6){
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
    @if((count($package->galleryLists)) > 6)
    <a class="btn btn-default" data-id ="{{$package->id}}" id ="add-lists">MORE PICS <i aria-hidden="true" class="fa fa-angle-down"></i></a>
    @endif
</div>
@endif

 @if($valentinesShow == 'true')
<div class="package package-style-2 text-center">
    <div class="row">                   
        <div class="col-md-12 col-sm-12">
        @if($valentinesShow == 'true')
            <a href="#" class="btn btn-default btn-enquiry" data-toggle="modal" data-target="#valentine-promo">Get Your Promo Code</a>
        @endif

      @if($valentinesShow == 'true')
          @if($valen == 'false')
          <a class="btn btn-default" data-toggle="modal" data-target="#valentine-promo">BOOK NOW</a>
          @else
            <a href="{{url('package/'.$package->slug.'/'.$package->datesPrices[0]->id.'/valentines-booking')}}" class="btn btn-default" @if($valentinesShow == 'false') disabled @endif>Book Now</a>
          @endif
        @endif
           <!-- <a href="{{url('package/'.$package->slug.'/booking-step1')}}" class="btn btn-default">BOOK NOW</a>-->
           <!-- <p> 
                This tour spends 3 nights in standard hotels and 12 nights in <br />mountain lodges (teahouses).
            </p> -->
        </div>
    </div>
</div>
@endif

</div>
</div>

</div>


                </div>
                </div>
            </div><!--Container -->

            <div class="divider"></div>
            @include('frontend.includes.essential')


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


                {{-- @include('frontend.includes.new.members') --}}

            </div>
            <script>


                $(document).ready(function () {
                    $('.readmore').click(function () {
                        $('.short_content').css('height','auto');
                        $(this).hide();
                    });
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

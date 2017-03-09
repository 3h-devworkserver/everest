@extends('frontend.layouts.master-new')
@section('title'){{ $title }}@endsection
@section('meta_title'){{ $meta_title }}@endsection
<!--@section('meta_title'){{ $meta_title }}@endsection-->
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection
@section('content')
<section class="banner bg-wrap {!! $page->image !!}" style="background-image: url({!! url().'/images/'.$page->image !!});">
    <div class="container"></div>
</section>
{{-- @include('frontend.includes.region') --}}
@include('frontend.includes.new.search')
<div class="main-content">
    <div class="container">
        <?php
        echo list_breadcrumbs($page->slug, $page->title);
        ?>


<div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="feature-content">
                        <div class="page-header bold_page-header">
                            <h2>{{$page->title}}</h2>
                        </div>

                        <?php
                        $content_length = strlen($page->content);
                        if ($content_length > 500) {
                            //echo '<div class="short_content" style="height:200px;overflow:hidden">';
                            echo '<div  id="complete" style="height:200px;overflow:hidden">';
                            echo $page->content;
                            echo '</div>';

                            ?> 
                             <a href="#" class="btn btn-default" id="more">read more <i class="fa fa-angle-down" aria-hidden="true"></i></a>                       
                            <?php
                        } else {
                            ?>
                            <div class="full_content">
                                <?php 
                                echo '<p style="text-align: justify;">';
                            echo $page->content;
                            echo '</p>';

                                ?>
                            </div>
                            <?php
                        }
                        ?>    

                        
                        <!-- <p>The Himalayas are a complex skein of ranges and probably the mightiest geographical feature on the surface of the earth. With more than a hundred peaks 7000m above sea level and about twenty peaks reaching almost 8000m are higher than the highest mountains in the rest of the world. The Himalayan mass which is about 3200 km long and 480m wide has successive ranges are steeped up and the highest peaks tend to be the furthest and appear to be dwarfed by smaller peaks. In the midst of all these mountains lies the mighty Everest.</p>
                        <a href="#" class="btn btn-default">read more <i class="fa fa-angle-down" aria-hidden="true"></i></a> -->
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="share_and_adds text-right">
                @include('frontend.includes.sharethis')
                    
                        <!-- <ul class="social-icon">
                            <li>
                                <p>SHARE</p>
                            </li>
                            <li>
                                <a class="fb" href="#">
                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                </a>
                            </li>

                            <li>
                                <a class="twitter" href="#">
                                    <i class="fa fa-twitter" aria-hidden="true"></i>
                                </a>
                            </li>

                            <li>
                                <a class="instagram" href="#">
                                    <i class="fa fa-instagram" aria-hidden="true"></i>
                                </a>
                            </li>

                            <li>
                                <a class="pinterest" href="#">
                                    <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                                </a>
                            </li>

                            <li>
                                <a class="envelope" href="#">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul> -->

                        <!-- <div class="adds">
                            <img src="images/inside_ad_yeti.jpg" alt="">
                            <p>Advertisement</p>
                        </div>-->

                        <!-- <div class="anchor text-left">
                            <ul>
                                <li><a href="#nuptse">Nuptse</a></li>
                                <li><a href="#makalu"> Makalu</a></li>
                                <li><a href="#chooyu">Cho Oyu</a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>

        
        <div class="feature-wrap trekking-pricing">
                <div class="row">
                @if(!empty($packages))
                @foreach($packages as $package)
                    @if($package->status == 1)
                    <div class="col-md-4 col-sm-4">
                        <a href="{{url('/package/'.$package->slug)}}" class="feature-box bg-wrap" style="background-image: url({{asset('images/packages-new/'.$package->feat_img)}});">
                            <div class="description">
                                <div>
                                    <h4>{{$package->title}}</h4>
                                    <p class="days"> <span>10 Nights</span><span>11 Days</span></p>
                                    <p class="price">${{$package->price}}</p>
                                </div>
                            </div>
                            <div class="mask"></div>
                        </a>
                    </div>
                    @endif
                @endforeach
                @endif

                   <!--  <div class="col-md-4 col-sm-4">
                        <a href="#" class="feature-box bg-wrap" style="background-image: url('images/inside_everest_trekking_small_1.jpg');">
                            <div class="description">
                                <div>
                                    <h4>clasic everest</h4>
                                    <p class="days"> <span>10 Nights</span><span>11 Days</span></p>
                                    <p class="price">$1210</p>
                                </div>
                            </div>
                            <div class="mask"></div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <a href="#" class="feature-box bg-wrap" style="background-image: url('images/inside_everest_trekking_small_1.jpg');">
                            <div class="description">
                                <div>
                                    <h4>clasic everest</h4>
                                    <p class="days"> <span>10 Nights</span><span>11 Days</span></p>
                                    <p class="price">$1210</p>
                                </div>
                            </div>
                            <div class="mask"></div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <a href="#" class="feature-box bg-wrap" style="background-image: url('images/inside_everest_trekking_small_1.jpg');">
                            <div class="description">
                                <div>
                                    <h4>clasic everest</h4>
                                    <p class="days"> <span>10 Nights</span><span>11 Days</span></p>
                                    <p class="price">$1210</p>
                                </div>
                            </div>
                            <div class="mask"></div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <a href="#" class="feature-box bg-wrap" style="background-image: url('images/inside_everest_trekking_small_1.jpg');">
                            <div class="description">
                                <div>
                                    <h4>clasic everest</h4>
                                    <p class="days"> <span>10 Nights</span><span>11 Days</span></p>
                                    <p class="price">$1210</p>
                                </div>
                            </div>
                            <div class="mask"></div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <a href="#" class="feature-box bg-wrap" style="background-image: url('images/inside_everest_trekking_small_1.jpg');">
                            <div class="description">
                                <div>
                                    <h4>clasic everest</h4>
                                    <p class="days"> <span>10 Nights</span><span>11 Days</span></p>
                                    <p class="price">$1210</p>
                                </div>
                            </div>
                            <div class="mask"></div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <a href="#" class="feature-box bg-wrap" style="background-image: url('images/inside_everest_trekking_small_1.jpg');">
                            <div class="description">
                                <div>
                                    <h4>clasic everest</h4>
                                    <p class="days"> <span>10 Nights</span><span>11 Days</span></p>
                                    <p class="price">$1210</p>
                                </div>
                            </div>
                            <div class="mask"></div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <a href="#" class="feature-box bg-wrap" style="background-image: url('images/inside_everest_trekking_small_1.jpg');">
                            <div class="description">
                                <div>
                                    <h4>clasic everest</h4>
                                    <p class="days"> <span>10 Nights</span><span>11 Days</span></p>
                                    <p class="price">$1210</p>
                                </div>
                            </div>
                            <div class="mask"></div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <a href="#" class="feature-box bg-wrap" style="background-image: url('images/inside_everest_trekking_small_1.jpg');">
                            <div class="description">
                                <div>
                                    <h4>clasic everest</h4>
                                    <p class="days"> <span>10 Nights</span><span>11 Days</span></p>
                                    <p class="price">$1210</p>
                                </div>
                            </div>
                            <div class="mask"></div>
                        </a>
                    </div> -->

                </div>
            </div>  


        @if(!empty($static))
        <div class="feature-wrap">
            <div class="row">
                @foreach($static as $data)
                @if($data->title !== 'essential' && $data->title !== 'video')
                <div class="col-md-4 col-sm-4">
                    <a class="feature-box bg-wrap" style="background-image: url({!! url().'/images/staticimages/'.$data->image !!});" href="{{URL::to('/'.$data->url)}}">
                        <div class="description">
                            <div>
                                <h4>{!! $data->title !!}</h4>
                                {!! $data->content !!}
                            </div>
                        </div>
                        <div class="mask"></div>
                    </a>
                </div>
                @else
                <div class="col-md-12 col-sm-12">
                    {!! $data->content !!}
                </div>
                @endif

                @endforeach
            </div>
        </div>
        @endif
    </div>

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
      <div class="divider"></div>
    <?php } ?>
   
   
@include('frontend.includes.new.members')
   
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

    


    var text = $('#complete'),
     btn = $('#more'),
       h = text[0].scrollHeight; 

if(h > 120) {
    btn.addClass('less');
    
}

btn.click(function(e) 
{
  e.stopPropagation();

  if (btn.hasClass('less')) {
      btn.removeClass('less');
      btn.addClass('more');
      btn.text('Show less');

      text.animate({'height': h});
  } else {
      btn.addClass('less');
      btn.removeClass('more');
      btn.text('Show more');
      text.animate({'height': '200px'});
  }  
});

</script>


@stop

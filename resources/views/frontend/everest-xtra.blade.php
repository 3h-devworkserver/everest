@extends('frontend.layouts.master-new')
@section('title'){{ $meta_title }}@endsection
<!--@section('meta_title'){{ $meta_title }}@endsection-->
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection
@section('content')
<section class="banner bg-wrap {!! $page->image !!}" style="background-image: url({!! url().'/images/'.$page->image !!});">
    <div class="container"></div>
</section>
@include('frontend.includes.region')
<div class="main-content">
    <div class="container">
        <?php
        echo list_breadcrumbs($page->slug, $page->title);
        ?>
        <!-- row start -->
        <div class="row">
        <?php
        $advs = \DB::table('page_ads')->where('pages_id', 'like', '%' . $page->id . '%')->get();         

        $contentClass = 'col-md-12 col-sm-12';

        if (!empty($advs)){
            $contentClass = 'col-md-12 col-sm-12';
        }

        // die('am here');
        ?> 
            <div class="col-md-8 col-sm-8">
                <div class="feature-content">
                    <div class="page-header bold_page-header">
                    <h2>{{$page->title}}</h2>
                    </div>
                   
                    <div class="<?= $contentClass ?>">
                        <div class="full_content">
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


                    </div>                         

                </div>               
                
                <?php
                if ($advs) {
                    ?>
                    <div class="col-md-4 col-sm-4">
                        <!--ads-->
                        <p>Advertisement</p>

                        <?php
                        foreach ($advs as $row) {
                            ?>
                            <div class="adds">
                                <a href="<?= $row->link ?>" target="_blank">
                                    <img src="<?= url() . '/images/' . $row->ads ?>" alt="">
                                </a>

                            </div>

                            <?php
                        }
                        ?>


                    </div>
                <?php } ?>    
                   
                   
                    </div>                

            </div>
            <div class="col-md-4 col-sm-4">
                <!--socila icons-->

                @include('frontend.includes.sharethis')
            </div>

        </div><!-- row end -->
        
        <div class="feature-content">

            
         
         <?php if ($page->slug == 'talk-to-everest-summitters') { ?>
                
            
                
                    @if (count($errors) > 0)
                    <div class="alert messages alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    
                    @if(Session::has('message'))
                    
                        
                    <p id="successMessage" class="alert messages {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif


                    <div class="contact-form inner">

                        <form action="{{url()}}/submitContact" method="post">

                            <div class="row">

                                <div class="col-md-6 col-sm-6">

                                    <div class="form-group">

                                        <input type="text" class="form-control" placeholder="Name" name="name" />

                                    </div>

                                    <div class="form-group">

                                        <input type="Email" class="form-control" placeholder="Email" name="email" />

                                    </div>
                                    
                                    <div class="form-group">

                                        <input type="text" class="form-control" placeholder="Nationality" name="nationality" />

                                    </div>

                                    <div class="form-group">

                                        <input type="text" class="form-control" placeholder="Contact No." name="contactno" />

                                    </div>
                        </div>
                                <input type="hidden" name="pageheading" value="{{$page->title}}">
                        <div class="col-md-6 col-sm-6">
                           <div class="form-group text-area">
                              <textarea class="form-control" placeholder="Message" name="message"></textarea>
                           </div>
                           <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        </div>

                        <div class="col-md-6 col-sm-6 captcha">
                              {!! app('captcha')->display(); !!}
                        </div>
                        <div class="col-md-6 col-sm-6">
                           <button type="submit" class="btn btn-default">Send</button>
                        </div>

                            </div>

                        </form>

                    </div>

                <?php } ?>
            
                    <?php if ($page->slug == 'talk-to-himalayan-rider') { ?>
                
                
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    
                    @if(Session::has('message'))
                    <p id="successMessage" class="alert messages {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif


                    <div class="contact-form inner">

                        <form action="{{url()}}/submitContact" method="post">

                            <div class="row">

                                <div class="col-md-6 col-sm-6">

                                    <div class="form-group">

                                        <input type="text" class="form-control" placeholder="Name" name="name" />

                                    </div>

                                    <div class="form-group">

                                        <input type="Email" class="form-control" placeholder="Email" name="email" />

                                    </div>
                                    
                                    <div class="form-group">

                                        <input type="text" class="form-control" placeholder="Nationality" name="nationality" />

                                    </div>

                                    <div class="form-group">

                                        <input type="text" class="form-control" placeholder="Contact No." name="contactno" />

                                    </div>
                        </div>
                                <input type="hidden" name="pageheading" value="{{$page->title}}">
                        <div class="col-md-6 col-sm-6">
                           <div class="form-group text-area">
                              <textarea class="form-control" placeholder="Message" name="message"></textarea>
                           </div>
                           <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        </div>

                        <div class="col-md-6 col-sm-6 captcha">
                              {!! app('captcha')->display(); !!}
                        </div>
                        <div class="col-md-6 col-sm-6">
                           <button type="submit" class="btn btn-default">Send</button>
                        </div>

                            </div>

                        </form>

                    </div>

                <?php } ?>
            <!-- form integration -->
            <?php if ($page->slug == 'talk-to-jerome-edou') { ?>
                
                
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    
                    @if(Session::has('message'))
                    <p id="successMessage" class="alert messages {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    
                    <div class="contact-form inner">

                        <form action="{{url()}}/submitContact" method="post">

                            <div class="row">

                                <div class="col-md-6 col-sm-6">

                                    <div class="form-group">

                                        <input type="text" class="form-control" placeholder="Name" name="name" />

                                    </div>

                                    <div class="form-group">

                                        <input type="Email" class="form-control" placeholder="Email" name="email" />

                                    </div>
                                    
                                    <div class="form-group">

                                        <input type="text" class="form-control" placeholder="Nationality" name="nationality" />

                                    </div>

                                    <div class="form-group">

                                        <input type="text" class="form-control" placeholder="Contact No." name="contactno" />

                                    </div>
                        </div>
                                <input type="hidden" name="pageheading" value="{{$page->title}}">
                        <div class="col-md-6 col-sm-6">
                           <div class="form-group text-area">
                              <textarea class="form-control" placeholder="Message" name="message"></textarea>
                           </div>
                           <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        </div>

                        <div class="col-md-6 col-sm-6 captcha">
                              {!! app('captcha')->display(); !!}
                        </div>
                        <div class="col-md-6 col-sm-6">
                           <button type="submit" class="btn btn-default">Send</button>
                        </div>

                            </div>

                        </form>

                    </div>

                <?php } ?>

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
   
   
   @include('frontend.includes.essential')
   
   
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

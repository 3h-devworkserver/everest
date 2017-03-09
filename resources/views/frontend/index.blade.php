    @extends('frontend.layouts.master-new')
    @section('title'){{ $meta_title }}@endsection
    <!--@section('meta_title'){{ $meta_title }}@endsection-->
    @section('meta_keywords'){{ $meta_keywords }}@endsection
    @section('meta_desc'){{ $meta_desc }}@endsection

    @section('loader')
    @include('frontend.includes.new.loader')
    @endsection

    @section('banner')
    @include('frontend.includes.banner')
    @stop
    @section('content')
    @include('frontend.includes.new.region')
    <section class="main-content">

    @include('frontend.includes.new.searchform')


                @foreach($page as $p)
                <div class="container">


                    <div class="about">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="about-text">
                                    <h1>{{$p->title}}</h1>
                                    <p>{!! $p->content !!}</p>
                                    <a class="btn btn-primary" href="{{url().'/'.$p->slug}}">
                                        <span class="dots"></span>
                                        <span class="dots"></span>
                                        <span class="dots"></span>
                                        more
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="feature-img bg-wrap" style="background-image: url('{{url()}}/images/{{$p->image}}');"> </div>
                            </div>
                        </div>
                    </div>

                    <div class="exploure">
                        <div class="page-header">
                            <h2>Explore the Adventure</h2>
                        </div>
                        <div class="exploure-content">
                            <div class="row">
                                <?php
                                $statBlock = \DB::table('static_blocks')->where('pid', $p->id)->where('position', 'top')->get();
                                $counter = 1;
                                foreach ($statBlock as $data) {
                                    $col_num = ($counter == 1 || $counter == 10) ? '8' : '4';
                                    ?>
                                    <a href="{{$data->url}}">
                                        <!--{!! $data->content !!}-->
                                        <div class="col-md-{{$col_num}} col-sm-{{$col_num}}">
                                            <div class="feature-box bg-wrap" style="background-image: url('{{url()}}/images/staticimages/{{$data->image}}');">
                                                <div class="description">
                                                    <div>
                                                        <h4>{{$data->title}}</h4>
                                                        <p>{!! $data->content !!}</p>
                                                    </div>
                                                </div>
                                                <div class="mask"> </div>
                                            </div>
                                        </div>

                                    </a>
                                    <?php
                                    $counter++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $video = \DB::table('p_videos')->where('pages_id', 'LIKE', '%' . $p->id . '%')->get();
                ?>

                <?php
                foreach ($video as $v) {
                    $link = parse_vimeo($v->video);
                    $video_link = "http://player.vimeo.com/video/" . $link;
                    ?>

                    <div class="video">

                        <iframe src=" {{$video_link}}" height="100%" width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

                    </div>
                    <?php } ?>
                    <div class="container">
                        <div class="post">
                            <div class="row">
                                <?php
                                $statBlockBottom = \DB::table('static_blocks')->where('pid', $p->id)->where('position', 'bottom')->get();

                                foreach ($statBlockBottom as $data) {
                                    ?>

                                    <div class="col-sm-4 col-md-4">
                                        <div class="thumbnail">
                                            <a  href="{{url()}}/{{$data->url}}"><div class="bg-wrap" style="background-image: url({{url()}}/images/staticimages/{{$data->image}});"></div></a>
                                            <!-- <img src="images/home_body_small_6.jpg" alt="..."> -->
                                            <div class="caption">
                                                <h3><a  href="{{url()}}/{{$data->url}}">{{$data->title}}</a></h3>
                                <?php 
                                        $content_length = strlen($data->content);
                                        if ($content_length <= 370) {
                                ?> 
                                                <p>{!! $data->content !!}</p>
                                <?php }else{
                                    ?>
                                                <p> {!! substr($data->content, 0, 370) !!}.. </p>
                                                <p></p>
                                <?php } ?> 
                                                <a class="btn btn-primary" href="{{url()}}/{{$data->url}}">
                                                    <span class="dots"></span>
                                                    <span class="dots"></span>
                                                    <span class="dots"></span>
                                                    more
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    @include('frontend.includes.new.essential')
                    @endforeach
                    @include('frontend.includes.new.members')
                </section>
                @stop
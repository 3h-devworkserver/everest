@extends('frontend.layouts.master-new')
@section('title'){{ $meta_title }}@endsection
<!--@section('meta_title'){{ $meta_title }}@endsection-->
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection
@section('content')

<script>

    $(document).ready(function () {
        var showValue = 50;
        var trs = $('#summittersTbody tr');
        var trsLength = trs.length;
        //console.log(trsLength);
        var currentIndex = showValue;

        $("#submitterName,#sumitterCountry,#sumitterYear").bind('keyup', function () {

            var name = $('#submitterName').val();
            var country = $('#sumitterCountry').val();
            var year = $('#sumitterYear').val();
            $.post('<?= url() ?>/search/summitteers',
                    {"_token": "{{ csrf_token() }}", name: name, country: country, date: year},
                    function (data) {
                        $('#summittersTbody').html(data);
                        trs = $('#summittersTbody tr');
                        trsLength = trs.length;
                        currentIndex = showValue;
                        trs.hide();
                        trs.slice(0, showValue).show();
                        checkButton();
                    });
        });




        var btnMore = $("#seeMoreRecords");
        var btnLess = $("#seeLessRecords");

        trs.hide();
        trs.slice(0, showValue).show();
        checkButton();

        btnMore.click(function (e) {
            e.preventDefault();
            $("#summittersTbody tr").slice(currentIndex, currentIndex + 50).show();
            currentIndex += showValue;
            checkButton();
        });

        btnLess.click(function (e) {
            e.preventDefault();
            $("#summittersTbody tr").slice(currentIndex - 10, currentIndex).hide();
            currentIndex -= showValue;
            checkButton();
        });

        function checkButton() {
            var currentLength = $("#summittersTbody tr:visible").length;

            if (currentLength >= trsLength) {
                btnMore.hide();
            } else {
                btnMore.show();
            }

            if (trsLength > showValue && currentLength > showValue) {
                btnLess.show();
            } else {
                btnLess.hide();
            }

        }


    });




</script>
<section class="banner bg-wrap {!! $page->image !!}" style="background-image: url({!! url().'/images/'.$page->image !!});">
    <div class="container"></div>
</section>
@include('frontend.includes.region')
<div class="main-content">
    <div class="container">
        <?php
        echo list_breadcrumbs($page->slug, $page->title);
        ?>
        <div class="row">

            <div class="col-md-8 col-sm-8">

                <div class="page-header bold_page-header">
                    <h2>{{$page->title}}</h2>
                </div>

            </div>

            <div class="col-md-4 col-sm-8">

                <!--socila icons-->

                @include('frontend.includes.sharethis')

            </div>

        </div>
        <?php
        $advs = \DB::table('page_ads')->where('pages_id', 'like', '%' . $page->id . '%')->get();

        $contentClass = 'col-md-12 col-sm-12';

        if ($advs)
            $contentClass = 'col-md-8 col-sm-8';

        // die('am here');
        ?>
        <div class="feature-content">

            <div class="row">

                <div class="<?= $contentClass ?>">

                    <div class="full_content">

                        <?php
                        $content_length = strlen($page->content);
                        if ($content_length > 1000) {
                            //echo '<div class="short_content" style="height:200px;overflow:hidden">';
                            echo '<div class="">';
                            echo $page->content;
                            echo '</div>';
                            ?>                        
                            <?php
                        } else {
                            ?>
                            <div class="full_content">
                                <?php echo $page->content; ?>
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

        <div class="summitteers-list">


            <div class="list-search">
                <div class="row">
                    <form>
                        <div class="form-group col-md-4 col-sm-4">
                            <input id="submitterName" name="name" value="<?= Input::get('name') ?>" type="text" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group col-md-4 col-sm-4">
                            <input id="sumitterCountry" name="country" value="<?= Input::get('country') ?>" type="text" class="form-control" placeholder="Country">
<!--                            <select id="sumitterCountry" name="country" class="SlectBox form-control" placeholder="this is placeholder">
                            <option selected="selected">Country</option>
                            <option value="Japan">Japan</option>
                            <option value="USA">USA</option>
                            <option value="Poland">Poland</option>
                            <option value="England">England</option>
                            <option value="Nepal">Nepal</option>
                        </select>-->
                        </div>
                        <div class="form-group col-md-2 col-sm-2">
                            <input id="sumitterYear" name="date" value="<?= Input::get('date') ?>" type="text" class="form-control" placeholder="Year">
<!--                            <select id="sumitterYear" name="year" class="SlectBox form-control" placeholder="this is placeholder">
                            <option selected="selected">Year</option>
                            <option value="2016">2016</option>
                            <option value="2015">2015</option>
                            <option value="2014">2014</option>
                            <option value="2013">2013</option>
                        </select>-->
                        </div>
                        <div class="form-group col-md-2 col-sm-2">
                            <button type="submit" class="btn btn-default">Search</button>
                        </div>

                    </form>
                </div>
            </div>
            <table id="">
                <thead>
                    <tr>
                        <th class="name">Name</th>
                        <th class="country">Country</th>
                        <th class="date">Year</th>
                        <th class="route">Route</th>
                        <th class="team">Team Name</th>
                        <th class="leader">Leader</th>
                    </tr>
                </thead>
                <tbody id="summittersTbody">
                    @if(!empty($summitteers))
                    @foreach($summitteers as $sum)
                    <tr>
                        <td class="name">{{$sum->name}}</td>
                        <td class="country">{{$sum->country}}</td>
                        <td class="date">{{$sum->date}}</td>
                        <td class="route">{{$sum->route}}</td>
                        <td class="team">{{$sum->team_name}}</td>
                        <td class="leader">{{$sum->leader}}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <!--
            <input id="seeMoreRecords" type="button" value="More" style="display: inline;">
            <input id="seeLessRecords" type="button" value="Less" style="display: none;">
            <a id="seeLessRecords" class="btn btn-default" href="javascript:;">less <i aria-hidden="true" class="fa fa-angle-up"></i></a>
            -->
            <a id="seeMoreRecords" class="btn btn-default" href="javascript:;">more <i aria-hidden="true" class="fa fa-angle-down"></i></a>
           
            
        </div>
    </div>
    @if(!empty($static))
    @foreach($static as $s)
    {!! $s->content !!}
    @endforeach
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
<?php } ?>
<script>
    $(document).ready(function () {
        $('.readmore').click(function () {
            $('.short_content').css('height', 'auto');
            $(this).hide();
        });
    });

</script>

@stop
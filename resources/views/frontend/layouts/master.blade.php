<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        <meta name="title" content="@yield('meta_title','Upeverest')">
        <meta name="keywords" content="@yield('meta_keywords','Upeverest')">
        <meta name="description" content="@yield('meta_desc','Upeverest')">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta property="og:title" content="@yield('title')" />
        <meta property="og:image" content="@yield('image')" />
        <link href='https://fonts.googleapis.com/css?family=Play:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:800italic,800,700italic,700,600italic,600,400italic,400,300italic,300' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="<?= url() ?>/css/reset.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= url() ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= url() ?>/css/sumoselect.css">
        <link rel="stylesheet" href="<?= url() ?>/css/jquery-ui-1.10.4.custom.css">
        <link rel="stylesheet" type="text/css" href="<?= url() ?>/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?= url() ?>/css/responsive.css">
        <link rel="icon" type="image/png" href="/favicon.png" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
        

        <script><?= url() ?> /
                    var base_url = '{{ URL::to("") }}';
            var full_current_url = '{{ URL::full() }}';
            var current_url = '{{ URL::current() }}';
        </script>
        
        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50928fab7ee84b5b"></script>


    <!-- <script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "e80417cd-1939-4ffb-9b04-0be7bb76833b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

        <!-- GA -->
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-83860320-1', 'auto');
            ga('send', 'pageview');

        </script>

        <!-- end of GA -->

    </head>
    <body class="{{$class}}">

        @if(url::full() != url().'/admin')
        @include('frontend.includes.header')
        @yield('banner')
        @endif

        @yield('content')

        @if(url::full() != url().'/admin')       
        @include('frontend.includes.footer')
        @endif


        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="js/jquery.sumoselect.min.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/bootstrap-tabcollapse.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/function.js"></script>       


        <script>
            $(function () {

                /*$( "#submitterName" ).autocomplete({
                 source: "<?= url() ?>/autocomplete/search",
                 close: function( event, ui ) { //alert( 'am select'+ $( "#submitterName" ).val() );}
                 }); */


            });
        </script>
    <a href="#" id="back-to-top" title="Scroll to Top" class="show">↑</a>
    </body>
</html>

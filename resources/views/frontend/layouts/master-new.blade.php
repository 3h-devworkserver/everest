<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="title" content="@yield('meta_title')">
    <meta name="keywords" content="@yield('meta_keywords')">
    <meta name="description" content="@yield('meta_desc')">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:image" content="@yield('image')" />
    <link href='https://fonts.googleapis.com/css?family=Play:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:800italic,800,700italic,700,600italic,600,400italic,400,300italic,300' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="<?= url() ?>/css/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= url() ?>/colorbox/colorbox.css">
    <link rel="stylesheet" href="<?= url() ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= url() ?>/css/sumoselect.css">
    <link rel="stylesheet" href="<?= url() ?>/css/jquery.steps.css">
    <link href="<?= url() ?>/css/owl.carousel.css" rel="stylesheet">
    <link href="<?= url() ?>/css/owl.theme.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= url() ?>/css/jquery-ui-1.10.4.custom.css">
    <link rel="stylesheet" type="text/css" href="<?= url() ?>/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= url() ?>/css/responsive.css">
    <link rel="icon" type="image/png" href="{{url('/favicon.png')}}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    @yield('extra')

    <script><?= url() ?> /
        var base_url = '{{ URL::to("") }}';
        var full_current_url = '{{ URL::full() }}';
        var current_url = '{{ URL::current() }}';
    </script>

    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50928fab7ee84b5b"></script>


    <!-- <script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "e80417cd-1939-4ffb-9b04-0be7bb76833b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script> -->

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

<?php /* ?>
<!-- CrazyEgg -->
<script type="text/javascript">
    setTimeout(function(){var a=document.createElement("script");
        var b=document.getElementsByTagName("script")[0];
        a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0061/3887.js?"+Math.floor(new Date().getTime()/3600000);
        a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
</script>
<!--  end of CrazyEgg -->
<?php */ ?>

</head>
<body class="{{$class}}">
@yield('loader')
<div class="main">
    @if(url::full() != url().'/admin')
    @include('frontend.includes.new.header')
    @yield('banner')
    @endif

    @yield('content')

    @if(url::full() != url().'/admin')       
    @include('frontend.includes.new.footer')
    @endif


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {!! Html::script('js/jquery.sumoselect.min.js') !!}
    {!! Html::script('js/jquery-ui.min.js') !!}
    {!! Html::script('colorbox/jquery.colorbox.js') !!}
    {!! Html::script('js/bootstrap-tabcollapse.js') !!}
    {!! Html::script('js/owl.carousel.min.js') !!}
    @if(empty($prevValidationJs))
    {!! Html::script('jquery-validation-1.15.0/dist/jquery.validate.js') !!}
    @else
    {!! Html::script('js/jquery.validate.js') !!}
    @endif
    {!! Html::script('js/jquery.steps.min.js') !!}
    @yield('extra-btm')
    <script type="text/javascript">
     $(document).ready(function(){
        $(document).on('submit', '#promoForm', function(event) {
            event.preventDefault();
    // $('.loading').show();

    $.validator.setDefaults({
        errorElement: "span",
        errorClass: "help-block",
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorPlacement: function (error, element) {
        // if (element.parent('.input-group').length || element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
        // if (element.parent('.input-group').length || element.prop('type') === 'checkbox') {
        // error.insertAfter(element.parent());
        // }else if(element.parent('.input-group').length || element.prop('type') === 'radio'){
        //  $('.radio-error').text(error.text());
        //   // error.insertAfter(element);
        // } else {

        //     // if (element.parent('.input-group').length || element.prop('type') === 'email' ) {
        //     //  error.insertAfter(element);
        //     // }
        //     // error.insertAfter(element);
        // // element.attr("placeholder",error.text());
        // }
    }
});

$('#promoForm').validate({
    rules: {
        "fullname": "required",
        "valentine_fullname": "required",
        "contact": "required",
        "email": {
          required: true,
          email: true
      },
  }
});
if($('#promoForm').valid() ){
    var response = grecaptcha.getResponse();

    if(response.length == 0){
    //reCaptcha not verified
    // alert('not verified');
}

else{
    // alert('verified');
    $('.loading').removeClass('hide');
    var _data = $(this).serialize();
    var token = '<?php echo csrf_token();  ?>';
// console.log(_data);
        // $.ajax({
        //     url: base_url + '/admin/access/users',
        //     type: 'POST',
        //     dataType: 'json',
        //     data: _data
        // })

$.ajax({
    url: base_url + '/promocode',
    headers:
    {
       'X-CSRF-Token': token
   },
   method: 'post',
   data: {data: _data},


   success:function(data){
    $('.loading').hide();
        // alert(data);
        $('#promoForm').hide();
        $('.form-wrapper').addClass('form-msg');
        if (data == 'success') {
            // $('#promoForm').trigger('reset');
            $('.form-wrapper').html('<div class="alert alert-success">Please check your email for a Promo Code.<br> Email could be in spam section.</div>');
        }else{
            $('.form-wrapper').html('<div class="alert alert-danger">Sorry, Something went wrong !!</div>');
        }
    }
});


}
                    // alert('submit');
                    // return  false;
                }
            });

});</script>
{!! Html::script('js/more.js') !!}
{!! Html::script('js/function.js') !!}


<script>

    $(function () {

                /*$( "#submitterName" ).autocomplete({
                 source: "<?= url() ?>/autocomplete/search",
                 close: function( event, ui ) { //alert( 'am select'+ $( "#submitterName" ).val() );}
             }); */


});
</script>
<a href="#" id="back-to-top" title="Scroll to Top" class="show">↑</a>
<?php 
$date1 = new DateTime('2017-02-5');
$date2 = new DateTime('2017-03-14');
$now = new DateTime();
$valen = 'false';
if( ($date1 <= $now) && ($date2 >= $now)  ){
    $valen = 'true';
}

?>
<!-- Modal -->
<div class="modal fade" id="valentine-promo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    @if($valen == 'false')
    <div class="modal-dialog" role="document">
        @else
        <div class="modal-dialog modal-lg" role="document">
            @endif
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <div class="modal-body">
                <div class="row-fluid">
                    @if($valen == 'false')
                    <div class="col-md-12 col-sm-12">
                        <div id="nonValidMsg">
                            <div class="alert alert-danger"><p>This package is open to online booking through E-Sewa only on 5-6  February 2017.</p><p> Please visit the page on the specified dates. </p></div>
                        </div> 
                    </div>
                    @else



                    <div class="col-md-6 col-sm-6">
                        <div class="pop-img" style="background-image:url({{asset('images/teddy.jpg')}})">
                        </div>

                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-wrapper form-msg" style="background-image:url({{asset('images/heart.png')}})">

                           <form action="javascript:;" id="promoForm" method="post" name="promoForm">
                              <div class="form-group">
                                <label>Your Full Name<em>*</em></label>
                                <input type="text" class="form-control" name="fullname" >
                            </div>
                            <div class="form-group">
                                <label>Your Valentine’s Full Name<em>*</em></label>
                                <input type="text" class="form-control" name="valentine_fullname" >
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
                                <div class="g-recaptcha" data-sitekey="6Lf0rREUAAAAAO5M0da7ZHf9Qu9r9vhSV_K8Fza6"></div>
                            </div>
                            <div class="form-group">
                              <input type="submit" class="btn btn-danger" value="Generate">
                              <div class="loading hide">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                        </div>

                    </form> 

                </div>

            </div>
            @endif

        </div>
    </div>

</div>
</div>
</div>
</div>
</body>
</html>

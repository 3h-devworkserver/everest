/***  By Yojan      ***/

for (i = new Date().getFullYear(); i > 1900; i--)
{
  $('.yearpicker').append($('<option />').val(i).html(i));
}
for (i = (new Date().getFullYear()- 2), j=1; j <= 11; i--, j++)
{
  $('.childyearpicker').append($('<option />').val(i).html(i));
}
for (i = 1; i < 33; i++)
{
  $('.daypicker').append($('<option />').val(i).html(i));
}

$(document).ready(function(){

  var totalbutton = $('.menu ul li').length;
if (totalbutton == 0) {
  $('.menu').hide();
}

//addition of extrapackage in valentine package and displaying in sidebar
$(document).on('change','.addextraPackage', function(){
  var select = $(this);
  var checkedTitle = $('.addextraPackage').find(":selected").map(function() {
    return $(this).attr('data-title');
  }).get();

  var checkedNo = $('.addextraPackage').find(":selected").map(function() {
    return $(this).attr('data-no');
  }).get();

  var select3 = $('.addextraPackage').find(':selected');
  var selectImg =$(this).closest('.thumbnail');
  var token = $('.token').val();
  var promocode = $('.promocode').val();
  var checkedValues = $('.addextraPackage').find(":selected").map(function() {
    return $(this).attr('data-id');
  }).get();


  var checkedPrices = $('.addextraPackage').find(":selected").map(function() {
    if(this.value != ''){
      return this.value;
    }
  }).get();

  if (select.val()!= '') {
    selectImg.addClass('select-msg');
  }else{
    selectImg.removeClass('select-msg');
  }

  $.ajax({
    url: base_url + '/package/addextpackage' ,
    headers:
    {
     'X-CSRF-Token': token
   },
   method: 'post',
   data: {data: checkedValues, promocode:promocode } ,

   success:function(data){
    if (data['stat'] == 'ok') {
      var amount =0;

      $.each(checkedPrices, function (index, value) {
        amount = amount + parseFloat(value);
      });

        $('.exten-text').removeClass('hide');

        $('.ext').attr('extprice',amount);
        $('.ext').html('NPR '+amount);

        titleText='';
        var i = 0;
        $.each(checkedTitle, function (index, value) {
          if (checkedNo[i] == '1') {
            no = 'single';
          }else if (checkedNo[i] == '2') {
            no='couple';
          }
            titleText = titleText + '<div class="clearfix"><div class="ext-text pull-left"><p>'+checkedTitle[i]+'<br><small>('+no +')</small></p></div><div class="content-text total-passenger-price ext pull-right">NPR '+checkedPrices[i]+'</div></div>';
            i++;
          });
        if (i == 0) {
          $('.exten-text').addClass('hide');
        }

        $('.extension').html('');
        $('.extension').html(titleText);

        var total = $('#total').attr('initial-total');
        $('#total').attr('totalprice',parseFloat(total) + amount);
        $('#total').html('NPR '+(parseFloat(total)+amount));

        //change esewa form values
        var psc = $('#esewaForm input[name=psc]').val();
        $('#esewaForm input[name=tAmt]').val(parseFloat(total)+amount);
        $('#esewaForm input[name=amt]').val((parseFloat(total)+amount) - (parseFloat(psc)) );
      }else{
        $('.promo-error').removeClass('hide');
        $('.promo-error').html(data['msg']);
      }
    }
  });

});

//  var total = $('#total').attr('initial-total');
// $('.totalAmount').val(parseFloat(total));


// addition of addon pacakge on sticky sidebar
$(document).on('change','.addonPackage', function(){
  var select = $(this);

  var selectImg =$(this).closest('.thumbnail');

  if (select.val()!= '') {
    selectImg.addClass('select-msg');
   
  }else{
    selectImg.removeClass('select-msg');
  }

  var checkedTitle = $('.addonPackage').find(":selected").map(function() {
    return $(this).attr('data-title');
  }).get();

  var checkedNo = $('.addonPackage').find(":selected").map(function() {
    return $(this).attr('data-no');
  }).get();

  var checkedPrices = $('.addonPackage').find(":selected").map(function() {
    if(this.value != ''){
      return $(this).attr('data-price');
    }
  }).get();

  var checkedValues = $('.addonPackage').find(":selected").map(function() {
    return $(this).attr('data-id');
  }).get();

  var amount =0;
  $.each(checkedPrices, function (index, value) {
    amount = amount + parseFloat(value);
  });

  $('.exten-text').removeClass('hide');
  $('.ext').attr('extprice',amount);
  $('.ext').html('NPR '+amount);

  titleText='';
        var i = 0;
        $.each(checkedTitle, function (index, value) {
          no = checkedNo[i];
          if (checkedNo[i] == '1') {
            no = checkedNo[i] +' person';
          }else{
            no = checkedNo[i] +' persons';
          }
            titleText = titleText + '<div class="clearfix"><div class="ext-text pull-left"><p>'+checkedTitle[i]+'<br><small>('+no +')</small></p></div><div class="content-text total-passenger-price ext pull-right">NPR '+checkedPrices[i]+'</div></div>';
            i++;
          });

        if (i == 0) {
          $('.exten-text').addClass('hide');
        }

        $('.extension').html('');
        $('.extension').html(titleText);
        $('.extensionText').val(titleText);

        var total = $('#total').attr('initial-total');
        var check = $('#adult').length;
        if(check == 1){
          var no = $('#adult').val();
        }else{
          var no = $('#adult-edit').val();
        }
        var finalAmount = no*parseFloat(total) + amount;
        $('#total').attr('totalprice',finalAmount);
        $('#total').html('NPR '+finalAmount);
        $('.totalAmount').val(finalAmount);
        $('.addonId').val(checkedValues);

});


// $(document).on('click','.addxtraPack', function(){
//   var selectImg =$(this).closest('.thumbnail');
//   var selectPack = $(this).closest('.thumbnail').find('.pack-msg');
//   // $('.selectPack').addClass('hide');
//   // console.log(selectPack);
//   var token = $('.token').val();
// var promocode = $('.promocode').val();

//  var checkedValues = $('input[type=checkbox][name=package\\[\\]]:checked').map(function() {
//     return $(this).attr('data-id');
//     // return this.value;
//   }).get();

//  var checkedPrices = $('input[type=checkbox][name=package\\[\\]]:checked').map(function() {
//     // return $(this).attr('data-id');
//     return this.value;
//   }).get();

//   if (this.checked) {
//     selectImg.addClass('select-msg');
//     // console.log(checkedValues);
//   }else{
//     selectImg.removeClass('select-msg');
//     // console.log(checkedValues);
//   }

//    $.ajax({
//       url: base_url + '/package/addextpackage' ,
//       headers:
//             {
//                'X-CSRF-Token': token
//             },
//       method: 'post',
//       data: {data: checkedValues, promocode:promocode } ,

//       success:function(data){
//         if (data['stat'] == 'ok') {
//           var amount =0;

//          $.each(checkedPrices, function (index, value) {
//             amount = amount + parseFloat(value);
//           });
//         // alert(amount);
//         $('.ext').attr('extprice',amount);
//         $('.ext').html('NPR '+amount);
//         var total = $('#total').attr('initial-total');
//         $('#total').attr('totalprice',parseFloat(total) + amount);
//         $('#total').html('NPR '+(parseFloat(total)+amount));

//         //change esewa form values
//         var psc = $('#esewaForm input[name=psc]').val();
//         $('#esewaForm input[name=tAmt]').val(parseFloat(total)+amount);
//         $('#esewaForm input[name=amt]').val((parseFloat(total)+amount) - (parseFloat(psc)) );
//         // selectPack.removeClass('hide');
//         // selectPack.html('<p>Extension package selected.</p>');
//         }else{
//           $('.promo-error').removeClass('hide');
//           $('.promo-error').html(data['msg']);
//         }

//       }

//     });


// // alert('here');

// // var price = $(this).val();
// // alert(price);

// });


$('#adult').val(1);

$(".group1").colorbox({rel:'group1'});

	// show additional gallerylist images
	$('#add-lists').click(function(){
  // alert('hrer');
  $.ajax({
  	url: 'morelist',
  	method: 'get',
  	data: {id: $('#add-lists').attr('data-id')},


  	success:function(data){
  		$.each( data, function( key, value ) {
  			$('#more-lists').append('<div class="col-md-4 col-sm-4"><a class="group1" href="'+base_url+'/images/packages-new/gallerylist/'+ value.image+'"><div class="bg-wrap" style="background-image: url('+base_url+'/images/packages-new/gallerylist/'+ value.image +')"></div></a></div>');
  		});
  		$('#add-lists').hide();
      $(".group1").colorbox({rel:'group1'});
    }
  });
});

// change no. of travellers in bookingstep1
$('#adult').change(function(){
	var no = $(this).val();
	var price = no * $(this).attr('data-rate');
	$('#traveller').text(no);
	$('#total').text('USD ' +price);
  $('.form-info').html('');
  for(var i = 1; i <= no; i++) {
    if (i != 1) {
      $('.form-info').append('<p class="form-title"> Traveller: '+i+'</p>');
      var html = $('.extra-traveller2').html();
    }else{
      var html = $('.extra-traveller').html();
    }
    $('.form-info').append(html);
    var rate = $('#total').attr('initial-total');
    $('#total').attr('totalprice',no* rate);
    $('.ext').attr('extprice', 0);
    $('.exten-text').addClass('hide');
    $('.extension').html('');
    $('.addonPackage').val('');
    $('.thumbnail').removeClass('select-msg');
    
    // $('.box').addClass('SlectBox');
    // $('.SlectBox').SumoSelect({ csvDispCount: 3 });
  }
});

//change no. of travellers in bookingstep1 Edit
$('#adult-edit').change(function(){
  var no = $(this).val();
  var price = no * $(this).attr('data-rate');
  $('#traveller').text(no);
  $('#total').text('USD ' +price);
  var html = $('.extra-traveller').html();
  var count = $('#count').val();
  // var number = count;
  if (count< no) {
    while (count != no){
      count++;
      $('.form-main').append(html);
      $('.form-main .form-info').last().prepend('<p class="form-title"> Traveller: '+count+ '</p>');
    }
    $('#count').val(count);
  }else if(count > no){
    while(count != no){
      $('.form-main .form-info').last().remove();
      count--;
    }
    $('#count').val(count);
  }
});

// $('.booking-edit').validate({

// });
// $('.bookedit').click(function(){
//   alert('form4');
//   $('.booking-edit').submit();
// });



$.validator.setDefaults({
  errorElement: "span",
  errorClass: "help-block",
  highlight: function(element) {
    $(element).closest('[class^=col-md]').addClass('has-error');
  },
  unhighlight: function(element) {
    $(element).closest('[class^=col-md]').removeClass('has-error');
  },
  errorPlacement: function (error, element) {
        // if (element.parent('.input-group').length || element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
          if (element.parent('.input-group').length || element.prop('type') === 'checkbox') {
            error.insertAfter(element.parent());
          }else if(element.parent('.input-group').length || element.prop('type') === 'radio'){
           $('.radio-error').text(error.text());
          // error.insertAfter(element);
        } else {

        	// if (element.parent('.input-group').length || element.prop('type') === 'email' ) {
        	// 	error.insertAfter(element);
        	// }
        	// error.insertAfter(element);
   		// element.attr("placeholder",error.text());
    }
  }
});

// var val= $('#email[]-error').text();
// if (error.search('This field is required') < 0) {
//                     $(this).hide();

//                 }else if(error.search('This field is required') < 0){

//  $(this).show();
//                 }


$('#booking-3').validate({
  rules :{
    'optionsRadios': 'required',
    'exp_year': 'required',
    'exp_month': 'required',
    'name': 'required',
    'credit_card': 'required',
  }
});
// validate payment form
$('#payment').click(function(){
  if (!($('#booking-3').valid())) {
    return;
  }
  $('#booking-3').submit();
});


$('#booking-2').validate({
  rules :{
    'condition': 'required'
  }
});

//validate booking-step2 
$('#summary-continue').click(function(){
  if (!($('#booking-2').valid())) {
    return;
  }
  $('#booking-2').submit();
});


$('#traveller-info').validate({
  rules: {
    "adult": "required",
    "title[]": "required",
    "fname[]": "required",
    "lname[]": "required",
    "email[]": {
      required: true,
      email: true
    },
    password: { 
     required: true,
     minlength: 6
   } , 
   password_confirmation: { 
    equalTo: ".travel-form #password",
    minlength: 6
  },
  "dob_year[]": "required",
  "dob_month[]": "required",
  "dob_day[]": "required",
  "passport[]": "required",
  "image[]": "required",
  "issue_year[]": "required",
  "issue_month[]": "required",
  "issue_day[]": "required",
  "exp_year[]": "required",
  "exp_month[]": "required",
  "exp_day[]": "required",
  "address[]": "required",
  "city[]": "required",
  "postal_zip[]": "required",
  "country[]": "required",
  "em_fname[]": "required",
  "em_lname[]": "required",
  "em_phone[]": "required",
  "em_country[]": "required",

}

});
$('#submit').click(function(e){

	if (!($('#traveller-info').valid())) {
return;
}
$('#traveller-info').submit();
});

//display name of file selected in booking-step1
$(document).on('change','.image', function(){
  var file = $(this)[0].files[0];
  $(this).closest('[class^=col-md]').find('.image-name').html('<small>'+file.name+'</small>');
})

//display name of file selected in booking-step1edit
$(document).on('change','.image-new', function(){
  var file = $(this)[0].files[0];
  $(this).closest('[class^=col-md]').find('.image-name').html('<small>'+file.name+'</small>');
})

//validate promocode
$('#checkPromoForm').validate({
  rules :{
    'promocode': 'required'
  }
});

//check promocode an populate form
$(document).on('submit', '#checkPromoForm', function(event){
  event.preventDefault();
  $('.promo-error').addClass('hide');
  $('.payment-options').addClass('hide');
  $('.addextraPackageDiv').addClass('hide');

  $('#CoupleInfoForm .form-group').addClass('hide');
  $('.check .loading').removeClass('hide');


  if(!$(this).valid()){
    return;
  }else{
    var token = $('.token').val();
    var promocode = $('.promocode').val();
    $.ajax({
      url: base_url +'/package/checkpromocode',
      headers:
      {
       'X-CSRF-Token': token
     },
     method: 'post',
     data: {promocode: promocode},

     success:function(data){
      if(data['stat'] === 'ok'){
              $('#CoupleInfoForm .form-group').removeClass('hide');
              $('#esewaForm .esewabtn .btn').removeAttr('disabled');
              $('.payment-options').removeClass('hide');
              $('.add-extra-package').removeClass('hide');
              $('.addextraPackageDiv').removeClass('hide');
              $('.validatepromo').addClass('hide');
              $('.check .loading').addClass('hide');
              $('#CoupleInfoForm [name=fullname]').val(data['row']['fullname']);
              $('#CoupleInfoForm [name=valentine_fullname]').val(data['row']['valentine_fullname']);
              $('#CoupleInfoForm [name=email]').val(data['row']['email']);
              $('#CoupleInfoForm [name=contact]').val(data['row']['contact']);
              $('#CoupleInfoForm [name=promo_code]').val(data['row']['promocode']);
              var url = $('#esewaForm [name=su]').val();
              var string = url.replace("promoid", data['row']['promocode'])
              $('#esewaForm [name=su]').val(string);
            }else{
              $('.promo-error').removeClass('hide');
              $('.check .loading').addClass('hide');
              $('.promo-error').html(data['msg']);
            }
          }

        });
}

});

//validate coupleInfo
$('#CoupleInfoForm').validate({
  rules :{
    'fullname': 'required',
    'valentine_fullname': 'required',
    "email": {
      required: true,
      email: true
    },
    'contact': 'required',
  }
});

//update promocode table info after valdating promocode
$(document).on('submit', '#CoupleInfoForm', function(event){
  event.preventDefault();
  $('.update').addClass('hide');
  $('.promo-error').addClass('hide');

  if(!$(this).valid()){
    return;
  }else{
    var token = $('.token').val();
  var _data = $(this).serialize();

  $.ajax({
    url: base_url +'/package/updatecoupleinfo',
    headers:
    {
     'X-CSRF-Token': token
   },
   method: 'post',
   data: {data: _data},

   success:function(data){
    if(data['stat'] === 'ok'){
      $('.update').removeClass('hide');
      $('.update').html(data['msg']);

    }else{
              $('.promo-error').removeClass('hide');
              $('.check .loading').addClass('hide');
              $('.promo-error').html(data['msg']);
            }
          }

        });
}

});

//adding package dateprice id in contact form
$(document).on('click', '.click-contact-btn', function() {
  var datePrice = $(this).attr('data-dateprice-id');
  $('#package-contactform .dateprice').val(datePrice);
});

$(document).on('submit', '#package-contactform', function(event) {
            event.preventDefault();

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

//validating package contact form
$('#package-contactform').validate({
    rules: {
        "fullname": "required",
        "contact": "required",
        "message": "required",
        "email": {
          required: true,
          email: true
      },
  }
});

//if valid
if($('#package-contactform').valid() ){
    var response = grecaptcha.getResponse();

//     if(response.length == 0){
//     //reCaptcha not verified
//     // alert('not verified');
// }else{
    // alert('verified');
    $('.loading').removeClass('hide');
    var _data = $(this).serialize();
    var token = $('.token').val();

$.ajax({
    url: base_url + '/package/contactpackage',
    headers:
    {
       'X-CSRF-Token': token
   },
   method: 'post',
   data: {data: _data},

   success:function(data){
    $('.loading').hide();
        // $('#promoForm').hide();
        $('.form-wrapper').addClass('form-msg');
        if (data['stat'] == 'ok') {
            $('.form-wrapper').html(data['msg']);
        }else{
            $('.form-wrapper').html(data['msg']);
        }
    }
});

// }
                }
            });

   
//sumoselect for selecting city for flight search
$( ".locations" ).SumoSelect({
  search: true, 
  searchText: 'Enter Location'
});

//sumoselect for selecting country for flight search
// $( ".country" ).SumoSelect(
// // {
// //   search: true, 
// //   searchText: 'Enter Country'
// // }
// );



// $( ".datepicker" ).datepicker({
//     minDate: new Date(),
//     dateFormat: "dd-M-yy"
//   });

//datepicker for search flight with return date greater and departure date
$(".datedepart").datepicker({
  minDate: new Date(),
  dateFormat: "dd-M-yy",
  onSelect: function(date) {
    $(".datereturn").datepicker('option', 'minDate', date);
  }
});
$(".datereturn").datepicker({
  dateFormat: "dd-M-yy"
});

//validate round trip form
$('.flightSearchForm').validate({
    rules: {
        "departure": "required",
        "arrival": "required",
        "date_depart": "required",
        "date_return": "required",
  }
});

//validate oneway form
$('.flightSearchForm2').validate({
    rules: {
        "departure": "required",
        "arrival": "required",
        "date_depart": "required",
        "dat_return": "required",
  }
});

//validate roundtrip flight form
$('.flightSelectFormR').validate({
   rules: {
        "flightId": "required",
        "returnFlightId": "required",
  }
});

// selecting departure flight
$(document).on('click', '#outbound-flight .action', function(){
    var flightId = $(this).attr('data-flight-id');
    var flightDetail = $(this).attr('data-flight');
var img = $(this).attr('data-img');
    $('.flight-id').val(flightId);
    $('.flight-detail').val(flightDetail);

    var count = $('.return-flight-id').length;
    if(count != 0){
    var returnFlightId = $('.return-flight-id').val();
      if( (flightId != '') && (returnFlightId != '') ){
          $('.flightSelectForm-btn').prop("disabled", false);
      }
    }else{
      if( (flightId != '') ){
          $('.flightSelectForm-btn').prop("disabled", false);
      }
    }

    $(this).html('<span class="tick"><img src="'+img+'">Selected</span>');
    $('#outbound-flight .action').not(this).html('<a href="javascript:void(0)" class="btn btn-danger btn-block btn-sm out-btn">Select</a>');
});

// selecting returning flight
$(document).on('click', '#inbound-flight .action', function(){
    var returnFlightId = $(this).attr('data-return-flight-id');
    var returnFlightDetail = $(this).attr('data-return-flight');
var img = $(this).attr('data-img');
    $('.return-flight-id').val(returnFlightId);
    $('.return-flight-detail').val(returnFlightDetail);

    var flightId = $('.flight-id').val();
      if( (flightId != '') && (returnFlightId != '') ){
          $('.flightSelectForm-btn').prop("disabled", false);
      }

    $(this).html('<span class="tick"><img src="'+img+'">Selected</span>');
    $('#inbound-flight .action').not(this).html('<a href="javascript:void(0)" class="btn btn-danger btn-block btn-sm in-btn">Select</a>');
});

// scrolling after selecting departure flight
$(document).on('click', '.out-btn', function(){
    var tripType = $('.trip-type').val();
    if(tripType == 'R'){

        $('html, body').animate({
            scrollTop: $("#inbound-flight").offset().top
        }, 2000);
    }else{
         $('html, body').animate({
            scrollTop: $(".flightSelectForm-btn").offset().top
        }, 2000);
    }
});

// scrolling after selecting returning flight
$(document).on('click', '.in-btn', function(){
    var depart = $('.flight-id').val();
    if(depart == ''){
      if($("#outbound-flight").length !=0){
        $('html, body').animate({
            scrollTop: $("#outbound-flight").offset().top
        }, 2000);
      }
    }else{
        $('html, body').animate({
            scrollTop: $(".flightSelectForm-btn").offset().top
        }, 2000);
    }
});

//sort by highest price
  $(document).on('click','.highprice', function(){
    var $wrapper = $('.searchWrapper');
                $wrapper.find('.box-flight').sort(function (a, b) {
                    return +b.dataset.price - +a.dataset.price;
                })
                .appendTo( $wrapper );
                $(".highprice").hide();
                $(".lowprice").show();
  });

//sort by lowest price
$(document).on('click','.lowprice', function(){
    var $wrapper = $('.searchWrapper');
                $wrapper.find('.box-flight').sort(function (a, b) {
                    return +a.dataset.price - +b.dataset.price;
                })
                .appendTo( $wrapper );
                $(".highprice").show();
                $(".lowprice").hide();
  });

//sort by highest price for returning flight
  $(document).on('click','.returnHighprice', function(){
    var $wrapper = $('.returnSearchWrapper');
                $wrapper.find('.box-flight').sort(function (a, b) {
                    return +b.dataset.price - +a.dataset.price;
                })
                .appendTo( $wrapper );
                $(".returnHighprice").hide();
                $(".returnLowprice").show();
  });

//sort by lowest price for returning flight
$(document).on('click','.returnLowprice', function(){
    var $wrapper = $('.returnSearchWrapper');
                $wrapper.find('.box-flight').sort(function (a, b) {
                    return +a.dataset.price - +b.dataset.price;
                })
                .appendTo( $wrapper );
                $(".returnHighprice").show();
                $(".returnLowprice").hide();
  });

//sort by late time
 $(document).on('click','.lateflight', function(){
    var $wrapper = $('.searchWrapper');
                $wrapper.find('.box-flight').sort(function (a, b) {
                    return +b.dataset.time - +a.dataset.time;
                })
                .appendTo( $wrapper );
                $(".lateflight").addClass('hide');
                $(".earlyflight").removeClass('hide');
  });

//sort by early time
$(document).on('click','.earlyflight', function(){
    var $wrapper = $('.searchWrapper');
                $wrapper.find('.box-flight').sort(function (a, b) {
                    return +a.dataset.time - +b.dataset.time;
                })
                .appendTo( $wrapper );
                $(".lateflight").removeClass('hide');
                $(".earlyflight").addClass('hide');
  });


//sort by late time for return flight
 $(document).on('click','.returnLateflight', function(){
    var $wrapper = $('.returnSearchWrapper');
                $wrapper.find('.box-flight').sort(function (a, b) {
                    return +b.dataset.time - +a.dataset.time;
                })
                .appendTo( $wrapper );
                $(".returnLateflight").addClass('hide');
                $(".returnEarlyflight").removeClass('hide');
  });

//sort by early time for return flight
$(document).on('click','.returnEarlyflight', function(){
    var $wrapper = $('.returnSearchWrapper');
                $wrapper.find('.box-flight').sort(function (a, b) {
                    return +a.dataset.time - +b.dataset.time;
                })
                .appendTo( $wrapper );
                $(".returnLateflight").removeClass('hide');
                $(".returnEarlyflight").addClass('hide');
  });

    // sorting by flight by all fare
    $(".flightfareall").click(function(){
        $('.box-flight').show().filter('[data-fare="T"][data-fare="F"]').show();
    });

    // sorting by flight by refundable
    $(".flightrefundable").click(function(){
        $('.box-flight').hide().filter('[data-fare="T"]').show();
    });

    // sorting by flight by non-refundable
    $(".flightnonrefundable").click(function(){
       $('.box-flight').hide().filter('[data-fare="F"]').show();
    });

    // sorting by return flight by all fare
      $(".returnflightfareall").click(function(){
          $('.returnSearchWrapper .box-flight').show().filter('[data-fare="T"][data-fare="F"]').show();
      });

      // sorting by return flight by refundable
      $(".returnflightrefundable").click(function(){
          $('.returnSearchWrapper .box-flight').hide().filter('[data-fare="T"]').show();
      });

      // sorting by return flight by non-refundable
      $(".returnflightnonrefundable").click(function(){
         $('.returnSearchWrapper .box-flight').hide().filter('[data-fare="F"]').show();
      });

    // $(document).on('change','.flightFareType', function(){
    //   var price = $(this).val();
    //   if(price == 'all'){
    //     $('.searchBox').show().filter('[data-fare="T"][data-fare="F"]').show();
    //   }else if(price == 'refund'){
    //      $('.searchBox').hide().filter('[data-fare="T"]').show();
    //   }else if(price == 'non-refund'){
    //      $('.searchBox').hide().filter('[data-fare="F"]').show();
    //   }
    // });

//sort by desc class
  $(document).on('click','.ascClass', function(){
    var $wrapper = $('.searchWrapper');
                $wrapper.find('.box-flight').sort(function (a, b) {
                    return b.dataset.class > a.dataset.class;
                })
                .appendTo( $wrapper );
                // $(".highprice").addClass('hide');
                $(".ascClass").hide();
                // $(".lowprice").removeClass('hide');
                $(".descClass").show();
  });

//sort by asc class
$(document).on('click','.descClass', function(){
    var $wrapper = $('.searchWrapper');
                $wrapper.find('.box-flight').sort(function (a, b) {
                    return a.dataset.class > b.dataset.class;
                })
                .appendTo( $wrapper );
                $(".ascClass").show();
                $(".descClass").hide();
  });

//sort by desc class for return flight
  $(document).on('click','.returnAscClass', function(){
    var $wrapper = $('.returnSearchWrapper');
                $wrapper.find('.box-flight').sort(function (a, b) {
                    return b.dataset.class > a.dataset.class;
                })
                .appendTo( $wrapper );
                // $(".highprice").addClass('hide');
                $(".returnAscClass").hide();
                // $(".lowprice").removeClass('hide');
                $(".returnDescClass").show();
  });

//sort by asc class for return flight
$(document).on('click','.returnDescClass', function(){
    var $wrapper = $('.returnSearchWrapper');
                $wrapper.find('.box-flight').sort(function (a, b) {
                    return a.dataset.class > b.dataset.class;
                })
                .appendTo( $wrapper );
                $(".returnAscClass").show();
                $(".returnDescClass").hide();
  });

// sorting by class
    $(document).on('change','.sortByClass', function(){
      var price = $(this).val();
        alert('class');

        var alphabeticallyOrderedDivs = $('.box-flight').sort(function(a, b) {
        return String.prototype.localeCompare.call(a.attr('data-class').toLowerCase(), b.attr('data-class').toLowerCase());
        });
        console.log(alphabeticallyOrderedDivs);
        var container = $(".searchWrapper");
        container.append(alphabeticallyOrderedDivs);
        $('.departureFlight').append(container);
        // $("#flightfromA").hide();
        // $("#flightfromZ").show();
    });


//display loader when form is submitted
$(document).on('submit', '.loaderDisplay', function(){
 $('body .loader').show();
 $('body .main').hide();
});

$(document).on('click', '.modifySearchFlight', function(){
  if($(this).hasClass('not-active')){
    return;
  }else{
    $(this).next('.modifyFlightSearchForm').submit();
  }
});

var form = $("#paxDetailForm").show();

form.steps({
    headerTag: "li",
    bodyTag: "fieldset",
    transitionEffect: "slideLeft",
    stepsOrientation: "vertical",
    onStepChanging: function (event, currentIndex, newIndex)
    {
      // alert('changing');
      var adultno = $('.adultno').val();
      var childno = $('.childno').val();
      var totalno = parseInt(adultno) + parseInt(childno) + parseInt('1');
        // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex)
        {
            // alert('inside if');
            return true;
        }
        // Forbid next action on "Warning" step if the user is to young
        if (newIndex === 3 && Number($("#age-2").val()) < 18)
        // if (newIndex === totalno )
        {
          // alert('will return false');
            return false;
        }
        // Needed in some cases if the user went back (clean up)
        if (currentIndex < newIndex)
        {
            // alert('clean back');
            // To remove error styles
            form.find(".body:eq(" + newIndex + ") label.error").remove();
            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }
        // alert('before validation');
        form.validate().settings.ignore = ":disabled,:hidden";
        // alert('before validation2');
        return form.valid();
        // if(!($('#paxDetailForm').valid()) ){
        // return;

        // }else{
        //   return true;
        // }
        // alert('before validation3');
    },
    onStepChanged: function (event, currentIndex, priorIndex)
    {
      // alert('changed');

        // Used to skip the "Warning" step if the user is old enough.
        if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
        // if (currentIndex === 2 )
        {
            form.steps("next");
        }
        // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
        if (currentIndex === 2 && priorIndex === 3)
        {
            form.steps("previous");
        }
    },
    onFinishing: function (event, currentIndex)
    {
        // form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {
        // alert("Submitted!");
        $("#paxDetailForm").submit();
    }
})
.validate({
  errorElement: "span",
  errorClass: "help-block",
  highlight: function(element) {
    $(element).closest('[class^=col-md]').addClass('has-error');
  },
  unhighlight: function(element) {
    $(element).closest('[class^=col-md]').removeClass('has-error');
  },
    errorPlacement: function errorPlacement(error, element) { 
      // element.before(error); 
    },
    // rules: {
    //   email_confirmation: { 
    //   equalTo: "#email",
    //   }
    // },
    
  
});

$(document).on('click', '.btnTravellerLogin', function(){
  var email = $('.email').val();
  var password = $('.password').val();
  var token = $('.token').val();

  $.ajax({
      url: base_url + '/login' ,
      headers:
      {
       'X-CSRF-Token': token
     },
     method: 'post',
     data: {email: email, password:password } ,

     success:function(data){
      alert(data['stat']);
      // alert(data['id']);

      if(data['stat'] == 'success'){
        $('.registeredUserForm').submit();
      }else{
        alert(data['stat']);
      }
     }


    });

});






});

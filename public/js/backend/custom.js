// Avoid `console` errors in browsers that lack a console.\

(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

formLoad = null;

// Place any jQuery/helper plugins in here.
$(document).ready(function() {

function loadForm(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    /*
     Allows you to add data-method="METHOD to links to automatically inject a form with the method on click
     Example: <a href="{{route('customers.destroy', $customer->id)}}" data-method="delete" name="delete_item">Delete</a>
     Injects a form with that's fired on click of the link with a DELETE request.
     Good because you don't have to dirty your HTML with delete forms everywhere.
     */
    $('[data-method]').append(function(){
        return "\n"+
        "<form action='"+$(this).attr('href')+"' method='POST' name='delete_item' style='display:none'>\n"+
        "   <input type='hidden' name='_method' value='"+$(this).attr('data-method')+"'>\n"+
        "   <input type='hidden' name='_token' value='"+$('meta[name="_token"]').attr('content')+"'>\n"+
        "</form>\n"
    })
        .removeAttr('href')
        .attr('style','cursor:pointer;')
        .attr('onclick','$(this).find("form").submit();');

    /*
     Generic are you sure dialog
     */
    $('form[name=delete_item]').submit(function(){
        return confirm("Are you sure you want to delete this item?");
    });

    /*
     Bind all bootstrap tooltips
     */
    $("[data-toggle=\"tooltip\"]").tooltip();
    $("[data-toggle=\"popover\"]").popover();
    //This closes the popover when its clicked away from
    $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });
}

    formLoad = loadForm;

    formLoad();
});

!function(e){e(["jquery"],function(e){return function(){function t(e,t,n){return f({type:O.error,iconClass:g().iconClasses.error,message:e,optionsOverride:n,title:t})}function n(t,n){return t||(t=g()),v=e("#"+t.containerId),v.length?v:(n&&(v=c(t)),v)}function i(e,t,n){return f({type:O.info,iconClass:g().iconClasses.info,message:e,optionsOverride:n,title:t})}function o(e){w=e}function s(e,t,n){return f({type:O.success,iconClass:g().iconClasses.success,message:e,optionsOverride:n,title:t})}function a(e,t,n){return f({type:O.warning,iconClass:g().iconClasses.warning,message:e,optionsOverride:n,title:t})}function r(e){var t=g();v||n(t),l(e,t)||u(t)}function d(t){var i=g();return v||n(i),t&&0===e(":focus",t).length?void h(t):void(v.children().length&&v.remove())}function u(t){for(var n=v.children(),i=n.length-1;i>=0;i--)l(e(n[i]),t)}function l(t,n){return t&&0===e(":focus",t).length?(t[n.hideMethod]({duration:n.hideDuration,easing:n.hideEasing,complete:function(){h(t)}}),!0):!1}function c(t){return v=e("<div/>").attr("id",t.containerId).addClass(t.positionClass).attr("aria-live","polite").attr("role","alert"),v.appendTo(e(t.target)),v}function p(){return{tapToDismiss:!0,toastClass:"toast",containerId:"toast-container",debug:!1,showMethod:"fadeIn",showDuration:300,showEasing:"swing",onShown:void 0,hideMethod:"fadeOut",hideDuration:1e3,hideEasing:"swing",onHidden:void 0,extendedTimeOut:1e3,iconClasses:{error:"toast-error",info:"toast-info",success:"toast-success",warning:"toast-warning"},iconClass:"toast-info",positionClass:"toast-top-right",timeOut:5e3,titleClass:"toast-title",messageClass:"toast-message",target:"body",closeHtml:'<button type="button">&times;</button>',newestOnTop:!0,preventDuplicates:!1,progressBar:!1}}function m(e){w&&w(e)}function f(t){function i(t){return!e(":focus",l).length||t?(clearTimeout(O.intervalId),l[r.hideMethod]({duration:r.hideDuration,easing:r.hideEasing,complete:function(){h(l),r.onHidden&&"hidden"!==b.state&&r.onHidden(),b.state="hidden",b.endTime=new Date,m(b)}})):void 0}function o(){(r.timeOut>0||r.extendedTimeOut>0)&&(u=setTimeout(i,r.extendedTimeOut),O.maxHideTime=parseFloat(r.extendedTimeOut),O.hideEta=(new Date).getTime()+O.maxHideTime)}function s(){clearTimeout(u),O.hideEta=0,l.stop(!0,!0)[r.showMethod]({duration:r.showDuration,easing:r.showEasing})}function a(){var e=(O.hideEta-(new Date).getTime())/O.maxHideTime*100;f.width(e+"%")}var r=g(),d=t.iconClass||r.iconClass;if("undefined"!=typeof t.optionsOverride&&(r=e.extend(r,t.optionsOverride),d=t.optionsOverride.iconClass||d),r.preventDuplicates){if(t.message===C)return;C=t.message}T++,v=n(r,!0);var u=null,l=e("<div/>"),c=e("<div/>"),p=e("<div/>"),f=e("<div/>"),w=e(r.closeHtml),O={intervalId:null,hideEta:null,maxHideTime:null},b={toastId:T,state:"visible",startTime:new Date,options:r,map:t};return t.iconClass&&l.addClass(r.toastClass).addClass(d),t.title&&(c.append(t.title).addClass(r.titleClass),l.append(c)),t.message&&(p.append(t.message).addClass(r.messageClass),l.append(p)),r.closeButton&&(w.addClass("toast-close-button").attr("role","button"),l.prepend(w)),r.progressBar&&(f.addClass("toast-progress"),l.prepend(f)),l.hide(),r.newestOnTop?v.prepend(l):v.append(l),l[r.showMethod]({duration:r.showDuration,easing:r.showEasing,complete:r.onShown}),r.timeOut>0&&(u=setTimeout(i,r.timeOut),O.maxHideTime=parseFloat(r.timeOut),O.hideEta=(new Date).getTime()+O.maxHideTime,r.progressBar&&(O.intervalId=setInterval(a,10))),l.hover(s,o),!r.onclick&&r.tapToDismiss&&l.click(i),r.closeButton&&w&&w.click(function(e){e.stopPropagation?e.stopPropagation():void 0!==e.cancelBubble&&e.cancelBubble!==!0&&(e.cancelBubble=!0),i(!0)}),r.onclick&&l.click(function(){r.onclick(),i()}),m(b),r.debug&&console&&console.log(b),l}function g(){return e.extend({},p(),b.options)}function h(e){v||(v=n()),e.is(":visible")||(e.remove(),e=null,0===v.children().length&&(v.remove(),C=void 0))}var v,w,C,T=0,O={error:"error",info:"info",success:"success",warning:"warning"},b={clear:r,remove:d,error:t,getContainer:n,info:i,options:{},subscribe:o,success:s,version:"2.1.0",warning:a};return b}()})}("function"==typeof define&&define.amd?define:function(e,t){"undefined"!=typeof module&&module.exports?module.exports=t(require("jquery")):window.toastr=t(window.jQuery)});
//# sourceMappingURL=/toastr.js.map
$(function() {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    

    $('.content .table').wrap('<div class=" table-responsive">');
});


$(document).ready(function(){
  $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
  });
});

// file browse

$(document).on('change', '.btn-file :file', function() {
  var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        
        if( input.length ) {
            input.val(log);
        } else {
            // if( log ) alert(log);
        }
        
    });

    /*seo_setting*/
    $('.form-page .test').hide();
    
    $("form#pagecreat #seo #seo_fields").on('ifChecked', function(event){
          $('.form-page .test').show();
    });
    $("form#pagecreat #seo #seo_fields").on('ifUnchecked', function(event){
          $('.form-page .test').hide();
    });

    $('.form-page #sb').hide();
    // $("form#pagecreat #static_fields").on('ifChecked', function(event){
    //       $('.form-page #sb').show();
    // });
    // $("form#pagecreat #static_fields").on('ifUnchecked', function(event){
    //       $('.form-page #sb').hide();
    // });
var count = 1;
    $("form.package-form .add-static").on('click', function(event){
      count++;
      var lastval = $( "input[name='uniqueId[]']:last" ).val();
      var val = +lastval+1;
        $.ajax({
        url: base_url + "/admin/packages/create",
        type: 'get',
        datatype: 'html',
        beforeSend: function() {
            $('.loader-overlay').show();
        },
        success: function(data) {
            console.log('success');
            console.log(data);
            $('.loader-overlay').hide();
            //success
            //var data = $.parseJSON(data);
            if(data.success == true) {
              //user_jobs div defined on page
              $('#added_blocks').append(data.html);
              if(lastval){
                $('.addmore-html input#uId').attr('id','uId'+ val);
                $('#uId' + val ).attr('value', val);
              }else{
                $('.addmore-html input#uId').attr('id','uId'+count);
                $('#uId' + count ).attr('value', count);   
              }
              $('.addmore-html textarea#scontent').attr('id','scontent'+count);
              tinymce.init({
        theme: "modern",
        mode : "exact",
        elements : ["scontent"+count],
        menubar : false,
        relative_urls: false,
        forced_root_block: false, // Start tinyMCE without any paragraph tag
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars media nonbreaking",
            "table contextmenu directionality paste textcolor code localautosave"
        ],
        toolbar1: "localautosave | bold italic underline hr | link unlink image media | styleselect forecolor backcolor paste | bullist numlist outdent indent | code preview ",
        entity_encoding: "raw",
        file_picker_callback : elFinderBrowser
    });
            } 
        },
        error: function(xhr,textStatus,thrownError) {
            alert(xhr + "\n" + textStatus + "\n" + thrownError);
        }
    });
    });

    var count = 1;
    $("form .innerpageStaticBlock").on('click', function(event){
      count++;
      var lastval = $( "input[name='uniqueId[]']:last" ).val();
      var val = +lastval+1;
      console.log(val)
        $.ajax({
        url: base_url + "/admin/innerpages/create",
        type: 'get',
        datatype: 'html',
        beforeSend: function() {
            $('.loader-overlay').show();
        },
        success: function(data) {
          $('.loader-overlay').hide();
            console.log('success');
            console.log(data);
            if(data.success == true) {
              $('#page_staticblock').append(data.html);
              if(lastval){
                $('.addmore-html input#uId').attr('id','uId'+ val);
                $('#uId' + val ).attr('value', val);
              }else{
                $('.addmore-html input#uId').attr('id','uId'+count);
                $('#uId' + count ).attr('value', count);   
              }
              $('.addmore-html textarea#scontent').attr('id','scontent'+count);
              tinymce.init({
        // selector: "textarea",
        theme: "modern",
        mode : "exact",
        elements : ["scontent"+count],
        menubar : false,
        relative_urls: false,
        forced_root_block: false, // Start tinyMCE without any paragraph tag
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars media nonbreaking",
            "table contextmenu directionality paste textcolor code localautosave"
        ],
        toolbar1: "localautosave | bold italic underline hr | link unlink image media | styleselect forecolor backcolor paste | bullist numlist outdent indent | code preview ",
        entity_encoding: "raw",
        file_picker_callback : elFinderBrowser
    });

            } 
        },
        error: function(xhr,textStatus,thrownError) {
            alert(xhr + "\n" + textStatus + "\n" + thrownError);
        }
    });
    });
    
    // $(document).on('click',"form#pagecreat #seo #seo_fields", function() {
    // if($(this).is(":checked")) {
    //     $('.form-page .test').show();
    // } else {
    //     $('.form-page .test').hide();
    // }
    // });

    /*menu*/
  $('.dd').nestable({ 
    dropCallback: function(details) {
       
       var order = new Array();
       $("li[data-id='"+details.destId +"']").find('ol:first').children().each(function(index,elem) {
         order[index] = $(elem).attr('data-id');
       });

       if (order.length === 0){
        var rootOrder = new Array();
        $("#nestable > ol > li").each(function(index,elem) {
          rootOrder[index] = $(elem).attr('data-id');
        });
       }
       $.ajax({
            type: "POST",
            url: base_url+'/admin/menus/order',
            data: { source : details.sourceId, 
                    destination: details.destId, 
                    order:JSON.stringify(order),
                    rootOrder:JSON.stringify(rootOrder) 
                },
            dataType: 'json',
        })
       .done(function(data) { 
          $( "#success-indicator" ).fadeIn(100).delay(1000).fadeOut();
       })
       .fail(function() { console.log('error'); })
     }
   });

  $('.delete_toggle').each(function(index,elem) {
      $(elem).click(function(e){
        e.preventDefault();
        // alert('here');
        $('#postvalue').attr('value',$(elem).attr('rel'));
        $('#deleteModal').modal('toggle');
      });
  });


  
//   $('form#package_create').on('submit', function(event) {
//     event.preventDefault();
//    var data = $(this).serialize()

//    $.ajax({
//      url: base_url + '/admin/packages',
//      type: 'POST',
//      dataType: 'json',
//      data: data,
//    })
//    .done(function(data) {
//     if(data.stat == 'ok'){
//      console.log('here')
//     }
//    })
//    .fail(function() {
//      console.log("error");
//    })
//    .always(function() {
//      console.log("complete");
//    });
   
// })
      $('#block_option select').change(function() {
            $('div.static').hide();
            $('#' + $(this).val()).show();
      }).change();


/*gallery-upload*/
 $("#galleryupload").on('change', function () {

     //Get count of selected files
     var countFiles = $(this)[0].files.length;

     var imgPath = $(this)[0].value;
     var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
     var image_holder = $("#imgpreview");
     image_holder.empty();

     if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
         if (typeof (FileReader) != "undefined") {
              var count = 0;
             //loop for each file selected for uploaded.
             for (var i = 0; i < countFiles; i++) {

                 var reader = new FileReader();
                 reader.onload = function (e) {
                     $("<img />", {
                         "src": e.target.result,
                             "class": "thumb-image",

                     }).appendTo(image_holder);
                     $(image_holder).append('<span id="'+ count++ +'" class="preRemove">X</span><div><label for="caption" class="control-label">Caption</label><input id="caption" class="form-control" name="caption[]" type="text"></div>');
                
                 }

                 image_holder.show();
                 reader.readAsDataURL($(this)[0].files[i]);
             }

         } else {
             alert("This browser does not support FileReader.");
         }
     } else {
         alert("Pls select only images");
     }
 });





/* ------ js for package -----  */

//for daterangepicker
// $('.daterange').daterangepicker({
//     "locale": {
//         "format": "MM/DD/YYYY",
//         "separator": " - ",
//         "applyLabel": "Apply",
//         "cancelLabel": "Cancel",
//         "fromLabel": "From",
//         "toLabel": "To",
//         "customRangeLabel": "Custom",
//         "weekLabel": "W",
//         "daysOfWeek": [
//             "Su",
//             "Mo",
//             "Tu",
//             "We",
//             "Th",
//             "Fr",
//             "Sa"
//         ],
//         "monthNames": [
//             "January",
//             "February",
//             "March",
//             "April",
//             "May",
//             "June",
//             "July",
//             "August",
//             "September",
//             "October",
//             "November",
//             "December"
//         ],
//         "firstDay": 1
//     },
//     "startDate": "11/18/2016",
//     "endDate": "11/24/2016"
// }, function(start, end, label) {
//   console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
// });


$('.daterange').daterangepicker({
         "locale": {
        "format": "ddd D MMM YYYY",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
    },
});


//add dateprice block in datesprices page
$('.btn-add-dateprice').on('click', function(){
  // alert('here');
  var html = $('.xtra-dateprice').html();
  $('#add-xtra-dateprice').append(html);
  $('#add-xtra-dateprice .remove').addClass('remove-dateprice');
  // $('#add-xtra-dateprice .btn-danger').hasClass('remove-dateprice');
   // var test1 = $('#add-xtra-dateprice .block-dateprice').last();
   // var test2 = test1.find('btn-danger');
   // var test = test2.addClass('remove-dateprice');
   // alert(test);
   // console.log(test);
   // $('#add-xtra-dateprice .block-dateprice').last().child('btn-danger').addClass('remove-dateprice');
  $('.daterange').daterangepicker({
         "locale": {
        "format": "ddd D MMM YYYY",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
    },
});

});

//remove specific dateprice block in datesprices page
$(document).on('click', '.block-dateprice .remove-dateprice', function(){
  // alert('here');
  $(this).closest('.block-dateprice').remove();
});

// $('.remove-dateprice').on('click', function(){
//   alert('here');
//   $(this).closest('.block-dateprice').remove();
// });

//remove dateprice block in datesprices page
$('.btn-remove-dateprice').on('click', function(){
  $('form .block-dateprice').last().remove();
});

// check if package is available for dateprice
$('#dateprice-package').change(function(){
    $('#overlay').addClass('disable overlay');
    $('.loading-icon').show();
    $.ajax({
      url: 'checkPackage' ,
      type: 'get',
      data:{'packageId' : $(this).val()},

      success:function(checkPackage){
        $('.loading-icon').hide();
        $('#overlay').removeClass('disable overlay');
        if(checkPackage == 'allow'){
        }else{
          $('#dateprice-package').val('');
          $('.msg-package-status').show().fadeOut(5000);
        }
      }
    });
})

// check if package is available in edit of datesprices page
$('#edit-dateprice-package').change(function(){
    var packageId =$(this).attr('data-prev');
    // alert(page);
    $('#overlay').addClass('disable overlay');
    $('.loading-icon').show();
    $.ajax({
      url: '../checkPackage' ,
      type: 'get',
      data:{'packageId' : $(this).val()},

      success:function(checkPackage){
        $('.loading-icon').hide();
        $('#overlay').removeClass('disable overlay');
        if(checkPackage == 'allow'){
        }else{
          $('#edit-dateprice-package').val(packageId);
          $('.msg-package-status').show().fadeOut(5000);
        }
      }
    });
  });

// check if package is available
$('#itinerary-package').change(function(){
    $('#overlay').addClass('disable overlay');
    $('.loading-icon').show();
    $.ajax({
      url: 'checkPackage' ,
      type: 'get',
      data:{'packageId' : $(this).val()},

      success:function(checkPackage){
        $('.loading-icon').hide();
        $('#overlay').removeClass('disable overlay');
        if(checkPackage == 'allow'){
        }else{
          $('#itinerary-package').val('');
          $('.msg-package-status').show().fadeOut(5000);
        }
      }
    });
})

// check if package is available in edit
$('#edit-itinerary-package').change(function(){
    var packageId =$(this).attr('data-prev');
    // alert(page);
    $('#overlay').addClass('disable overlay');
    $('.loading-icon').show();
    $.ajax({
      url: '../checkPackage' ,
      type: 'get',
      data:{'packageId' : $(this).val()},

      success:function(checkPackage){
        $('.loading-icon').hide();
        $('#overlay').removeClass('disable overlay');
        if(checkPackage == 'allow'){
        }else{
          $('#edit-itinerary-package').val(packageId);
          $('.msg-package-status').show().fadeOut(5000);
        }
      }
    });
  });

// check if package is available
$('#gallery-package').change(function(){
    $('#overlay').addClass('disable overlay');
    $('.loading-icon').show();
    $.ajax({
      url: 'checkPackage' ,
      type: 'get',
      data:{'packageId' : $(this).val()},

      success:function(checkPackage){
        $('.loading-icon').hide();
        $('#overlay').removeClass('disable overlay');
        if(checkPackage == 'allow'){
        }else{
          $('#gallery-package').val('');
          $('.msg-package-status').show().fadeOut(5000);
        }
      }
    });
})

// check if package is available in edit
$('#edit-gallery-package').change(function(){
    var packageId =$(this).attr('data-prev');
    // alert(page);
    $('#overlay').addClass('disable overlay');
    $('.loading-icon').show();
    $.ajax({
      url: '../checkPackage' ,
      type: 'get',
      data:{'packageId' : $(this).val()},

      success:function(checkPackage){
        $('.loading-icon').hide();
        $('#overlay').removeClass('disable overlay');
        if(checkPackage == 'allow'){
        }else{
          $('#edit-gallery-package').val(packageId);
          $('.msg-package-status').show().fadeOut(5000);
        }
      }
    });
  });

$('.option-type').change(function(){
    var type =$(this).val();
    if (type == 'expert') {
      $('.designation').show();
    }else{
      $('.designation').hide();
    }

});

//validation settings
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
        if (element.parent('.input-group').length || element.prop('type') === 'checkbox') {
        error.insertAfter(element.parent());
        }else if(element.parent('.input-group').length || element.prop('type') === 'radio'){
         // $('.radio-error').text(error.text());
          // error.insertAfter(element);
        } else {

          // if (element.parent('.input-group').length || element.prop('type') === 'email' ) {
          //  error.insertAfter(element);
          // }
          // error.insertAfter(element);
      // element.attr("placeholder",error.text());
        }
    }
});


$('.iti-form').validate({
    rules :{
      'day_it[]': 'required',
      'title_it[]': 'required',
      'package_id': 'required'
    }
});
//validating itinerary form
$(document).on('click','#itinerary-btn', function(){
  if (!($('.iti-form').valid())) {
    return;
  }
  $('.iti-form').submit();
});


$('.dateprice-form').validate({
    rules :{
      'daterange[]': 'required',
      'price[]': 'required',
      'status[]': 'required',
      'package_id': 'required'
    }
});
//validating dateprice form
$(document).on('click','#dateprice-btn', function(){
  if (!($('.dateprice-form').valid())) {
    return;
  }
  $('.dateprice-form').submit();
});


// removing gallery image in edit page
$('.gallery-image').click(function(e){
  e.preventDefault();
  var conf = confirm('Are your sure want to delete image !!');
  if(conf){
  $('#overlay').addClass('disable overlay');
   $('.loading-icon').show();
  var val = $(this).attr('data-id');
  var element = this;
  $.ajax({
    url: '../deleteImage' ,
    method: 'get' ,
    data:{id: val },

    success:function(msg){
      $('.loading-icon').hide();
        $('#overlay').removeClass('disable overlay');
      if(msg == 'success'){
        var test = element.closest('.parent-image');
        element.closest('.parent-image').remove();
      }else{
        // alert('failure');
      }
    }
  });
}
});

/* ------ for removing package map-image -----  */
$('#delete-map-image').on('click', function(){
  var conf = confirm('Are your sure want to delete image !!');
  if(conf){
  var id = $(this).attr('data-id');
  // alert(id);
  $.ajax({
    url : '../deletemapimage' ,
    method : 'post' ,
    data: {id : id },
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    },
    success: function(data){
      $('#map-img-preview').remove();
    }

  });
}
});
   

/* ------ for removing itineraray -----  */
$('.btn-remove-itinerary').on('click', function(){
    $('form .block-itinerary').last().remove();
});

/* ------ for package gallery -----  */
// var selDiv = "";
  // var storedFiles = [];
$("#files").on("change", handleFileSelect);
$("#files2").on("change", handleFileSelect2);

    // selDiv = $("#selectedFiles"); 

/* ------  integrating choosen jquery for selecting addon package in main package-----  */
$(document).ready(function(){
    $('.addon').chosen();

//show or hide addon select div
    var typeVal = $('.pack_type').val();
    if(typeVal == 'main'){
      $('.addon-block').show();
    }else{
      $('.addon-block').hide();
    }

    $(document).on('change','.pack_type',function(){
      var typeVal = $('.pack_type').val();
      if(typeVal == 'main'){
        $('.addon-block').show();
      }else{
        $('.addon-block').hide();
      }
    });
});


/* ------ for adding itineraray -----  */
$(document).on('click', '.btn-add-itinerary', function(){
    // $('.xtra-itinerary .editor').addClass('tinymce');
    var html = $('.xtra-itinerary').html();
    // alert(html);
    $('#add-xtra-itinerary').append(html);
    $('#add-xtra-itinerary .editor').addClass('tinymce');

    tinymce.init({
        selector: "#add-xtra-itinerary .tinymce",
        theme: "modern",
        mode : "exact",
        // elements : ["content","short_desc","statcontent"],
        menubar : false,
        relative_urls: false,
        
        forced_root_block: false, // Start tinyMCE without any paragraph tag
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars media nonbreaking",
            "table contextmenu directionality paste textcolor code localautosave"
        ],
        toolbar1: "localautosave | bold italic underline hr | link unlink image media | styleselect forecolor backcolor paste | bullist numlist outdent indent | code preview ",
        entity_encoding: "raw",
        file_picker_callback : elFinderBrowser
    });

    function elFinderBrowser(callback, value, meta) {
        var request = base_url + '/elfinder/tinymce4';
        tinymce.activeEditor.windowManager.open({
            title: 'admin.elfinder',
            url: request,
            width: 900,
            height: 450,
           path : '/public/files/',
            resizable: 'yes',
            
            uiOptions: {
                    toolbar : [
                        // toolbar configuration
                        ['open'],
                        ['back', 'forward'],
                        ['reload'],
                        ['home', 'up'],
                        ['mkdir', 'mkfile', 'upload'],
                        ['info'],
                        ['quicklook'],
                        ['copy', 'cut', 'paste'],
                        ['rm'],
                        ['duplicate', 'rename', 'edit'],
                        ['extract', 'archive'],
                        ['search'],
                        ['view'],
                        ['help']
                    ],
                    path : '/public/files/'
                },
                contextmenu : {
                    files  : [
                        'getfile', '|','open', '|', 'copy', 'cut', 'paste', 'duplicate', '|',
                        'rm', '|', 'edit', 'rename', '|', 'archive', 'extract', '|', 'info'
                    ]
                }
        }, {
            setUrl: function (url) {
                callback(url);
                //$('.mce-textbox').val(url.replace('files','public/files'));
               
            }
        });
        return false;
    }

})



});

function readURL(input) {
// alert('first');
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#feat-img-preview').hide();
            $('#preview').css('background-image', 'url('+e.target.result+')').show();
        }

        reader.readAsDataURL(input.files[0]);
    }else{
      $('#preview').hide().css('background-image', 'url(\'\')');
    }
}

function readURLmap(input) {
// alert('first');
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#map-img-preview').hide();
            $('#map-preview').css('background-image', 'url('+e.target.result+')').show();
        }

        reader.readAsDataURL(input.files[0]);
    }else{
      $('#map-preview').hide().css('background-image', 'url(\'\')');
    }
}

  function handleFileSelect(e) {
    $('#selectedFiles').html('');
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    filesArr.forEach(function(f) {          
      if(!f.type.match("image.*")) {
        return;
      }
      // storedFiles.push(f);
      var reader = new FileReader();
      reader.onload = function (e) {
        var html = "<div class=\"col-md-6 col-sm-6 margin-btm2\"><div class=\"show-img-bg2\" style= \"background-image: url('"+e.target.result+"')\"></div><input type=\"radio\" name=\"default\" value=\""+f.name+"\"> Set Default Image" + "</div>";
        // var html = "<div><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='Click to remove'>" + f.name + "<br clear=\"left\"/></div>";
        $("#selectedFiles").append(html);

          $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
  });
      }
      reader.readAsDataURL(f); 
    });
  }

 function handleFileSelect2(e) {
    $('#selectedFiles2').html('');
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    filesArr.forEach(function(f) {          
      if(!f.type.match("image.*")) {
        return;
      }
      // storedFiles.push(f);
      var reader = new FileReader();
      reader.onload = function (e) {
        var html = "<div class=\"col-md-6 col-sm-6 margin-btm2\"><div class=\"show-img-bg2\" style= \"background-image: url('"+e.target.result+"')\"></div>"  + "</div>";
        $("#selectedFiles2").append(html);

        $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
  });
      }
    
      reader.readAsDataURL(f); 
    });
  }

  function handleForm(e) {
   
    $("#myForm").submit();

  }

//preview profile pic in customer management
function readURLprofile(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.profile-avatar').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }else{
            $('.profile-avatar').attr('src', '');
    }
}

//preview document pic in customer management
function readURLdoc(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#doc-preview').css('background-image', 'url('+e.target.result+')').show();
        }
        reader.readAsDataURL(input.files[0]);
    }else{
      $('#doc-preview').css('background-image', 'url(\'\')').removeClass('show-img-bg2');
    }
}

  $(document).ready(function(){
  });


/* ------ end of js for package -----  */
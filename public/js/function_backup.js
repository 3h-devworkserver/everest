(function($) {
$(document).ready(function(){

	//$(document).on('click','.menu-icon',function(e){
		$('.menu-icon').click(function(e){
	  $(".mega-menu").toggleClass("show-form1"); 
	 	e.stopPropagation(); //Toggle the active class to the area is hovered
	});
	$('body').on('click',function(e) {
		//alert('dsakfja');
        if (!$(e.target).is('.mega-menu, .mega-menu *')) {
            $(".mega-menu").hide();
            $('.mega-menu').removeClass('show-form1')
        }
    });


	$(".booked").click(function(e){
	  $(".booking-form .container").toggleClass("show-form");  
	   e.stopPropagation();//Toggle the active class to the area is hovered
	});
	$(document).click(function(e) {
        if (!$(e.target).is('.booking-form, .booking-form *')) {
            //$(".booking-form .contianer").hide();
            $('.booking-form .container').removeClass('show-form')
        }
    });

    $(".booked").click(function(){
    	$(".mega-menu").removeClass('show-form1');
    });
    $(".menu-icon").click(function(){
    	$(".booking-form .container").removeClass('show-form');
    });
    $(".booking-form .close").click(function(){
    	$(".booking-form .container").removeClass('show-form');
    });


	window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });

	$(function() {
	    $( "#from" ).datepicker({
	    	'dateFormat': 'dd M yy',
		      defaultDate: "+1w",
		      changeMonth: true,
		      numberOfMonths: 1,
		      onClose: function( selectedDate ) {
		        $( "#to" ).datepicker( "option", "minDate", selectedDate );
	      }
	    });
	    $( "#to" ).datepicker({
	    	'dateFormat': 'dd M yy',
		      defaultDate: "+1w",
		      changeMonth: true,
		      numberOfMonths: 1,
		      onClose: function( selectedDate ) {
		        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
	      }
	    });
  	});

		if ($(window).width() <=767) {
				$('.sub-menu').hide()

		$('.column').each(function() {
		    var $column = $(this);

		    $("a.title .fa-angle-down", $column).click(function(e) {
		      e.preventDefault();
		      $div = $("ul.sub-menu", $column);
		      $div.toggle('slow');
		      $("ul.sub-menu").not($div).hide();
		      return false;
		    });

		});
		    
		  //$('html').click(function(){
		  //  $("ul.sub-menu").hide();
		  //});
		  
		}else if($(window).width() > 767){
			$(".column ul.sub-menu").show();
		}
	
	$('#accordion').collapse({
  toggle: false,
  parent:false
})
	// if($('.panel-heading').parent().children('.panel-collapse').hasClass('in')){
	// 			$('#headingOne').css('background-color','#E42E29')
	// 		}
	// 	$('.panel-heading').click(function(){
	// 		if($(this).parent().children('.panel-collapse').hasClass('in')){
	// 			$(this).css('background-color','#f9f9f9')
	// 			//$('.panel-heading').css('background-color','#E42E29')
	// 		}else{
	// 			$(this).css('background-color','#E42E29')
	// 			//$('.panel-heading').css('background-color','#f9f9f9')
	// 		}
	// 	})
/*country-autocomplete*/
var countries = [
   { value: 'Poland' },
   { value: 'Japan'},
   { value: 'USA'},
   { value: 'Chaina'}
];

// $('#country-autocomplete').autocomplete({
//     source: countries,
//     onSelect: function (suggestion) {
//        ('#country-autocomplete').val(suggestion.value);
//     }
// });
/*end-person*/
var persons = ['Mrs. Junko Tabei', 'Ms. Wanda Rutkewicz', 'Ms. Bachendripal', 'Ms. JBachendripal'
];
// 	$('#person-name').autocomplete({
//         source: persons,
//     onSelect: function (suggestion) {
//        ('#person-name').val(suggestion.value);
//     }
// });
	$('#person-name').autocomplete({
        serviceUrl: base_url+'/autocomplete/search?type=name',
        dataType: 'json',
        type: 'GET',
        onSelect: function (suggestion) {
            $('#person-name').val(suggestion.value);
        },
});

	/*date-autocompelete*/
	var date = ['16.5.1975', '17.5.1975', '18.5.1975'
];
// 	$('#summitteer-date').autocomplete({
//         source: date,
//     onSelect: function (suggestion) {
//        ('#summitteer-date').val(suggestion.value);
//     }
// });

/*append-anchor*/
	$('.home .more-btn').prepend("<span class='dots'></span>"+"<span class='dots'></span>"+"<span class='dots'></span>");

    $( ".trekking-page .feature-box").each(function( i ){
    	$(this).wrap('<a href="classic-everest/'+ i +'">');
    })
	
	$( ".everest-page .feature-box").wrap("<a href='#'>");

	$( " .fb").empty().append("<i class='fa fa-facebook' aria-hidden='true'></i>");
	$( " .twitter").empty().append("<i class='fa fa-twitter' aria-hidden='true'></i>");
	$( " .instagram").empty().append("<i class='fa fa-instagram' aria-hidden='true'></i>");
	$( ".pinterest").empty().append("<i class='fa fa-pinterest-p' aria-hidden='true'></i>");
	$( ".envelope").empty().append("<i class='fa fa-envelope-o' aria-hidden='true'></i>");

	$(".classic-everest-page .trek-type").append("<span id='difficult'></span>"+"<span id='hard'></span>"+"<span id='medium'></span>"+"<span id='easy' class='selected'></span>");

})
})(window.jQuery);


$(window).resize(function(){
	if ($(window).width() < 767) {
				$('.sub-menu').hide()

			$('.column').each(function() {
		    var $column = $('.column');

		    $(document).on('click','a.title .fa-angle-down',function(e) {
		      e.stopPropagation();
		      $div =  $(this).parent().parent().children("ul.sub-menu");
		      $div.show('slow');
		      $("ul.sub-menu").not($div).hide();
		      return false;
		    });

		});
		    
		
		}else if($(window).width() > 767){
			$(".column ul.sub-menu").show();
		}
});

/*jQuery('.mega-menu .fa-angle-down').click(function(){
	if(jQuery('.mobile-nav ul li .sub-menu').hasClass('sub-open')){
	    jQuery('.mobile-nav ul li .sub-menu').parent().children().removeClass('sub-open');
	    jQuery(this).parent().children().toggleClass('sub-open')
	}else{
	  jQuery(this).parent().children().toggleClass('sub-open')
	}

	if(jQuery(this).has('.sub-menu')){
	jQuery(this).parent().children().toggleClass('sub-open')
	}
});*/








  
     

   

          
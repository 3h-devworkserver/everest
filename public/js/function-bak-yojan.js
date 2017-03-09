(function($) {
$(document).ready(function(){
        //sidebar sticky for booking page
        var win = $(window).width()
        if(win > 767){
    var element = $('.travel-booking .sidebar-travel'),
        originalY = element.offset().top;
        var footerTopPos = $('footer').height() + 200;
    // Space between element and top of screen (when scrolling)
    var topMargin = 20;
    //console.log(footerTopPos)
    // Should probably be set in CSS; but here just for emphasis
    element.css('position', 'relative');
    
    $(window).on('scroll', function(event) {
        var scrollTop = $(window).scrollTop();
       
        var height = $('#traveller-info').height() + $('header').height() - footerTopPos + topMargin
        if((scrollTop - originalY + topMargin) < height){
            element.stop(false, false).animate({
            top: scrollTop < originalY
                    ? 0
                    : scrollTop - originalY + topMargin
        }, 300);
        }
        
    });
}

	if ($('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}

	// //owl carousel initalizing
	//var owl = $("#owl-demo.flight-schedule");

      $("#owl-demo.flight-schedule").owlCarousel({

        
        itemsCustom : [
          [0, 2],
          [450, 4],
          [600, 5],
          [700, 5],
          [1000, 6],
          [1200, 6],
          [1400, 6],
          [1600, 6]
        ],
        autoPlay:false,
        navigation : true,
        pagination: false,            
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]

      });

      //flight features
      $("#owl-demo.flightfeatures").owlCarousel({
 
		      navigation : false, // Show next and prev buttons
		      slideSpeed : 300,
		      pagination: true,
		      paginationSpeed : 400,
		      singleItem:true
		 
		});

	$('#myTab').tabCollapse();
	
	//tooltip
	$('[data-toggle="tooltip"]').tooltip()
	//collapse close button
	$("#closepanel, #closepanel1").on("click", function() {
		$(this).parent().parent('.collapse').removeClass('in');
		//$('.collapse').removeClass('in');
	});

	//for plus minus counter button
	 $('.btn-number').click(function(e){
        e.preventDefault();
        
        var fieldName = $(this).attr('data-field');
        var type      = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {
                var minValue = parseInt(input.attr('min')); 
                if(!minValue) minValue = 1;
                if(currentVal > minValue) {
                    input.val(currentVal - 1).change();
                } 
                if(parseInt(input.val()) == minValue) {
                    $(this).attr('disabled', true);
                }
    
            } else if(type == 'plus') {
                var maxValue = parseInt(input.attr('max'));
                if(!maxValue) maxValue = 9999999999999;
                if(currentVal < maxValue) {
                    input.val(currentVal + 1).change();
                }
                if(parseInt(input.val()) == maxValue) {
                    $(this).attr('disabled', true);
                }
    
            }
        } else {
            input.val(0);
        }
    });
    $('.input-number').focusin(function(){
       $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function() {
        
        var minValue =  parseInt($(this).attr('min'));
        var maxValue =  parseInt($(this).attr('max'));
        if(!minValue) minValue = 1;
        if(!maxValue) maxValue = 9999999999999;
        var valueCurrent = parseInt($(this).val());
        
        var name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        
        
    });
    $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                 // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) || 
                 // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                     // let it happen, don't do anything
                     return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
    });


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

	// $(function() {
	//     $( "#from" ).datepicker({
	//     	'dateFormat': 'dd M yy',
	// 	      defaultDate: "+1w",
	// 	      changeMonth: true,
	// 	      numberOfMonths: 1,
	// 	      onClose: function( selectedDate ) {
	// 	        $( "#to" ).datepicker( "option", "minDate", selectedDate );
	//       }
	//     });
	//     $( "#to" ).datepicker({
	//     	'dateFormat': 'dd M yy',
	// 	      defaultDate: "+1w",
	// 	      changeMonth: true,
	// 	      numberOfMonths: 1,
	// 	      onClose: function( selectedDate ) {
	// 	        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
	//       }
	//     });
 //  	});

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
	// 			$('#headingOne').css('background-color','#e42e2a')
	// 		}
	// 	$('.panel-heading').click(function(){
	// 		if($(this).parent().children('.panel-collapse').hasClass('in')){
	// 			$(this).css('background-color','#f9f9f9')
	// 			//$('.panel-heading').css('background-color','#e42e2a')
	// 		}else{
	// 			$(this).css('background-color','#e42e2a')
	// 			//$('.panel-heading').css('background-color','#f9f9f9')
	// 		}
	// 	})

});

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








  
     

   

          
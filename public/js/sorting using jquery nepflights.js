 jQuery(document).ready(function(){

            $('#return').attr("disabled","disabled");

            if($('#one_way').is(":checked")) $('#return').attr("disabled","disabled");
            if($('#round_way').is(":checked")) $('#return').removeAttr("disabled");
            
            $('#one_way').click(function()
            {
              $('#return').attr("disabled","disabled");
            });

            $('#round_way').click(function()
            {
              $('#return').removeAttr("disabled");
            });
            
            $("#lowprice").hide();
            $("#earlyflight").hide();
            $("#flightfromZ").hide();

            // Default sorting by price
            var $wrapper = $('.searchBoxWrapper');
            $wrapper.find('.searchBox').sort(function (a, b) {
                return +a.dataset.price - +b.dataset.price;
            })
            .appendTo( $wrapper );

            // sorting by high price to low price
            $("#highprice").click(function(){
                var $wrapper = $('.searchBoxWrapper');
                $wrapper.find('.searchBox').sort(function (a, b) {
                    return +b.dataset.price - +a.dataset.price;
                })
                .appendTo( $wrapper );
                $("#highprice").hide();
                $("#lowprice").show();
            });

            // sorting by low price to high price
            $("#lowprice").click(function(){
                var $wrapper = $('.searchBoxWrapper');
                $wrapper.find('.searchBox').sort(function (a, b) {
                    return +a.dataset.price - +b.dataset.price;
                })
                .appendTo( $wrapper );
                $("#highprice").show();
                $("#lowprice").hide();
            });


            // sorting by early flight to late flight
            $("#earlyflight").click(function(){
                var $wrapper = $('.searchBoxWrapper');
                $wrapper.find('.searchBox').sort(function (a, b) {
                    return +a.dataset.time - +b.dataset.time;
                })
                .appendTo( $wrapper );  
                $("#earlyflight").hide();
                $("#lateflight").show();
            });

            // sorting by late flight to early flight
            $("#lateflight").click(function(){
                var $wrapper = $('.searchBoxWrapper');
                $wrapper.find('.searchBox').sort(function (a, b) {
                    return +b.dataset.time - +a.dataset.time;
                })
                .appendTo( $wrapper );
                $("#earlyflight").show();
                $("#lateflight").hide();
            });

            // sorting by flight class A to Z
            $("#flightfromA").click(function(){
                var alphabeticallyOrderedDivs = $('.searchBox').sort(function(a, b) {
                return String.prototype.localeCompare.call($(a).data('class').toLowerCase(), $(b).data('class').toLowerCase());
                });
                var container = $(".searchBoxWrapper");
                container.append(alphabeticallyOrderedDivs);
                $('.onewayflightlist').append(container);
                $("#flightfromA").hide();
                $("#flightfromZ").show();
            });

            // sorting by flight class Z to A
            $("#flightfromZ").click(function(){
                var alphabeticallyOrderedDivs = $('.searchBox').sort(function(a, b) {
                return String.prototype.localeCompare.call($(b).data('class').toLowerCase(), $(a).data('class').toLowerCase());
                });
                var container = $(".searchBoxWrapper");
                container.append(alphabeticallyOrderedDivs);
                $('.onewayflightlist').append(container);
                $("#flightfromA").show();
                $("#flightfromZ").hide();
            });


            // sorting by flight by all fare
            $("#flightfareall").click(function(){
                $('.searchBox').show().filter('[data-fare="T"][data-fare="F"]').show();
            });

            // sorting by flight by refundable
            $("#flightrefundable").click(function(){
                $('.searchBox').hide().filter('[data-fare="T"]').show();
            });

            // sorting by flight by non-refundable
            $("#flightnonrefundable").click(function(){
               $('.searchBox').hide().filter('[data-fare="F"]').show();
            });

            // sorting by flight by airlines all
            $("#airlineall").click(function(){
                $('.searchBox').show().filter('[data-airlines="U4"][data-airlines="S1"][data-airlines="RMK"][data-airlines="TA"][data-airlines="YT"]').show();
            });

            $(".airline-filter").on("change", "input[type=checkbox]", function () {
                $(".searchBoxWrapper .searchBox").hide();
                var filter2HasChecked = $("[data-filter=flightair]:checked").length;
                $(".searchBoxWrapper .searchBox").each(function(i,v){
                    var $this = $(this);
                    if((!filter2HasChecked || $("#" + $this.data("airlines")).is(":checked"))){
                       $this.show();
                    }        
                });
            });

            // Return
            $("#returnlowprice").hide();
            $("#returnearlyflight").hide();
            $("#returnflightfromZ").hide();

            var $wrapper = $('.returnsearchBoxWrapper');
            $wrapper.find('.returnsearchBox').sort(function (a, b) {
                return +a.dataset.price - +b.dataset.price;
            })
            .appendTo( $wrapper );

            // sorting by high price to low price
            $("#returnhighprice").click(function(){
                var $wrapper = $('.returnsearchBoxWrapper');
                $wrapper.find('.returnsearchBox').sort(function (a, b) {
                    return +b.dataset.price - +a.dataset.price;
                })
                .appendTo( $wrapper );
                $("#returnhighprice").hide();
                $("#returnlowprice").show();
            });

            // sorting by low price to high price
            $("#returnlowprice").click(function(){
                var $wrapper = $('.returnsearchBoxWrapper');
                $wrapper.find('.returnsearchBox').sort(function (a, b) {
                    return +a.dataset.price - +b.dataset.price;
                })
                .appendTo( $wrapper );
                $("#returnhighprice").show();
                $("#returnlowprice").hide();
            });


            // sorting by early flight to late flight
            $("#returnearlyflight").click(function(){
                var $wrapper = $('.returnsearchBoxWrapper');
                $wrapper.find('.returnsearchBox').sort(function (a, b) {
                    return +a.dataset.time - +b.dataset.time;
                })
                .appendTo( $wrapper ); 
                $("#returnearlyflight").hide();
                $("#returnlateflight").show(); 
            });

            // sorting by late flight to early flight
            $("#returnlateflight").click(function(){
                var $wrapper = $('.returnsearchBoxWrapper');
                $wrapper.find('.returnsearchBox').sort(function (a, b) {
                    return +b.dataset.time - +a.dataset.time;
                })
                .appendTo( $wrapper );
                $("#returnearlyflight").show();
                $("#returnlateflight").hide();
            });

            // sorting by flight class A to Z
            $("#returnflightfromA").click(function(){
                var alphabeticallyOrderedDivs = $('.returnsearchBox').sort(function(a, b) {
                return String.prototype.localeCompare.call($(a).data('class').toLowerCase(), $(b).data('class').toLowerCase());
                });
                var container = $(".returnsearchBoxWrapper");
                container.append(alphabeticallyOrderedDivs);
                $('.returnflightlist').append(container);
                $("#returnflightfromA").hide();
                $("#returnflightfromZ").show();
            });

            // sorting by flight class Z to A
            $("#returnflightfromZ").click(function(){
                var alphabeticallyOrderedDivs = $('.returnsearchBox').sort(function(a, b) {
                return String.prototype.localeCompare.call($(b).data('class').toLowerCase(), $(a).data('class').toLowerCase());
                });
                var container = $(".returnsearchBoxWrapper");
                container.append(alphabeticallyOrderedDivs);
               $('.returnflightlist').append(container);
               $("#returnflightfromA").show();
               $("#returnflightfromZ").hide();
            });


            // sorting by flight by all fare
            $("#returnflightfareall").click(function(){
                $('.returnsearchBox').show().filter('[data-fare="T"][data-fare="F"]').show();
            });

            // sorting by flight by refundable
            $("#returnflightrefundable").click(function(){
                $('.returnsearchBox').hide().filter('[data-fare="T"]').show();
            });

            // sorting by flight by non-refundable
            $("#returnflightnonrefundable").click(function(){
               $('.returnsearchBox').hide().filter('[data-fare="F"]').show();
            });

            // sorting by flight by airlines all
            $("#returnairlineall").click(function(){
                $('.returnsearchBox').show().filter('[data-airlines="U4"][data-airlines="S1"][data-airlines="RMK"][data-airlines="TA"][data-airlines="YT"]').show();
            });

            $(".return-airline-filter").on("change", "input[type=checkbox]", function () {
                $(".returnsearchBoxWrapper .returnsearchBox").hide();
                var filter2HasChecked = $("[data-filter=flightair]:checked").length;
                $(".returnsearchBoxWrapper .returnsearchBox").each(function(i,v){
                    var $this = $(this);
                    if((!filter2HasChecked || $("#" + $this.data("airlines")).is(":checked"))){
                       $this.show();
                    }        
                });
            });

        });
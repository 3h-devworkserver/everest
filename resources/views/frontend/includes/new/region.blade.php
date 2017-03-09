<?php /* ?><section class="full-width-search">
	<div class="container">
		<div class="row">
			<form class="form-inline">
				<div class="form-group col-md-5 col-xs-5 col-sm-5">
					<select class="SlectBox form-control">
						<option selected="selected">Select Region</option>
						<option>Annapurna</option>
						<option>Mustang</option>
						<option value="Makalu">Makalu</option>
					</select>
				</div>
				<div class="form-group col-md-5 col-xs-5 col-sm-5">
					<select class="SlectBox form-control" placeholder="this is placeholder">
						<option selected="selected">Select Adventure</option>
						<option>Bungyjumping</option>
						<option>Paragliding</option>
						<option value="Makalu">Rafting</option>
					</select>
				</div>
				<div class="form-group  col-md-2 col-xs-2 col-sm-2">
					<button type="submit" class="btn btn-default">Select</button>
				</div>
			</form>
		</div>
	</div>
</section><?php */ ?>
<section class="full-width-search">
		<div class="container">
			<div class="row">
				<form class="form-inline">
					<div class="form-group col-md-10 col-xs-12 col-sm-10">
					<!--	<select class="SlectBox form-control">
							<option selected="selected">Search Upeverest</option>
							<option>Annapurna</option>
							<option>Mustang</option>
							<option value="Makalu">Makalu</option>
						</select>
                                          -->
                                          
                                          <input id="autosuggest" placeholder="Find your Adventure in Nepal" />
                                          
                                          
					</div>
					<!-- <div class="form-group col-md-5 col-xs-5 col-sm-5">
						<select class="SlectBox form-control" placeholder="this is placeholder">
							<option selected="selected">Select Adventure</option>
							<option>Bungyjumping</option>
							<option>Paragliding</option>
							<option value="Makalu">Rafting</option>
						</select>
					</div> -->
					<div class="form-group  col-md-2 col-xs-2 col-sm-2">
						<button type="submit" class="btn btn-default">Search</button>
					</div> 
				</form>
			</div>
		</div>
	</section>


<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
      
  
  $( function() {
    $( "#autosuggest" ).autocomplete({
        
        source : function(request, response) {
        $.ajax({
            url: '<?=url().'/autocomplete/search'?>',
            data: { _token : "{{ csrf_token() }}",searchText:$( "#autosuggest" ).val()},
            dataType: "json",
            type: "POST",
            success: function(data) { 
                
                
                response($.map(data, function(obj) {
                   
                    return {
                        label: obj.keyword,
                        value: obj.url
                    };
                }));
            }
        });
    },
      select: function( event, ui ) {
        event.preventDefault();
        $( "#autosuggest" ).val(ui.item.label);
        window.location.href = ui.item.value;
      
      
      }
    });
  } );
  
  </script>
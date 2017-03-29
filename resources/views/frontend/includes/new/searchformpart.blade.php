<div class="booking-form">
    <div class="tab-wrapper">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#roundtrip" aria-controls="roundtrip" role="tab" data-toggle="tab">Round Trip</a></li>
            <li role="presentation"><a href="#oneway" aria-controls="oneway" role="tab" data-toggle="tab">One Way</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="roundtrip">
                <div class="row">
                    <form action="{{url('/flight/search')}}" class="flightSearchForm loaderDisplay" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" class="token">
                        <div class="col-md-7 col-sm-7">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>From <em>*</em></label>
                                        <select name="departure" placeholder="Your place of departure" class="form-control locations">
                                            <option value=""></option>
                                            <?php if (empty($departure)) {
                                                    $departure = '';
                                                } ?> @foreach($sector as $sect) @if($sect->SectorCode == $departure)
                                            <option value="{{$sect->SectorCode}}" selected="selected">{{$sect->SectorName}} @else
                                                <option value="{{$sect->SectorCode}}">{{$sect->SectorName}}
                                                </option>
                                                @endif @endforeach
                                        </select>
                                    </div>
                                    <?php /* ?>
                                    <input type="text" name="departure" class="form-control locations" placeholder="Your place of departure">
                                    <input type="hidden" name="depart" class="loc">
                                    <?php */ ?>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>To <em>*</em></label>
                                        <select name="arrival" placeholder="Your Destination" class="form-control locations">
                                            <option value=""></option>
                                            <?php if (empty($arrival)) {
                                                        $arrival = '';
                                                    } ?> @foreach($sector as $sect) @if($sect->SectorCode == $arrival)
                                            <option value="{{$sect->SectorCode}}" selected="selected">{{$sect->SectorName}} @else
                                                <option value="{{$sect->SectorCode}}">{{$sect->SectorName}}
                                                </option>
                                                @endif @endforeach
                                        </select>
                                        {{--
                                        <input type="text" class="form-control" placeholder="Your Destination"> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label>Adult: 12+yrs</label>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                                                    <button type="button" class="btn btn-default btn-number" @if(!empty($adult)) @if($adult == 0) disabled="disabled" @endif @else disabled="disabled" @endif data-type="minus" data-field="adult">
                                                                                        <span class="glyphicon glyphicon-minus"></span>
                                                    </button>
                                                    </span>
                                                    <input type="text" name="adult" class="form-control input-number" value="{{$adult or 1}}" min="0" max="100">
                                                    <span class="input-group-btn">
                                                                                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="adult">
                                                                                        <span class="glyphicon glyphicon-plus"></span>
                                                    </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label>Child:2-12yrs</label>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                                                <button type="button" class="btn btn-default btn-number" @if(!empty($child)) @if($child == 0) disabled="disabled" @endif @else disabled="disabled" @endif data-type="minus" data-field="child">
                                                                                    <span class="glyphicon glyphicon-minus"></span>
                                                    </button>
                                                    </span>
                                                    <input type="text" name="child" class="form-control input-number" value="{{$child or 0}}" min="0" max="100">
                                                    <span class="input-group-btn">
                                                                                <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="child">
                                                                                    <span class="glyphicon glyphicon-plus"></span>
                                                    </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <!--    <label>Infant:0-2 yrs</label
                                                                        >
                                                                    <div class="input-group">
                                                                      <span class="input-group-btn">
                                                                          <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="infant">
                                                                              <span class="glyphicon glyphicon-minus"></span>
                                                                          </button>
                                                                      </span>
                                                                      <input type="text" name="infant" class="form-control input-number" value="{{$infant or 0}}" min="0" max="100">
                                                                      <span class="input-group-btn">
                                                                          <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="infant">
                                                                              <span class="glyphicon glyphicon-plus"></span>
                                                                          </button>
                                                                      </span>
                                                                  </div> -->
                                            <div class="form-group">
                                                <label>Nationality<em>*</em></label>
                                                @if(empty($country)) {!! Form::select('country', $countries, 'NP', ['class' => 'form-control country']) !!} @else {!! Form::select('country', $countries, $country, ['class' => 'form-control country']) !!} @endif
                                            </div>
                                            <!-- <input type="text" class="form-control" placeholder="Enter Promotional Code"> -->
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-12">
                                                            <div class="btn-group" data-toggle="buttons">
                                                              <label class="btn btn-info active">
                                                                <input type="radio" name="options" id="option1" autocomplete="off" checked> Economy
                                                              </label>
                                                              <label class="btn btn-info">
                                                                <input type="radio" name="options" id="option2" autocomplete="off"> Premium Economy
                                                              </label>
                                                              <label class="btn btn-info">
                                                                <input type="radio" name="options" id="option3" autocomplete="off">Business
                                                              </label>
                                                            </div>
                                                        </div> -->
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Departing <em>*</em></label>
                                        <input type="text" name="date_depart" class="form-control datepicker datedepart" placeholder="Your Departure Date" value="{{$date_depart or ''}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Returning <em>*</em></label>
                                        <input type="text" name="date_return" class="form-control datepicker datereturn" placeholder="Your Returning Date" value="{{$date_return or ''}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!--
                                                        <div class="col-md-6 col-sm-6">
                                                            <label>Promotion Code <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Promotion Code"></i></label>
                                                        <input type="text" class="form-control" placeholder="Enter Promotional Code">

                                                        </div> -->
                                <input type="hidden" name="trip_type" value="R">
                                <div class="col-md-6 col-sm-6">
                                    <button class="btn btn-danger btn-block btnSearch">
                                        Search Flight
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="oneway">
                <div class="row">
                    <form action="{{url('/flight/search')}}" class="flightSearchForm2 loaderDisplay" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" class="token">
                        <div class="col-md-7 col-sm-7">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>From <em>*</em></label>
                                        <select name="departure" placeholder="Your place of departure" class="form-control locations">
                                            <option value=""></option>
                                            <?php if (empty($departure)) {
                                                                    $departure = '';
                                                                } ?> @foreach($sector as $sect) @if($sect->SectorCode == $departure)
                                            <option value="{{$sect->SectorCode}}" selected="selected">{{$sect->SectorName}} @else
                                                <option value="{{$sect->SectorCode}}">{{$sect->SectorName}}
                                                </option>
                                                @endif @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>To <em>*</em></label>
                                        <select name="arrival" placeholder="Your Destination" class="form-control locations">
                                            <option value=""></option>
                                            <?php if (empty($arrival)) {
                                                                        $arrival = '';
                                                                    } ?> @foreach($sector as $sect) @if($sect->SectorCode == $arrival)
                                            <option value="{{$sect->SectorCode}}" selected="selected">{{$sect->SectorName}} @else
                                                <option value="{{$sect->SectorCode}}">{{$sect->SectorName}}
                                                </option>
                                                @endif @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label>Adult: 12+yrs</label>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default btn-number" @if(!empty($adult)) @if($adult == 0) disabled="disabled" @endif @else disabled="disabled" @endif data-type="minus" data-field="adult">
                                                                <span class="glyphicon glyphicon-minus"></span>
                                                    </button>
                                                    </span>
                                                    <input type="text" name="adult" class="form-control input-number" value="{{$adult or 1}}" min="0" max="100">
                                                    <span class="input-group-btn">
                                                                                        <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="adult">
                                                                                            <span class="glyphicon glyphicon-plus"></span>
                                                    </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label>Child:2-12yrs</label>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default btn-number" @if(!empty($child)) @if($child == 0) disabled="disabled" @endif @else disabled="disabled" @endif data-type="minus" data-field="child">
                                                                <span class="glyphicon glyphicon-minus"></span>
                                                    </button>
                                                    </span>
                                                    <input type="text" name="child" class="form-control input-number" value="{{$child or 0}}" min="0" max="100">
                                                    <span class="input-group-btn">
                                                                                        <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="child">
                                                                                            <span class="glyphicon glyphicon-plus"></span>
                                                    </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <!--    <label>Infant:0-2 yrs</label
                                                                                >
                                                                                <div class="input-group">
                                                                                    <span class="input-group-btn">
                                                                                        <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="infant">
                                                                                            <span class="glyphicon glyphicon-minus"></span>
                                                                                        </button>
                                                                                    </span>
                                                                                    <input type="text" name="infant" class="form-control input-number" value="{{$infant or 0}}" min="0" max="100">
                                                                                    <span class="input-group-btn">
                                                                                        <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="infant">
                                                                                            <span class="glyphicon glyphicon-plus"></span>
                                                                                        </button>
                                                                                    </span>
                                                                                </div>
                                                                                -->
                                            <div class="form-group">
                                                <label>Nationality<em>*</em></label>
                                                @if(empty($country)) {!! Form::select('country', $countries, 'NP', ['class' => 'form-control country']) !!} @else {!! Form::select('country', $countries, $country, ['class' => 'form-control country']) !!} @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-12">
                                                            <div class="btn-group" data-toggle="buttons">
                                                              <label class="btn btn-info active">
                                                                <input type="radio" name="options" id="option1" autocomplete="off" checked> Economy
                                                              </label>
                                                              <label class="btn btn-info">
                                                                <input type="radio" name="options" id="option2" autocomplete="off"> Premium Economy
                                                              </label>
                                                              <label class="btn btn-info">
                                                                <input type="radio" name="options" id="option3" autocomplete="off">Business
                                                              </label>
                                                            </div>
                                                        </div> -->
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Departing <em>*</em></label>
                                        <input type="text" name="date_depart" class="form-control datepicker datedepart" placeholder="Your Departure Date" value="{{$date_depart or ''}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Returning <em>*</em></label>
                                        <input type="text" name="date_return" class="form-control datepicker datereturn" placeholder="Your Returning Date" value="{{$date_return or ''}}" disabled>
                                        <!-- <label>Returning <em>*</em></label>
                                                            <input type="text" class="form-control" placeholder="Your Returning Date"> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!--
                                                    <div class="col-md-6 col-sm-6">
                                                        <label>Promotion Code <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Promotion Code"></i></label>
                                                        <input type="text" class="form-control" placeholder="Enter Promotional Code">
                                                    </div>
                                                    -->
                                <input type="hidden" name="trip_type" value="O">
                                <div class="col-md-6 col-sm-6">
                                    <button class="btn btn-danger btn-block btnSearch">
                                        Search Flight
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

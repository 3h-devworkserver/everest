@extends('frontend.layouts.master-new')
@section('title') Flight Passengers Detail | {{ $siteTitle or '' }}@endsection
@section('meta_keywords'){{ $meta_keywords }}@endsection
@section('meta_desc'){{ $meta_desc }}@endsection

@section('loader')
@include('frontend.includes.new.loader')
@endsection

@section('content')
@include('frontend.includes.new.functions')
 <section class="main-content">
        <div class="flight-booking-progress-step">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="progress-step progress-step--medium list-unstyled">
                            <!-- <li class="is-complete"> -->
                            <li class="is-complete">
                                <span class="circle">
                                    <i class="fa fa-check"></i>
                                </span>
                                <span class="progress-text">Selection</span>
                            </li>
                            <!-- <li class="is-active"> -->
                            <li class="is-complete">
                                <span class="circle">
                                    <i class="fa fa-file-text"></i>
                                </span>
                                <span class="progress-text">Review</span>
                            </li>
                            <li class="is-active">
                                <span class="circle">
                                    <i class="fa fa-user"></i>
                                </span>
                                <span class="progress-text">Passanger Details</span>
                            </li>
                            <li>
                                <span class="circle">
                                    <i class="fa fa-credit-card"></i>
                                </span>
                                <span class="progress-text">Payment</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="flight-wrapper flight-payment">
            <div class="container">
                <div class="flight-list-block">
                    <div class="flight-review-header">
                        <div class="row">
                            <div class="first-row">
                            
                                <div class="col-md-3 col-sm-3 text-right pull-right">
                                    {!! Form::open(['url'=>'/flight/search', 'class' => 'modifyFlightSearchForm loaderDisplay'])!!}
                                        {!!Form::hidden('departure', $departure)!!}
                                        {!!Form::hidden('arrival', $arrival)!!}
                                        {!!Form::hidden('adult', $flightDetail->Adult)!!}
                                        {!!Form::hidden('child', $flightDetail->Child)!!}
                                        {!!Form::hidden('country', $country)!!}
                                        {!!Form::hidden('date_depart', $flightDetail->FlightDate)!!}
                                        @if($trip_type == 'R')
                                        {!!Form::hidden('date_return', $returnFlightDetail->FlightDate)!!}
                                        @else
                                        {!!Form::hidden('date_return', '')!!}
                                        @endif
                                        {!!Form::hidden('trip_type', $trip_type)!!}

                                        <button class="btn btn-back"><i class="fa fa-angle-left"></i>Back To Flight List</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <article class="box-flight @if($trip_type == 'O') oneway-flight @endif">
                        <div class="row-fluid">
                            
                            <div class="details">
                                <div class="details-wrapper">
                                    <div class="second-row">
                                        <div class="col-md-10 col-sm-10">
                                            <div class="row-fluid time">
                                                @if(empty($returnFlightDetail))
                                                <div class="col-md-12">
                                                @else
                                                <div class="col-md-6">
                                                @endif
                                                @if(!empty($flightDetail))
                                                <div class="ailrline-wrap clearfix">
                                                    <div class="airlines-info">
                                                        <img src="{{$flightDetail->AirlineLogo}}" alt="">
                                                        <h4 class="box-title"><?php echo airlinesName($flightDetail->Airline); ?> <span class="badge">Class {{$flightDetail->FlightClassCode}}</span></h4>

                                                    </div>
                                                    <div class="baggage-info">
                                                    <span class="fare-type">
                                                            Fare Type : @if($flightDetail->Refundable == 'T') Refundable @else Non-Refundable @endif
                                                        </span>
                                                        <span class="baggage">
                                                            Baggage : @if(!empty($flightDetail->FreeBaggage)) {{$flightDetail->FreeBaggage}} @endif
                                                        </span>
                                                    </div>

                                                </div>

                                                    <h5><i class="fa fa-plane"></i>{{ucfirst(strtolower($flightDetail->Departure))}} <i class="fa fa-long-arrow-right"></i>{{ucfirst(strtolower($flightDetail->Arrival))}}</h5>
                                                    <div class="short-desc">
                                                        <span class="depart-date">
                                                            {{$flightDetail->DepartureTime}}
                                                             <small><?php echo (new DateTime($flightDetail->FlightDate))->format('j M Y') ?></small>
                                                        </span>
                                                        <span class="distance-line">
                                                            <span class="distance-time"><i class="fa fa-clock-o"></i><?php 
                                                                                $d1 = $flightDetail->FlightDate.' '.$flightDetail->DepartureTime;
                                                                                $d2 = $flightDetail->FlightDate.' '.$flightDetail->ArrivalTime;
                                                                                $datetime1 = new DateTime($d1);
                                                                                $datetime2 = new DateTime($d2);
                                                                                $interval = $datetime2->diff($datetime1);
                                                                                $elapsed = $interval->format('%h hr %i min');
                                                                                echo $elapsed;
                                                                                ?></span>
                                                            <span class="flight-name">{{$flightDetail->FlightNo}}</span>
                                                        </span>
                                                        <span class="arv-date">
                                                            {{$flightDetail->ArrivalTime}}
                                                            <small><?php echo (new DateTime($flightDetail->FlightDate))->format('j M Y') ?></small>
                                                        </span>
                                                    </div>
                                                @endif
                                                </div>
                                                @if(!empty($returnFlightDetail))
                                                <div class="col-md-6">
                                                <div class="ailrline-wrap clearfix">
                                                    <div class="airlines-info">
                                                        <img src="{{$returnFlightDetail->AirlineLogo}}" alt="">
                                                        <h4 class="box-title"><?php echo airlinesName($returnFlightDetail->Airline); ?> <span class="badge">Class {{$returnFlightDetail->FlightClassCode}}</span></h4>

                                                    </div>
                                                    <div class="baggage-info">
                                                    <span class="fare-type">
                                                            Fare Type : @if($returnFlightDetail->Refundable == 'T') Refundable @else Non-Refundable @endif
                                                        </span>
                                                        <span class="baggage">
                                                            Baggage : @if(!empty($returnFlightDetail->FreeBaggage)) {{$returnFlightDetail->FreeBaggage}} @endif
                                                        </span>
                                                    </div>

                                                </div>
                                                    <h5 class="return-flight"><i class="fa fa-plane"></i>{{ucfirst(strtolower($returnFlightDetail->Arrival))}} <i class="fa fa-long-arrow-left"></i>{{ucfirst(strtolower($returnFlightDetail->Departure))}}</h5>
                                                    <div class="short-desc">
                                                        <span class="depart-date">
                                                            {{$returnFlightDetail->ArrivalTime}}
                                                             <small><?php echo (new DateTime($returnFlightDetail->FlightDate))->format('j M Y') ?></small>
                                                        </span>
                                                        <span class="distance-line">
                                                            <span class="distance-time"><i class="fa fa-clock-o"></i><?php 
                                                                                $d1 = $returnFlightDetail->FlightDate.' '.$returnFlightDetail->DepartureTime;
                                                                                $d2 = $returnFlightDetail->FlightDate.' '.$returnFlightDetail->ArrivalTime;
                                                                                $datetime1 = new DateTime($d1);
                                                                                $datetime2 = new DateTime($d2);
                                                                                $interval = $datetime2->diff($datetime1);
                                                                                $elapsed = $interval->format('%h hr %i min');
                                                                                echo $elapsed;
                                                                                ?></span>
                                                            <span class="flight-name">{{$returnFlightDetail->FlightNo}}</span>
                                                        </span>
                                                        <span class="arv-date">
                                                            {{$returnFlightDetail->DepartureTime}}
                                                             <small><?php echo (new DateTime($returnFlightDetail->FlightDate))->format('j M Y') ?></small>
                                                        </span>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                       

                                            
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <div class="action">
                                                <div class="passanger-wrap">
                                                    <div>
                                                        <p>Adult</p>
                                                        <div class="passenger-count">
                                                            @if(!empty($flightDetail))
                                                                {{$flightDetail->Adult}}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <p>Child</p>
                                                        <div class="passenger-count">
                                                            @if(!empty($flightDetail))
                                                                {{$flightDetail->Child}}
                                                            @endif
                                                        </div>

                                                    </div>
                                                    <!--
                                                    <div>
                                                        <p>Infant</p>
                                                        <div class="passenger-count">
                                                            02
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <div class="grand-total">
                        <div class="row">
                            <div class="col-md-9 col-sm-8">
                                <section id="vertical">
                                    <h4>Passanger Details</h4>

                                    <form id="paxDetailForm" class="loaderDisplay" action="{{url('/flight/payment')}}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        {!! Form::hidden('adultno', $flightDetail->Adult, ['class'=>'adultno']) !!}
                                        {!! Form::hidden('childno', $flightDetail->Child, ['class'=>'childno']) !!}
                                        {!! Form::hidden('trip_type', $trip_type ) !!}
                                        {!! Form::hidden('departure', $flightDetail->Departure ) !!}
                                        {!! Form::hidden('arrival', $flightDetail->Arrival ) !!}
                                        {!! Form::hidden('country', $country ) !!}
                                        {!! Form::hidden('flight_id', $flightDetail->FlightId ) !!}
                                        {!! Form::hidden('flightDetail', json_encode($flightDetail) ) !!}
                                        {!! Form::hidden('departure_total', totalPrice($flightDetail->Adult, $flightDetail->Child, $flightDetail->AdultFare, $flightDetail->ChildFare, $flightDetail->ResFare, $flightDetail->FuelSurcharge, $flightDetail->Tax ) ) !!}
                                        @if($trip_type == 'R')
                                        {!! Form::hidden('return_total', totalPrice($returnFlightDetail->Adult, $returnFlightDetail->Child, $returnFlightDetail->AdultFare, $returnFlightDetail->ChildFare, $returnFlightDetail->ResFare, $returnFlightDetail->FuelSurcharge, $returnFlightDetail->Tax ) ) !!}
                                        {!! Form::hidden('returnflight_id', $returnFlightDetail->FlightId ) !!}
                                        {!! Form::hidden('returnFlightDetail', json_encode($returnFlightDetail) ) !!}
                                        {!! Form::hidden('totalAmount', totalPrice($returnFlightDetail->Adult, $returnFlightDetail->Child, $returnFlightDetail->AdultFare, $returnFlightDetail->ChildFare, $returnFlightDetail->ResFare, $returnFlightDetail->FuelSurcharge, $returnFlightDetail->Tax ) + totalPrice($flightDetail->Adult, $flightDetail->Child, $flightDetail->AdultFare, $flightDetail->ChildFare, $flightDetail->ResFare, $flightDetail->FuelSurcharge, $flightDetail->Tax )  )  !!}
                                        @else
                                        {!! Form::hidden('return_total', null ) !!}
                                        {!! Form::hidden('returnFlightDetail', null ) !!}
                                        {!! Form::hidden('totalAmount', totalPrice($flightDetail->Adult, $flightDetail->Child, $flightDetail->AdultFare, $flightDetail->ChildFare, $flightDetail->ResFare, $flightDetail->FuelSurcharge, $flightDetail->Tax ) )  !!}
                                        @endif
                                        

                                        {{-- <div id="example-vertical" style="display: none;"> --}}

                                        <?php $i =1; ?>
                                        @while($i <= $flightDetail->Adult)
                                        <li>Adult {{$i}}</li>
                                        <?php $i++; ?>
                                        @endwhile

                                        <?php $i =1; ?>
                                        @while($i <= $flightDetail->Child)
                                        <li>Child {{$i}}</li>
                                        <?php $i++; ?>
                                        @endwhile

                                            <?php 
                                                $i = 1;
                                                if(Auth::check()){
                                                    $lead = Auth::user();
                                                }
                                             ?>
                                            @while($i <= $flightDetail->Adult)
                                                <?php 
                                                    if($i == 1 && (!empty($lead))){
                                                        $leadAdult = 'true';
                                                    }else{
                                                        $leadAdult = '';
                                                    }
                                                 ?>
                                             <fieldset>
                                                <div class="tab-pane @if($i == 1)active @endif" id="adult{{$i}}">
                                                   
                                                    <article class="personal-info">
                                                        <div class="row-fluid">
                                                            <div class="col-md-12">
                                                                
                                                            <h5 class="passanger-title">Adult {{$i}}:</h5>
                                                            <p>
                                                                Please make sure that you enter the names of all passengers as shown on passports. This will avoid problems at the airport. Name changes are not permitted once the booking has been finalised.
                                                            </p>
                                                            <hr>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row-fluid">
                                                                <div class="col-md-12">
                                                                    <label for="">Full name <small>(as per passport)<em>*</em></small></label>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="row-fluid row-margin-adj">
                                                                <div class="col-md-2">
                                                                @if(!empty($leadAdult))
                                                                    <input name="adult_title[]" class="form-control" required readonly value="{{$lead->profile->title}}">
                                                                @else
                                                                    <select name="adult_title[]" id="" class="SlectBox form-control" required <?php  if(!empty($leadAdult)){
                                                                               echo "readonly";
                                                                            }  ?>>
                                                                        <option value="">Title</option>
                                                                        <option value="MR" <?php  if(!empty($leadAdult)){
                                                                                if($lead->profile->title == 'MR'){
                                                                                    echo 'selected = "selected"';
                                                                                }
                                                                            }  ?> >Mr</option>

                                                                        <option value="MRS" <?php  if(!empty($leadAdult)){
                                                                                if($lead->profile->title == 'MRS'){
                                                                                    echo 'selected = "selected"';
                                                                                }
                                                                            }  ?>>Mrs</option>
                                                                        <option value="MS" <?php  if(!empty($leadAdult)){
                                                                                if($lead->profile->title == 'MS'){
                                                                                    echo 'selected = "selected"';
                                                                                }
                                                                            }  ?>>Ms</option>
                                                                    </select>
                                                                @endif
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div class="row-fluid">
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="adult_fname[]" class="form-control" placeholder="First Name" <?php  if(!empty($leadAdult)){
                                                                               echo 'value="'.$lead->profile->fname.'"'.' '.'readonly';
                                                                            }  ?> required >
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="adult_mname[]" class="form-control" <?php  if(!empty($leadAdult)){
                                                                               echo 'value="'.$lead->profile->mname.'"'.' '.'readonly';
                                                                            }  ?> placeholder="Middle Name" >
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="adult_lname[]" class="form-control" <?php  if(!empty($leadAdult)){
                                                                               echo 'value="'.$lead->profile->lname.'"'.' '.'readonly';
                                                                            }  ?> placeholder="Last Name" required>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row-fluid">
                                                                <div class="col-md-4">
                                                                <label for="">Document Type</label>
                                                                    {!! Form::select('adult_document_type[]',['passport' => 'Passport', 'id-card'=> 'ID Card', 'birth-certificate'=>'Birth Certificate'], 'NP', ['class'=>'form-control SlectBox', 'required']) !!}
                                                                </div>
                                                                <div class="col-md-4">
                                                                <label for="">Document Number</label>
                                                                   <input type="text" name="adult_document_no[]" class="form-control" placeholder="Document Number" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                <label for="">Nationality</label>
                                                                @if(!empty($leadAdult))
                                                                    <?php /* ?>
                                                                    <input type="text" name="adult_nationality[]" class="form-control" required readonly value="{{$lead->profile->nationality}}">
                                                                    <?php */ ?>
                                                                    {!!Form::select('adult_nationality[]', [], null, ['class'=>'form-control countrylist', 'required' ]) !!}
                                                                    
                                                                @else
                                                                {!!Form::select('adult_nationality[]', [], null, ['class'=>'form-control countrylist', 'required' ]) !!}
                                                                    {{-- {!! Form::select('adult_nationality[]',$countries, 'NP', ['class'=>'form-control country', 'required']) !!} --}}
                                                                @endif
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row-fluid">
                                                                <div class="col-md-4">
                                                                <label for="">Phone Type</label>
                                                                   <select name="adult_phone_type[]" id="" class="SlectBox form-control">
                                                                        <option>Mobile</option>
                                                                        <option>Home</option>
                                                                        <option>Office</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                <label for="">Phone Number</label>
                                                                    <input type="text" name="adult_phone_no[]" class="form-control" placeholder="Phone Number" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                <label for="">Email</label>
                                                                    <input type="email" name="adult_email[]" <?php  if(!empty($leadAdult)){
                                                                               echo 'value="'.$lead->email.'"'.' '.'readonly';
                                                                            }  ?> class="form-control" placeholder="Email" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <div class="row-fluid">
                                                                <div class="col-md-4 col-sm-6">
                                                                    <label>Document Image</label>
                                                                    <span class="btn btn-primary btn-file btn-sm">
                                                                        <i class="fa fa-folder-open"></i>Upload
                                                                        <input type="file" id="image" class="image" name="adult_document_image[]" >
                                                                    </span>
                                                                    <span class="image-name"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if($i == 1)
                                                        <div class="form-group">
                                                            <div class="row-fluid">
                                                                <div class="col-md-12">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                          <input type="checkbox" name="main_traveller" value="{{$i}}" @if($i == 1) checked disabled @endif> I am Lead Traveller
                                                                          <input type="hidden" name="main_traveller" value="{{$i}}" @if($i == 1) checked @endif> 
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </article>
                                                        
                                                    
                                                </div>
                                            <?php $i++; ?>
                                            </fieldset>
                                            @endwhile

                                            <?php $i =1; ?>
                                            @while($i <= $flightDetail->Child)
                                            <?php  if($i == 1 && (!empty($lead)) && $flightDetail->Adult == '0' ){
                                                $leadChild = 'true';
                                            }else{
                                                $leadChild = '';
                                            }
                                            ?>
                                            <fieldset>
                                                <div class="tab-pane" id="child{{$i}}">
                                                   
                                                    <article class="personal-info">
                                                        <div class="row-fluid">
                                                            <div class="col-md-12">
                                                                
                                                            <h5 class="passanger-title">Child {{$i}}:</h5>
                                                            <p>
                                                                Please make sure that you enter the names of all passengers as shown on passports. This will avoid problems at the airport. Name changes are not permitted once the booking has been finalised.
                                                            </p>
                                                            <hr>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row-fluid">
                                                                <div class="col-md-12">
                                                                    <label for="">Full name</label>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="row-fluid row-margin-adj">
                                                                <div class="col-md-2">
                                                                    @if(!empty($leadChild))
                                                                        <input name="child_title[]" class="form-control" required readonly value="{{$lead->profile->title}}">
                                                                    @else
                                                                    <select name="child_title[]" id="" class="SlectBox form-control" required <?php  if(!empty($leadChild)){
                                                                               echo "readonly";
                                                                             } ?>>
                                                                        <option value="">Title</option>
                                                                        <option value="MR" <?php  if(!empty($leadChild)){
                                                                                if($lead->profile->title == 'MR'){
                                                                                    echo 'selected = "selected"';
                                                                                }
                                                                            }  ?> >Mr</option>
                                                                        <option value="MRS" <?php  if(!empty($leadChild)){
                                                                                if($lead->profile->title == 'MRS'){
                                                                                    echo 'selected = "selected"';
                                                                                }
                                                                            }  ?>>Mrs</option>
                                                                        <option value="MS" <?php  if(!empty($leadChild)){
                                                                                if($lead->profile->title == 'MS'){
                                                                                    echo 'selected = "selected"';
                                                                                }
                                                                            }  ?>>Ms</option>
                                                                    </select>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div class="row-fluid">
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="child_fname[]" class="form-control" <?php  if(!empty($leadChild)){
                                                                               echo 'value="'.$lead->profile->fname.'"'.' '.'readonly';
                                                                            }  ?> placeholder="First Name" required>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="child_mname[]" class="form-control" <?php  if(!empty($leadChild)){
                                                                               echo 'value="'.$lead->profile->mname.'"'.' '.'readonly';
                                                                            }  ?> placeholder="Middle Name" >
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="child_lname[]" class="form-control" <?php  if(!empty($leadChild)){
                                                                               echo 'value="'.$lead->profile->lname.'"'.' '.'readonly';
                                                                            }  ?> placeholder="Last Name" required>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row-fluid">
                                                                <div class="col-md-4">
                                                                <label for="">Document Type</label>
                                                                 {!! Form::select('child_document_type[]',['birth-certificate'=>'Birth Certificate','passport' => 'Passport', 'id-card'=> 'ID Card' ], 'NP', ['class'=>'form-control SlectBox', 'required']) !!}
                                                                </div>
                                                                <div class="col-md-4">
                                                                <label for="">Document Number</label>
                                                                   <input type="text" name="child_document_no[]"class="form-control" placeholder="Document Number" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                <label for="">Nationality</label>
                                                                    @if(!empty($leadChild))
                                                                        <?php /* ?>
                                                                        <input name=" type="text" child_nationality[]" class="form-control" required readonly value="{{$lead->profile->nationality}}">
                                                                        <?php */ ?>
                                                                    {!!Form::select('child_nationality[]', [], null, ['class'=>'form-control countrylist', 'required' ]) !!}
                                                                    
                                                                @else
                                                                {!!Form::select('child_nationality[]', [], null, ['class'=>'form-control countrylist', 'required' ]) !!}
                                                                    {{-- {!! Form::select('child_nationality[]',$countries, 'NP', ['class'=>'form-control country', 'required']) !!} --}}
                                                                @endif
                                                                </div>
                                                            
                                                            <?php /* ?>
                                                                <div class="col-md-4 doe">
                                                                <label for="">Date of Issue</label>
                                                                    <select name="child_issue_day[]" class="SlectBox daypicker form-control" required>
                                                                    <option value="">DD</option>
                                                                    </select>

                                                                    {!! Form::select('child_issue_month[]', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'SlectBox form-control', 'required' ]) !!}

                                                                        <select name="child_issue_year[]" class="childyearpicker SlectBox form-control" required>
                                                                            <option value="">YEAR</option>
                                                                        </select>
                                                                </div>
                                                                <?php */ ?>

                                                                
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="row-fluid">
                                                                <div class="col-md-4">
                                                                <label for="">Phone Type</label>
                                                                   <select name="child_phone_type[]" id="" class="SlectBox form-control">
                                                                        <option>Mobile</option>
                                                                        <option>Home</option>
                                                                        <option>Office</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                <label for="">Phone Number</label>
                                                                    <input type="text" name="child_phone_no[]" class="form-control" placeholder="Phone Number" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                <label for="">Email</label>
                                                                    <input type="email" name="child_email[]" @if(!empty($leadChild)) value="{{$lead->email}}" readonly @endif class="form-control" placeholder="Email" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="row-fluid">
                                                                <div class="col-md-12">
                                                                <label for="">Date of Birth</label>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="row-fluid">
                                                                <div class="col-md-4">
                                                                    <select name="child_dob_day[]" class="SlectBox daypicker form-control" required>
                                                                    <option value="">DD</option>
                                                                    </select>
                                                                    
                                                                </div>
                                                                <div class="col-md-4">
                                                                   
                                                                   {!! Form::select('child_dob_month[]', [''=>'MM', '1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec'], null, ['class'=>'SlectBox form-control', 'required']) !!}
                                                                   
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <select name="child_dob_year[]" class="childyearpicker SlectBox form-control" required>
                                                                        <option value="">YEAR</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="row-fluid">
                                                                <div class="col-md-4 col-sm-6">
                                                                    <label>Document Image</label>
                                                                    <span class="btn btn-primary btn-file btn-sm">
                                                                        <i class="fa fa-folder-open"></i>Upload
                                                                        <input type="file" id="image" class="image" name="child_document_image[]" >
                                                                    </span>
                                                                    <span class="image-name"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @if($flightDetail->Adult == '0')
                                                        @if($i==1)
                                                        <div class="form-group">
                                                            <div class="row-fluid">
                                                                <div class="col-md-12">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                          <input type="checkbox" name="main_child_traveller" value="{{$i}}" checked disabled> I am Lead Traveller
                                                                          <input type="hidden" name="main_child_traveller" value="{{$i}}" checked > 
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endif

                                                    </article>
                                                   
                                                </div>
                                            </fieldset>
                                            <?php $i++; ?>
                                            @endwhile

                                    </form>
                                </section>
                            </div>
                            <div class="col-md-3 col-sm-4 sidebar-total">
                                
                                <div class="flight-more-info">
                                    <ul id="myTab" class="nav nav-tabs hidden-xs" role="tablist">
                                        <li class="active" role="presentation">
                                            <a href="#a" aria-controls="home" role="tab" data-toggle="tab">Departure</a>
                                        </li>
                                        @if(!empty($returnFlightDetail))
                                        <li class="" role="presentation">
                                            <a href="#b" aria-controls="home1" role="tab" data-toggle="tab">Return</a>
                                        </li>
                                        @endif
                                    </ul>
                                    <div class="tab-content">
                                        @if(!empty($flightDetail))
                                        <div id="a" class="tab-pane active" role="tabpanel">
                                            <h4>Departure Fare Details</h4>
                                            <div class="btm-block">
                                                <div class="grand-total-block">
                                                    <h5>Base Fare</h5>
                                                    <table class="table">
                                                        @if($flightDetail->Adult != 0)
                                                        <tr>
                                                            <td>Adult(s) ‎({{$flightDetail->Adult}} X {{custom_number_format($flightDetail->AdultFare)}})‎</td>
                                                            <td>{{custom_number_format($flightDetail->Adult * $flightDetail->AdultFare)}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($flightDetail->Child != 0)
                                                        <tr>
                                                            <td>Child(s) ‎({{$flightDetail->Child}} X {{custom_number_format($flightDetail->ChildFare)}})‎</td>
                                                            <td>{{custom_number_format($flightDetail->Child * $flightDetail->ChildFare)}}</td>
                                                        </tr>
                                                        @endif
                                                    </table>
                                                    <h5>Surcharges :</h5>
                                                    <table class="table">
                                                        @if($flightDetail->Adult != 0)
                                                        <tr>
                                                            <td>Adult(s) ‎({{$flightDetail->Adult}} X {{custom_number_format($flightDetail->FuelSurcharge)}})‎</td>
                                                            <td>{{custom_number_format($flightDetail->Adult * $flightDetail->FuelSurcharge)}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($flightDetail->Child != 0)
                                                        <tr>
                                                            <td>Child(s) ‎({{$flightDetail->Child}} X {{custom_number_format($flightDetail->FuelSurcharge)}})‎</td>
                                                            <td>{{custom_number_format($flightDetail->Child * $flightDetail->FuelSurcharge)}}</td>
                                                        </tr>
                                                        @endif
                                                    </table>
                                                    <h5>Taxes and Fees :</h5>
                                                    <table class="table">
                                                        @if($flightDetail->Adult != 0)
                                                        <tr>
                                                            <td>Adult(s) ‎({{$flightDetail->Adult}} X {{custom_number_format($flightDetail->Tax + $flightDetail->ResFare)}})‎</td>
                                                            <td>{{custom_number_format($flightDetail->Adult * ($flightDetail->Tax + $flightDetail->ResFare))}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($flightDetail->Child != 0)
                                                        <tr>
                                                            <td>Child(s) ‎({{$flightDetail->Child}} X {{custom_number_format($flightDetail->Tax + $flightDetail->ResFare)}})‎</td>
                                                            <td>{{custom_number_format($flightDetail->Child * ($flightDetail->Tax + $flightDetail->ResFare))}}</td>
                                                        </tr>
                                                        @endif
                                                    </table>

                                                    <div class="total-block">
                                                        <h3>Total Amount
                                                        </h3>
                                                    </div>
                                                    <div class="total-block price">
                                                        <h3>{{$flightDetail->Currency}} <?php echo custom_number_format(totalPrice($flightDetail->Adult, $flightDetail->Child, $flightDetail->AdultFare, $flightDetail->ChildFare, $flightDetail->ResFare, $flightDetail->FuelSurcharge, $flightDetail->Tax )) ?></h3>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                        @endif
                                        @if(!empty($returnFlightDetail))
                                        <div id="b" class="tab-pane" role="tabpanel">
                                            <h4>Return Fare Details</h4>
                                            <div class="btm-block">
                                                <div class="grand-total-block">
                                                    <h5>Base Fare</h5>
                                                    <table class="table">
                                                        @if($returnFlightDetail->Adult != 0)
                                                        <tr>
                                                            <td>Adult(s) ‎({{$returnFlightDetail->Adult}} X {{custom_number_format($returnFlightDetail->AdultFare)}})‎</td>
                                                            <td>{{custom_number_format($returnFlightDetail->Adult * $returnFlightDetail->AdultFare)}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($returnFlightDetail->Child != 0)
                                                        <tr>
                                                            <td>Child(s) ‎({{$returnFlightDetail->Child}} X {{custom_number_format($returnFlightDetail->ChildFare)}})‎</td>
                                                            <td>{{custom_number_format($returnFlightDetail->Child * $returnFlightDetail->ChildFare)}}</td>
                                                        </tr>
                                                        @endif
                                                    </table>
                                                    <h5>Surcharges :</h5>
                                                    <table class="table">
                                                        @if($returnFlightDetail->Adult != 0)
                                                        <tr>
                                                            <td>Adult(s) ‎({{$returnFlightDetail->Adult}} X {{custom_number_format($returnFlightDetail->FuelSurcharge)}})‎</td>
                                                            <td>{{custom_number_format($returnFlightDetail->Adult * $returnFlightDetail->FuelSurcharge)}}</td>
                                                        </tr>
                                                        @endif
                                                        @if($returnFlightDetail->Child != 0)
                                                        <tr>
                                                            <td>Child(s) ‎({{$returnFlightDetail->Child}} X {{custom_number_format($returnFlightDetail->FuelSurcharge)}})‎</td>
                                                            <td>{{custom_number_format($returnFlightDetail->Child * $returnFlightDetail->FuelSurcharge)}}</td>
                                                        </tr>
                                                        @endif
                                                    </table>
                                                    <h5>Taxes and Fees :</h5>
                                                    <table class="table">
                                                        @if($returnFlightDetail->Adult != 0)
                                                            <tr>
                                                                <td>Adult(s) ‎({{$returnFlightDetail->Adult}} X {{custom_number_format($returnFlightDetail->Tax + $returnFlightDetail->ResFare)}})‎</td>
                                                                <td>{{custom_number_format($returnFlightDetail->Adult * ($returnFlightDetail->Tax + $returnFlightDetail->ResFare))}}</td>
                                                            </tr>
                                                        @endif
                                                        @if($returnFlightDetail->Child != 0)
                                                            <tr>
                                                                <td>Child(s) ‎({{$returnFlightDetail->Child}} X {{custom_number_format($returnFlightDetail->Tax + $returnFlightDetail->ResFare)}})‎</td>
                                                                <td>{{custom_number_format($returnFlightDetail->Child * ($returnFlightDetail->Tax + $returnFlightDetail->ResFare))}}</td>
                                                            </tr>
                                                        @endif
                                                    </table>

                                                    <div class="total-block">
                                                        <h3>Total Amount
                                                        </h3>
                                                    </div>
                                                    <div class="total-block price">
                                                        <h3>{{$returnFlightDetail->Currency}} <?php echo custom_number_format(totalPrice($returnFlightDetail->Adult, $returnFlightDetail->Child, $returnFlightDetail->AdultFare, $returnFlightDetail->ChildFare, $returnFlightDetail->ResFare, $returnFlightDetail->FuelSurcharge, $returnFlightDetail->Tax )) ?></h3>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                    
                            </div>
                                <!--
                                <div class="btm-block">
                                    <div class="discount-wrap">
                                        <h3>Apply Discount</h3>
                                        <form action="#">
                                            <div class="input-group">
                                              <input type="text" class="form-control" placeholder="Search for...">
                                              <span class="input-group-btn">
                                                <button class="btn btn-back" type="button">
                                                    Apply</button>
                                              </span>
                                            </div>
                                        </form>
                                        
                                    </div>
                                    
                                </div> -->
                            
                                

                                
                            {{-- </div> --}}
                        </div>


                    </div>

                    
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
    print_country_package('countrylist', '-- Select Country --');
    </script>

@endsection
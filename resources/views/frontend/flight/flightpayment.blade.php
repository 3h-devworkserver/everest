@extends('frontend.layouts.master-new')
@section('title') Flight Payment | {{ $siteTitle or '' }}@endsection
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
                        <li class="is-complete">
                            <span class="circle">
								<i class="fa fa-user"></i>
							</span>
                            <span class="progress-text">Passanger Details</span>
                        </li>
                        <li class="is-active">
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
                                {!! Form::open(['url'=>'/flight/search', 'class' => 'loaderDisplay'])!!}
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

                <div class="payment-wrapper">
                    <div class="grand-total">
                        <div class="row">
                            <div class="col-md-9 col-sm-8">
                                <div class="payment-methods">
                                    <h4>Choose Payment Mode <small>Convenience fee will be charged based on payment mode</small></h4>

                                    <!-- <div class="row-fluid payment-tab"> -->
                                    <div class="payment-tab">
                                        <!-- <div class="col-xs-3">  -->
                                            <!-- required for floating -->
                                          <!-- Nav tabs -->
                                          <ul class="nav nav-tabs tabs-left sideways" id="myTab">
                                            <li class="active"><a href="#creditcard" data-toggle="tab">Credit Card</a></li>
                                            <li><a href="#debitcard" data-toggle="tab">Debit Card</a></li>
                                            <!-- <li><a href="#netbanking" data-toggle="tab">Net Banking</a></li>
                                            <li><a href="#emi" data-toggle="tab">EMI</a></li> -->
                                            <li><a href="#paypal" data-toggle="tab">Paypal</a></li>
                                            <!-- <li><a href="#wallets" data-toggle="tab">Wallets</a></li> -->
                                          </ul>
                                        <!-- </div> -->

                                        <!-- <div class="col-xs-9"> -->
                                          <!-- Tab panes -->
                                          <div class="tab-content">
                                            <div class="tab-pane active" id="creditcard">
                                                <form action="#">
                                                    <div class="form-group">
                                                        <div class="row-fluid">
                                                            <div class="col-md-12">
                                                                <label>Card Number <small>(we support all major cards)</small></label>
                                                                <input type="text" class="form-control" placeholder="Card Number">
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row-fluid">
                                                            <div class="col-md-12">
                                                                <label>Card Holder Name <small>(as mentioned on cards)</small></label>
                                                                <input type="text" class="form-control" placeholder="Card Holder Name">
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        
                                                        <div class="row-fluid row-margin-10">
                                                            <div class="col-md-8">
                                                                <div class="row-fluid">
                                                                    <div class="col-md-12">
                                                                        <label>Expiry Date</label>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="row-fluid">
                                                                    
                                                                    <div class="col-md-6">
                                                                        <select class="SlectBox form-control">
                                                                            <option> Month</option>
                                                                            <option> 1</option>
                                                                            <option> 2</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        
                                                                        <select class="SlectBox form-control">
                                                                            <option> Year</option>
                                                                            <option> 1</option>
                                                                            <option> 2</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>CW</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                      
                                                    </div>
                                                    <div class="form-group">
                                                        <span class="total-price">
                                                            <h4>Total Amount: <span>650 USD</span></h4>
                                                        </span>
                                                    </div>
                                                    <div class="row-fluid">
                                                        <div class="col-md-12">
                                                            <div class="button-groups">
                                                                <button type="button" class="btn btn-danger payment-btn">
                                                                    <i class="fa fa-money"></i>Make a secure payment                                               
                                                                </button>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>


                                                </form>
                                                
                                            </div>
                                            <div class="tab-pane" id="debitcard">
                                                <form action="#">
                                                    <div class="form-group">
                                                        <div class="row-fluid">
                                                            <div class="col-md-12">
                                                                <label>Select Bank</label>
                                                                 <select name="" id="" class="SlectBox form-control">
                                                                        <option selected="selected">Select Your Bank</option>
                                                                        <option>Bank 1</option>
                                                                        <option>Bank 2</option>
                                                                        
                                                                    </select>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row-fluid">
                                                            <div class="col-md-12">
                                                                <label>Card Number <small>(we support all major cards)</small></label>
                                                                <input type="text" class="form-control" placeholder="Card Number">
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row-fluid">
                                                            <div class="col-md-12">
                                                                <label>Card Holder Name <small>(as mentioned on cards)</small></label>
                                                                <input type="text" class="form-control" placeholder="Card Holder Name">
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        
                                                        <div class="row-fluid row-margin-10">
                                                            <div class="col-md-8">
                                                                <div class="row-fluid">
                                                                    <div class="col-md-12">
                                                                        <label>Expiry Date</label>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="row-fluid">
                                                                    
                                                                    <div class="col-md-6">
                                                                        <select class="SlectBox form-control">
                                                                            <option> Month</option>
                                                                            <option> 1</option>
                                                                            <option> 2</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        
                                                                        <select class="SlectBox form-control">
                                                                            <option> Year</option>
                                                                            <option> 1</option>
                                                                            <option> 2</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>CW</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                      
                                                    </div>
                                                    <div class="form-group">
                                                        <span class="total-price">
                                                            <h4>Total Amount: <span>650 USD</span></h4>
                                                        </span>
                                                    </div>
                                                    <div class="row-fluid">
                                                        <div class="col-md-12">
                                                            <div class="button-groups">
                                                                <button type="button" class="btn btn-danger payment-btn">
                                                                    <i class="fa fa-money"></i>Make a secure payment                                               
                                                                </button>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>


                                                </form>
                                                
                                            </div>
                                            <!-- <div class="tab-pane" id="netbanking">
                                                <form action="#">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Select Bank</label>
                                                                 <select name="" id="" class="SlectBox form-control">
                                                                        <option selected="selected">Select Your Bank</option>
                                                                        <option>Bank 1</option>
                                                                        <option>Bank 2</option>
                                                                        
                                                                    </select>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    

                                                    
                                                    <div class="form-group">
                                                        <span class="total-price">
                                                            <h4>Total Amount: <span>650 USD</span></h4>
                                                        </span>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="button-groups">
                                                                <button type="button" class="btn btn-danger payment-btn">
                                                                    <i class="fa fa-money"></i>Make a secure payment                                               
                                                                </button>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>


                                                </form>
                                                
                                            </div> -->
                                            
                                            
                                            <!-- <div class="tab-pane" id="emi">
                                                <form action="#">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Select Bank</label>
                                                                 <select name="" id="" class="SlectBox form-control">
                                                                        <option selected="selected">Select Your Bank</option>
                                                                        <option>Bank 1</option>
                                                                        <option>Bank 2</option>
                                                                        
                                                                    </select>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Select Emi Tenure <small>See interest rates &amp; monthly instalment upfront</small></label>
                                                                 <div class="table-responsive">
                                                                     <table class="table table-bordered">
                                                                        <thead> 
                                                                            <tr> 
                                                                                <th>Select</th>
                                                                                <th>Tenure</th>
                                                                                <th> Interest rate(per year)</th> 
                                                                                <th>Monthly Installment</th> 
                                                                                <th>Total Interest Paid to Bank</th>
                                                                                <th>Total Amount Paid to Bank (inclusive of interest)</th>
                                                                            </tr> 
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr> 
                                                                                <td><input type="radio" name="check"></td>
                                                                                <td>3 months</td>
                                                                                <td> 14%</td> 
                                                                                <td>100 USD</td> 
                                                                                <td>10 USD</td>
                                                                                <td>620 USD</td>
                                                                            </tr>
                                                                            <tr> 
                                                                                <td><input type="radio" name="check"></td>
                                                                                <td>3 months</td>
                                                                                <td> 14%</td> 
                                                                                <td>100 USD</td> 
                                                                                <td>10 USD</td>
                                                                                <td>620 USD</td>
                                                                            </tr>
                                                                            <tr> 
                                                                                <td><input type="radio" name="check"></td>
                                                                                <td>3 months</td>
                                                                                <td> 14%</td> 
                                                                                <td>100 USD</td> 
                                                                                <td>10 USD</td>
                                                                                <td>620 USD</td>
                                                                            </tr>
                                                                        </tbody>
                                                                         
                                                                     </table>
                                                                 </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    

                                                    
                                                    <div class="form-group">
                                                        <span class="total-price">
                                                            <h4>Total Amount: <span>650 USD</span></h4>
                                                        </span>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="button-groups">
                                                                <button type="button" class="btn btn-danger payment-btn">
                                                                    <i class="fa fa-money"></i>Make a secure payment                                               
                                                                </button>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>


                                                </form>
                                                
                                            </div> -->
                                             <div class="tab-pane" id="paypal">
                                                <form action="#">
                                                    <div class="form-group">
                                                        <div class="row-fluid">
                                                            <div class="col-md-12">
                                                                <label>Fast and Convenient</label>
                                                                <p>Use PayPal only if you are using an international credit card or if you have registered your PayPal account outside of India</p>
                                                                 <select name="" id="" class="SlectBox form-control">
                                                                        <option selected="selected">Change Currency</option>
                                                                        
                                                                        <option _alias="EUR" value="EUR-0.0133-3.0">EUR</option>
                                                                        <option _alias="GBP" value="GBP-0.0103-3.0">GBP</option>
                                                                        <option _alias="HKD" value="HKD-0.1154-3.0">HKD</option>
                                                                        <option _alias="SGD" value="SGD-0.0205-3.0">SGD</option>
                                                                        <option _alias="THB" value="THB-0.5309-3.0">THB</option>
                                                                        <option _alias="USD" value="USD-0.0148-3.0">USD</option>
                                                                        
                                                                    </select>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    

                                                    
                                                    <div class="form-group">
                                                        <span class="total-price">
                                                            <h4>Total Amount: <span>650 USD</span></h4>
                                                        </span>
                                                    </div>
                                                    <div class="row-fluid">
                                                        <div class="col-md-12">
                                                            <div class="button-groups">
                                                                <button type="button" class="btn btn-danger payment-btn">
                                                                    <i class="fa fa-money"></i>Make a secure payment                                               
                                                                </button>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>


                                                </form>
                                                
                                            </div>
                                            
                                            <!-- <div class="tab-pane" id="wallets">Settings Tab.</div> -->
                                          </div>
                                        <!-- </div> -->
                                    </div>
                                    
                                </div>
                               
                                
                                
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
                                                            </td>
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
                    	</div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>

</section>

@endsection
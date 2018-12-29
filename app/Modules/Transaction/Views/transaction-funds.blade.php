@extends('layouts.app')

@section('content')
<div class="row">
<div class="col-sm-2">
  <h4 class="title"><b>Related Links</b></h4><br>
  <a href="{{route('transaction.create')}}">New Transaction</a><br><br>
  <a href="{{route('transaction.index')}}">Transaction List</a><br>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><center><h1>{{ 'Fund Balance' }}</h1></center></div>
                  <div class="card-body">
                  	<div class="row col-md-12">
            			<form method="GET" action="{{ route('transaction.funds') }}" aria-label="{{ __('Search') }}">
						<div class="form-row align-items-center col-md-12">
	                        <div class="col-5">
	                          <label class="sr-only" for="inlineFormInput">Bank Accounts</label>                  	                      		<?php $bank_name = ""; ?>
	                          <select name="bank_name" class="form-control{{ $errors->has('transaction_type') ? ' is-invalid' : '' }}" >
	                            <option value ="" >All</option>
		                            @foreach ($bank_details as $bank)

		                            <?php $selected="";


		                                if(old('bank_name') == $bank['id']){

		                                	$bank_name = $bank['bank_name'];

		                                  $selected = 'selected';
		                                }

		                             ?>
	                              	<option {{$selected}}  value="{{$bank['id']}}">{{$bank['bank_name']." - ".$bank['account_number']}}</option>
	                                @endforeach
	                          </select>
	                        </div>
	                        <div class="col-5">
	                          <label class="sr-only" for="inlineFormInputGroup">Date</label>
	                         <input type="date" class="form-control" placeholder="Select Date" name= "transaction_time" value="{{old('transaction_time')}}">
	                        </div>
	                        <div class="col-2">
	                          <button type="submit" class="btn btn-primary mb-2">Search</button>
	                        </div>
	                     </div>
					 	</form>
						 <br><br><br><br><br>
		            </div>
                    <div class="row"><br><br>
                    	<div class="col-md-6">
                    	 	<div class="card" style="width: 18rem;">
							  <div class="card-body">
							    <h5 class="card-title"><b>Cash Balance</b></h5>
							    <h6 class="card-subtitle mb-2 text-muted">{{$cash_balance[0]->balance}}</h6>
		   					  </div>
							</div>
                       	</div>
                    	<div class="col-md-6">
            				<div class="card" style="width: 18rem;">
						     	<div class="card-body">
								    <h5 class="card-title"><b>{{$bank_name}} Bank Balance</b></h5>
								    <h6 class="card-subtitle mb-2 text-muted">{{$bank_balance[0]->balance}}</h6>

							  	</div>
							</div>
                       	</div>
                    </div>
	              </div>
            </div>
        </div>
    </div>
</div>


@endsection

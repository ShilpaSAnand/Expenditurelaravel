@extends('layouts.app')

@section('content')
<div class="row">
<div class="col-sm-2">
  <h4 class="title"><b>Related Links</b></h4><br>
  <a href="{{route('transaction.create')}}">New Transaction</a><br><br>
  <a href="{{route('transaction.index')}}">Transaction List</a><br><br>
  <a href="{{route('transaction.funds')}}">Fund Balance</a><br>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            	@if(Session::has('alert-message'))

        				<?php $alert = Session::get('alert-message'); ?>

  				      <div class="alert {{ $alert['class'] }}">
  				      <a href="#" class="close" data-dismiss="alert">&times;</a>
  				      <strong>{{ $alert['type'] }}: </strong> {{ $alert['text'] }}
  				      </div>

 				      @endif
               <div class="card-header"><center><h1>{{ 'Transaction Details' }}</h1></center></div>

              <br><br><br>
                <div class="row">
                @foreach($transaction_show as $transaction)
                  <div class="col-md-3 col-sm-2 col-xs-12 form-group">
                    <label for="from_account_head"><b>From Account Head</b></label>
                    <input id="from_account_head" name="from_account_head" disabled class="form-control" type="text" value="{{$transaction->from_category}}">
                  </div>
                  <div class="col-md-3 col-sm-2 col-xs-12 form-group ">
                    <label for="to_account_head"><b>To Account Head</b></label>
                    <input id="to_account_head" name="to_account_head" class="form-control" disabled type="text" value="{{$transaction->to_category}}">
                  </div>
                  <div class="col-md-3 col-sm-2 col-xs-12 form-group">
                    <label for="amount"><b>Amount</b></label>
                    <input id="amount" name="amount" class="form-control" disabled type="text" value="{{$transaction->amount}}">
                  </div>
                  <div class="col-md-3 col-sm-2 col-xs-12 form-group ">
                    <label for="name"><b>Transaction Done By</b></label>
                    <input id="name" name="name" class="form-control" disabled type="text" value="{{$transaction->name}}  ">
                  </div><br><br>
                 
              @endforeach
              </div> <br><br>             
            </div>
        </div>
    </div>
  </div>
</div>

@endsection

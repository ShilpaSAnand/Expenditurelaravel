@extends('layouts.app')

@section('content')
<div class="row">
<div class="col-sm-2">
  <h4 class="title"><b>Related Links</b></h4><br>
  <a href="{{route('transaction.create')}}">New Transaction</a><br><br>
  <a href="{{route('transaction.funds')}}">Fund Balance</a><br>
</div>

@if(Session::has('alert-message'))
  <?php $alert = Session::get('alert-message'); ?>
      <div class="alert {{ $alert['class'] }}">
          <a href="#" class="close" data-dismiss="alert">&times;</a>
          <strong>{{ $alert['type'] }}: </strong> {{ $alert['text'] }}
      </div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card col-md-12">
                <div class="card-header"><center><h1>{{ 'Transaction Lists' }}</h1></center></div><br>
                  <div class="card-body col-md-12">
                    <form method="GET" action="{{ route('transaction.index') }}" >
                      <div class="form-row align-items-center">
                        <div class="col-2">
                          <label class="sr-only" for="inlineFormInput">Transaction Type</label>
                          <select name="transaction_type" class="form-control{{ $errors->has('transaction_type') ? ' is-invalid' : '' }}" >
                            <option value="">Transaction Type</option>
                            <option value="1" <?php 
                            if(old('transaction_type') =="1")
                              echo "selected='selected'";
                            ?>>Income
                            </option>
                                  <option value="2" <?php 
                            if(old('transaction_type') =="2")
                              echo "selected='selected'";
                            ?>>Expense
                            </option>
                          </select>
                        </div>
                        <div class="col-2">
                          <label class="sr-only" for="inlineFormInputGroup">Source of Income/Expense</label>
                          <select name="account_head" class="form-control{{ $errors->has('account_head') ? ' is-invalid' : '' }}">
                            <option value="">Source of Income/Expense</option>

                              @foreach ($account_head as $head)

                              <?php $selected="";

                                if(old('account_head') == $head['id']){

                                  $selected = 'selected';
                                }

                                ?>
                                  <option {{$selected}} value="{{$head['id']}}">{{$head['category']}}</option>
                              @endforeach

                           </select>
                        </div>
                        <div class="col-2">
                          <label class="sr-only" for="inlineFormInput">Payment Mode</label>
                          <select name="payment_mode" class="form-control{{ $errors->has('payment_mode') ? ' is-invalid' : '' }}">
                            <option value="">Payment Mode</option>
                            <option value="1" <?php 
                            if(old('payment_mode') =="1")
                              echo "selected='selected'";
                            ?>>Cash
                            </option>
                            <option value="2" <?php 
                            if(old('payment_mode') =="2")
                              echo "selected='selected'";
                            ?>>Bank</option>
                            <option value="3">Journal Entry</option>
                          </select>
                        </div>
                        <div class="col-2">
                          <label class="sr-only" for="inlineFormInput">Date From</label>
                          <input type="text" class="form-control mb-2" name="date_from" id="inlineFormInput" placeholder="Date From" value="{{old('date_from')}}">
                        </div>
                        <div class="col-2">
                          <label class="sr-only" for="inlineFormInput">Date To</label>
                          <input type="text" class="form-control mb-2" name="date_to" id="inlineFormInput" placeholder="Date To" value="{{old('date_to')}}">
                        </div>                        
                        <div class="col-2">
                          <button type="submit" class="btn btn-primary mb-2">Submit</button>
                        </div>
                      </div>
                    </form>  <br><br><br>                                       
                    <center>
                    <div class="panel-body">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-panel">
                          <div class="table-responsive">
                            <table class="table" border="1">
                              <tr>
                                <th>Voucher Id</th>
                                <th>Transaction Type</th>
                                <th>Source</th>
                                <th>Payment Mode</th>
                                <th>Amount</th>
                              </tr>                                                
                              @foreach($transaction_index as $transaction)
                              <tr>
                                <td><a href="{{route('transaction.show', $transaction->id)}}">{{$transaction->voucher_id}}</a></td>
                                <td> 
                                  @if($transaction->to_category == "cash" || $transaction->to_category == "bank" )

                                      {{"Income"}}

                                    @else

                                      {{"Expense"}}

                                  @endif
                                </td>
                                <td>{{$transaction->from_category}}</td>
                                <td>{{$transaction->to_category}}</td>
                                <td>{{$transaction->amount}}</td>
                              </tr>
                              @endforeach
                                            
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div>{{$transaction_index->appends(['transaction_type' => old('transaction_type'), 'account_head' =>  old('account_head'), 'payment_mode' => old('payment_mode'), 'date_from' => old('date_from'), 'date_to' => old('date_to')])->links()}}
                  </div>
                </div>
              </div>
            </div>    
           </center>
          </div>
       </div>
   </div>
</div>
</div>
</div>
@endsection

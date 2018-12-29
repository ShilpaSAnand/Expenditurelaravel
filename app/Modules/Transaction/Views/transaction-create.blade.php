@extends('layouts.app')




<script>

    
 function showDiv(elem){
   if(elem.value == 2)
   document.getElementById('hidden_div').style.display = "block";
}

    

</script>



@section('content')
<div class="row">
  <div class="col-sm-2">
    <h4 class="title"><b>Related Links</b></h4><br>
    <a href="{{route('transaction.index')}}">Transaction List</a><br><br>
    <a href="{{route('transaction.funds')}}">Fund Balance</a><br>
  </div>

  @if(Session::has('alert-message'))
  <?php $alert = Session::get('alert-message'); ?>
  <div class="alert {{ $alert['class'] }}">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>{{ $alert['type'] }}: </strong> {{ $alert['text'] }}
  </div>
  @endif

  <div class="container ">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header"><center><h1>{{ 'Expenditure Chart' }}</h1></center></div>
            <div class="card-body">
              <form method="POST" action="{{ route('transaction.create.p') }}" aria-label="{{ __('Expenditure') }}">
              @csrf

              <div class="form-group row">
                <label for="transacton_time" class="col-sm-4 col-form-label text-md-right">{{ 'Transaction Time' }}</label>

                <div class="col-md-6">
                  <input id="transacton_time" type="date" data-provide="datepicker"  class="form-control{{ $errors->has('transacton_time') ? ' is-invalid' : '' }}" name="transacton_time" value="{{ old('transacton_time') }}" >


                  @if ($errors->has('transacton_time'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('transacton_time') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="transaction_type" class="col-sm-4 col-form-label text-md-right">{{ 'Transaction Type' }}</label>
                <div class="col-md-6">
                  <select name="transaction_type" class="form-control{{ $errors->has('transaction_type') ? ' is-invalid' : '' }}" >
                  <option value="">--Select--</option>
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

                  @if ($errors->has('transaction_type'))

                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('transaction_type') }}</strong>
                    </span>

                  @endif

                </div>
              </div>

              <div class="form-group row">
                <label for="account_head" class="col-sm-4 col-form-label text-md-right">{{ 'Account Head' }}</label>
                <div class="col-md-6">
                  <select name="account_head" class="form-control{{ $errors->has('account_head') ? ' is-invalid' : '' }}">
                  <option value="">--Select--</option>

                  @foreach ($account_head as $head)

                  <?php $selected="";

                  if(old('account_head') == $head['id']){

                    $selected = 'selected';
                  }
                  ?>
                    <option {{$selected}} value="{{$head['id']}}">{{$head['category']}}</option>

                  @endforeach

                  </select>

                  @if ($errors->has('account_head'))

                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('account_head') }}</strong>
                    </span>

                  @endif

                </div>
              </div>

              <div class="form-group row">
                <label for="payment_mode" class="col-sm-4 col-form-label text-md-right">{{ 'Payment Mode' }}</label>
                <div class="col-md-6">
                  <select name="payment_mode" class="form-control{{ $errors->has('payment_mode') ? ' is-invalid' : '' }}" onChange="showDiv(this)">
                  <option value="">--Select--</option>
                  <option value="1" <?php 
                      if(old('payment_mode') =="1")
                        echo "selected='selected'";
                      ?>>Cash
                  </option>
                  <option value="2" <?php 
                      if(old('payment_mode') =="2")
                        echo "selected='selected'";
                      ?>>Bank
                  </option>
                  <option value="3" <?php 
                      if(old('payment_mode') =="2")
                        echo "selected='selected'";
                      ?>>Journal Entry
                  </option>
                  </select>

                  @if ($errors->has('payment_mode'))

                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('payment_mode') }}</strong>
                    </span>

                  @endif
                </div>
              </div>

              <div class="form-group row" id="hidden_div" style="display: none;">
                <label for="account_number" class="col-sm-4 col-form-label text-md-right">{{ 'Bank Account Number' }}</label>
                <div class="col-md-6">
                  <select name="account_number" class="form-control{{ $errors->has('account_number') ? ' is-invalid' : '' }}">
                  <option value="">--Select--</option>

                  @foreach ($bank_details as $bank)
                  <?php $selected="";

                  if(old('account_number') == $head['id']){

                    $selected = 'selected';
                  }
                  ?>

                  <option {{$selected}} value="{{$bank['id']}}">{{$bank['bank_name']." - ".$bank['account_number']}}</option>

                  @endforeach

                  </select>

                  @if ($errors->has('account_number'))

                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('account_number') }}</strong>
                    </span>

                  @endif

                </div>
              </div>
              <div class="form-group row">
                <label for="amount" class="col-sm-4 col-form-label text-md-right">{{ 'Amount' }}</label>

                <div class="col-md-6">
                  <input id="amount" type="text" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount') }}" >

                  @if ($errors->has('amount'))

                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('amount') }}</strong>
                    </span>

                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="narration" class="col-sm-4 col-form-label text-md-right">{{ __('Narration') }}</label>
                <div class="col-md-6">
                  <textarea name="narration" class="form-control{{ $errors->has('narration') ? ' is-invalid' : '' }}" >{{ Request::old('narration') }}</textarea>

                  @if ($errors->has('narration'))

                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('narration') }}</strong>
                    </span>

                  @endif
                </div>
              </div>
              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                  {{ 'Create' }}
                  </button><br>
                 </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>



</div>
@endsection

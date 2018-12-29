@extends('layouts.app')

@section('content')
<div class="col-md-4">
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







@endsection


@if(Session::has('alert-message'))
  <?php $alert = Session::get('alert-message'); ?>
      <div class="alert {{ $alert['class'] }}">
          <a href="#" class="close" data-dismiss="alert">&times;</a>
          <strong>{{ $alert['type'] }}: </strong> {{ $alert['text'] }}
      </div>
@endif
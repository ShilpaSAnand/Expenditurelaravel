<?php

 // Route::group(['middleware' => ['auth:api'], 'namespace' => 'App\Modules\Transaction\Controllers'], function(){
Route::group(['middleware' => ['auth:api'], 'namespace' => 'App\Modules\Transaction\Controllers'], function(){
 Route::get('/transaction/create', ['as' => 'transaction.create', 'uses' => 'TransactionController@create']);

  Route::post('/transaction/create/postman', ['as' => 'transaction.create.postman', 'uses' => 'TransactionController@create_transaction']);

  Route::get('/transaction/show/postman/{id}', ['as' => 'transaction.show.postman', 'uses' => 'TransactionController@show_transaction']);
  //Route::post('/transaction/create',['as' =>'transaction.create.p', 'uses'=>'TransactionController@store']);

  Route::get('/transaction/show/{id}', ['as' => 'transaction.show', 'uses' => 'TransactionController@show']);

  Route::get('/transaction/index', ['as' => 'transaction.index', 'uses' => 'TransactionController@index']);

  Route::get('/transaction/index/postman', ['as' => 'transaction.index.postman', 'uses' => 'TransactionController@transaction_index']);

  Route::get('/transaction/funds', ['as' => 'transaction.funds', 'uses' => 'TransactionController@funds']);

  Route::get('/transaction/funds/postman', ['as' => 'transaction.funds.postman', 'uses' => 'TransactionController@transaction_funds']);

  Route::get('/transaction/getRelavantDatas', ['as' => 'transaction.getRelavantDatas', 'uses' => 'TransactionController@getRelavantDatas']);


  });

?>

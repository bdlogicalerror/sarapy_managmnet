<?php

Route::get('/', 'LoginController@check');
Route::post('/login','LoginController@login');
Route::post('/license','LicenseController@store')->name('store_license');
Route::get('/logout','LoginController@logout')->name('logout');

Route::get('/check','LoginController@login_session');

Route::group(['prefix'=>'system','middleware'=>'CheckSession'],function (){

   Route::group(['prefix'=>'user'],function (){
       Route::get('/','UserController@index');
       Route::get('/{id}','UserController@sel_user');
       Route::put('/{id}','UserController@update_user');
       Route::post('/add','UserController@store');
   });
   Route::group(['prefix'=>'branch'],function (){
       Route::get('/','BranchController@index');
       Route::get('/{id}','BranchController@sel_branch');
       Route::put('/{id}','BranchController@update_branch');
       Route::post('/add','BranchController@store');
   });
   Route::group(['prefix'=>'client'],function (){
       Route::get('/','ClientController@index');
       Route::get('/acc_number','ClientController@get_acc');
       Route::get('/{id}','ClientController@sel_client');
       Route::put('/{id}','ClientController@update_client');
       Route::post('/add','ClientController@store');
   });
   Route::group(['prefix'=>'currency'],function (){
       Route::get('/','CurrencyController@index');
       Route::get('/{id}','CurrencyController@sel_currency');
       Route::put('/{id}','CurrencyController@update_currency');
       Route::post('/add','CurrencyController@store');
   });


});
Route::get('/test',function (){
    /*$now = strtotime('2018-11-02'); // or your date as well
    $your_date = strtotime("2018-11-02");
    $datediff = $now - $your_date;

    echo round($datediff / (60 * 60 * 24));*/


    //return date('Y-m-d');






});

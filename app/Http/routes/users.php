<?php

Route::group(['prefix'=>'admin', 'middleware'=>'auth'], function(){
    Route::get('users', 'UsersController@index');
    Route::post('users', 'UsersController@store');
    Route::get('users/create', 'UsersController@create');
    Route::get('users/{userId}/edit', 'UsersController@edit');
    Route::put('users/{userId}', 'UsersController@update');
    Route::delete('users/{userId}/delete', 'UsersController@delete');
});
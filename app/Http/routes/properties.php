<?php
use App\Jobs\UserSendMessageToPropertyOwner;
use App\Property;
use Carbon\Carbon;
use Illuminate\Http\Request;

Route::get('api/isPropertyOwner/{propertyId}', function($propertyId){
    if(!Auth::user()){
        $check = false;
        $property = Property::findOrFail($propertyId);
        if($property->owner == Auth::user())  $check = true;
        return response()->json(['isPropertyOwner'=>$check]);
    }
    return response()->json(['isPropertyOwner'=>false]);

});

Route::group(['middleware' => 'auth'], function () {

    // This will pass to you property.js
    Route::get('properties/{segment1?}/{segment2?}/{segment3?}', function(){
        return view('front.pages.properties.index');
    });
    // This will pass to you property.js
    Route::get('properties', function(){
        return view('front.pages.properties.index');
    });

    Route::get('api/properties/newSingle', 'PropertiesController@createSingleRoomType');
    Route::get('api/properties/newMultiple', 'PropertiesController@createMultipleRoomType');
    Route::get('api/properties/multipleRoomType/{roomTypeId?}', 'PropertiesController@createMultipleRoomType');
    Route::post('api/properties/updateMultipleRoomType', 'PropertiesController@updateMultipleRoomType');
});

// The following api endpoint if only for property owner himself. Administrator will have another set of endpoints.
Route::group(['middleware' => 'isPropertyOwner'], function () {
    Route::group(['prefix'=>'api/properties'], function(){
        Route::get('new', 'PropertiesController@create');
        Route::get('getProperties', 'PropertiesController@getAll');
        Route::get('createNewRoomType', 'PropertiesController@createNewRoomType');
        Route::post('createNew', 'PropertiesController@createBasic');
        Route::get('getAmenities', 'PropertiesController@getAmenities');
        Route::put('updateProperty', 'PropertiesController@update');
        Route::post('uploadPic', 'PropertiesController@uploadPic');
        Route::delete('{propertyId}/delete', 'PropertiesController@delete');
        Route::delete('{propertyId}/deleteMedia/{mediaId}',
            'PropertiesController@deleteMedia');
        Route::post('{propertyId}/updatePicDescription/{mediaId}',
            'PropertiesController@updateMediaDescription');
    });
    Route::group(['prefix'=>'api/roomType'], function(){
        Route::post('uploadPic', 'PropertiesController@uploadRoomPic');
        Route::delete('{roomTypeId}/deleteMedia/{mediaId}',
            'PropertiesController@deleteRoomMedia');
        Route::post('{roomTypeId}/updatePicDescription/{mediaId}',
            'PropertiesController@updateRoomMediaDescription');
    });
});

Route::get('/api/getTheProperty/{propertyId}', 'PropertiesController@getTheProperty');
Route::get('/api/searchProperties', 'PropertiesController@searchProperties');

Route::get('/api/getPropertyTypes', function (Request $request) {
    $propertyTypes = \App\PropertyType::all();

    return response()->json(compact("propertyTypes"));
});


<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Amenities;
use App\dto\ajaxResponseDataObject;
use App\Permission;
use App\PropertyType;
use App\Role;
use App\RoomTypeList;
use App\Services\ReservationService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {

    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('api/getReservations/{reservationId?}', function($reservationId=null){
        if(Auth::user()){
            $service = new ReservationService();

            $reservations = $reservationId? $service->getMyReservations($reservationId):$service->getMyReservations();
        }
        return response()->json(['message'=>'this is from route', 'reservations'=>$reservations]);
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::auth();
    });
    Route::get('/api/isAuth', function () {
        if (Auth::user()) {
            return response()->json(['auth' => true, 'user' => getAuthUserForJson()]);
        }

        return response()->json(['auth' => false]);
    });
    Route::get('/home', 'HomeController@index');
    Route::get('/api/wishList/{propertyId}', function ($propertyId) {
        $wishListItem = Auth::user()->wishListItems()->wherePropertyId($propertyId)->first();
        $action = '';
        if ($wishListItem) {
            $wishListItem->delete();
            $action = "remove";
        } else {
            $defaultWishList = Auth::user()->wishLists()->whereName('default')->first();
            if (!$defaultWishList) {
                $defaultWishList = Auth::user()->wishLists()->create([
                    'name' => 'default'
                ]);
            }
            $item = $defaultWishList->items()->create([
                'property_id' => $propertyId
            ]);
            $action = "add";
        }

        return response()->json(['action' => $action]);
    });
    Route::post('/api/message', 'MessagesController@sendMessageToOwner');
    Route::post('/api/makeReservation', function (Request $request) {
        $roomType = \App\RoomType::findOrFail($request->get('roomTypeId'));
        $service = new ReservationService();
        $reservation = $service->make(Auth::user(), $roomType, $request->get('occupancy'), $request->get('checkInDate'),
            $request->get('checkOutDate'));

        // TODO:: do something about the response
        $responseObject = new ajaxResponseDataObject();
        $responseObject->code = "okay";
        $responseObject->message = 'Booking successful';
        $responseObject->data = $reservation;

        return response()->json($responseObject);
    });
    Route::get('/api/getMessages', function (Request $request) {
        $messageRooms = Auth::user()->messageRooms()->orderBy('updated_at', 'desc')->with([
            'messages'=>function($query){
            $query->orderBy('updated_at', 'desc');
        },'users'])->get();


        $responseObject = new ajaxResponseDataObject();
        $responseObject->code = "okay";
        $responseObject->message = 'Getting Message Successful';
        $responseObject->data = $messageRooms;

        return response()->json($responseObject);
    });


    include_once 'routes/properties.php';
    include_once 'routes/users.php';

    Route::get('/{other1?}/{other2?}/{others3?}/{others4?}/{others5?}', function () {
        return view('front/pages/index');
    });

    Route::get('/', function () {
        return view('front.pages.index');
    });

});


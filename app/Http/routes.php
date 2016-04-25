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
    dd('right here');

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

function setUp()
{
//    $user = User::first()?? factory(User::class)->create();
//    $permission = Permission::create([
//        'label' => 'Can Has Multiple Room Type Property',
//        'code'  => 'multiple',
//    ]);
//    $role = Role::create([
//        'label' => 'Who can has multiple room type property',
//        'code'  => 'multiple',
//    ]);
//
//    $role->permissions()->save($permission);
//    $user->roles()->save($role);
//    if (count(User::all()) < 2) {
//        factory(User::class)->create();
//    }
//    if (!Role::whereCode('dev')->first()) {
//        $data = [
//            'code'  => 'dev',
//            'label' => 'Developer',
//        ];
//        Role::create($data);
//    }

    $developer = Role::whereCode('dev')->first();
    $allPermissionIds = \App\Permission::lists('id')->toArray();
    $developer->permissions()->sync($allPermissionIds);

    if(!$developer->users->count()){
        $data = [
            'name'=>'Xavier Au',
            'email'=>'xavier.au@anacreation.com',
            'password'=>bcrypt('aukaiyuen')
        ];
        $developer->users()->create($data);
    }

    if (!RoomTypeList::first()) {
        $array = [
            ["label" => "Entire home/apt", "code" => 'entire', 'is_multiple' => 0],
            ["label" => "Private Room", "code" => 'private', 'is_multiple' => 0],
            ["label" => "Share Room", "code" => 'shared', 'is_multiple' => 0],
            ["label" => "Standard Single Room", "code" => 'stn_single', 'is_multiple' => 1],
            ["label" => "Standard Double Room", "code" => 'stn_double', 'is_multiple' => 1],
            ["label" => "Deluxe Double Room", "code" => 'de_double', 'is_multiple' => 1],
        ];

        foreach ($array as $type) {
            RoomTypeList::create($type);
        }
    };
    if (!PropertyType::first()) {
        $array = [
            ["label" => "Apartment", "code" => 'apt', 'is_multiple' => 0],
            ["label" => "House", "code" => 'hse', 'is_multiple' => 0],
            ["label" => "Bread and Breakfast", "code" => 'b&b', 'is_multiple' => 0],
            ["label" => "Other", "code" => 'others', 'is_multiple' => 0],
            ["label" => "Hotel", "code" => 'hotel', 'is_multiple' => 1],
        ];

        foreach ($array as $type) {
            PropertyType::create($type);
        }
    };
    if (!Amenities::first()) {
        $array = [
            ["label" => "Essentials", "code" => 'essentials', 'category' => 'Common Amenities', 'is_room'=>0],
            ["label" => "TV", "code" => 'tv', 'category' => 'Common Amenities', 'is_room'=>1],
            ["label" => "Cable TV", "code" => 'cable_tv', 'category' => 'Common Amenities', 'is_room'=>1],
            ["label" => "Air Conditioner", "code" => 'air_con', 'category' => 'Common Amenities', 'is_room'=>1],
            ["label" => "Heating", "code" => 'heating', 'category' => 'Common Amenities', 'is_room'=>1],
            ["label" => "Kitchen", "code" => 'kitchen', 'category' => 'Common Amenities', 'is_room'=>1],
            ["label" => "Internet", "code" => 'internet', 'category' => 'Common Amenities', 'is_room'=>1],
            ["label" => "Wireless Internet", "code" => 'wifi', 'category' => 'Common Amenities', 'is_room'=>1],
            ["label" => "24-Hours Check-In", "code" => '24_check_in', 'category' => 'Common Amenities', 'is_room'=>0],
            ["label" => "Hot Tub", "code" => 'hot_tub', 'category' => 'Additional Amenities', 'is_room'=>1],
            ["label" => "Washer", "code" => 'washer', 'category' => 'Additional Amenities', 'is_room'=>1],
            ["label" => "Pool", "code" => 'pool', 'category' => 'Additional Amenities', 'is_room'=>0],
            ["label" => "Dryer", "code" => 'dryer', 'category' => 'Additional Amenities', 'is_room'=>1],
            ["label" => "Breakfast", "code" => 'breakfast', 'category' => 'Additional Amenities', 'is_room'=>0],
            ["label" => "Free Parking on Premises", "code" => 'free_parking', 'category' => 'Additional Amenities', 'is_room'=>0],
            ["label" => "Gym", "code" => 'Gym', 'category' => 'Additional Amenities', 'is_room'=>0],
            ["label" => "Elevator in Building", "code" => 'elevator', 'category' => 'Additional Amenities', 'is_room'=>0],
            ["label" => "Indoor Fireplace", "code" => 'fireplace', 'category' => 'Additional Amenities', 'is_room'=>1],
            ["label" => "Door Man", "code" => 'door_man', 'category' => 'Additional Amenities', 'is_room'=>0],
            ["label" => "Family/Kid Friendly", "code" => 'family_friendly', 'category' => 'Special Features', 'is_room'=>0],
            ["label" => "Smoking Allowed", "code" => 'can_smoke', 'category' => 'Special Features', 'is_room'=>1],
            ["label" => "Pets Allowed", "code" => 'pet_allowed', 'category' => 'Special Features', 'is_room'=>1],
            ["label" => "Pets live on this property", "code" => 'with_pets', 'category' => 'Special Features', 'is_room'=>0],
            ["label" => "Wheelchair Accessible", "code" => 'wheelchair', 'category' => 'Special Features', 'is_room'=>0],
        ];

        foreach ($array as $type) {
            Amenities::create($type);
        }
    };
}

setUp();


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


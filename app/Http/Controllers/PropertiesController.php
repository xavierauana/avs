<?php

namespace App\Http\Controllers;

use App\Amenities;
use App\Http\Requests;
use App\Property;
use App\PropertyType;
use App\RoomType;
use App\RoomTypeList;
use App\Services\MediaService;
use App\Services\SearchProperties;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertiesController extends Controller
{
    use DispatchesJobs;
    protected $property;

    /**
     * PropertiesController constructor.
     * @param $property
     */
    public function __construct(Property $property)
    {
        $this->property = $property;
    }

    public function create(Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'user'          => getAuthUserForJson(),
                'roomTypeLists' => RoomTypeList::all(),
                'propertyTypes' => PropertyType::all()
            ]);
        }

        return view('front.pages.properties.create');
    }

    public function createSingleRoomType(Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'user'          => getAuthUserForJson(),
                'roomTypeLists' => RoomTypeList::whereIsMultiple(0)->get(),
                'propertyTypes' => PropertyType::whereIsMultiple(0)->get()
            ]);
        }
    }

    public function createMultipleRoomType(Request $request, $roomTypeId = null)
    {
        if ($request->wantsJson()) {
            if ($roomTypeId) {
                $object = RoomType::with(['media'])->findOrFail($roomTypeId);
                $amenities = ['amenities'=>$object->amenities()->lists('id')];
                $roomType = array_merge($object->toArray(), $amenities);
            } else {
                $roomType = new RoomType();
            }

            return response()->json([
                'user'          => getAuthUserForJson(),
                'roomTypeLists' => RoomTypeList::whereIsMultiple(1)->get(),
                'propertyTypes' => PropertyType::whereIsMultiple(1)->get(),
                'roomType'      => $roomType
            ]);
        }
    }

    public function store()
    {
        return 'persist new property record';
    }

    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $property = $this->getPropertyWithSingleRoomType($id);

            return response()->json(compact("property"));
        }

        return view('front.pages.properties.edit');
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $property = $this->updateProperty($request);

            return response()->json(compact("property"));
        }

        return 'edit existing property record with id ';
    }

    public function show($propertyId)
    {
        $property = $this->property->findOrFail($propertyId);

        return 'get property detail ' . $property->id;
    }

    public function destroy($propertyId)
    {
        return 'delete property record ' . $propertyId;
    }

    public function getAll(Request $request)
    {
        $properties = $request->user()->properties()->with('media')->latest()->get();
        return response()->json($properties);
//        return Property::whereOwnerId(Auth::id())->latest()->get();
    }

    public function createBasic(Request $request)
    {
        if ($request->ajax()) {
            $this->createNewProperty($request);

            return response()->json([
                'status'      => 'completed',
                'property_id' => Auth::user()->properties()->latest()->first()->id
            ]);
        }
    }

    public function getAmenities(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('hotel')) {
                if ($request->get('hotel') == 'true') {
                    $amenities = Amenities::whereIsRoom(0)->get();
                } else {
                    $amenities = Amenities::whereIsRoom(1)->get();
                }
            } else {
                $amenities = Amenities::get();
            }

            return response()->json(compact('amenities'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    private function getPropertyWithSingleRoomType($id)
    {
        $property = Property::with([
            'propertyType',
            'media',
            'address',
            'roomTypes' => function ($query) {
                $query->first();
            }
        ])->find($id);
        $property = array_merge($property->toArray(), ['amenities' => $property->amenities()->lists('id')->toArray()]);

        return $property;
    }

    public function uploadPic(Request $request)
    {
        if ($request->ajax()) {
            if ($request->hasFile('file')) {
                $property = Property::findOrFail($request->get('propertyId'));

                $fileName = $request->file('file')->getClientOriginalName();
                
                $mediaService = new MediaService();
                $path = '/tests/files';
                $absoluteLink = $path . $fileName;
                $mediaService->prepare($request->file('file'))->saveImage(public_path($path), $fileName);

//                $request->file('file')->move(public_path($path), $fileName);
                $mediaParam = [
                    'link' => $absoluteLink,
                    'type' => 'image'
                ];
                $media = $property->media()->create($mediaParam);
                $message = 'done';

                return response()->json(compact('message', 'media'));
            }
        }
    }

    public function deleteMedia($propertyId, $mediaId, MediaService $mediaService)
    {
        $media = $mediaService->getMediaByPropertyIdAndMediaId($propertyId, $mediaId);

        $media->delete();
        $message = "deleted";

        return response()->json(compact('message', 'media'));
    }

    public function updateMediaDescription(Request $request, $propertyId, $mediaId, MediaService $mediaService)
    {
        $media = $mediaService->getMediaByPropertyIdAndMediaId($propertyId, $mediaId);

        $media->description = $request->get('description');
        $media->save();
        $message = 'Yes';

        return response()->json(compact('media', 'message'));
    }

    public function getTheProperty($propertyId)
    {
        $property = Property::with([
            'media',
            'propertyType',
            'roomTypes' => function ($query) {
                return $query->with(['type', 'media']);
            },
            'address',
            'amenities'
        ])->whereId($propertyId)->firstOrFail();

        return response()->json(compact('property'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    private function createNewProperty(Request $request)
    {
        $defaultAddress = ['city' => 'Hong Kong', 'country' => 'Hong Kong'];
        $request->merge([
            'address' => $defaultAddress
        ]);
        $propertyData = $request->get('property');

        $property = Auth::user()->properties()->create($propertyData);

        if ($request->has('roomType')) {
            $roomTypeData = $request->get('roomType');
            $property->roomTypes()->create($roomTypeData);
        }

        $addressData = $request->get('address');
        $property->address()->create($addressData);
    }

    public function searchProperties(Request $request, SearchProperties $service)
    {

        $properties = $service->fetchProperties($request->get('propertyTypeId'));

        $properties = $service->filterOccupancy($properties, $request->get('occupancy'));

        $properties = $this->filterCheckInCheckOutDate($request, $service, $properties);

        return response()->json(compact("properties"));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    private function updateProperty(Request $request)
    {
        $addressData = $request->get('address');
        $roomTypeData = $request->get('room_types');
        $amenitiesData = $request->get('amenities');

        $property = Property::findOrFail($request->get('id'));
        $property->update($request->all());
        if (count($roomTypeData) > 0) {
            foreach ($roomTypeData as $roomType) {
                $property->roomTypes()->whereId($roomType['id'])->firstOrFail()->update($roomType);
            }
        }
        $property->address()->update($addressData);
        $property->amenities()->sync($amenitiesData);

        return $property;
    }

    public function updateMultipleRoomType(Request $request)
    {
        if ($request->has('id')) {
            $roomType = RoomType::findOrFail($request->get('id'));
            $roomType->update($request->all());
            $roomType->amenities()->sync(explode(",", $request->get('amenities')) );
        } else {
            $property = $this->property->findOrFail($request->get('property_id'));
            $roomType = $property->roomTypes()->create($request->all());
            $roomType->amenities()->sync(explode(",", $request->get('amenities')));
        }

        return response()->json(['roomType' => $roomType]);
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \App\Services\SearchProperties $service
     * @param                                $properties
     * @return \Illuminate\Support\Collection
     */
    private function filterCheckInCheckOutDate(Request $request, SearchProperties $service, $properties)
    {
        if ($request->has('checkIn') && $request->has('checkOut')) {
            $checkInDate = Carbon::createFromFormat('d/m/Y', $request->get('checkIn'));
            $checkOutDate = Carbon::createFromFormat('d/m/Y', $request->get('checkOut'));
            $properties = $service->filterByDates($properties, $checkInDate, $checkOutDate);

            return $properties;
        }

        return $properties;
    }

    public function delete(Request $request, $propertyId)
    {
        if ($request->wantsJson()) {
            $property = Property::findOrFail($propertyId);
            $property->delete();

            return response()->json(['message' => 'completed']);
        }
    }

    public function uploadRoomPic(Request $request)
    {
        if ($request->ajax()) {
            if ($request->hasFile('file')) {
                $property = RoomType::findOrFail($request->get('roomTypeId'));

                $fileName = $request->file('file')->getClientOriginalName();
                $path = '/tests/files/';
                $absoluteLink = $path . $fileName;
                $request->file('file')->move(public_path($path), $fileName);
                $mediaParam = [
                    'link' => $absoluteLink,
                    'type' => 'image'
                ];
                $media = $property->media()->create($mediaParam);
                $message = 'done';

                return response()->json(compact('message', 'media'));
            }
        }
    }


    public function deleteRoomMedia($roomTypeId, $mediaId, MediaService $mediaService)
    {
        $media = $mediaService->getMediaByRoomTypeIdAndMediaId($roomTypeId, $mediaId);

        $media->delete();
        $message = "deleted";

        return response()->json(compact('message', 'media'));
    }

    public function updateRoomMediaDescription(Request $request, $roomTypeId, $mediaId, MediaService $mediaService)
    {
        $media = $mediaService->getMediaByRoomTypeIdAndMediaId($roomTypeId, $mediaId);

        $media->description = $request->get('description');
        $media->save();
        $message = 'Yes';

        return response()->json(compact('media', 'message'));
    }
}

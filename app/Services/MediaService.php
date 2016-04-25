<?php
/**
 * Author: Xavier Au
 * Date: 16/1/16
 * Time: 9:57 PM
 */

namespace App\Services;


use App\Contracts\HasMediaResource;
use App\Media;
use App\RoomType;
use App\User;
use Illuminate\Support\Facades\Auth;

class MediaService
{
    public function getMediaByPropertyIdAndMediaId(int $propertyId, int $mediaId, User $user=null ): Media
    {
        $user = $user?? Auth::user();
        $property = $user->properties()->whereId($propertyId)->firstOrFail();
        $media = $property->media()->whereId($mediaId)->firstOrFail();
        return $media;
    }
    public function getMediaByRoomTypeIdAndMediaId(int $roomTypeId, int $mediaId): Media
    {
        $roomType = RoomType::whereId($roomTypeId)->firstOrFail();
        $media = $roomType->media()->whereId($mediaId)->firstOrFail();
        return $media;
    }
    public function addANewMediaRecord(HasMediaResource $owner, int $propertyId, array $mediaParam ): Media
    {
        $media = $owner->addMedia();
        $user = $user?? Auth::user();
        $property = $user->properties()->whereId($propertyId)->firstOrFail();
        $media = $property->media()->whereId($mediaId)->firstOrFail();
        return $media;
    }
}
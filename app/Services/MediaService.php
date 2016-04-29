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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

class MediaService
{
    private $image;
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


    public function prepare(UploadedFile $file): MediaService
    {
        $this->image = Image::make($file);
        $this->resizeImage();
        return $this;
    }
    public function saveImage(string $path, string $fileName, UploadedFile $file = null)
    {
        $file = $file?Image::make($file): $this->image;
        
        $file->save($path.$fileName);
    }

    private function resizeImage(float $ratio = null)
    {
        $ratio = $ratio? $ratio: 4/3.0;
        $imageHeight = $this->image->height();
        $imageWidth = $this->image->width();
        if($imageHeight != ($imageHeight * $ratio))
            $this->image->fit($imageWidth, intval($imageHeight*(1/$ratio)));

    }
}
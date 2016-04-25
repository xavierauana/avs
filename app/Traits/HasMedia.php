<?php
/**
 * Author: Xavier Au
 * Date: 13/1/16
 * Time: 2:08 PM
 */

namespace App\Traits;


use App\Media;
use Illuminate\Support\Collection;

trait HasMedia
{
    public function media()
    {
        return $this->morphMany(Media::class, 'owner');
    }

    public function addMedia(array $mediaParam): Media
    {
        return $this->media()->create($mediaParam);
    }
}
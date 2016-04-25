<?php

namespace App;

use App\Contracts\HasMediaResource;
use App\Exceptions\CannotHaveMultipleRoomTypes;
use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Model;

class Property extends Model implements HasMediaResource
{
    use HasMedia;

    protected $fillable = [
      'name', 'description', 'property_type_id', 'owner_id'
    ];

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }
    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }

    public function createNewRoomType(array $roomTypeParams):RoomType
    {
        if($this->is_multiple() or !$this->hasRoomType()){
            $roomType = $this->roomTypes()->create($roomTypeParams);
            return $roomType;
        }
        throw new CannotHaveMultipleRoomTypes;
    }

    public function is_multiple()
    {
        return !! $this->propertyType->is_multiple;
    }

    private function hasRoomType()
    {
        return !! $this->roomTypes()->count();
    }
    public function owner(){
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function amenities()
    {
        return $this->morphToMany(Amenities::class, 'amenowner');
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

}

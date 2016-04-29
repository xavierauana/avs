<?php

namespace App;

use App\RoomTypeCalendar;
use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasMedia;

    protected $fillable =[
        'code',
        'occupancy',
        'availability',
        'room_type_list_id',
        'base_price',
        'weekly_price',
        'monthly_price',
        'description',
        'bedrooms',
        'beds',
        'bathrooms',];



    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function calendar()
    {
        return $this->hasMany(RoomCalendar::class, 'room_id');
    }

    public function setDescriptionAttribute($value)
    {
        return $this->attributes['description'] = nl2br($value);
    }

    public function isAvailableOnDateForOccupancy(string $date, int $occupancy)
    {
        $calendar = $this->calendar()->where('date',$date)->first();
        if(!$calendar){
            $data = [
                'availability' => $this->availability,
                'date' => $date
            ];
            $calendar = $this->calendar()->create($data);
        }
        return $calendar->availability > 0 and $this->occupancy >= $occupancy;
    }

    public function amenities()
    {
        return $this->morphToMany(Amenities::class, 'amenowner');
    }

    public function isAvailable(string $date)
    {
        $calendar = $this->calendar()->where('date', $date)->first();
        if(!$calendar){
            $data = [
                'availability' => $this->availability,
                'date' => $date
            ];
            $calendar = $this->calendar()->create($data);
        }
        return  $calendar->availability > 0;
    }

    public function type()
    {
        return $this->belongsTo(RoomTypeList::class, 'room_type_list_id');
    }
}

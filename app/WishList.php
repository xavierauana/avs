<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $fillable =[
        'name'
    ];

    public function items()
    {
        return $this->hasMany(WishListItem::class);
    }

    public function addItem(Property $property):WishListItem
    {
        $param = ['property_id'=>$property->id];
        return $this->items()->create($param);
    }
}
